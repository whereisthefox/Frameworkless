<?php

return [
    ['GET', '/', ['Frameworkless\Controllers\IndexController', 'index']],
    ['GET', '/exception', ['Frameworkless\Controllers\IndexController', 'exception']],
    ['GET', '/greet/{name}', ['Frameworkless\Controllers\GreetController', 'greet']],
    ['POST', '/api', ['Frameworkless\Controllers\ApiController', 'getData']],
    ['GET', '/test-api', ['Frameworkless\Controllers\ApiController', 'sendData']],
    ['GET', '/export', ['Frameworkless\Controllers\ApiController', 'tomyCSV']],
];
