<?php
/**
 * Created by PhpStorm.
 * User: fouca
 * Date: 06/02/2017
 * Time: 14:44
 */

namespace AppBundle\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;

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
     * @Route("/settings/deleteEntity", name="ChoiceForDeletion")
     */
    public function entityChoiceAction()
    {
        $em = $this->getDoctrine();
        $places = $em->getRepository('AppBundle:Place')->findAll();
        $rooms = $em->getRepository('AppBundle:Room')->findAll();
        $materials = $em->getRepository('AppBundle:Object')->findAll();

        return $this->render('deletion.html.twig',
                             ['places'=>$places,
                              'objects' => $materials,
                              'rooms' => $rooms,
                              'base_dir' => realpath($this->getParameter('kernel.root_dir').'/..').DIRECTORY_SEPARATOR,
        ]);
    }

    /**
     * @param $id
     * @Route("/settings/deleteEntity/{id}", name="deleteRoute")
     */
    public function deleteAction($id)
    {
        $em = $this->getDoctrine()->getManager();
        $object = $em->getRepository('AppBundle:Object')->findBy(array('id' => $id));

        $em->remove($object[0]);
        $em->flush();
        $message = 'L\'élément '.$object[0]->getName().' a bien été supprimé.';
        return $this->render('infos.html.twig', [ 'message'=> $message, 'base_dir' => realpath($this->getParameter('kernel.root_dir').'/..').DIRECTORY_SEPARATOR,
    ]);;
    }
}
