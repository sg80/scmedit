<?php

class FileOutputterTest extends PHPUnit_Framework_TestCase {
    /**
     * @runInSeparateProcess
     */
	public function testOutput() {
		ob_start();
		$fo = new ScmEdit\FileOutputter();
		$fo->output(__FILE__, false);
	}
	
	/**
	 * @expectedException ScmEdit\FileUnreadableException
	 */
	public function testOutputFail() {
		$fo = new ScmEdit\FileOutputter();
		$fo->output("foobar", false);
	}
}