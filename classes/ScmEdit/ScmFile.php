<?php

namespace ScmEdit;

abstract class ScmFile {
	const DATASET_COUNT_CEIL = 1000; ///< always store a multiple of this number of datasets to the file
	
	protected $channelCollectionFactory;
	protected $channelFactory;
	protected $channelFiles = [];
	protected $zipArchive;

	public function __construct(ChannelCollectionFactory $channelCollectionFactory, ChannelFactory $channelFactory, \ZipArchive $zipArchive) {
		$this->channelCollectionFactory = $channelCollectionFactory;
		$this->channelFactory = $channelFactory;
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
	
	protected abstract function initChannelFiles();
}