<?php

namespace SG\RateBundle\Event;

use Symfony\Component\EventDispatcher\Event as BaseEvent;
use SG\RateBundle\Entity\Rate;

/**
 * Description of RatingEvent
 *
 * @author Bat <contact@graindeweb.net>
 */
class RateEvent extends BaseEvent
{
    /**
     * Pre-persist event occ
     * 
     * Persisting of the rating vote can be aborted by calling abortPersist()
     * 
     * @var string
     */
    const RATE_PRE_PERSIST    = 'sg_comment.rate.pre_persist';
    
    /**
     * @var string
     */
    const RATE_POST_PERSIST   = 'sg_comment.rate.post_persist';
    
    /**
     * @var string
     */
    const RATE_PRE_UPDATE     = 'sg_comment.rate.pre_update';
    
    /**
     * @var string
     */
    const RATE_POST_UPDATE    = 'sg_comment.rate.post_update';
    
    /**
     * @var string
     */
    const RATE_CREATE         = 'sg_comment.rate.create';
    
    /**
     * @var string
     */
    const RATE_PRE_DELETE     = 'sg_comment.rate.pre_delete';
    
    /**
     * @var string
     */
    const RATE_POST_DELETE    = 'sg_comment.rate.post_delete';

    /**
     *
     * @var type 
     */
    protected $rate;
    
    /**
     * Indicates if persisting of the comment shold be aborted 
     * (only on a RATE_PRE_PERSIST)
     * 
     * @var type 
     */
    private $persistenceAborted = false;
    
    /**
     *
     * @param Rate $rate 
     */
    public function __construct(Rate $rate)
    {
        $this->rate = $rate;
    }
    
    /**
     * Return event for this event
     * @return Rate 
     */
    public function getRate()
    {
        return $this->rate;
    }
    
    /**
     * 
     */
    public function abortPersistence()
    {
        $this->persistenceAborted = true;
    }
    
    /**
     *
     * @return bool
     */
    public function isPersistenceAborted()
    {
        return $this->persistenceAborted;
    }
}