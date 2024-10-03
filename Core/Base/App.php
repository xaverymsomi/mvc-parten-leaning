<?php
/*
 * This file is part of the Abc package.
 *
 * This source code is for educational purposes only. 
 * It is not recommended using it in production as it is.
 */

declare(strict_types = 1);

namespace Abc\Base;

use Abc\Utility\ErrorHandler;
use Abc\Utility\Log;
use Exception;

class App
{
    protected string $controller = 'home';
    protected string $controller_suffix = 'controller';
    protected string $method = 'index';

    public function __construct()
    {
        $this->run();
    }

    private function run()
    {
        // echo '<pre>';
        // print_r($_SERVER);
        $url = $this->parseUrl() ?? [];

        // echo 'URL: ';
        // print_r($url);

        $controller = !empty($url) ? ucfirst(strtolower($url[0])) : ucfirst(strtolower($this->controller));
        $controller_with_namespace = 'App\\Controllers\\' . $controller . ucfirst(strtolower($this->controller_suffix));

        Log::write('Controller: ' . $controller);
        Log::write('Controller With Namespace: ' . $controller_with_namespace);

        if (!class_exists($controller_with_namespace)) {
            ErrorHandler::exceptionHandler(new Exception('Class ' . $controller . ' does not exist'), CRITICAL_LOG, 404);
        }
        
        Log::write('Controller exists');
        $controller_object = new $controller_with_namespace;
        // print_r($controller_object);

        Log::write('Controller object created. Searching for the method to be called...');

        $method = isset($url[1]) ? strtolower($url[1]) : strtolower($this->method);

        Log::write('Method: ' . $method);

        Log::write('Is ' . $controller . ucfirst(strtolower($this->controller_suffix)) . '@' . $method . ' callable?');

        if (is_callable([$controller_object, $method])) {
            Log::write('Yes. Calling it...');
            $controller_object->$method();
        } else {
            ErrorHandler::exceptionHandler(new Exception('Method ' . $method . ' NOT FOUND in ' . $controller . ucfirst(strtolower($this->controller_suffix))), CRITICAL_LOG, 404);
        }
    }

    protected function parseUrl()
    {
        Log::write('Parsing the URL');

        if (isset($_SERVER)) {
            $unclean_url = $_SERVER['QUERY_STRING'] ?? $_SERVER['REQUEST_URI'];

            if ($unclean_url) {
                return explode(DS, filter_var(rtrim($unclean_url, DS), FILTER_SANITIZE_URL));
            } else {
                Log::write('Both QUERY_STRING and REQUEST_URI variables were NOT found. How weird is that?', LOG_ALERT);
                return null;
            }
        } else {
            Log::write('The super global $_SERVER variable was NOT found. How weird is that?', LOG_ALERT);
            return null;
        }
    }
}