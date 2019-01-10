<?php

namespace App\Controllers;

use \Twig_Loader_Filesystem;
//hay que poner ese use porque cree que twig esta en el namespace app\controllers

use Zend\Diactoros\Response\HtmlResponse;
class BaseController {

    protected $templateEngine;

    public function __construct() {
        $loader = new Twig_Loader_Filesystem('../views');
        $this->templateEngine = new \Twig_Environment($loader, [
            'debug'=>TRUE,
            'cache' => FALSE,
        ]);
    }
    
    public function renderHTML($fileName,$data=[]) {
        return new HtmlResponse( $this->templateEngine->render($fileName,$data));
    }

}
