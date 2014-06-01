<?php

namespace ScmEdit;

class ScmFile1201 extends ScmFile {
	protected function initChannelFiles() {
		$this->channelFiles = [
			"Cable" => new CableChannelFile320($this->channelCollectionFactory, $this->channelFactory, $this, "map-CableD"),
		];
	}
}