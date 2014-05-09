<?php

include_once __DIR__ . "/Channel.class.php";

class ChannelCollection implements Iterator {
	private $channels = array();
	private $position = 0;

	public function add(Channel $channel) {
		if (empty($channel->getIndex())) return;
		$this->channels[] = $channel;
	}

	public function remove($index) {
		for ($i = 0; $i < count($this->channels); $i++) {
			if ($this->channels[$i]->getIndex() == $index) {
				array_splice($this->channels, $i, 1);
			}
		}
	}

	public function getBytes() {
		$akku = "";
		$count = 0;

		foreach ($this as $channel) {
			$akku .= $channel->getBytes();
			$count++;
		}

		if ($count % 1000 > 0) {
			$missing = 1000 * (1 + $count - ($count % 1000)) - $count;
			$akku .= str_repeat(chr(0), $missing * CableChannel::BYTE_COUNT);
		}

		return $akku;
	}

	public function current() {
		return $this->channels[$this->position];
	}

	public function key() {
		return $this->position;
	}

	public function next() {
		$this->position++;
	}

	public function valid() {
		return isset($this->channels[$this->position]);
	}

	public function rewind() {
		$this->position = 0;
	}
}