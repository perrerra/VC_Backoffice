<?php


namespace AppBundle\Controller\Webservice;

use AppBundle\Entity\Bike;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;

class GetBikesController extends Controller
{
    /**
     * @Route("/api/user/getbikes")
     * @Method({"POST"})
     */
    public function getBikesAction(Request $request)
    {
        //dump($request->request->all());
        $em = $this->get('doctrine.orm.entity_manager');
        $user_id = $request->request->get('user_id');
        $user = null;
        if (null === $user_id) {
            return new JsonResponse(array('status' => 0, 'message' => 'The "user_id" parameter is missing from the request\'s body', 'request' => $request->request->all()), 422);
        }else{
            $user = $em->getRepository('AppBundle:User')->findOneById($user_id);
            if($user === null){
                return new JsonResponse(array('statut' => 0, 'message' => 'User not found.'), 422);
            }
        }


        $bikes = $user->getBikesToArray();
        $em->flush();

        return new JsonResponse(array('status' => 1, 'bikes' => $bikes), 201);
    }
}