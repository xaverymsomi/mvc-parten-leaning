<?php
/*
 * This file is part of the Abc package.
 *
 * This source code is for educational purposes only. 
 * It is not recommended using it in production as it is.
 */

namespace Abc\Base;

use Abc\Utility\ErrorHandler;
use Exception;

class BaseView
{
    public static function render(string $template, array $data = [])
    {
        $file = ROOT_PATH . '/App/Views/' . $template;
        // echo $file;

        if (is_readable($file)) {
            require_once $file;
        } else {
            ErrorHandler::exceptionHandler(new Exception("$file not found"));
        }
    }

    public static function template(string $template, array $data = [])
    {
        $file = ROOT_PATH . '/App/Views/_templates/' . $template;
//        echo $file;

        if (is_readable($file)) {
            require_once $file;
        } else {
            ErrorHandler::exceptionHandler(new Exception("$file not found"));
        }
    }
}
