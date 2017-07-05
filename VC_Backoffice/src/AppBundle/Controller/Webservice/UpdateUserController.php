<?php


namespace AppBundle\Controller\Webservice;

use AppBundle\Entity\User;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;

class UpdateUserController extends Controller
{
    /**
     * @Route("/api/user/updateuser")
     * @Method({"POST"})
     */
    public function updateUserAction(Request $request)
    {
        //dump($request->request->all());
        $em = $this->get('doctrine.orm.entity_manager');
        $user_id = $request->request->get('user_id');
        $username = $request->request->get('username');
        $email = $request->request->get('email');
        $password = $request->request->get('password');

        $userManager = $this->get('fos_user.user_manager');

        $user = $userManager -> findUserBy(array('id' => $user_id));
        if (null === $user) {
            return new JsonResponse(array('statut' => 0, 'message' => 'User not found.'), 422);
        }


        if (null != $username) {

            $user_by_username = $em->getRepository('AppBundle:User')->findOneByUsername($username);
            $username_taken = false;
            if (null !== $user_by_username) {
                if($user_by_username->getId() !== intval($user_id)){
                    $username_taken = true;
                }
            }

            if ($username_taken) {
                return new JsonResponse(array('statut' => 0, 'message' => 'The username "'.$username.'" is already taken'), 422);
            }
            else{
                $user->setUsername($username);
            }
        }
        if (null != $email) {
            $user_by_email = $em->getRepository('AppBundle:User')->findOneByEmail($email);
            $email_taken = false;
            if (null !== $user_by_email) {
                if($user_by_email->getId() !== intval($user_id)){
                    $email_taken = true;
                }
            }
            if($email_taken) {
                return new JsonResponse(array('status' => 0, 'message' => 'The email adress "'.$email.'" is already taken'), 422);
            }
            else{
                $user->setEmail($email);
            }
        }
        if (null != $password) {
            $user->setPlainPassword($password);
        }

        $user->addRole('ROLE_USER');
        $user->setEnabled(true);
        $userManager->updateUser($user);

        return new JsonResponse(array('statut' => 1, 'user' => $user->toArray()), 201);
    }
}