<?php

namespace SG\RateBundle\Event;

use Symfony\Component\EventDispatcher\Event as BaseEvent;
use SG\RateBundle\Entity\Rate;
use DoctrineExtensions\Rateable\Rateable;

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
    const RATE_PRE_PERSIST    = 'sg_rate.rate.pre_persist';
    
    /**
     * @var string
     */
    const RATE_POST_PERSIST   = 'sg_rate.rate.post_persist';
    
    /**
     * @var string
     */
    const RATE_PRE_UPDATE     = 'sg_rate.rate.pre_update';
    
    /**
     * @var string
     */
    const RATE_POST_UPDATE    = 'sg_rate.rate.post_update';
    
    /**
     * @var string
     */
    const RATE_CREATE         = 'sg_rate.rate.create';
    
    /**
     * @var string
     */
    const RATE_PRE_DELETE     = 'sg_rate.rate.pre_delete';
    
    /**
     * @var string
     */
    const RATE_POST_DELETE    = 'sg_rate.rate.post_delete';

    /**
     * @var type 
     */
    protected $rate;
    
    /**
     * @var type 
     */
    protected $resource;
    
    /**
     * Indicates if persisting of the rate should be aborted 
     * (only on a RATE_PRE_PERSIST)
     * 
     * @var type 
     */
    private $persistenceAborted = false;
    
    /**
     *
     * @param Rate $rate 
     */
    public function __construct(Rateable $resource, Rate $rate = null)
    {
        $this->resource = $resource;
        $this->rate     = $rate;
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
     * Return resource for this event
     * @return Rateable 
     */
    public function getResource()
    {
        return $this->resource;
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