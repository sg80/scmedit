<?php
include_once __DIR__ . "/init.php";

$uploadDir = __DIR__ . "/uploads";

if (empty($_FILES)) {
	throw new Exception("Upload-script called but there are no files to upload.");
}

if (!is_writable($uploadDir)) {
	throw new Exception("Upload-dir '{$uploadDir}' is not writable.");
}

$targetDir = $uploadDir . "/" . session_id();
mkdir($targetDir);

$targetFile = preg_replace("/[^A-Za-z0-9_\.]/", "", $_FILES['file']['name']);
$targetPath =  $targetDir . "/" . $targetFile;

$_SESSION['uploadedScmPath'] = $targetPath;

move_uploaded_file($_FILES['file']['tmp_name'], $targetPath);