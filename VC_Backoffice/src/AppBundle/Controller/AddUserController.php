<?php


namespace AppBundle\Controller;

use AppBundle\Entity\User;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;

class AddUserController extends Controller
{
    /**
     * @Route("/api/v1/adduser")
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
            return new JsonResponse(array('error' => 'The "username" parameter is missing from the request\'s body', 'request' => $request->request->all()), 422);
        }
        if (null === $email) {
            return new JsonResponse(array('error' => 'The "email" parameter is missing from the request\'s body', 'request' => $request->request->all()), 422);
        }
        if (null === $password) {
            return new JsonResponse(array('error' => 'The "password" parameter is missing from the request\'s body', 'request' => $request->request->all()), 422);
        }
        if (null !== $em->getRepository('AppBundle:User')->findOneByUsername($username)) {
            return new JsonResponse(array('error' => 'The username "'.$username.'" is already taken'), 422);
        }
//        $createdUser = new User($username, $email, $password);
//        $em->persist($createdUser);
//        $em->flush();


        $userManager = $this->get('fos_user.user_manager');

        $user = $userManager->createUser();
        $user->setUsername($username);
        $user->setEmail($email);
        $user->setPlainPassword($password);
        $user->addRole('ROLE_USER');
        $user->setEnabled(true);

        $userManager->updateUser($user);

        return new JsonResponse($user->toArray(), 201);
    }
}