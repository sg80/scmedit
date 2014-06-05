<?php

namespace ScmEdit;

class ScmFile1101 extends ScmFile {
	const DATASET_MULTIPLE = 1000;
	
	protected function initChannelFiles() {
		$this->channelFiles = [
			"Cable" => new CableChannelFile320($this->channelCollectionFactory, $this->channelFactory, $this, "map-CableD"),
			"Air" => new AirChannelFile320($this->channelCollectionFactory, $this->channelFactory, $this, "map-AirD"),
			"Sat" => new SatChannelFile172($this->channelCollectionFactory, $this->channelFactory, $this, "map-SateD"),
		];
	}
}