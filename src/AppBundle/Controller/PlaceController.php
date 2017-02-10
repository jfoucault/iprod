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

class PlaceController extends Controller
{
    /**
     * @Route("/hospital", name="hospital")
     */
    public function hospitalAction()
    {
        $em = $this->getDoctrine();
        $data = $em->getRepository('AppBundle:Room')->findBy(array('place' => 1));
        return $this->render('place.html.twig', ['data' => $data, 'base_dir' => realpath($this->getParameter('kernel.root_dir').'/..').DIRECTORY_SEPARATOR,
        ]);
    }

    /**
     * @Route("/house", name="hospital")
     */
    public function houseAction()
    {
        $em = $this->getDoctrine();
        $data = $em->getRepository('AppBundle:Room')->findBy(array('place' => 2));
        return $this->render('place.html.twig', ['data' => $data, 'base_dir' => realpath($this->getParameter('kernel.root_dir').'/..').DIRECTORY_SEPARATOR,
        ]);
    }
}
