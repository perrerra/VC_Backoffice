<?php
/**
 * Created by PhpStorm.
 * User: pierre
 * Date: 21/06/17
 * Time: 10:52
 */

namespace AppBundle\Service;


class HelloService
{
    private $mailer;

    public function __construct(\Swift_Mailer $mailer)
    {
        $this->mailer = $mailer;
    }

    public function hello($name)
    {

        $message = new \Swift_Message('Hello Service');
        $message->setTo('pierrelemarre@gmail.com')
                ->setBody($name . ' says hi!');

        $this->mailer->send($message);

        return 'Hello, '.$name;
    }
}