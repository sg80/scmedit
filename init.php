<?php

error_reporting(E_ALL);
ini_set("display_errors", "on");

if (-1 == version_compare(phpversion(), '5.4.0')) {
	throw new Exception("A newer version of PHP is required.");
}

// Timezone & Locale
date_default_timezone_set("Europe/Berlin");
setlocale(LC_CTYPE, 'en_US.UTF8');

// Composer-Autoloader
require_once __DIR__ . "/vendor/autoload.php";

// DI-Container
$container = new Pimple();
$container['channel_collection_factory'] = $container->share(function() {
	return new ScmEdit\ChannelCollectionFactory();
});
$container['channel_factory'] = $container->share(function() {
	return new ScmEdit\ChannelFactory();
});
$container['file_outputter'] = $container->share(function() {
	return new ScmEdit\FileOutputter();
});

// Session
session_start();