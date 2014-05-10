<?php

class ChannelFile {
	private $channelCollection;
	private $scmFilePath;
	private $zip;
	private $channelFileName;

	public function __construct($scmFilePath) {
		$this->scmFilePath = $scmFilePath;
		$this->channelFileName = "map-CableD"; // @todo extend for sat and air

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
		$i = 0;

		$this->channelCollection = new ChannelCollection();

		while ($i + CableChannel::BYTE_COUNT <= strlen($allBytes)) { // @todo extend for sat and air
			$channelBytes = substr($allBytes, $i, CableChannel::BYTE_COUNT);
			$i += CableChannel::BYTE_COUNT;

			$this->channelCollection->add(new CableChannel($channelBytes));
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