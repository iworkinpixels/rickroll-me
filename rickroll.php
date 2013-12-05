<?php
	include 'include.php';
	mysql_connect($mysql_host, $mysql_username, $mysql_password) or die(__LINE__ . ' Invalid connect: ' . mysql_error());
	mysql_select_db($mysql_database) or die( "Unable to select database.");

	$query = "SELECT i.invoice_id, i.video_code, ip.played FROM invoice_payments ip LEFT JOIN invoices i ON ip.invoice_id = i.invoice_id WHERE ip.played = 0 AND ip.value = i.price_in_btc ORDER BY ip.invoice_id ASC LIMIT 1";
	$result = mysql_query($query);
	$row = mysql_fetch_array($result);
	if($row){
		$video = $row['video_code'];
	} else {
		$video = '';
	}
?>
<html>
<head>
	<title>Rickroll Me</title>
    <script type="text/javascript" src="https://ajax.googleapis.com/ajax/libs/jquery/1.8.0/jquery.min.js"></script>
</head>
    <body>
    	<div style="margin: 100px auto 40px auto; width: 640px; text-align: center;">
		   	<h1>Rickroll Page</h1>
		   	When someone pays, a video will play below within 30 seconds of a 6x confirmation.<br/><br/>
		   	<?
		   		if ($video){
		   	?>
		   			<!--<embed src="mystream.asx" height="480" width="640">-->
				   	<div id="player"></div>
					<script>	 
				      theVideo = '<?=$video?>';
			      	  var tag = document.createElement('script');
				      tag.src = "https://www.youtube.com/iframe_api";
				      var firstScriptTag = document.getElementsByTagName('script')[0];
				      firstScriptTag.parentNode.insertBefore(tag, firstScriptTag);
				      var player;
				      function onYouTubeIframeAPIReady() {

				        player = new YT.Player('player', {
				          height: '480',
				          width: '640',
				          videoId: theVideo,
				          playerVars: {
				          	controls : 0,
				          	showInfo : 0,
				          	rel : 0
				          },
				          events: {
				            'onReady': onPlayerReady,
				            'onStateChange': onPlayerStateChange
				          }
				        });  
				      }
			   
				      function onPlayerReady(event) {
				        event.target.playVideo();
				      }

				      function onPlayerStateChange(event) {
				        if (event.data == YT.PlayerState.ENDED) {
				          setTimeout(replayVideo, 1000);
				        }
				      }
				      function replayVideo() {
				        player.seekTo(0);
				        player.playVideo();
				      }
				    </script>
			<? } else { ?>
				<script>setTimeout("location.reload(true);", 30000);</script>
			<? } ?>
		</div>
    </body>
</html>