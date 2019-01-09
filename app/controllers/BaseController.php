<?php

namespace App\Controllers;

use \Twig_Environment;
//hay que poner ese use porque cree que twig esta en el namespace app\controllers 
class BaseController {

    protected $templateEngine;

    public function __construct() {
        $loader = new Twig_Loader_Filesystem('../views');
        $this->templateEngine = new Twig_Environment($loader, [
            'debug'=>TRUE,
            'cache' => FALSE,
        ]);
    }
    
    public function renderHTML($fileName,$data) {
        return $this->templateEngine->render($fileName,$data);
    }

}
