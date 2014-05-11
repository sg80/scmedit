<?php

class ScmFile {
	const SERIES_NUMBER_AUTODETECT = -1;

	private $seriesNumber;
	private $scmFilePath;
	private $channelTypes = array("Cable", "Sat", "Air");

	public function __construct($scmFilePath, $seriesNumber = self::SERIES_NUMBER_AUTODETECT) {
		$this->scmFilePath = $scmFilePath;

		if ($seriesNumber == self::SERIES_NUMBER_AUTODETECT) {
			$matches = null;
			$returnValue = preg_match("/_([0-9]{4})\\.scm/i", $scmFilePath, $matches);

			if ($returnValue != 1) {
				throw new Exception("Autodetection of series-number for file '{$scmFilePath}' failed.");
			}

			$this->seriesNumber = $matches[1];
		} else {
			$this->seriesNumber = $seriesNumber;
		}

		if (!in_array($this->seriesNumber, array("1101"))) {
			throw new Exception("Unknown series number '{$this->seriesNumber}'.");
		}
	}

	public function getChannelCollection($channelType) {
		if (!in_array($channelType, $this->channelTypes)) {
			throw new Exception("Unknown channel type '{$channelType}'.");
		}

		$channelFile = new ChannelFile($this->scmFilePath, $channelType, $this->seriesNumber);
		$channelCollection = $channelFile->getChannelCollection();

		return $channelCollection;
	}

	public function getAllCollections() {
		$collections = array();

		foreach ($this->channelTypes as $channelType) {
			$collections[$channelType] = $this->getChannelCollection($channelType);
		}

		return $collections;
	}
}