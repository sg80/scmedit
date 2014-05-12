<?php
$scmFile = new ScmFile($_SESSION['uploadedScmPath']);
$collections = $scmFile->getAllCollections();
?>

<script type="text/javascript">
	$(function() {
		$('.channel-list tr').tsort({attr: 'data-index'});
		$('.channel-list').tableDnD({
			onDragClass: 'dragging',
			onDrop: function(table, row) {
				renumberChannels();
			}
		});

		$('.delete').on('click', function() {
			return false;
		});

		$('.delete').on('dblclick', function() {
			$(this).parentsUntil('tr').parent().fadeOut(function() {
				$(this).remove();
				renumberChannels();
			});
			return false;
		});

		$('#download-warning').on('click', function() {
			$('#download').show();
			$(this).hide();
			$(this).parent().addClass('warning');

			return false;
		});

		$('#download').on('click', function() {
			// build sorting-data from tables
			var sortingData = new Array();

			$('table[data-type]').each(function() {
				var indexOrder = new Array();
				var type = $(this).data('type');
				$(this).find('tr.channel').each(function() {
					indexOrder.push($(this).data('index'));
				});
				sortingData.push({
					"type": type,
					"indexOrder": indexOrder
				});
			});

			// send sorting-data to server-side script
			location.href = "updatescm.php?sortingdata=" + encodeURI(JSON.stringify(sortingData)); // found no working way of sending it by POST instead of GET

			$(this).hide();
			$('#download-warning').show();
			$(this).parent().removeClass('warning');

			return false;
		});
	});

	function renumberChannels() {
		var i = 1;

		$('.channel-list .index').each(function() {
			$(this).text(i++);
		});
	}
</script>

<div class="download">
	<a id="download-warning" href="#">apply changes and download .scm-file</a>
	<a id="download" href="#">no warranty &dash; use at own risk &dash; now click again</a>
</div>

<div class="lists-container">
	<? foreach ($collections as $collectionName => $channelCollection) { ?>
		<table class="channel-list" data-type="<?=$collectionName?>">
			<tr class="nodrag">
				<th colspan="5"><?=$collectionName?></th>
			</tr>
			<? if ($channelCollection->isEmpty()) { ?>
				<tr class="nodrag">
					<td colspan="5"><div class="empty-list"><span class="invisible">no channels found</span></div></td>
				</tr>
			<? } ?>
			<? foreach($channelCollection as $channel) { ?>
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