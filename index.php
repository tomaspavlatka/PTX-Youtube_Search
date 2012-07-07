<?php 
// Access.
define('GRAND_ACCESS',1);

// Zend Settings.
defined('APPLICATION_PATH') || define('APPLICATION_PATH', realpath(dirname(__FILE__)));
set_include_path(implode(PATH_SEPARATOR, array(realpath(APPLICATION_PATH . '/library'),get_include_path())));

// Required.
require_once './inc/functions.php';

// Build content.
require_once './inc/header.php';
require_once './inc/search_form.php';
require_once './inc/search_results.php';
require_once './inc/footer.php';