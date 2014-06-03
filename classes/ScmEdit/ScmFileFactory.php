<?php

namespace ScmEdit;

class ScmFileFactory {
	public static function getScmFile(ChannelCollectionFactory $channelCollectionFactory, ChannelFactory $channelFactory, FileOutputter $fileOutputter, $filePath) {
		if (!is_readable($filePath)) {
			throw new FileUnreadableException("Input file '{$filePath}' is not readable.");
		}
		
		$zip = new \ZipArchive();
		$zip->open($filePath);

		$baseInfoReader = new BaseInfoReader($zip);
		$seriesNumber = $baseInfoReader->getSeriesNumber();

		$scmFileClassName = "ScmEdit\\ScmFile{$seriesNumber}";

		$scmFile = new $scmFileClassName($channelCollectionFactory, $channelFactory, $fileOutputter, $zip, $baseInfoReader);

		return $scmFile;
	}
}