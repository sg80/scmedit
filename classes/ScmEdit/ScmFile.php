<?php

namespace ScmEdit;

abstract class ScmFile {
	const DATASET_COUNT_CEIL = 1000; ///< always store a multiple of this number of datasets to the file
	
	protected $channelCollectionFactory;
	protected $channelFactory;
	protected $channelFiles = [];
	protected $fileOutputter;
	protected $zipArchive;

	public function __construct(ChannelCollectionFactory $channelCollectionFactory, ChannelFactory $channelFactory, FileOutputter $fileOutputter, \ZipArchive $zipArchive) {
		$this->channelCollectionFactory = $channelCollectionFactory;
		$this->channelFactory = $channelFactory;
		$this->fileOutputter = $fileOutputter;
		$this->zipArchive = $zipArchive;
		$this->initChannelFiles();
	}

	public function getChannelFiles() {
		return $this->channelFiles;
	}

	public function getZipArchive() {
		return $this->zipArchive;
	}

	public function getPath() {
		return $this->zipArchive->filename;
	}
	
	public function reorderChannelsAndOutput($sortingDataRaw) {
		$sortingData = json_decode($sortingDataRaw, true);
		
		if (NULL === $sortingData) {
			throw new MalformedJSONException("JSON for sorting could not be decoded.");
		}
		
		foreach ($this->getChannelFiles() as $type => $channelFile) {
			if ($type != "Cable") continue; // @todo remove
		
			$channelFile->getChannelCollection()->reorder($sortingData[0]['indexOrder']);
			$channelFile->writeChannels();
		}
		
		$this->fileOutputter->output($this->getPath());
	}
	
	protected abstract function initChannelFiles();
}