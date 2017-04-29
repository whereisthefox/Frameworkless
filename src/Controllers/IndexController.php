<?php
namespace Frameworkless\Controllers;

use Exception;
use Symfony\Component\HttpFoundation\Response;
use Twig_Environment;

/**
 * Handles all requests to /.
 *
 * @author Michael Meyer <michael@meyer.io>
 */
class IndexController
{
    /** @var Twig_Environment */
    private $twig;

    /**
     * IndexController, constructed by the container
     *
     * @param Twig_Environment $twig
     */
    public function __construct(Twig_Environment $twig)
    {
        $this->twig = $twig;
    }

    /**
     * Index page
     *
     * @return Response
     */
    public function index()
    {
        $datafile = file_get_contents($_SERVER["DOCUMENT_ROOT"].'/data/json/datapoints.geojson');

        $response = new Response(
            $this->twig->render('pages/index.html.twig', [
                'mapbox_token' => getenv("MAPBOX"),
                'datapoints' => $datafile
            ])
        );
        return $response;
    }

    /**
     * Throw an exception (for testing the error handler)
     *
     * @throws Exception
     */
    public function exception()
    {
        throw new Exception('Test exception');
    }
}
