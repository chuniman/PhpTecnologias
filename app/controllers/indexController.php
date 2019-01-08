<?php

namespace App\Controllers;

use App\Models\Job;

class IndexController {

    public function indexAction() {
        $jobs = Job::all();

        //require_once ('mostrarJobs.php');


        $name = 'Hector Benitez';
        $limitMonths = 2000;
        
        include '../views/index.php';
    }

}
