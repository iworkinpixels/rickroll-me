<?php
	include 'include.php';

	$row = DB::queryFirstRow("SELECT i.invoice_id, i.video_id, i.video_code, i.played FROM invoice_payments ip LEFT JOIN invoices i ON ip.invoice_id = i.invoice_id WHERE i.played = 0 ORDER BY ip.invoice_id ASC LIMIT 1");
	if($row){
		if($_GET['secret'] == $secret)
			DB::query('UPDATE invoices SET played = 1 WHERE invoice_id = %i', $row['invoice_id']);
		if ($row['video_id'] != 0) {
			$vid = DB::queryFirstRow("SELECT * FROM videos WHERE id = %i", $row['video_id']);
			$video = $vid['video_code'];
		} else {
			$video = $row['video_code'];
		}
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
				          setTimeout('location.reload(true);', 1000);
				        }
				      }
				    </script>
			<? } else { ?>
				<script>setTimeout("location.reload(true);", 30000);</script>
			<? } ?>
		</div>
    </body>
</html>
