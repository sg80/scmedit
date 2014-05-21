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
		var address = "updatescm.php?sortingdata=" + encodeURI(JSON.stringify(sortingData));
		location.href = address; // found no working way of sending it by POST instead of GET

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