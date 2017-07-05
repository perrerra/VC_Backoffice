<?php


namespace AppBundle\Controller\Webservice;

use AppBundle\Entity\Bike;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;

class DeleteBikeController extends Controller
{
    /**
     * @Route("/api/user/deletebike")
     * @Method({"POST"})
     */
    public function deleteBikeAction(Request $request)
    {
        //dump($request->request->all());
        $em = $this->get('doctrine.orm.entity_manager');

        $bike_id = $request->request->get('bike_id');


        $bike =  $em->getRepository('AppBundle:Bike')->findOneById($bike_id);

        if($bike === null){
            return new JsonResponse(array('statut' => 0, 'message' => 'Bike not found.'), 422);
        }

        $em->delete($bike);
        $em->flush();

        return new JsonResponse(array('status' => 1), 201);
    }
}