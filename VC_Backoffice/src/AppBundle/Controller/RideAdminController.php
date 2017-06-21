<?php

// src/AppBundle/Controller/LuckyController.php
namespace AppBundle\Controller;


use Sonata\AdminBundle\Controller\CRUDController as Controller;
use AppBundle\Entity\Ride;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Component\HttpFoundation\Response;


class RideAdminController extends Controller
{
// route - get_bikes_for_user
    /**
     * @param $userId
     * @return Response
     */
    public function getBikesForUserAction($userId)
    {
        $html = ""; // HTML as response
        $user = $this->getDoctrine()
            ->getRepository('AppBundle:User')
            ->find($userId);

        $bikes = $user->getBikes();

        foreach($bikes as $bike){
            $html .= '<option value="'.$bike->getId().'" >'.$bike->getName().'</option>';
        }
        return new Response($html, 200);
    }
}
