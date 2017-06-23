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

        $measurements = json_decode($json_measurements, true);

        $ride = null;
        if (null === $ride_id) {
            return new JsonResponse(array('status' => 0, 'message' => 'The "ride_id" parameter is missing from the request\'s body'), 422);
        }else{
            $ride = $em->getRepository('AppBundle:Ride')->findOneById($ride_id);
            if($ride === null){
                return new JsonResponse(array('statut' => 0, 'message' => 'Ride not found.'), 422);
            }
        }
        dump($measurements['measures']);
        if (null === $measurements) {
            return new JsonResponse(array('statut' => 0, 'message' => 'No measures found.'), 422);
        }else{
            $points =  array();
            foreach($measurements['measures'] as $measure){
                dump($measure);
                $point = new Point('measure', 1, array(), [
                    'ride' => $ride_id,
                    'temperature' => $measure['temperature'],
                    'rotations' => $measure['rotations'],
                    'tilts' => $measure['tilts'],
                    'slope' => $measure['slope'],
                    'air_quality' => $measure['air_quality']
                ], $measure['timestamp']);
                array_push($points, $point);
            }
            $this->get("influxdb_database")->writePoints($points);
        }

        $ride->setEndDate($endDate);
        $em->persist($ride);
        $em->flush();

        return new JsonResponse(array('status' => 1), 201);
    }
}