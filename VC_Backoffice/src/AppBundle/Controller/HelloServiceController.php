<?php
/**
 * Created by PhpStorm.
 * User: pierre
 * Date: 21/06/17
 * Time: 10:55
 */

namespace AppBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Response;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use AppBundle\Service\HelloService;

class HelloServiceController extends Controller
{
    /**
     * @Route("/soap")
     */
    public function indexAction(HelloService $helloService)
    {
        $server = new \SoapServer('/path/to/hello.wsdl');
        $server->setObject($helloService);

        $response = new Response();
        $response->headers->set('Content-Type', 'text/xml; charset=ISO-8859-1');

        ob_start();
        $server->handle();
        $response->setContent(ob_get_clean());

        return $response;
    }
}