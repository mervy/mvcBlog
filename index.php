<?php

session_start();
ini_set('display_errors', 1);

define('CONTROLLERS', 'app/controllers/');
define('VIEWS', 'app/views/');
define('MODELS', 'app/models/');
define('HELPERS', 'system/helpers/');

require_once 'system/system.php';
require_once 'system/controller.php';
require_once 'system/model.php';

spl_autoload_register(function ($class) {
    if (file_exists(MODELS.$class.'.php')) {
        require_once MODELS.$class.'.php';
    } elseif (file_exists(HELPERS.$class.'.php')) {
        require_once HELPERS.$class.'.php';
    } else {
        die("<b>$class</b>  - Model ou Helper nao encontrado.");
    }
});

$start = new System();
$start->run();
