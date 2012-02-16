<?php

namespace SG\RateBundle\Service;

use Doctrine\ORM\EntityManager;
use Symfony\Component\EventDispatcher\EventDispatcherInterface;

use InvalidArgumentException;

/**
 * Description of RateableManager
 *
 * @author Bat <contact@graindeweb.fr>
 */
class RateableManager
{
    /**
     * @var EntityManager
     */
    protected $em;

    /**
     * @var EventDispatcher
     */
    protected $dispatcher;
    
    /**
     * @var CommentInterface
     */
    protected $comment;
    
    /**
     * @var array
     */
    protected $parameters;
    
    /**
     *
     * @param EntityManager $em
     * @param EventDispatcherInterface $dispatcher 
     */
    public function __construct(EntityManager $em, EventDispatcherInterface $dispatcher, array $parameters = array())
    {
        $this->em           = $em;
        $this->dispatcher   = $dispatcher; 
        $this->parameters   = $parameters;
    }
    
    /**
     * Get Rateable resource with its type and id (look for repository)
     * 
     * @param string $rateable_id
     * @param string $rateable_type
     * @return Rateable rateable resource
     */
    public function findRateableByIdAndType($rateable_id, $rateable_type)
    {
        return $this->em->getRepository($this->getResourceClassByType($rateable_type))->find($rateable_id);
    }
    
    /**
     * Retrieve class with namespace for a given type
     * 
     * @param type $type
     * @return string 
     */
    public function getResourceClassByType($type)
    {
        if (isset($this->parameters['rateables'][$type]['class'])) {
            // throw new Config Exception (Already fired by Configuration mecanism ?)
        }
        
        return $this->parameters['rateables'][$type]['class'];
    }
}
