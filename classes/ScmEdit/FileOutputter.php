<?php 

namespace ScmEdit;

class FileOutputter implements Outputtable {
	const CHUNK_SIZE = 8192;
	
	public function output($filePath, $actuallyDoOutput = true) {
		if (!is_readable($filePath)) {
			throw new FileUnreadableException("File {$filePath} is not readable.");
		}
		
		header("Pragma: public");
		header("Cache-Control: must-revalidate");
		header("Expires: Mon, 24 Mar 1980 12:00:00 CET");
		header("Content-Type: application/octet-stream");
		header("Content-Transfer-Encoding: Binary");
		header("Content-Length: " . filesize($filePath));
		header("Content-Disposition: attachment; filename=" . basename($filePath));
		
		// Output the result (by intent, I didn't use readfile() since this
		// may cause hard to find problems with large files depending on
		// the server-configuration).
		
		$fh = fopen($filePath, "rb");
		
		if ($fh === false) {
			throw new \RuntimeException("Unable to open file '{$filePath}'.");
		}
		
		while (!feof($fh)) {
			$bytes = fread($fh, static::CHUNK_SIZE);
			if ($actuallyDoOutput) echo $bytes;
			ob_flush();
			flush();
		}
	}
}