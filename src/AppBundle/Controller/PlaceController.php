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
    /**
     * @Route("/{function}", name="placepage")
     */
    public function appChoiceAction($function)
    {
        switch ($function){
            case 'settings' : $data = $this->getFunction($function); $twig = 'settings'; break;
            case 'emergency' : $data = $this->getFunction($function); $twig = 'emergency'; break;
            case ('hospital' || 'house' ) : $data = $this->getRooms($function); $twig = 'place'; break;
            default : throw $this->createNotFoundException('No matching function or place');
        }

        return $this->render($twig.'.html.twig', ['data' => $data, 'base_dir' => realpath($this->getParameter('kernel.root_dir').'/..').DIRECTORY_SEPARATOR,
        ]);
    }

    /**
     * Récupération des lieux dans la base de données
     * @param $place
     * @return array
     */
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
     *
     * @param $function
     *
     */
    private function getFunction($function){
        $em = $this->getDoctrine();
        switch ($function){
            case 'emergency': $data = $em->getRepository('AppBundle:EmergencyContact')->findAll(); break;
            case 'settings': $data = []; break;
            default: throw $this->createNotFoundException('No emergency in database');
        }

        return $data;
    }
}
