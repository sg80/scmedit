<?php 

namespace ScmEdit;

class SatChannelFile144 extends ChannelFile {
	const DATASET_SIZE = 144;
	const UNPACK_FORMAT = "v1index/a12fill_1/C1servicetype/a22fill_2/a100name/a0short/a6fill_3/C1checksum";
}