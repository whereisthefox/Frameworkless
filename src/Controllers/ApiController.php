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

        $data = $request->getContent();

        $status = $this->appendData($data);
        $response = new Response(
            $status,
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

    public function appendData($data)
    {
	  try {
	    $_SERVER["DOCUMENT_ROOT"];
      $data2 = json_decode($data, true);
	    $inp = file_get_contents($_SERVER["DOCUMENT_ROOT"].'/data/json/datapoints.geojson');
	    $tempArray = json_decode($inp, true);
      array_push($tempArray, $data2);
	    $jsonData = json_encode($tempArray);
	    file_put_contents($_SERVER["DOCUMENT_ROOT"].'/data/json/datapoints.geojson', $jsonData);
	    return 'succes';
	  } catch(Exception $e) {
	    return $e->getMessage();
	  }
  }

    public function tomyCSV()
    {
        $titleList = array (
            "latitude",
            "longitude",
            "name_of_spiecies",
            "picture_name",
            "weather_desc",
            "temp",
            "pressure",
            "humidity",
            "temp_min",
            "temp_max",
            "sea_level",
            "grnd_level",
            "wind_speed",
            "wind_deg",
            "clouds_all",
            "timespan"
        );
        $csvfile = fopen($_SERVER["DOCUMENT_ROOT"].'/data/file.csv','w+');
        fputcsv($csvfile, $titleList);
        $json = file_get_contents($_SERVER["DOCUMENT_ROOT"].'/data/json/datapoints.geojson');
        $tempArray = json_decode($json, true)["features"];
        // print("<pre>");
        // var_dump($tempArray);
        foreach ($tempArray as $k => $v) {
            $list = array();
            $list[] = $v['geometry']['coordinates'][0];
            $list[] = $v['geometry']['coordinates'][1];
            $list[] = $v["properties"]['species'];
            $list[] = $v["properties"]['picture'];
            $list[] = $v['weather'][0]['description'];
            $list[] = $v['main']['temp'];
            $list[] = $v['main']['pressure'];
            $list[] = $v['main']['humidity'];
            $list[] = $v['main']['temp_min'];
            $list[] = $v['main']['temp_max'];
            $list[] = $v['main']['sea_level'];
            $list[] = $v['main']['grnd_level'];
            $list[] = $v['wind']['speed'];
            $list[] = $v['wind']['deg'];
            $list[] = $v['clouds']['all'];
            $list[] = $v['dt'];
            fputcsv($csvfile, $list);
        }
        fclose($csvfile);

        $request = Request::createFromGlobals();

        $response = new Response(
            "successful",
            Response::HTTP_OK,
            array('Content-Type' => 'text/plain')
        );

        $response->send();
   }

}

 ?>
