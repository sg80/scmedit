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
	
	<p>Your TV model: <?=$scmFile->getModelName();?> (Series <?=$scmFile->getSeriesNumber()?>)</p>
	
	<div class="download">
		<a id="download-warning" href="#">apply changes and download .scm-file</a>
		<a id="download" href="#">no warranty &dash; use at your own risk &dash; click again to agree</a>
	</div>
	
	<div class="lists-container">
		<table class="channel-list">
			<? foreach ($channelFiles as $medium => $channelFile) { ?>
				<? foreach($channelFile->getChannelCollection() as $channel) { ?>
					<tr class="channel" data-type="<?=$medium?>" data-index="<?=$channel->getIndex()?>">
						<td class="medium-type"><div class="medium-type medium-type-<?=strtolower($medium)?>"><span class="invisible"><?=$medium?></span></div>
						<td class="index"><?=$channel->getIndex()?></td>
						<td class="service-type"><div class="service-type service-type-<?=$channel->getServiceType()?>"><span class="invisible"><?=$channel->getServiceTypeName()?></span></td>
						<td class="logo logo-<?=$channel->getNormalizedName()?>"></td>
						<td class="name"><?=utf8_encode($channel->getName())?></td>
						<td class="options">
							<a class="delete" href="#" title="double-click"><span class="invisible">delete</span></a>
						</td>
					</tr>
				<? } ?>
			<? } ?>
		</table>
	</div>
<? } ?>