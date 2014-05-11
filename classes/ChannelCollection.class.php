<?php

class ChannelCollection implements Iterator {
	private $channels = array();
	private $position = 0;

	private function findChannelByIndex($index) {
		for ($i = 0; $i < count($this->channels); $i++) {
			if ($this->channels[$i]->getIndex() == $index) {
				return $i;
			}
		}

		throw new Exception("Channel '{$index}' could not be found.");
	}

	public function add(Channel $channel) {
		if (empty($channel->getIndex())) return;
		$this->channels[] = $channel;
	}

	public function remove($index) {
		$i = $this->findChannelByIndex($index);
		array_splice($this->channels, $i, 1);
	}

	public function getByIndex($index) {
		$i = $this->findChannelByIndex($index);
		return $this->channels[$i];
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
			$akku .= str_repeat(chr(0), $missing * CableChannel1101::BYTE_COUNT); // @todo implement for sat and air also
		}

		return $akku;
	}

	public function isEmpty() {
		return empty($this->channels);
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