<?php

class ScmFile1201 extends ScmFile {
	protected function initChannelFiles() {
		$this->channelFiles = [
			"Cable" => new CableChannelFile320($this, "map-CableD"),
//			"Air" => new CableChannelFile320($this, "map-AirD"),
//			"Sat" => new SatChannelFile168($this, "map-SateD")
		];
	}
}