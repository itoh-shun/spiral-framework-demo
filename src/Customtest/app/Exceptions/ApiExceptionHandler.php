<?php

namespace Customtest\Exceptions;

use Exception;
use framework\Exception\ExceptionHandler as BaseExceptionHandler;
use framework\Http\View;

class ApiExceptionHandler extends BaseExceptionHandler
{
    public $debug = false;

    public function render($request, Exception $exception)
    {
        $code = $exception->getCode();
        $message = $exception->getMessage();
        if($message){
            echo response()->json([] , $code , $message , '')->send();
            return;
        }
        echo response()->json([] , 404 , 'Not Found.' , '')->send();
        return;
    }
}
