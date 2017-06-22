<?php


namespace AppBundle\Controller\Webservice;

use AppBundle\Entity\Bike;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use InfluxDB\Point;

class EndRideController extends Controller
{
    /**
     * @Route("/api/user/endride")
     * @Method({"POST"})
     */
    public function startRideAction(Request $request)
    {
        //dump($request->request->all());
        $em = $this->get('doctrine.orm.entity_manager');
        $ride_id = $request->request->get('ride_id');
        $endDate = $request->request->get('startDate');
        $json_measurements = $request->request->get('measurements');

        $measurements = json_decode($json_measurements);

        $ride = null;
        if (null === $ride_id) {
            return new JsonResponse(array('status' => 0, 'message' => 'The "ride_id" parameter is missing from the request\'s body'), 422);
        }else{
            $user = $em->getRepository('AppBundle:Ride')->findOneById($ride_id);
            if($user === null){
                return new JsonResponse(array('statut' => 0, 'message' => 'Ride not found.'), 422);
            }
        }

        if (null === $ride_id) {
            return new JsonResponse(array('statut' => 0, 'message' => 'No measures found.'), 422);
        }else{
            if(null===$json_measurements){

            }
        }

        $ride->setEndDate($endDate);
        $em->persist($ride);
        $em->flush();

        return new JsonResponse(array('status' => 1), 201);
    }
}