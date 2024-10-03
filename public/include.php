<?php
/*
 * This file is part of the Abc package.
 *
 * This source code is for educational purposes only. 
 * It is not recommended using it in production as it is.
 */

const DS = '/';

define('ROOT_PATH', realpath(dirname(__FILE__, 2)));

/**
 * Load the composer library
 */
$autoload = ROOT_PATH . '/vendor/autoload.php';
const CONFIG_PATH = ROOT_PATH . DS . 'config/';

if (is_file($autoload)) {
    require $autoload;
}

require_once CONFIG_PATH . 'AppConfig.php';
require_once CONFIG_PATH . 'SysConstants.php';
