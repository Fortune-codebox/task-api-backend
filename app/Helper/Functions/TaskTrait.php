<?php

namespace App\Helper\Functions;

use App\Response\TaskResponse;
// use App\Service\ApiHandler;

trait TaskTrait {

    protected function apiResponse($status_code = 0, $status, $data){
        if( !isset($data) || !isset($status)){
            return false;
        }
        if($status_code != 0)
            $res = new TaskResponse($status_code, $status, $data);
        else
            $res = new TaskResponse($status_code, $status, $data);
       return $res->send();
    }

    protected function getErrorMessages(\Illuminate\Contracts\Validation\Validator $validator){
        $messages =  $validator->errors()->getMessages();
        $replaced = str_replace(['[',']', '"', '.','id'], '', json_encode(array_values($messages)));
        return explode(',',$replaced);
    }


}
