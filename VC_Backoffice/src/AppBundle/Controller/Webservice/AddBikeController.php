<?php


namespace AppBundle\Controller\Webservice;

use AppBundle\Entity\Bike;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;

class AddBikeController extends Controller
{
    /**
     * @Route("/api/user/addbike")
     * @Method({"POST"})
     */
    public function addBikeAction(Request $request)
    {
        //dump($request->request->all());
        $em = $this->get('doctrine.orm.entity_manager');
        $name = $request->request->get('name');
        $wheelsize = $request->request->get('wheelsize');
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

        if (null === $name) {
            return new JsonResponse(array('status' => 0, 'message' => 'The "name" parameter is missing from the request\'s body', 'request' => $request->request->all()), 422);
        }
        if (null === $wheelsize) {
            return new JsonResponse(array('status' => 0, 'message' => 'The "wheelsize" parameter is missing from the request\'s body', 'request' => $request->request->all()), 422);
        }

        $bike = new Bike($name, $wheelsize, $user);
        $em->persist($bike);
        $em->flush();

        return new JsonResponse(array('status' => 1, 'bike' => $bike->toArray()), 201);
    }
}