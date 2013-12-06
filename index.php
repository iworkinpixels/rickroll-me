<?php
	include 'include.php';
	$videos = DB::query('SELECT * FROM videos ORDER BY name ASC');

	foreach ($videos as $v) {
	}
?>

<html>
<head>
	<title>Rickroll Me</title>
    <script type="text/javascript" src="https://ajax.googleapis.com/ajax/libs/jquery/1.8.0/jquery.min.js"></script>
    <script type="text/javascript">
	$(document).ready(function() {
		$( "#item" ).change(function() {
			if ($('#item').val() == '0')
				$('#extra').show();
			else
				$('#extra').hide();
		});	
	});
	</script>
	<style>
		#extra {
			display: none;
		}
	</style>
</head>
    <body>
       <div style="margin: 100px auto 40px auto; width: 525px; text-align: center;">
		   	<h1>Rickroll Me</h1>
		   	<ol style="text-align: left;">
		   		<li>Choose a song, pay the appropriate amount of BTC, and it starts playing in my browser as soon as it's confirmed 6x!</li>
		   		<li>To watch me listen to your video, <a href="rickroll.php">click here</a>.
		   	</ol>
		   	<br/><br/><br/>
			
			<form action="payment.php" method="POST">
				<h2>Choose A Song</h2>
				<select name="item" id="item">
					<? 
						foreach ($videos as $v):
							$last_updated = strtotime($v['price_last_updated']);
							if($last_updated == '') $last_updated = 0;
							$timediff = time() - $last_updated;
							if ($timediff > $one_day || $v['price_in_btc'] == 0) {
								$price_in_btc = file_get_contents($blockchain_root . "tobtc?currency=USD&value=" . $v['price_in_usd']);
								DB::query('UPDATE videos SET price_in_btc = %d, price_last_updated = %t WHERE id = %i', $price_in_btc, date('Y-m-d H:i:s'), $v['id']);
							} else {
								$price_in_btc = $v['price_in_btc'];
							}
					?>
						<option value="<?=$v['id']?>"><?=$v['name']?> (<?=$price_in_btc?> BTC)</option>
					<? endforeach ?>
					<option value="0"> YOU GET TO CHOOSE THE VIDEO! (0.02 BTC)</option>
				</select>
				<div id="extra">
					<p><strong>Type in the video code of your chosen video (Example: 'dQw4w9WgXcQ')</strong></p>
					<input type"text" size="20" name="custom" id="custom"/>
				</div>
				<br/><br/>
				<input type="submit" value="Proceed to Payment"/>
			</form>
		</div>
    </body>
</html>
