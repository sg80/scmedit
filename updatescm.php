<?php

include_once __DIR__ . "/init.php";

if (empty($_REQUEST['sortingdata'])) {
	$scmFile = ScmEdit\ScmFileFactory::getScmFile($container['channel_collection_factory'], $container['channel_factory'], $container['file_outputter'], $_SESSION['uploadedScmPath']);
	$scmFile->reorderChannelsAndOutput($_SESSION['sortingdata']);
} else {
	$_SESSION['sortingdata'] = $_REQUEST['sortingdata'];	
}