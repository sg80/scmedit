<?php

abstract class ChannelFile {
	const DATASET_SIZE = 0;
	const UNPACK_FORMAT = "";

	protected $collection;
	protected $scmFile;
	private $fileName;

	public function __construct(ScmFile $scmFile, $fileName) {
		$this->scmFile = $scmFile;
		$this->fileName = $fileName;

		$this->readChannels();
	}

	/**
	 * Converts format-definition if unpack() to format definition of pack().
	 * Will work only if all parts are named (e.g. "/C1checksum" vs. "/C1").
	 */
	protected function getPackFormat() {
		return preg_replace('/([a-zA-Z@][0-9*]*)([^\\/]+)\\/?/u', '\\1', static::UNPACK_FORMAT);
	}

	protected function getUnpackFormat() {
		return static::UNPACK_FORMAT;
	}

	private function getBytes() {
		$akku = "";
		$count = 0;

		
		foreach ($this->collection as $channel) {
			$akku .= $channel->getRawBytes($this->getPackFormat());
			$count++;
		}

		$datasetCountCeil = 1000;// $this->scmFile::DATASET_COUNT_CEIL; // @todo read from instance

		if ($count % $datasetCountCeil > 0) {
			$missing = $datasetCountCeil * (1 + $count - ($count % $datasetCountCeil)) - $count;
			$akku .= str_repeat(chr(0), $missing * self::DATASET_SIZE);
		}
		
		return $akku;
	}

	public function getFileName() {
		return $this->fileName;
	}

	protected function readChannels() {
		$this->collection = new ChannelCollection();

		$bytes = $this->scmFile->getZipArchive()->getFromName($this->fileName);

		$i = 0;
		while ($i + static::DATASET_SIZE <= strlen($bytes)) {
			$channelBytes = substr($bytes, $i, static::DATASET_SIZE);
			$i += static::DATASET_SIZE;

			$channel = new Channel($this->getUnpackFormat(), $channelBytes);
			$this->collection->add($channel);
		}
	}

	public function writeChannels() {
		$this->scmFile->getZipArchive()->addFromString($this->fileName, $this->getBytes());
	}

	public function getChannelCollection() {
		return $this->collection;
	}
}