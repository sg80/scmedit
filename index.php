<?php

include_once __DIR__ . "/init.php";

$scmFileName = "channel_list_UE46D8000_1101.scm";
$channelFile = new ChannelFile($scmFileName);
$channelCollection = $channelFile->getChannelCollection();

$content = "channellist";
include __DIR__ . "/view/main.php";