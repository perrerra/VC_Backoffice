<?php


namespace AppBundle\Controller\Webservice;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;

class AddUserController extends Controller
{
    /**
     * @Route("/api/user/adduser")
     * @Method({"POST"})
     */
    public function addUserAction(Request $request)
    {
        //dump($request->request->all());
        $em = $this->get('doctrine.orm.entity_manager');
        $username = $request->request->get('username');
        $email = $request->request->get('email');
        $password = $request->request->get('password');
        if (null === $username) {
            return new JsonResponse(array('status' => 0, 'message' => 'The "username" parameter is missing from the request\'s body', 'request' => $request->request->all()), 422);
        }
        if (null === $email) {
            return new JsonResponse(array('status' => 0, 'message' => 'The "email" parameter is missing from the request\'s body', 'request' => $request->request->all()), 422);
        }
        if (null === $password) {
            return new JsonResponse(array('status' => 0, 'message' => 'The "password" parameter is missing from the request\'s body', 'request' => $request->request->all()), 422);
        }
        if (null !== $em->getRepository('AppBundle:User')->findOneByUsername($username)) {
            return new JsonResponse(array('status' => 0, 'message' => 'The username "'.$username.'" is already taken'), 422);
        }
        if (null !== $em->getRepository('AppBundle:User')->findOneByEmail($email)) {
            return new JsonResponse(array('status' => 0, 'message' => 'The email adress "'.$email.'" is already taken'), 422);
        }

        $userManager = $this->get('fos_user.user_manager');
        $user = $userManager->createUser();
        $user->setUsername($username);
        $user->setEmail($email);
        $user->setPlainPassword($password);
        $user->addRole('ROLE_USER');
        $user->setEnabled(true);
        $userManager->updateUser($user);

        return new JsonResponse(array('status' => 1, 'user' => $user->toArray()), 201);
    }
}