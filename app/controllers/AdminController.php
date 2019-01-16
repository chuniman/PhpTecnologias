<?php

namespace App\Controllers;

use Zend\Diactoros\Response\RedirectResponse;

class AdminController extends BaseController {

    public function AdminView() {

        $sessionName = $_SESSION['userName'] ?? NULL;

        if (!$sessionName) {
            return new RedirectResponse('/cursoPHP/login/');
        } else {
            return $this->renderHTML('admin.twig');
        }
    }

}
