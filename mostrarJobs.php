<?php

use App\Models\Job;

require_once 'vendor/autoload.php';

$jobs = Job::all();

function printJob($job) {   
    
    echo '<li>';
    echo '<h5> titulo: ' . $job->title . '</h5>';
    echo '<p> descripcion: ' . $job->description . '</p>';
    echo '<p> meses: ' . $job->months . '</p>';
    echo '<strong>Achievements:</strong>';
    echo '</li>';
  }