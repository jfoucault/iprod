<?php
/**
 * Created by PhpStorm.
 * User: fouca
 * Date: 10/02/2017
 * Time: 19:07
 */
namespace AppBundle\Service;

use Symfony\Component\HttpFoundation\Response;
use Doctrine\ORM\EntityManager;

class StateHandler
{
    protected $entityManager;

    public function __construct(EntityManager $entityManager)
    {
        $this->em = $entityManager;
    }

    public function changeState($object_id){

        $object = $this->em->getRepository('AppBundle:Object')->findBy(array('id' => $object_id));

        $currentState = $object[0]->getIsOpen();
        if($currentState)
        {
            $object[0]->setIsOpen(false);
        }
        else
        {
            $object[0]->setIsOpen(true);
        }

        $this->em->persist($object[0]);

        $this->em->flush();
        var_dump($object[0]);

        return new Response('nouvelle valeur :' .$object[0]->getIsOpen());
    }
}