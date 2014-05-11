<?php

class SatChannel1101 extends CableChannel {
	const BYTE_COUNT = 172;
	const MAP_FILE_NAME = "map-SateD";

	public function getIndex() {
		if (empty($this->index)) $this->index = unpack("v", $this->getRawBytes(0, 1))[1];
		return $this->index;
	}

	public function setIndex($index) {
		$this->overwriteBytes(0, pack("v", $index));
		$this->index = getIndex();
	}

	public function getName() {
		return trim($this->getRawBytes(36, 135));
	}

	public function getServiceType() {
		return unpack("C", $this->bytes[14])[1];
	}
}