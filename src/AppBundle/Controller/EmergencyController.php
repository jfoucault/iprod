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

class EmergencyController extends Controller
{
    /**
     * @Route("/emergency", name="placepage")
     */
    public function appChoiceAction()
    {
        $em = $this->getDoctrine();
        $data = $em->getRepository('AppBundle:EmergencyContact')->findAll();

        return $this->render('emergency.html.twig', ['data' => $data, 'base_dir' => realpath($this->getParameter('kernel.root_dir').'/..').DIRECTORY_SEPARATOR,
        ]);
    }
}
