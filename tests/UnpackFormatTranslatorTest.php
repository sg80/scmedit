<?php

class UnpackFormatTranslatorTest extends PHPUnit_Framework_TestCase {
	private $packFormatTranslator;
	
	public function setUp() {
		$this->packFormatTranslator = new ScmEdit\UnpackFormatTranslator();
	}
	
	public function testGetPackFormat() {
		$unpackFormat = "C1foo/v3bar/Abaz";
		$packFormat = $this->packFormatTranslator->getPackFormat($unpackFormat);
		
		$this->assertEquals("C1v3A", $packFormat);
	}
}