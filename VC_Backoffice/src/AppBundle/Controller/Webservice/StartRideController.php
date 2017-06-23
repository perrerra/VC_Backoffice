<?php


namespace AppBundle\Controller\Webservice;

use AppBundle\Entity\Bike;
use AppBundle\Entity\Ride;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;


class StartRideController extends Controller
{
    /**
     * @Route("/api/user/startride")
     * @Method({"POST"})
     */
    public function startRideAction(Request $request)
    {
        //dump($request->request->all());
        $em = $this->get('doctrine.orm.entity_manager');
        $startDate = $request->request->get('startDate');
        $user_id = $request->request->get('user_id');
        $bike_id = $request->request->get('bike_id');

        $user = null;
        if (null === $user_id) {
            return new JsonResponse(array('status' => 0, 'message' => 'The "user_id" parameter is missing from the request\'s body', 'request' => $request->request->all()), 422);
        }else{
            $user = $em->getRepository('AppBundle:User')->findOneById($user_id);
            if($user === null){
                return new JsonResponse(array('statut' => 0, 'message' => 'User not found.'), 422);
            }
        }

        $bike = null;
        if (null === $bike_id) {
            return new JsonResponse(array('status' => 0, 'message' => 'The "bike_id" parameter is missing from the request\'s body', 'request' => $request->request->all()), 422);
        }else{
            $bike = $em->getRepository('AppBundle:Bike')->findOneById($bike_id);
            if($bike === null){
                return new JsonResponse(array('statut' => 0, 'message' => 'Bike not found.'), 422);
            }
        }

        $date = new \DateTime();
        $date->setTimestamp($startDate);

        $ride = new Ride($date, $user, $bike);
        $em->persist($ride);
        $em->flush();

        return new JsonResponse(array('status' => 1), 201);
    }
}