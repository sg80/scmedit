<?
$scmFile = ScmEdit\ScmFileFactory::getScmFile($container['channel_collection_factory'], $container['channel_factory'], $container['file_outputter'], $_SESSION['uploadedScmPath']);
$channelFiles = $scmFile->getChannelFiles();
?>

<script type="text/javascript" src="js/channellist.js"></script>

<div class="download">
	<a id="download-warning" href="#">apply changes and download .scm-file</a>
	<a id="download" href="#">no warranty &dash; use at own risk &dash; now click again</a>
</div>

<div class="lists-container">
	<? foreach ($channelFiles as $title => $channelFile) { ?>
		<table class="channel-list" data-type="<?=$title?>">
			<tr class="nodrag">
				<th colspan="5"><?=$title?></th>
			</tr>
			<? if ($channelFile->getChannelCollection()->isEmpty()) { ?>
				<tr class="nodrag">
					<td colspan="5"><div class="empty-list"><span class="invisible">no channels found</span></div></td>
				</tr>
			<? } ?>
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