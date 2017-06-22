<?php


namespace AppBundle\Controller\Webservice;

use AppBundle\Entity\Bike;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;

class UpdateBikeController extends Controller
{
    /**
     * @Route("/api/user/updatebike")
     * @Method({"POST"})
     */
    public function addBikeAction(Request $request)
    {
        //dump($request->request->all());
        $em = $this->get('doctrine.orm.entity_manager');

        $bike_id = $request->request->get('bike_id');
        $name = $request->request->get('name');
        $wheelsize = $request->request->get('wheelsize');

        $bike =  $em->getRepository('AppBundle:Bike')->findOneById($bike_id);

        if($bike === null){
            return new JsonResponse(array('statut' => 0, 'message' => 'Bike not found.'), 422);
        }

        if (null != $name) {
            $bike -> setName($name);
        }
        if (null != $wheelsize) {
            $bike -> setWheelsize($wheelsize);
        }

        $em->persist($bike);
        $em->flush();

        return new JsonResponse(array('status' => 1, 'bike' => $bike->toArray()), 201);
    }
}