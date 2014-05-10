<?php

// Source of file format definition: http://preamp.org/revenge/scm-dateiformat-samsung-programmlisten

class CableChannel extends Channel { // @todo implement differences between series (this one is for 1101: D-Series)
	const BYTE_COUNT = 320;

	public function getIndex() {
		if (empty($this->index)) $this->index = unpack("v", $this->concatRawBytes(0, 1))[1];
		return $this->index;
	}

	public function setIndex($index) {
		$this->overwriteBytes(0, pack("v", $index));
		$this->index = getIndex();
	}

	public function getName() {
		return $this->concatRawBytes(64, 263);
	}

	public function setName($name) {
		if (strlen($name) < 200) $name = $name . str_repeat(chr(0), 200 - strlen($name));
		if (strlen($name) > 200) $name = substr($name, 0, 200);
		$this->overwriteBytes(64, $name);
	}

	public function getServiceType() {
		return unpack("C", $this->bytes[15])[1];
	}
}