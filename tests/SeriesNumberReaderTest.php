<?php

class SeriesNumberReaderTest extends PHPUnit_Framework_TestCase {
	public function testSuccess() {
		$bytes = chr(0xCC) . chr(0xCC) . chr(0x10) . chr(0x00);
		
		$zipArchive = $this->getMock("\ZipArchive");
		
		$zipArchive->expects($this->once())
			->method("getFromName")
			->will($this->returnValue($bytes));
		
		$seriesNumberReader = new ScmEdit\SeriesNumberReader($zipArchive);
		
		$this->assertEquals(1101, $seriesNumberReader->getSeriesNumber());
	}
	
	/**
	 * @expectedException ScmEdit\UnknownSeriesNumberException
	 */
	public function testFail() {
		$bytes = chr(0xAB) . chr(0xCD) . chr(0xEF) . chr(0x00);
		
		$zipArchive = $this->getMock("ZipArchive");
		
		$zipArchive->expects($this->once())
			->method("getFromName")
			->will($this->returnValue($bytes));
		
		$seriesNumberReader = new ScmEdit\SeriesNumberReader($zipArchive);
		
		$seriesNumberReader->getSeriesNumber();
	}
}