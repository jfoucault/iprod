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
use Symfony\Component\HttpFoundation\Response;

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

    /**
     * @Route("/ajax/my/service", name="StateUpdateService")
     */
    public function stateAction(Request $request){
        if ($request->getMethod() !== "POST") {
            throw $this->createNotFoundException();
        }

        $em = $this->getDoctrine()->getManager();
        $object_id = $_POST['object_id'];

        $object = $em->getRepository('AppBundle:Object')->findBy(array('id' => $object_id));

        $currentState = $object[0]->getIsOpen();
        $object[0]->setIsOpen(!$currentState);

        $em->persist($object[0]);

        $em->flush();

        return new Response('nouvelle valeur : '. $object[0]->getIsOpen());
    }

}
