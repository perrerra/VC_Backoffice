<?php


namespace AppBundle\Controller\Webservice;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Security\Core\Authentication\Token\UsernamePasswordToken;
use Symfony\Component\Security\Http\Event\InteractiveLoginEvent;

class GetRidesController extends Controller
{
    /**
     * @Route("/api/user/getrides")
     * @Method({"POST"})
     */
    public function loginAction(Request $request)
    {
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
        return new JsonResponse(array('rides' => $user->getRidesAsArray()), 201);
    }

}