<?php
/**
 * Created by PhpStorm.
 * User: fouca
 * Date: 03/02/2017
 * Time: 15:39
 */

namespace AppBundle\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;

class HomeController extends Controller
{
    /**
     * @Route("/", name="homepage")
     */
    public function indexAction(Request $request)
    {

        $em = $this->getDoctrine();

        $places = $em->getRepository('AppBundle:Place')->findAll();

        $settings = ['name' =>'Réglages','color' => '#b0d4c8', 'route'=>'settings', 'iconPath' => './images/settings.png'];
        $emergency = ['name' =>'Urgences','color' => 'red', 'route'=>'emergency', 'iconPath' => './images/emergency.png'];

        return $this->render('base.html.twig', ['emergency'=>$emergency,'settings'=> $settings, 'places' => $places, 'base_dir' => realpath($this->getParameter('kernel.root_dir').'/..').DIRECTORY_SEPARATOR,
        ]);

    }
}
