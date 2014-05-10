<pre><?php

if (-1 == version_compare(phpversion(), '5.2.0')) {
	throw new Exception("A newer version of PHP is required.");
}

define('CLASS_DIR', 'classes/');
set_include_path(get_include_path() . PATH_SEPARATOR . CLASS_DIR);
spl_autoload_extensions('.class.php');
spl_autoload_register();

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