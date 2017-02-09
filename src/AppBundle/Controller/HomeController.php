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
        $functionalities = [['name' => 'Hopital','color' => '#ffbabc','route'=> 'hospital', 'iconPath' => "./images/hospital.png"],
                            ['name' =>'Maison','color' => ' #caf3f5','route'=>'house','iconPath' =>'./images/home.png']];
        $settings = ['name' =>'Réglages','color' => '#b0d4c8', 'route'=>'settings', 'iconPath' => './images/settings.png'];
        $emergency = ['name' =>'Urgences','color' => 'red', 'route'=>'emergency', 'iconPath' => './images/emergency.png'];

        return $this->render('base.html.twig', ['emergency'=>$emergency,'settings'=> $settings, 'functionalities' => $functionalities, 'base_dir' => realpath($this->getParameter('kernel.root_dir').'/..').DIRECTORY_SEPARATOR,
        ]);

    }
}
