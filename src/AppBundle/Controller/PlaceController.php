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
use Symfony\Component\HttpFoundation\Request;

class PlaceController extends Controller
{

    private function getRooms($place){

        $em = $this->getDoctrine();

        if ($place == 'hospital')
        {
            $data = $em->getRepository('AppBundle:Room')->findBy(array('place' => 1));
        }
        elseif ($place == 'house')
        {
            $data = $em->getRepository('AppBundle:Room')->findBy(array('place' => 2));
        }
        else
        {
            throw $this->createNotFoundException('Le lieu '.$place.' n\'existe pas en base');
        }

        return $data;
    }
    /**
     * @Route("/{place}", name="housepage")
     */
    public function appChoiceAction($place)
    {
        $rooms = $this->getRooms($place);

        return $this->render('place.html.twig', ['rooms' => $rooms, 'base_dir' => realpath($this->getParameter('kernel.root_dir').'/..').DIRECTORY_SEPARATOR,
        ]);
    }
}
