<?php
// @todo refactor to proper classes

include_once __DIR__ . "/init.php";

$sortingData = json_decode($_REQUEST['sortingdata'], true);

//file_put_contents(__DIR__ . "/log.txt", print_r($sortingData, true)); // @todo remove after testing

$scmFile = ScmEdit\ScmFileFactory::getScmFile($container['channel_collection_factory'], $container['channel_factory'], $_SESSION['uploadedScmPath']);

foreach ($scmFile->getChannelFiles() as $type => $channelFile) {
	if ($type != "Cable") continue; // @todo remove

	$channelFile->getChannelCollection()->reorder($sortingData[0]['indexOrder']);
	$channelFile->writeChannels();
}

header("Pragma: public");
header("Cache-Control: must-revalidate");
header("Expires: Mon, 24 Mar 1980 12:00:00 CET");
header("Content-Type: application/octet-stream");
header("Content-Transfer-Encoding: Binary");
header("Content-Length: " . filesize($scmFile->getPath()));
header("Content-Disposition: attachment; filename=" . basename($scmFile->getPath()));

// output the result (by intent, I didn't use readfile() since this
// may cause problems depending on the server-configuration)

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