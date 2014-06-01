<?php

namespace ScmEdit;

class SeriesNumberReader {
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
		$actualSeriesNumberBytes = $this->zipArchive->getFromName("map-ChKey");

		$seriesNumber = array_search(bin2hex($actualSeriesNumberBytes), $this->seriesNumberBytes);

		if ($seriesNumber === FALSE) {
			throw new UnknownSeriesNumberException("Unknown version of file.");
		}

		return $seriesNumber;
	}
}