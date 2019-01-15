<?php

namespace App\Controllers;

use App\Models\Job;
use Respect\Validation\Validator as v;

class JobsController extends BaseController {

    public function AddJobAction($request) {
        $responseMessage = null;
        if ($request->getMethod() == 'POST') {

            $postData = $request->getParsedBody();
            
            var_dump($postData);

            $jobValidator = v::key('title-jobs', v::stringType()->notEmpty())->key('description-jobs', v::stringType()->notEmpty());

            try {
                //validador
                $jobValidator->assert($postData);
                //seccion job
                $job = new Job();

                $job->title = $postData['title-jobs'];
                $job->description = $postData['description-jobs'];
                $job->visible = $postData['visible-jobs'];
                $job->months = $postData['months-jobs'];
                
                //seccion archivo esta es la parte del archivo, anda por ahora te deja la imagen en la carpeta uploads
                //no es lo recomendable pero es un ejemplo de algo que anda
                //estaria para ahora hacer que los jobs tengan imagenes
                $files=$request->getUploadedFiles();
                $imagenNar=$files['file-jobs'];
                if ($imagenNar->getError()== \UPLOAD_ERR_OK){
                    $fileName=$imagenNar->getClientFilename();
                    $imagenNar->moveTo("uploads/$fileName");
                }
                $job->dirImagen="uploads/$fileName";
                $job->save();
                $responseMessage = 'Saved';
            } catch (\Exception $exc) {
                $responseMessage = $exc->getMessage();
            }
        }
        //include '../views/addJob.twig';
        return $this->renderHTML('addJob.twig',['responseMessage'=>$responseMessage]);
    }

}
