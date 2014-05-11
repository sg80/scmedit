<?php

class ChannelFile {
	private $channelCollection;
	private $scmFilePath;
	private $zip;
	private $channelFileName;
	private $channelClassName;

	public function __construct($scmFilePath, $channelType, $seriesNumber) {
		$this->channelClassName = "{$channelType}Channel{$seriesNumber}";
		$this->scmFilePath = $scmFilePath;

		$channelClassName = $this->channelClassName;
		$this->channelFileName = $channelClassName::MAP_FILE_NAME; // can't see why $this->channelClassName::... doesn't work

		$this->readChannels();
	}

	public function __destruct() {
		$this->zip->close();
	}

	private function readChannels() {
		$this->zip = new ZipArchive();
		$res = $this->zip->open($this->scmFilePath);

		if ($res !== TRUE) {
			throw new Exception("Unable to open zip-archive '{$this->scmFilePath}'.");
		}

		$allBytes = $this->zip->getFromName($this->channelFileName);
		// @todo check if size of allBytes is reasonable compared to multiples of 1000 * channelClassName::BYTE_COUNT

		$this->channelCollection = new ChannelCollection();

		$channelClassName = $this->channelClassName;

		$i = 0;
		while ($i + $channelClassName::BYTE_COUNT <= strlen($allBytes)) { // @todo extend for sat and air
			$channelBytes = substr($allBytes, $i, $channelClassName::BYTE_COUNT);
			$i += $channelClassName::BYTE_COUNT;

			$this->channelCollection->add(new $channelClassName($channelBytes));
		}
	}

	public function writeChannelsToFile() {
		$scmDir = dirname($this->scmFilePath);

		if (!is_writable($scmDir)) {
			throw new Exception("Can't write to directory '{$scmDir}'.");
		}

		if (!is_writable($this->scmFilePath)) {
			throw new Exception("Can't write to file '{$this->scmFilePath}'.");
		}

		$bytes = $this->channelCollection->getBytes();

		$success = $this->zip->addFromString($this->channelFileName, $bytes);
		
		if (!$success) {
			throw new Exception("Zip-archive '{$this->channelFileName}' could not be updated.");
		}

		$this->zip->close();

		$this->readChannels();
	}

	public function getChannelCollection() {
		return $this->channelCollection;
	}
}