<!DOCTYPE html>
<html>
	<head>
		<title>Online .scm-editor</title>
		<link rel="stylesheet" href="style.css" />
		<link rel="stylesheet" href="stations.css" />
		<meta charset="utf-8" />
		<script type="text/javascript" src="http://code.jquery.com/jquery.min.js"></script>
		<script type="text/javascript" src="js/jquery.tablednd.js"></script>
		<script type="text/javascript" src="js/jquery.tinysort.min.js"></script>
	</head>
	<body>
		<div class="intro">
			<h1>Online .scm-editor</h1>
			<p>
				Use this platform-independent tool to comfortably modify your channel-list-files (.scm) of your <a href="http://de.wikipedia.org/wiki/Suwon">South Korean</a> TV set.
			</p>
			<p>
				Just <a href="http://youtu.be/31RjBg_mNrU?t=1m29s">export the channel list</a> from your TV set to a USB drive and upload the file below. After removing channels and editing the ordering, you can download the modified file from this tool. Upload it to your TV set and you're done.
			</p>
		</div>
		<? include __DIR__ . "/{$page}.php"; ?>
		<div class="footer">
			Developed by <a href="https://www.facebook.com/stefan.m.groh">Stefan Groh</a>. Sources available at <a href="https://github.com/sg80/scmedit">GitHub</a>.
		</div>
	</body>
</html>