<?php

namespace ScmEdit;

abstract class ChannelFile {
	const DATASET_SIZE = 0;
	const UNPACK_FORMAT = "";

	protected $collection;
	protected $scmFile;
	private $channelCollectionFactory;
	private $channelFactory;
	private $fileName;

	public function __construct(ChannelCollectionFactory $channelCollectionFactory, ChannelFactory $channelFactory, ScmFile $scmFile, $fileName) {
		$this->scmFile = $scmFile;
		$this->fileName = $fileName;
		$this->channelCollectionFactory = $channelCollectionFactory;
		$this->channelFactory = $channelFactory;

		$this->readChannels();
	}

	protected function getPackFormat() {
		$pft = new UnpackFormatTranslator();
		
		return $pft->getPackFormat(static::UNPACK_FORMAT);
	}

	protected function getUnpackFormat() {
		return static::UNPACK_FORMAT;
	}

	private function getBytes() {
		$akku = "";
		$count = 0;
	
		foreach ($this->collection as $channel) { // @todo How to test \Iterable-interfaced in ChannelFileTest?
			$akku .= $channel->getRawBytes($this->getPackFormat());
			$count++;
		}

		$datasetMultiple = constant(get_class($this->scmFile) . "::DATASET_MULTIPLE");

		if ($count % $datasetMultiple > 0) {
			$missing = $datasetMultiple * (1 + $count - ($count % $datasetMultiple)) - $count;
			$akku .= str_repeat(chr(0), $missing * self::DATASET_SIZE);
		}
		
		return $akku;
	}

	public function getFileName() {
		return $this->fileName;
	}

	protected function readChannels() {
		$this->collection = $this->channelCollectionFactory->getNewChannelCollection();

		$bytes = $this->scmFile->getZipArchive()->getFromName($this->fileName);

		$i = 0;
		while ($i + static::DATASET_SIZE <= strlen($bytes)) {
			$channelBytes = substr($bytes, $i, static::DATASET_SIZE);
			$i += static::DATASET_SIZE;

			$channel = $this->channelFactory->getNewChannel($this->getUnpackFormat(), $channelBytes);
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