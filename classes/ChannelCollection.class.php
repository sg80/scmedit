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

	public function removeByIndex($index) {
		$i = $this->findChannelByIndex($index);
		array_splice($this->channels, $i, 1);
	}

	public function getByIndex($index) {
		$i = $this->findChannelByIndex($index);
		return $this->channels[$i];
	}

	public function reorder($reorderedIndexes) {
		foreach ($this->channels as $channel) {
			$sorting = array_flip($reorderedIndexes);

			if (!isset($sorting[$channel->getIndex()])) {
				$this->remove($channel->getIndex());
			} else {
				$channel->setIndex($sorting[$channel->getIndex()] + 1);
			}
		}
	}

	public function add(Channel $channel) {
		if (empty($channel->getIndex())) return;
		$this->channels[] = $channel;
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