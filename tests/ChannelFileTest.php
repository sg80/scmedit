<?php

class ChannelFileTest extends PHPUnit_Framework_TestCase {
	public function setUp() {
	}
	
	public function testReadWriteChannels() {
		$bytes = str_repeat("a", 42 * ScmEdit\CableChannelFile320::DATASET_SIZE);
		
		$zipArchive = $this->getMock("\ZipArchive");
		
		$zipArchive->expects($this->once())
			->method("getFromName")
			->will($this->returnValue($bytes));
		
		$zipArchive->expects($this->once())
			->method("addFromString");
		
		$scmFile = $this->getMockBuilder("ScmEdit\ScmFile1201")
			->disableOriginalConstructor()
			->getMock();
		
		$scmFile->expects($this->exactly(2))
			->method("getZipArchive")
			->will($this->returnValue($zipArchive));
		
		$channel = $this->getMockBuilder("ScmEdit\Channel")
			->disableOriginalConstructor()
			->getMock();
		
		$channelCollection = $this->getMock("ScmEdit\ChannelCollection");
		$channelCollection->expects($this->exactly(42))
			->method("add");
		
		$channelCollectionFactory = $this->getMock("ScmEdit\ChannelCollectionFactory");
		$channelCollectionFactory->expects($this->once())
			->method("getNewChannelCollection")
			->will($this->returnValue($channelCollection));
		
		$channelFactory = $this->getMock("ScmEdit\ChannelFactory");
		$channelFactory->expects($this->exactly(42))
			->method("getNewChannel")
			->will($this->returnValue($channel));
		
		$channelFile = new ScmEdit\CableChannelFile320($channelCollectionFactory, $channelFactory, $scmFile, "mychannelfilename");
		
		$channelFile->writeChannels();
	}
}