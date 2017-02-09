<?php
/**
 * Created by PhpStorm.
 * User: fouca
 * Date: 07/02/2017
 * Time: 15:25
 */

namespace AppBundle\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;

class RoomController extends Controller
{

    private function getMaterialState($ipAdress){
        if ($ipAdress % 2 == 0 ){
            $state ="active";
        } else {
            $state = "inactive";
        }
        return $state;
    }

    private function getMaterialListByRoom($room){

        $matLivingroom =[["type"=>"light", "name"=>"Plafonnier","state"=>$this->getMaterialState(1)],["type"=>"light","name"=>"Spots bibliothèque","state"=>$this->getMaterialState(2)],
                         ["type"=>"shutter","name"=>"Volet fenêtre","state"=>$this->getMaterialState(1)],["type"=>"shutter","name"=>"Velux","state"=>$this->getMaterialState(2)]];

        $matBathroom =[["type"=>"light","name"=>"Spots miroir","state"=>$this->getMaterialState(1)],["type"=>"light","name"=>"Plafonnier","state"=>$this->getMaterialState(2)],
                       ["type"=>"shutter","name"=>"Volet fenêtre","state"=>$this->getMaterialState(1)]];

        $matKitchen =[["type"=>"light","name"=>"Spots hotte","state"=>$this->getMaterialState(1)],["type"=>"light","name"=>"Plafonnier","state"=>$this->getMaterialState(2)],
                      ["type"=>"shutter","name"=>"Volet vélux","state"=>$this->getMaterialState(1)],["type"=>"shutter","name"=>"Volet fenêtre","state"=>$this->getMaterialState(2)]];

        $matBedroom=[["type"=>"light","name"=>"Table de chevet","state"=>$this->getMaterialState(1)],["type"=>"light","name"=>"Plafonnier","state"=>$this->getMaterialState(1)],
                     ["type"=>"shutter","name"=>"Volet fenêtre","state"=>$this->getMaterialState(2)]];

        switch ($room) {
            case "livingroom":
                $materials = $matLivingroom;
                break;
            case "bathroom":
                $materials = $matBathroom;
                break;
            case "bedroom":
                $materials = $matBedroom;
                break;
            case "kitchen":
                    $materials = $matKitchen;
                break;
        }
        return $listMaterials = $materials;
    }

    /**
     * @Route("/{place}/{room}", name="room")
     */
    public function roomAction($room)
    {
        $materials = $this->getMaterialListByRoom($room);
        return $this->render('Room.html.twig', ['materials' => $materials, 'base_dir' => realpath($this->getParameter('kernel.root_dir').'/..').DIRECTORY_SEPARATOR,
        ]);
    }


}
