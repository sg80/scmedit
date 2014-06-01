<?php

class ChannelTest extends PHPUnit_Framework_TestCase {
	private $unpackFormat;
	private $packFormat;
	private $bytesWithoutChecksum;
	private $correctChecksum;
	private $stationName;
	
	public function setUp() {
		$this->unpackFormat = "v1index/a1fill_1/C1servicetype/a1fill_2/a200name/a1fill_3/C1checksum";
		$this->packFormat = "v1a1C1a1a200a1C1";
		$this->stationName = "My StŠtion HD";
		$this->bytesWithoutChecksum = chr(42) . chr(0) . "f" . chr(25) . "f" . utf8_decode($this->stationName . str_repeat(chr(0), 200 - strlen($this->stationName))) . "f";
		$this->correctChecksum = 199;
	}
	
	public function testRawBytes() {
		$bytes = $this->bytesWithoutChecksum . chr($this->correctChecksum);
		$channel = new ScmEdit\Channel($this->unpackFormat, $bytes);
		
		$channel->setServiceType(1);
		$channel->setName("abc");
		$rawBytes = $channel->getRawBytes($this->packFormat);
		
		$channel->setServiceType(25);
		$channel->setName(utf8_decode($this->stationName));
		$rawBytes = $channel->getRawBytes($this->packFormat);
		
		$this->assertEquals($bytes, $rawBytes);
	}
	
	public function testUnknownServiceType() {
		$bytes = $this->bytesWithoutChecksum . chr($this->correctChecksum);
		$channel = new ScmEdit\Channel($this->unpackFormat, $bytes);
		
		$channel->setServiceType(42);
		
		$this->assertEquals("-", $channel->getServiceTypeName());
	}
	
	public function testBasicDataReadout() {
		$bytes = $this->bytesWithoutChecksum . chr($this->correctChecksum);
		$channel = new ScmEdit\Channel($this->unpackFormat, $bytes);
		
		$this->assertEquals(utf8_decode("My StŠtion HD"), $channel->getName());
		$this->assertEquals(42, $channel->getIndex());
		$this->assertEquals(25, $channel->getServiceType());
		$this->assertEquals("HD", $channel->getServiceTypeName());
		$this->assertEquals(utf8_decode("mysttion"), $channel->getNormalizedName()); // @todo transliterate won't work
	}
	
	public function testGetSetIndex() {
		$bytes = $this->bytesWithoutChecksum . chr($this->correctChecksum);
		$channel = new ScmEdit\Channel($this->unpackFormat, $bytes);
		
		$channel->setIndex(24);
		
		$this->assertEquals(24, $channel->getIndex());
	}
	
	/**
	 * @expectedException ScmEdit\InvalidChecksumException
	 */
	public function testChecksumFail() {
		$bytes = $this->bytesWithoutChecksum . chr(42);
		$channel = new ScmEdit\Channel($this->unpackFormat, $bytes);
	}
}