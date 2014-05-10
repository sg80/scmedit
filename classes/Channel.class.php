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
	//abstract public function setName($name);
	abstract public function getServiceType();

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

	public function getServiceTypeName() {
		$typeMap = array(
			0 => "-",
			1 => "SD",
			2 => "Radio",
			25 => "HD"
		);

		return $typeMap[$this->getServiceType()];
	}

	/**
	 * Normalizes the channel-name to enable the
	 * association to a file.
	 */
	public function getLogoFileName() {
		$name = $this->getName();
		$name = strtolower($name);
		$name = preg_replace("/[^a-z0-9]/", "", $name);
		$name = str_replace(array("television", "hd"), array("", ""), $name);

		return $name;
	}
}