<?php
$scmPath = __DIR__ . "/../uploads/" . session_id() . "/my.scm";
$channelFile = new ChannelFile($scmPath);
$channelCollection = $channelFile->getChannelCollection();
?>

<script type="text/javascript">
	$(function() {
		$('.channel-list tr').tsort({attr: 'data-index'});
		$('.channel-list').tableDnD({
			onDragClass: 'dragging'
		});

		$('.delete').on('dblclick', function() {
			// @todo implement
			alert("Not yet implemented.");
			return false;
		});
	});
</script>

<div class="lists-container">
	<? for ($i = 0; $i < 1; $i++) { // idea is to show air, cable and sat-lists here ?>
	<table class="channel-list">
		<? foreach($channelCollection as $channel) { ?>
			<tr data-index="<?=$channel->getIndex()?>">
				<td class="index"><?=$channel->getIndex()?></td>
				<td class="service-type"><div class="service-type service-type-<?=$channel->getServiceType()?>"><span class="invisible"><?=$channel->getServiceTypeName()?></span></td>
				<td class="logo logo-<?=$channel->getLogoFileName()?>"></td>
				<td class="name"><?=utf8_encode($channel->getName())?></td>
				<td class="options">
					<a class="delete" href="#" title="double-click"><span class="invisible">delete</span></a>
				</td>
			</tr>
		<? } ?>
	</table>
	<? } ?>
</div>