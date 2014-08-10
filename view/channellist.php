<?
try {
	$scmFile = ScmEdit\ScmFileFactory::getScmFile($container['channel_collection_factory'], $container['channel_factory'], $container['file_outputter'], $_SESSION['uploadedScmPath']);
	$channelFiles = $scmFile->getChannelFiles();
} catch (Exception $e) {
	$errorMessage = $e->getMessage();
}
?>

<? if (!empty($errorMessage)) { ?>
	<p class="error-message">An error occured: <?=$errorMessage?></p>
	<p>To retry, <a href="?">go back</a> and upload your file again.
<? } else { ?>
	<script type="text/javascript" src="js/scmedit_channellist.js"></script>
	
	<p>
		Your TV model:
		<? if (strlen($scmFile->getModelName()) > 0) { ?>
			 <a href="https://www.google.de/search?q=<?=urlencode($scmFile->getModelName());?>"><?=$scmFile->getModelName();?></a>
			 &dash;
		<? } ?>
		Series <?=$scmFile->getSeriesNumber()?>
	</p>
	
	<div class="download">
		<a id="download-warning" href="#"><div class="icon"></div>apply changes and download .scm-file</a>
		<a id="download" href="#"><div class="icon"></div>no warranty &dash; use at your own risk &dash; click again to agree</a>
	</div>
	
	<div class="lists-container">
		<? foreach ($channelFiles as $medium => $channelFile) { ?>
			<table class="channel-list" data-type="<?=$medium?>">
				<tr class="nodrag">
					<th colspan="5"><?=$medium?></th>
				</tr>
				<? foreach($channelFile->getChannelCollection() as $channel) { ?>
					<tr class="channel" data-index="<?=$channel->getIndex()?>">
						<td class="index"><?=$channel->getIndex()?></td>
						<td class="service-type"><div class="service-type service-type-<?=$channel->getServiceType()?>"><span class="invisible"><?=$channel->getServiceTypeName()?></span></td>
						<td class="logo logo-<?=$channel->getNormalizedName()?>"></td>
						<td class="name"><?=utf8_encode($channel->getName())?></td>
						<td class="options">
							<a class="delete" href="#" title="double-click"><span class="invisible">delete</span></a>
						</td>
					</tr>
				<? } ?>
			</table>
		<? } ?>
	</div>
<? } ?>