<pre><?php

include_once __DIR__ . "/init.php";

$scmFileName = "channel_list_UE46D8000_1101.scm";

$cf = new ChannelFile($scmFileName);

foreach ($cf->getChannelCollection() as $c) {
	echo implode(", ", array($c->getIndex(), $c->getName(), $c->getServiceTypeMapped())) . "\n";
}

$channel = $cf->getChannelCollection()->getByIndex(14);
echo $channel->getName();
$channel->setName("my channel");
echo $channel->getName();

$cf->writeChannelsToFile();