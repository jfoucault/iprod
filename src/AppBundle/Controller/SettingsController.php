<?php
/**
 * Created by PhpStorm.
 * User: fouca
 * Date: 06/02/2017
 * Time: 14:44
 */

namespace AppBundle\Controller;

use AppBundle\Entity\Object;
use AppBundle\Entity\Room;
use AppBundle\Form\ObjectType;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\HttpFoundation\Request;

class SettingsController extends Controller
{
    /**
     * @Route("/settings", name="settings")
     */
    public function appChoiceAction()
    {
        return $this->render('settings.html.twig', ['base_dir' => realpath($this->getParameter('kernel.root_dir').'/..').DIRECTORY_SEPARATOR,
        ]);
    }

    /**
     * Récupère la liste des lieux qui ont des pièces
     * @return array
     */
    public function getUnemptyEntities($entity, $component){

        $em = $this->getDoctrine();
        $mng = $em->getManager();

        $listEntities = $mng->createQuery('SELECT p FROM AppBundle:'.$entity.' p')->getResult();
        $index = -1;
        foreach ($listEntities as $element){
            $index++;
            $nbcomp = $mng->createQuery('SELECT count(c) FROM AppBundle:'.$component.' c WHERE c.'.strtolower($entity).' ='.$element->getId())->getResult();

            if ( $nbcomp[0][1] == 0){array_splice($listEntities,$index,1);}
        }
        return $listEntities;
    }

    public function getObjectsInRoom($roomId, $listObjects){

        $tab = array();
        foreach ($listObjects as $obj) {
            if($obj->getRoom()->getId() == $roomId){array_push($tab, ['ObjectId'=> $obj->getId(),'ObjectName' => $obj->getName()]);}
        }

        return $tab;
    }

    public function getRoomsInPlace($placeId, $listRooms, $listObjects){

        $tab = array();
        foreach ($listRooms as $room) {
            if($room->getPlace()->getId() == $placeId && !empty($this->getObjectsInRoom($room->getId(), $listObjects)))
            {array_push($tab, ['Room'=>$room,'Objects'=>$this->getObjectsInRoom($room->getId(), $listObjects)]);}
        }

        return $tab;
    }
    /**
     * @Route("/settings/deleteEntity", name="ChoiceForDeletion")
     */
    public function entityChoiceAction()
    {
        $places = $this->getUnemptyEntities('Place','Room');
        $rooms = $this->getUnemptyEntities('Room','Object');
        $materials = $this->getDoctrine()->getManager()->getRepository('AppBundle:Object')->findAll();

        $data = array();
        foreach ($places as $place){
            if( !empty($this->getRoomsInPlace($place->getId(), $rooms, $materials))){
                array_push($data, ['Place'=>$place->getName(), 'PlaceId'=>$place->getId(),'Rooms' => $this->getRoomsInPlace($place->getId(), $rooms, $materials)]);
            }
        }
        return $this->render('deletion.html.twig',['data'=>$data, 'base_dir' => realpath($this->getParameter('kernel.root_dir').'/..').DIRECTORY_SEPARATOR,]);
    }

    /**
     * Change the state in database
     * @param $id
     * @Route("/settings/deleteEntity/{type}/{id}", name="deleteRoute")
     */
    public function deleteAction($type, $id)
    {
        $em = $this->getDoctrine()->getManager();
        $entity = $em->getRepository('AppBundle:'.$type)->findBy(array('id' => $id));
        $em->remove($entity[0]);
        $em->flush();
        $message = 'L\'élément '.$entity[0]->getName().' a bien été supprimé.';
        return $this->render('infos.html.twig', [ 'message'=> $message, 'base_dir' => realpath($this->getParameter('kernel.root_dir').'/..').DIRECTORY_SEPARATOR,]);
    }

    /**
     * Formulaire d'ajout d'un module
     * @Route("/settings/addEntity", name="addEntity")
     */
    public function addEntityAction(Request $request){

        $em = $this->getDoctrine()->getManager();
        $rooms = $em->getRepository('AppBundle:Room')->findAll();

        $roomsChoices = array();
        foreach ($rooms as $room){
            $roomsChoices[$room->getName().' de '.$room->getPlace()->getName()]  = $room->getId();
        }
        /*Build the form*/
        $object = new Object();
        $object->setIsOpen(0);

        $form = $this->createFormBuilder($object)
            ->add('name', TextType::class)
            ->add('room', ChoiceType::class, array('choices' => $roomsChoices,))
            ->add('type',  ChoiceType::class, array('choices' => ['Luminaire'=>'light','Volet'=>'shutter']))
            ->add('objectIP', IntegerType::class)->getForm();

        /*Handle the request*/
        $form->handleRequest($request);
        if ($form->isSubmitted()){
            $object->setId($object->getObjectIP());
            $object->setRoom($em->getRepository('AppBundle:Room')->find($object->getRoom()));
            $object = $form->getData();
            $em = $this->getDoctrine()->getManager();
            $em->persist($object);
            $em->flush();

            return $this->redirectToRoute('homepage');
        }

        return $this->render('addition.html.twig', array('form' => $form->createView()));
    }


}
