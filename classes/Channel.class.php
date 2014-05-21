<?php

class Channel {
	private $channelData = [];
	private $typeMap = [
		0 => "-",
		1 => "SD",
		2 => "Radio",
		25 => "HD"
	];


	public function __construct($unpackFormat, $bytes) {
		$this->channelData = unpack($unpackFormat, $bytes);

		// @todo validate checksum
	}

	public function getRawBytes($packFormat) {
		$params = array_values($this->channelData);
		array_unshift($params, $packFormat);

		$packed = substr(call_user_func_array("pack", $params), 0, -1);
		$checksum = $this->calculateChecksum($packed);
		$packed .= chr($checksum);

		return $packed;
	}

	private function calculateChecksum($bytes) {
		$splitBytes = str_split($bytes);
		$akku = 0;

		foreach ($splitBytes as $b) {
			$akku += ord($b);
		}

		return $akku % (0xFF + 1);
	}

	public function getIndex() {
		return $this->channelData['index'];
	}

	public function setIndex($index) {
		$this->channelData['index'] = $index;
	}

	public function getName() {
		return $this->channelData['name'];
	}

	public function setName($name) {
		$this->channelData['name'] = $name;
	}

	public function getNormalizedName() {
		$name = $this->getName();
		$name = strtolower($name);
		ini_set('mbstring.substitute_character', "none"); // remove illegal UTF-8-characters
  		$name = mb_convert_encoding($name, 'UTF-8', 'UTF-8');
		$name = iconv('UTF-8', 'ASCII//TRANSLIT', $name); // transliterate
		$name = preg_replace("/\(.*\)/", "", $name); // remove parts between braces (including braces)
		$name = preg_replace("/[^a-z0-9]/", "", $name); // remove any remaining odd characters
		$name = str_replace( // remove some tv-specific parts
			["television", "hd"],
			["", ""],
			$name
		);

		return trim($name);
	}

	public function getServiceType() {
		return $this->channelData['servicetype'];
	}

	public function getServiceTypeName() {
		return $this->typeMap[$this->getServiceType()];
	}

	public function setServiceType($serviceType) {
		$this->channelData['servicetype'] = $serviceType;
	}
}