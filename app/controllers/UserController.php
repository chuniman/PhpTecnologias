<?php

namespace App\Controllers;

use App\Models\User;
use Respect\Validation\Validator as v;

class UserController extends BaseController {

    public function AddUserView($request) {
        return $this->renderHTML('addUser.twig');
    }

    public function AddUserAction($request) {
        $responseMessage = null;

        $postData = $request->getParsedBody();

        //valida campos no vacios
        $userValidator = v::key('email-user', v::stringType()->notEmpty())->key('name-user', v::stringType()->notEmpty());

        //valida las direcciones email
        $emailValidator = v::email();

        try {
            //validador
            $userValidator->assert($postData);

            //valida emails
            $emailValidator->assert($postData['email-user']);

            //seccion user
            $user = new User();

            $user->email = $postData['email-user'];
            $user->name = $postData['name-user'];
            $user->password = password_hash($postData['password-user'], PASSWORD_BCRYPT);

            $user->save();
            $responseMessage = 'Saved';
        } catch (\Exception $exc) {
            $responseMessage = $exc->getMessage();
        }
        return $this->renderHTML('addUser.twig',['responseMessage'=>$responseMessage]);
    }

}
