<?php

include_once __DIR__ . "/init.php";

$sortingData = json_decode($_REQUEST['sortingdata'], true);

file_put_contents(__DIR__ . "/log.txt", print_r($sortingData, true)); // @todo remove after testing

$scmFile = new ScmFile($_SESSION['uploadedScmPath']);
$collections = $scmFile->getAllCollections();

foreach ($collections as $type => $collection) {
	if ($type != "Cable") continue; // @todo remove

	$collection->reorder($sortingData[0]['indexOrder']);
	$channelFile = new ChannelFile($scmFile->getPath(), $type, $scmFile->getSeriesNumber(), $collection);
	$channelFile->writeChannelsToFile();
}

header("Expires: 0");
header("Cache-Control: must-revalidate");
header("Pragma: public");
header("Content-Type: application/octet-stream");
header("Content-Transfer-Encoding: Binary");
header("Content-Length: " . filesize($scmFile->getPath()));
header("Content-Disposition: attachment; filename=" . basename($scmFile->getPath()));

$chunk = 8 * 1024;
$fh = fopen($scmFile->getPath(), "rb");

if ($fh === false) {
    throw new Exception("Unable to open file '{$scmFile->getPath()}'.");
}

while (!feof($fh)) {
    echo fread($fh, $chunk);
    ob_flush();
    flush();
}