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
		// build sorting-data from table
		var sortingData = new Array();
		
		var types = getChannelTypes();
		
		$.each(getChannelTypes(), function(index, channelType) {
			var indexOrder = new Array();
			
			$('tr.channel[data-type="' + channelType + '"]').each(function() {
				indexOrder.push($(this).data('index'));
			});
			
			sortingData.push({
				"type": channelType,
				"indexOrder": indexOrder
			});
		});
		
		console.log(sortingData);

		// send sorting-data to server-side script
		var address = "updatescm.php?sortingdata=" + encodeURI(JSON.stringify(sortingData));
		location.href = address; // @todo found no working way of sending it by POST instead of GET

		$(this).hide();
		$('#download-warning').show();
		$(this).parent().removeClass('warning');

		return false;
	});
});

function getChannelTypes() {
	var channelTypes = new Array();
	
	$('tr.channel[data-type]').each(function() {
		channelTypes.push($(this).data('type'));
	});
	
	return makeUnique(channelTypes);
}

function makeUnique(arr) {
	var unique = arr.filter(function(item, i, a) {
	    return i == a.indexOf(item);
	});
	
	return unique;
}

function renumberChannels() {
	var i = 1;

	$('.channel-list .index').each(function() {
		$(this).text(i++);
	});
}