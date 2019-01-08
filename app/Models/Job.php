<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;
class Job extends Model{

    protected $title;
    protected $description;
    protected $visible;
    protected $months;

    function getTitle() {
        return $this->title;
    }

    function getDescription() {
        return $this->description;
    }

    function getVisible() {
        return $this->visible;
    }

    function getMonths() {
        return $this->months;
    }

    function setTitle($title) {
        $this->title = $title;
    }

    function setDescription($description) {
        $this->description = $description;
    }

    function setVisible($visible) {
        $this->visible = $visible;
    }

    function setMonths($months) {
        $this->months = $months;
    }

    function __construct() {
      
    }
//    function __construct($tit,$desc,$vis,$mon) {
//        $this->title=$tit;
//        $this->description=$desc;
//        $this->visible=$vis;
//        $this->months=$mon;        
//    }


}
