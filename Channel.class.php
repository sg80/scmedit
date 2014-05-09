<?php

abstract class Channel {
	protected $bytes;
	protected $index;

	public function __construct($bytes) {
		$this->bytes = $bytes;

		$this->index = $this->getIndex();
	}

	abstract public function getIndex();
	abstract public function setIndex($index);
	abstract public function getName();
	abstract public function setName($name);
	abstract public function getType();

	public function getBytes() {
		return $this->bytes;
	}

	protected function overwriteBytes($start, $newBytes) {
		$akku = substr($this->bytes, 0, $start);
		$akku .= $newBytes;
		$akku .= substr($this->bytes, $start + strlen($newBytes), strlen($this->bytes) - strlen($newBytes));

		$this->bytes = $akku;
	}

	protected function concatRawBytes($from, $to) {
		$akku = "";

		for ($i = $from; $i <= $to; $i++) {
			$akku .= $this->bytes[$i];
		}

		return $akku;
	}

	public function getTypeMapped() {
		$typeMap = array(
			0 => "-",
			1 => "SD",
			2 => "Radio",
			25 => "HD"
		);

		return $typeMap[$this->getType()];
	}
}