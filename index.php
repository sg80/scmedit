<pre><?php

include_once __DIR__ . "/CableChannel.class.php"; // @todo implement autoloader
include_once __DIR__ . "/ChannelCollection.class.php";
include_once __DIR__ . "/ChannelFile.class.php";

if (-1 == version_compare(phpversion(), '5.2.0')) {
	throw new Exception("A newer version of PHP is required.");
}

$scmFileName = "channel_list_UE46D8000_1101.scm";

$cf = new ChannelFile($scmFileName);

foreach ($cf->getChannelCollection() as $c) {
	echo implode(", ", array($c->getIndex(), $c->getName(), $c->getServiceTypeMapped())) . "\n";
}

$channel = $cf->getChannelCollection()->getByIndex(14);
echo $channel->getName();
$channel->setName("my channel");
echo $channel->getName();

$cf->writeChannelsToFile(); // @todo updated info doesn't get saved to file