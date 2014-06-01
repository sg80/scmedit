<?php

namespace ScmEdit;

class UnpackFormatTranslator {
	
	/**
	 * Converts format-definition if unpack() to format definition of pack().
	 * Will work only if all parts are named (e.g. "/C1checksum" vs. "/C1").
	 */
	public function getPackFormat($unpackFormat) {
		return preg_replace('/([a-zA-Z@][0-9*]*)([^\\/]+)\\/?/u', '\\1', $unpackFormat);
	}
}