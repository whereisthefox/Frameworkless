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
	    $data = $request->getContent();
            $data2 = json_decode($data, true);
            $request->request->replace(is_array($data2) ? $data2 : array());
        } else {
            $data2 = $request->getContent();
        }

	var_dump($data2);
        $response = new Response(
            'Upload sucessfull!',
            Response::HTTP_OK,
            array('Content-Type' => 'application/json')
        );

        $response->send();
    }

/**
  * Usedfortesting
  *
  */
    public function sendData()
    {
        $r = Request::createFromGlobals();
        $r->headers->set(('Content-Type'), 'application/json');
        $r->request->set(('body'), '{"coord":{"lon":139,"lat":35},
"sys":{"country":"JP","sunrise":1369769524,"sunset":1369821049},
"weather":[{"id":804,"main":"clouds","description":"overcast clouds","icon":"04n"}],
"main":{"temp":289.5,"humidity":89,"pressure":1013,"temp_min":287.04,"temp_max":292.04},
"wind":{"speed":7.31,"deg":187.002},
"rain":{"3h":0},
"clouds":{"all":92},
"dt":1369824698,
"id":1851632,
"name":"Shuzenji",
"cod":200}');
        return($this->getData($r));
    }

   public function apendData()
   {
   }

}

 ?>
