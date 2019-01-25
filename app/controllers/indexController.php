<?php

namespace App\Controllers;

use App\Models\Job;

class IndexController extends BaseController{

    public function indexAction() {
        $jobs = Job::all();
        $name = 'Juan Ignacio Zunino';
        $limitMonths = 2000;
        
       // include '../views/index.php';
        return $this->renderHTML('index.twig', ['name'=>$name,'jobs'=>$jobs]);
    }

}
