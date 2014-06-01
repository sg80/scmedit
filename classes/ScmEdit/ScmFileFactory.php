<?php

namespace ScmEdit;

class ScmFileFactory {
	public static function getScmFile(ChannelCollectionFactory $channelCollectionFactory, ChannelFactory $channelFactory, $filePath) {
		if (!is_readable($filePath)) {
			throw new FileUnreadableException("Input file '{$filePath}' is not readable.");
		}
		
		$zip = new \ZipArchive();
		$zip->open($filePath);

		$seriesNumberReader = new SeriesNumberReader($zip);
		$seriesNumber = $seriesNumberReader->getSeriesNumber();

		$scmFileClassName = "ScmEdit\\ScmFile{$seriesNumber}";

		$scmFile = new $scmFileClassName($channelCollectionFactory, $channelFactory, $zip);

		return $scmFile;
	}
}