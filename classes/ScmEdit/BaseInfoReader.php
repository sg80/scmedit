<?php

namespace ScmEdit;

class BaseInfoReader {
	const SERIES_NUMBER_FILENAME = "map-ChKey";
	const CLONE_INFO_FILENAME = "CloneInfo";
	const CLONE_INFO_UNPACK_FORMAT = "C3countrycode/a1fill_1/a*modelname";
	
	protected $zipArchive;
	private $seriesNumberBytes = [
		1001 => "2f460f00",
		1101 => "cccc1000",
		1201 => "6d531200"
	];

	public function __construct(\ZipArchive $zipArchive) {
		$this->zipArchive = $zipArchive;
	}

	public function getSeriesNumber() {
		$actualSeriesNumberBytes = $this->zipArchive->getFromName(static::SERIES_NUMBER_FILENAME);

		$seriesNumber = array_search(bin2hex($actualSeriesNumberBytes), $this->seriesNumberBytes);

		if ($seriesNumber === FALSE) {
			throw new UnknownSeriesNumberException("Unknown version of file.");
		}

		return $seriesNumber;
	}
	
	public function getModelName() {
		$bytes = $this->zipArchive->getFromName(static::CLONE_INFO_FILENAME);
		
		$info = unpack(static::CLONE_INFO_UNPACK_FORMAT, $bytes);
		
		return trim($info['modelname']);
	}
}