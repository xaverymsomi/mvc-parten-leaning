<?php
/*
 * This file is part of the Abc package.
 *
 * This source code is for educational purposes only. 
 * It is not recommended using it in production as it is.
 */

declare(strict_types = 1);

/**
 * Load the composer autoloader library which enables us to bootstrap the application
 * and initialize the necessary components.
 */

use Abc\Base\App;
use Abc\Utility\Log;
use Abc\Utility\ErrorHandler;

require_once 'include.php';
//print_r(phpversion());

error_reporting(E_ALL);
set_error_handler(APP['error_handler']);
set_exception_handler(APP['exception_handler']);

session_start();

function getRequestData(): array
{
    $data = [];
    $files = [];

    if ($_FILES) {
        $files = $_FILES;
        $data = $_POST;
    } else {
        $data = file_get_contents('php://input');
    }

    return [
        'data' => $data, 'files' => $files
    ];
}

Log::$request_number = hrtime(true);

Log::write("*********************************************************************************************************************************\n\n", 'plain');
Log::write('REQUEST-STARTED');

$url = $_SERVER['QUERY_STRING'] ?? $_SERVER['REQUEST_URI'];

if (strpos($url, '.ico') || strpos($url, '.png') || strpos($url, '.jpg') || strpos($url, '.css') || strpos($url, '.js')) {
    Log::write('Invalid URL: ' . $url, WARNING_LOG);
    Log::write('REQUEST-TERMINATED');
    exit;
}

Log::write('REQUEST-URL: ' . $url);
Log::write('REQUEST-CONTENT-TYPE: ' . (array_key_exists('CONTENT_TYPE', $_SERVER) ? $_SERVER['CONTENT_TYPE'] : null));
Log::write('REQUEST-DATA: ' . json_encode(getRequestData()));

try {
    new App();
} catch (Exception $e) {
    ErrorHandler::exceptionHandler($e, CRITICAL_LOG);
}

Log::write('REQUEST-ENDED');