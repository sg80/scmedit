<!DOCTYPE html>
<html>
	<head>
		<title>Edit channel-lists online</title>
		<link href='http://fonts.googleapis.com/css?family=Noticia+Text:700italic' rel='stylesheet' type='text/css'>
		<link rel="stylesheet" href="style.css" />
		<link rel="stylesheet" href="stations.css" />
		<meta charset="utf-8" />
		<script type="text/javascript" src="http://code.jquery.com/jquery.min.js"></script>
		<script type="text/javascript" src="js/jquery.tablednd.js"></script>
		<script type="text/javascript" src="js/jquery.tinysort.min.js"></script>
	</head>
	<body>
		<div class="intro">
			<h1>Edit channel-lists online</h1>
			<p>
				Use this platform-independent tool to comfortably modify your channel-list-files (.scm) of your <a href="http://de.wikipedia.org/wiki/Suwon">South Korean</a> TV set.
			</p>
			<p>
				Just <a href="http://youtu.be/31RjBg_mNrU?t=1m29s">export the channel list</a> from your TV set to a USB drive and <a href="?">upload</a> the file. After removing channels and editing the order, you can download the modified file from this tool. Upload it to your TV set and you're done.
			</p>
		</div>
		<? include __DIR__ . "/{$page}.php"; ?>
		<div class="footer">
			Developed by <a href="https://www.facebook.com/stefan.m.groh">S. Groh</a>.
			Sources available at <a id="github" href="https://github.com/sg80/scmedit"><span class="invisible">GitHub</span></a>.
			<a id="flattr" href="https://flattr.com/submit/auto?user_id=sg80&url=http%3A%2F%2Fwww.ziztonenlimo.de"><img src="//api.flattr.com/button/flattr-badge-large.png" alt="Flattr this" title="Flattr this" border="0"></a>
		</div>
	</body>
</html>