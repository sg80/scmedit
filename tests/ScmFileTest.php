<?php

class ScmFileTest extends PHPUnit_Framework_TestCase {
	private $zipArchive;
	private $channelCollection;
	private $channelCollectionFactory;
	private $channel;
	private $fileOutputter;
	
	public function setUp() {
		$this->zipArchive = $this->getMock("\ZipArchive");
		
		$this->channelCollection = $this->getMock("ScmEdit\ChannelCollection");
		
		$this->channelCollectionFactory = $this->getMock("ScmEdit\ChannelCollectionFactory");
		$this->channelCollectionFactory->expects($this->once())
			->method("getNewChannelCollection")
			->will($this->returnValue($this->channelCollection));
		
		$this->channel = $this->getMockBuilder("ScmEdit\Channel")
			->disableOriginalConstructor()
			->getMock();
		
		$this->channelFactory = $this->getMock("ScmEdit\ChannelFactory");
		$this->channelFactory->expects($this->any())
			->method("getNewChannel")
			->will($this->returnValue($this->channel));
	}
	
	public function testReorderChannelsAndOutput() {
		$fileOutputter = $this->getMock("ScmEdit\FileOutputter");
		$fileOutputter->expects($this->once())
			->method("output");
		
		$scmFile = new ScmEdit\ScmFile1201($this->channelCollectionFactory, $this->channelFactory, $fileOutputter, $this->zipArchive);
		$scmFile->reorderChannelsAndOutput('[{"type":"Cable","indexOrder":[1,2,3]}]');
	}
	
	/**
	 * @expectedException ScmEdit\MalformedJSONException
	 */
	public function testReorderChannelsAndOutputFail() {
		$fileOutputter = $this->getMock("ScmEdit\FileOutputter");
		$fileOutputter->expects($this->never())
			->method("output");
		
		$scmFile = new ScmEdit\ScmFile1201($this->channelCollectionFactory, $this->channelFactory, $fileOutputter, $this->zipArchive);
		$scmFile->reorderChannelsAndOutput('foobar');
	}
}