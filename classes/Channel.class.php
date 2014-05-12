<?php

/**
 * Source of file format definition:
 * http://preamp.org/revenge/scm-dateiformat-samsung-programmlisten
 */

abstract class Channel {
	const BYTE_COUNT = 0;
	const MAP_FILE_NAME = "";

	protected $bytes;
	protected $index;

	public function __construct($bytes) {
		$this->bytes = $bytes;

		$this->index = $this->getIndex();
	}

	abstract public function getIndex();
	abstract public function setIndex($index);
	abstract public function getName();
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

	protected function getRawBytes($from, $to) {
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
	public function getNormalizedName() {
		$name = $this->getName();
		$name = strtolower($name);
		ini_set('mbstring.substitute_character', "none"); // remove illegal UTF-8-characters
  		$name = mb_convert_encoding($name, 'UTF-8', 'UTF-8');
		$name = iconv('UTF-8', 'ASCII//TRANSLIT', $name); // transliterate
		$name = preg_replace("/\(.*\)/", "", $name); // remove parts between braces (including braces)
		$name = preg_replace("/[^a-z0-9]/", "", $name); // remove any remaining odd characters
		$name = str_replace( // remove some tv-specific parts
			array("television", "hd"),
			array("", ""),
			$name
		);

		return $name;
	}
}