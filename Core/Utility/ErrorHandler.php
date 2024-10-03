<?php
/*
 * This file is part of the Abc package.
 *
 * This source code is for educational purposes only. 
 * It is not recommended using it in production as it is.
 */

declare(strict_types = 1);

namespace Abc\Utility;

use ErrorException;
use Abc\Utility\Log;

class ErrorHandler
{
    private const ERROR_CODES = [404, 403];
    private const DEFAULT_ERROR_CODE = 500;

    public function __construct()
    {
        register_shutdown_function( function () {
            $error = error_get_last();
            if ($error) {
                $message = "Error [" . $error['type'] . "]: ";
                $message .= "Message: " . $error['message'] . " - ";
                $message .= "File: " . $error['file'] . " - ";
                $message .= "Line: " . $error['line'];

                Log::write($message, ERROR_LOG, new ErrorException($error['message'], -1, $error['type'], $error['file'], $error['line']));
            }
        });
    }

    public static function errorHandler($errno, $errstr, $errfile, $errline)
    {
        $message = "Code: " . $errno . "\n";
        $message .= "Message: " . $errstr . "\n";
        $message .= "File: " . $errfile . "\n";
        $message .= "Line: " . $errline;

        $data = 'An error was thrown: ' . $errfile . ' @ ' . $errline;

        Log::write($data, 'error', $message);
    }

    public static function exceptionHandler($exception, $log_type = EXCEPTION_LOG, $code = null)
    {
        if (!in_array($code, self::ERROR_CODES)) {
            $code = self::DEFAULT_ERROR_CODE;
        }

        $code = ($code == null) || ($code == '') ? 500 : $code;

        http_response_code($code);

        $message = "Uncaught exception: \n" . get_class($exception);
        $message .= "\nMessage: " . $exception->getMessage();
        $message .= "\nStack trace:\n" . $exception->getTraceAsString();
        $message .= "\nFile: " . $exception->getFile();
        $message .= "\nLine: " . $exception->getLine();

        Log::write('An exception was thrown: ' . $exception->getFile() . ' @ ' . $exception->getLine(), $log_type, $message);

        $content = self::errorContent($code, Log::$request_number);

        require_once TEMPLATE_PATH . 'error.php';
        exit;
    }

    private static function errorContent($code, $request_number): array
    {
        switch ($code) {
            case 404:
                return [
                    'title' => TITLE_404,
                    'header' => HEADER_404,
                    'message' => MSG_404,
                    'info' => INFO_404,
                ];
            case 403:
                return [
                    'title' => TITLE_403,
                    'header' => HEADER_403,
                    'message' => MSG_403,
                    'info' => INFO_403,
                ];
            default:
                return [
                    'title' => TITLE_500,
                    'header' => HEADER_500,
                    'message' => MSG_500,
                    'info' => INFO_500 . $request_number
                ];
        }
    }
}
