<?php

namespace ScmEdit;

class ChannelFactory {
	public function getNewChannel($unpackFormat, $channelBytes) {
		return new Channel($unpackFormat, $channelBytes);
	}
}