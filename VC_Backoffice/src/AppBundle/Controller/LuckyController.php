<?php

// src/AppBundle/Controller/LuckyController.php
namespace AppBundle\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use AppBundle\Entity\Ride;

class LuckyController extends Controller
{
    /**
     * @Route("/lucky/number")
     */
    public function numberAction()
    {
        $number = mt_rand(0, 100);
        $tag = $this->getDoctrine()
            ->getRepository('AppBundle:User')
            ->find(2);

        $categories = $tag->getBikes();

        foreach($categories as $cat){
            //$html .= '<option value="'.$cat->getId().'" >'.$cat->getName().'</option>';
            var_dump($cat->getId());
        }

        return $this->render('lucky/number.html.twig', array(
            'number' => $number,
        ));



    }
}
