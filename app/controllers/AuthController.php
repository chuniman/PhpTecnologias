<?php

namespace App\Controllers;


class AuthController extends BaseController{
    public function LoginView() {
        return $this->renderHTML('login.twig');
    }
}