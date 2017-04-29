<?php
namespace Frameworkless\Controllers;

use Exception;
use Cloudinary/Cloudinary as Cloudinary;


/**
 *
 */
class ImageController
{
    \Cloudinary::config(array(
        "cloud_name" => getenv("CLOUD_NAME"),
        "api_key" => getenv("CLOUD_KEY"),
        "api_secret" => getenv("CLOUD_SECRET")
    ));

    function __construct(argument)
    {
        # code...
    }
}
 ?>
