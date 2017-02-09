<?php
/**
 * Created by PhpStorm.
 * User: fouca
 * Date: 09/02/2017
 * Time: 09:57
 */

namespace AppBundle\Controller;

use AppBundle\Entity\Object;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\BrowserKit\Response;
use Symfony\Component\HttpFoundation\Request;

class SettingsController extends Controller
{
    /**
     * @Route("/settings", name="settings")
     */
    public function settingsAction(Request $request)
    {
        return $this->render('settings.html.twig', ['base_dir' => realpath($this->getParameter('kernel.root_dir').'/..').DIRECTORY_SEPARATOR,
        ]);

    }

    /**
     * @Route("/settings/{action}", name="settingsActions")
     */
    public function entityManagementAction($action){
        switch ($action) {
            case "addEntity": return "adding";
            case "deleteEntity": return "deletion";
            default : return "error";
        }
    }


    private function createObject(){

        $object = new Object();
        $object->setIsOpen();
        $object->setName();
        $object->setRoom();

        $em = $this->getDoctrine()->getManager();
        $em->persist($object);
        $em->flush();

        return new Response('Saved new object with id'.$object->getId());

    }
}