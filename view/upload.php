<script type="text/javascript" src="js/dropzone.js"></script>

<script type="text/javascript">
	$(function() {
		$("#dnd-upload").dropzone({
			url: "upload.php",
			uploadMultiple: false,
			maxFiles: 1,
			maxFilesize: 1,
			clickable: false,
			acceptedFiles: '.scm',
			success: function(file) {
				location.href = "?page=channellist";
			},
			complete: function(file) {
				$('.upload-info').hide();
			},
			drop: function(file) {
				this.removeAllFiles();
			},
			dictInvalidFileType: "Only .scm-files are accepted."
		});
	});
</script>

<div class="upload">
	<div id="dnd-upload">
		<div class="upload-info">
			Drag &amp; drop your<br />.scm-file here to edit.
		</div>
	</div>
</div>