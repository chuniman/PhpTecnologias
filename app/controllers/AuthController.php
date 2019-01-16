<?php

namespace App\Controllers;

use App\Models\User;
use Zend\Diactoros\Response\RedirectResponse;

class AuthController extends BaseController {

    public function LoginView() {
        return $this->renderHTML('login.twig');
    }

    public function LoginUser($request) {
        $postData = $request->getParsedBody();
        $responseMessage = '';

        $user = User::where('email', $postData['email-user'])->first();
        if ($user) {

            if (password_verify($postData['password-user'], $user->password)) {

                $_SESSION['userName'] = $user->name;
                return new RedirectResponse('/cursoPHP/admin/');
            } else {
                $responseMessage = 'Incorrect Data';
                return $this->renderHTML('login.twig', ['responseMessage' => $responseMessage]);
            }
        } else {
            $responseMessage = 'Incorrect Data';
            return $this->renderHTML('login.twig', ['responseMessage' => $responseMessage]);
        }
    }

    public function LogOut() {
        unset($_SESSION['userName']);
        return new RedirectResponse('/cursoPHP/login/');
    }

}
