<?php
namespace Frameworkless\Controllers;

use Exception;
use Symfony\Component\HttpFoundation\AcceptHeader;
use Symfony\Component\HttpFoundation\ParameterBag;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Twig_Environment;

/**
 * Handles API requests and responses
 *
 * @author Marin Treselj <marin@pixelipo.com>
 */
class ApiController
{
    public function getData()
    {
        $request = Request::createFromGlobals();
        if (0 === strpos($request->headers->get('Content-Type'), 'application/json')) {
            $data = json_decode($request->getContent(), true);
            // $data = $request->getContent();
            $request->request->replace(is_array($data) ? $data : array());
        } else {
            $data = $request->getContent();
        }

        $response = new Response(
            $data,
            Response::HTTP_OK,
            array('Content-Type' => 'text/html')
        );

        $response->send();
    }

    public function sendData()
    {
        $r = Request::createFromGlobals();
        $r->headers->set(('Content-Type'), 'application/json');
        $r->body = '{
            "aaa": "bbb",
            "ccc": "ddd"
        }';

        return($this->getData());
    }
}

 ?>
