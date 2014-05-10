<?php
include_once __DIR__ . "/init.php";

$uploadDir = __DIR__ . "/uploads";

if (empty($_FILES)) {
	throw new Exception("Upload-script called but there are no files to upload.");
}

$targetDir = $uploadDir . "/" . session_id();
mkdir($targetDir);

$tempFile = $_FILES['file']['tmp_name'];
$targetFile =  $targetDir . "/my.scm";

$_SESSION['originalFileName'] = $_FILES['file']['name'];

move_uploaded_file($tempFile, $targetFile);