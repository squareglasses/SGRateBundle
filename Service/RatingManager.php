<?php

/**
 * This file is part of the Rateable package.
 * (c) Square Glasses <http://www.squareglasses.com/>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace SG\RateBundle\Service;

use Doctrine\ORM\EntityManager;
use DoctrineExtensions\Rateable\RatingManager as BaseRatingManager;
use SG\RateBundle\Event\RateEvent;

/**
 * RatingManager.
 *
 * @author bat <contact@graindeweb.fr>
 */
class RatingManager extends BaseRatingManager
{
    protected $dispatcher;
    
    public function __construct(EntityManager $em, $class = null, $minRateScore = 1, $maxRateScore = 5, EventDispatcherInterface $dispatcher = null)
    {
        $this->em = $em;
        $this->class = $class ?: 'DoctrineExtensions\Rateable\Entity\Rate';
        $this->minRateScore = $minRateScore;
        $this->maxRateScore = $maxRateScore;
        $this->dispatcher   = $dispatcher;
    }
  
    /**
     * Adds a new rate.
     *
     * @param Rateable  $resource   The resource object
     * @param Reviewer  $reviewer   The reviewer object
     * @param integer   $rateScore  The rate score
     *
     * @return void
     */
    public function addRate(Rateable $resource, Reviewer $reviewer, $rateScore, $save = true)
    {
        $rate = parent::addRate($resource, $reviewer, $rateScore, $save);
        
        $this->dispatcher->dispatch(RateEvent::RATE_POST_PERSIST, new RateEvent($rate));

        return $rate;
    }

    /**
     * Removes an existant rate.
     * Warning : This method only works fine with single Rating
     * @todo : add method to remove All Rate, or on Rate by id
     *
     * @param Rateable  $resource   The resource object
     * @param Reviewer  $reviewer   The reviewer object
     *
     * @return void
     */
    public function removeRate(Rateable $resource, Reviewer $reviewer)
    {
        if (!$reviewer->canRemoveRate($resource)) {
            throw new Exception\PermissionDeniedException('This reviewer cannot remove his rate for this resource');
        }

        if (!($rate = $this->findRate($resource, $reviewer))) {
            throw new Exception\NotFoundRateException('Unable to find rate object');
        }

        $this->dispatcher->dispatch(RateEvent::RATE_PRE_DELETE, new RateEvent($resource, $rate));
        
        $resource->setRatingVotes($resource->getRatingVotes() - 1);
        $resource->setRatingTotal($resource->getRatingTotal() - $rate->getScore());

        $this->em->remove($rate);
        $this->em->flush();

        $this->saveEntity($resource);
        
        $this->dispatcher->dispatch(RateEvent::RATE_POST_DELETE, new RateEvent($resource));
    }
}