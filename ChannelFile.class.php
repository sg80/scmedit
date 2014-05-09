<?php

include_once __DIR__ . "/ChannelCollection.class.php";
include_once __DIR__ . "/CableChannel.class.php";

class ChannelFile {
	private $channelCollection;
	private $scmFilePath;
	private $zip;

	public function __construct($scmFilePath) {
		$this->scmFilePath = $scmFilePath;

		$this->readChannels();
	}

	public function __destruct() {
		$this->zip->close();
	}

	private function readChannels() {
		$this->zip = new ZipArchive();
		$res = $this->zip->open($this->scmFilePath);

		if ($res !== TRUE) {
			throw new Exception("Unable to open ZIP file '{$scmFilePath}'.");
		}

		$cableFileName = "map-CableD";

		$allBytes = $this->zip->getFromName($cableFileName);
		$i = 0;
		
		$this->channelCollection = new ChannelCollection();

		while ($i + CableChannel::BYTE_COUNT <= strlen($allBytes)) {
			$channelBytes = substr($allBytes, $i, CableChannel::BYTE_COUNT);
			$i += CableChannel::BYTE_COUNT;

			$this->channelCollection->add(new CableChannel($channelBytes));
		}
	}

	public function getChannelCollection() {
		return $this->channelCollection;
	}
}