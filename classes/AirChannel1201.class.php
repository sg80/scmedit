<?php

class AirChannel1201 extends AirChannel {
	const BYTE_COUNT = 320;
	const MAP_FILE_NAME = "map-AirD";

	public function getIndex() {
		if (empty($this->index)) $this->index = unpack("v", $this->getRawBytes(0, 1))[1];
		return $this->index;
	}

	public function setIndex($index) {
		$this->overwriteBytes(0, pack("v", $index));
		$this->index = $index;
	}

	public function getName() {
		return trim($this->getRawBytes(64, 263));
	}

	public function getServiceType() {
		return unpack("C", $this->bytes[15])[1];
	}
}