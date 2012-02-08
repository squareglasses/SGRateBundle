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
    
    public function findResourceByIdAndType($rateable_id, $rateable_type)
    {
        return $this->em->getRepository($this->getResourceClassByType($resource_type))->find($resource_id);
    }
    
    /**
     *
     * @param type $type
     * @return type 
     */
    public function getResourceClassByType($type)
    {
        if (isset($this->parameters['rateables'][$type])) {
            // throw new Exception
        }
        
        return $this->parameters['rateables'][$type];
    }
}
