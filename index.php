<pre><?php

include_once __DIR__ . "/CableChannel.class.php";
include_once __DIR__ . "/ChannelCollection.class.php";

if (-1 == version_compare(phpversion(), '5.2.0')) {
	throw new Exception("Newer PHP-version required.");
}

$scmFileName = "channel_list_UE46D8000_1101.scm";
$tmpDirName = "tmp" . uniqid();

if (is_writable($tmpDirName)) {
	throw new Exception("Permissions for writing to '{$tmpDirName}' required.");
}

$succ = mkdir($tmpDirName);

if ($succ !== TRUE) {
	throw new Exception("Unable to create temporary directory '{$tmpDirName}'.");
}

$zip = new ZipArchive();
$res = $zip->open($scmFileName);

if ($res !== TRUE) {
	throw new Exception("Unable to open ZIP file '{$scmFileName}'.");
}

$zip->extractTo($tmpDirName);

$cableBlockSize = 320;

$filePath = $tmpDirName . "/" . "map-CableD";
$handle = fopen($filePath, "rb");

$cc = new ChannelCollection();

while ($raw = fread($handle, $cableBlockSize)) {
	$cableChannel = new CableChannel($raw);
	$cc->add($cableChannel);
}

foreach ($cc as $c) {
	echo implode(", ", array($c->getName(), $c->getTypeMapped())) . "\n";
}

fclose($handle);

$succ = $zip->addFromString("map-CableD", $cc->getBytes());
$zip->close();

delTree($tmpDirName);


function delTree($dir) {
	foreach(new RecursiveIteratorIterator(new RecursiveDirectoryIterator($dir, FilesystemIterator::SKIP_DOTS), RecursiveIteratorIterator::CHILD_FIRST) as $path) {
	    $path->isFile() ? unlink($path->getPathname()) : rmdir($path->getPathname());
	}
	rmdir($dir);
}

function concatRawBytes($arr, $from, $to) {
	$akku = "";

	for ($i = $from; $i <= $to; $i++) {
		$akku .= $arr[$i];
	}

	return $akku;
}