<?php

class ScmFileFactory {
	public static function getScmFile($filePath) {
		$zip = new ZipArchive();
		$zip->open($filePath);

		$seriesNumberReader = new seriesNumberReader($zip);
		$seriesNumber = $seriesNumberReader->getSeriesNumber();

		$scmFileClassName = "ScmFile{$seriesNumber}";

		$scmFile = new $scmFileClassName($zip);

		return $scmFile;
	}
}