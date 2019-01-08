<?php

namespace App\Controllers;

use App\Models\Job;

class JobsController {

    public function AddJobAction($request) {
        if ($request->getMethod()=='POST') {
            
            $postData=$request->getParsedBody();
            $job = new Job();

            $job->title = $postData['title-jobs'];
            $job->description = $postData['description-jobs'];
            $job->visible = $postData['visible-jobs'];
            $job->months = $postData['months-jobs'];
            
            $job->save();
        }
        include '../views/addJob.php';
    }

}
