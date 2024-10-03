<?php
/*
 * This file is part of the Abc package.
 *
 * This source code is for educational purposes only. 
 * It is not recommended using it in production as it is.
 */

// write your own configuration in here

const DEFAULT_THEME = 'bootstrap';
const TAILWIND_THEME = 'tailwind';
const BOOTSTRAP_THEME = 'bootstrap';
const MDB_THEME = 'mdb';

const MY_THEME = BOOTSTRAP_THEME;

const TEMPLATE_PATH = ROOT_PATH . '/App/Views/_templates/';

const TEMPLATE_EXTENSION = '.php';
const LOG_EXTENSION = '.log';
const MODULE_NAMESPACE = '_Modules\\';
const MODEL_NAMESPACE = 'App\Models\\';
const CONTROLLER_NAMESPACE = 'App\Controllers\\';

const APP = [
    "debug_mode" => "dev",
    "error_handler" => "\\Abc\\Utility\\ErrorHandler::errorHandler",
    "exception_handler" => "\\Abc\\Utility\\ErrorHandler::exceptionHandler"
];

const RECORDS_PER_PAGE = 10;