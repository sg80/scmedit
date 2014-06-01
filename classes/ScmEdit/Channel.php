<?php

namespace ScmEdit;

class Channel {
	const CHECKSUM_LENGTH = 1;
	const UNKNOWN_TYPE = 0;
	
	private $channelData = [];
	private $typeMap = [
		self::UNKNOWN_TYPE => "-",
		1 => "SD",
		2 => "Radio",
		25 => "HD"
	];


	public function __construct($unpackFormat, $bytes) {
		$this->channelData = unpack($unpackFormat, $bytes);
		
		$checksum = $this->calculateChecksum(substr($bytes, 0, -static::CHECKSUM_LENGTH));
		
		if ($this->getChecksum() != $checksum) {
			throw new InvalidChecksumException("Calculated checksum ({$checksum}) doesn't match stored checksum ({$this->getChecksum()})");
		}
	}

	public function getRawBytes($packFormat) {
		$params = array_values($this->channelData);
		array_unshift($params, $packFormat);

		$packed = substr(call_user_func_array("pack", $params), 0, -static::CHECKSUM_LENGTH);
		$checksum = $this->calculateChecksum($packed);
		$packed .= chr($checksum);

		return $packed;
	}

	private function calculateChecksum($bytesWithoutChecksum) {
		$splitBytes = str_split($bytesWithoutChecksum);
		$akku = 0;

		foreach ($splitBytes as $b) {
			$akku += ord($b);
		}

		return $akku % (0xFF + 1);
	}
	
	public function getChecksum() {
		return $this->channelData['checksum'];
	}

	public function getIndex() {
		return $this->channelData['index'];
	}

	public function setIndex($index) {
		$this->channelData['index'] = $index;
	}

	public function getName() {
		return trim($this->channelData['name']);
	}

	public function setName($name) {
		$this->channelData['name'] = $name;
	}

	public function getNormalizedName() {
		$name = $this->getName();
		$name = strtolower($name);
		ini_set('mbstring.substitute_character', "none"); // remove illegal UTF-8-characters
  		$name = mb_convert_encoding($name, 'UTF-8', 'UTF-8');
		// $name = iconv('UTF-8', 'ASCII//TRANSLIT', $name); // transliterate // @todo won't work
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
		if (!isset($this->typeMap[$this->getServiceType()])) {
			return $this->typeMap[static::UNKNOWN_TYPE];
		}
		return $this->typeMap[$this->getServiceType()];
	}

	public function setServiceType($serviceType) {
		$this->channelData['servicetype'] = $serviceType;
	}
}