<?php


namespace AppBundle\Controller\Webservice;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Security\Core\Authentication\Token\UsernamePasswordToken;
use Symfony\Component\Security\Http\Event\InteractiveLoginEvent;

class LoginController extends Controller
{
    /**
         * @Route("/api/login")
     * @Method({"POST"})
     */
    public function loginAction(Request $request)
    {

        $username = $request->request->get('username');
        $password = $request->request->get('password');

        $user_manager = $this->get('fos_user.user_manager');
        $factory = $this->get('security.encoder_factory');

        $user = $user_manager->findUserByUsername($username);

        if($user === null){
            return new JsonResponse(array('statut' => 0, 'message' => 'User not found.'), 422);
        }

        $encoder = $factory->getEncoder($user);
        $auth = ($encoder->isPasswordValid($user->getPassword(),$password,$user->getSalt())) ? "true" : "false";

        if($auth){
            $providerKey = $this->getParameter('fos_user.firewall_name');
            $token = new UsernamePasswordToken($username, $password, $providerKey, $user->getRoles());
            $this->get("security.token_storage")->setToken($token);
            $event = new InteractiveLoginEvent($request, $token);
            $this->get("event_dispatcher")->dispatch("security.interactive_login", $event);
        }

        return new JsonResponse(array('login_status' => $auth, 'user' => $user->toArray(), 'rides' => $user->getRidesAsArray()), 201);

    }

}