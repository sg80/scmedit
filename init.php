<?php

error_reporting(E_ALL);
ini_set("display_errors", "on");

if (-1 == version_compare(phpversion(), '5.2.0')) {
	throw new Exception("A newer version of PHP is required.");
}

// Timezone
date_default_timezone_set("Europe/Berlin");

// Autoload
set_include_path(get_include_path() . PATH_SEPARATOR . "classes");
spl_autoload_extensions('.class.php');
spl_autoload_register();