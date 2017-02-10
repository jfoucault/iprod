<?php
/**
 * Created by PhpStorm.
 * User: fouca
 * Date: 09/02/2017
 * Time: 09:57
 */

namespace AppBundle\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;

class EmergencyController extends Controller
{
    /**
     * @Route("/settings", name="settings")
     */
    public function emergencyAction(Request $request)
    {
        return $this->render('settings.html.twig', ['base_dir' => realpath($this->getParameter('kernel.root_dir').'/..').DIRECTORY_SEPARATOR,
        ]);
    }
}