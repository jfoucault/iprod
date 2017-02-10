<?php
/**
 * Created by PhpStorm.
 * User: fouca
 * Date: 07/02/2017
 * Time: 15:25
 */

namespace AppBundle\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;

class RoomController extends Controller
{
    private function getMaterialListByRoom($room){
        return $this->getDoctrine()->getRepository('AppBundle:Object')->findBy(array('room' => $room));
    }

    /**
     * @Route("/materiel/{place}/{room}", name="room")
     */
    public function roomAction($room, $place)
    {
        $em = $this->getDoctrine();
        $room = $em->getRepository('AppBundle:Room')->findBy(array('route'=>$place.'/'.$room));
        $materials = $this->getMaterialListByRoom($room[0]->getId());

        return $this->render('Room.html.twig', ['materials' => $materials, 'base_dir' => realpath($this->getParameter('kernel.root_dir').'/..').DIRECTORY_SEPARATOR,
        ]);
    }


}
