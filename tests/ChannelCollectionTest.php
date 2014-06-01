<?php

class ChannelCollectionTest extends PHPUnit_Framework_TestCase {
	private $channelStub24;
	private $channelStub42;
	
	public function setUp() {
		$this->channelStub24 = $this->makeChannelStub(24);
		$this->channelStub42 = $this->makeChannelStub(42);
	}
	
	private function makeChannelStub($index) {
		$channelStub = $this->getMockBuilder("ScmEdit\Channel")
			->disableOriginalConstructor()
			->getMock();
			
		$channelStub
			->expects($this->any())
			->method("getIndex")
			->will($this->returnValue($index));
		
		return $channelStub;
	}
	
	public function testInterate() {
		$channelCollection = new ScmEdit\ChannelCollection();
		$channelCollection->add($this->channelStub42);
		$channelCollection->add($this->channelStub24);
		
		$count = 0;
		
		foreach ($channelCollection as $channel) {
			$count++;
		}
		
		$this->assertEquals(2, $channelCollection->key());
		
		$this->assertEquals(2, $count);
	}
	
	public function testAddRemoveChannel() {
		$channelCollection = new ScmEdit\ChannelCollection();
		$channelCollection->add($this->channelStub24);
		$channelCollection->add($this->channelStub42);

		$channelCollection->removeByIndex(24);
		
		$this->assertFalse($channelCollection->isEmpty());
		
		$channelCollection->removeByIndex(42);
		
		$this->assertTrue($channelCollection->isEmpty());
	}
	
	public function testAddGetChannel() {
		$channelCollection = new ScmEdit\ChannelCollection();
		$channelCollection->add($this->channelStub24);
		$channelCollection->add($this->channelStub42);
		
		$storedChannel = $channelCollection->getByIndex(42);
		
		$this->assertSame($this->channelStub42, $storedChannel);
	}
	
	public function testReorder() {
		$channelCollection = new ScmEdit\ChannelCollection();
		$channelCollection->add($this->channelStub42);
		$channelCollection->add($this->channelStub24);
		
		$this->channelStub24
			->expects($this->once())
			->method("setIndex")
			->with(1);
		
		$this->channelStub42
			->expects($this->once())
			->method("setIndex")
			->with(2);
		
		$channelCollection->reorder([0 => 24, 1 => 42]);
	}
	
	/**
	 * @expectedException ScmEdit\ChannelNotFoundException
	 */
	public function testReorderRemove() {
		$channelCollection = new ScmEdit\ChannelCollection();
		$channelCollection->add($this->channelStub42);
		$channelCollection->add($this->channelStub24);
	
		$this->channelStub24
			->expects($this->never())
			->method("setIndex");
	
		$this->channelStub42
			->expects($this->once())
			->method("setIndex")
			->with(1);
	
		$channelCollection->reorder([0 => 42]);
		
		$channelCollection->getByIndex(24);
	}
	
	/**
	 * @expectedException ScmEdit\ChannelNotFoundException
	 */
	public function testRemoveFail() {
		$channelCollection = new ScmEdit\ChannelCollection();
		$channelCollection->removeByIndex(42);
	}
}