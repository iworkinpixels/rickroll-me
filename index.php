<?php
	include 'include.php';

	mysql_connect($mysql_host, $mysql_username, $mysql_password) or die(__LINE__ . ' Invalid connect: ' . mysql_error());
	mysql_select_db($mysql_database) or die( "Unable to select database.");
?>

<html>
<head>
	<title>Rickroll Me</title>
    <script type="text/javascript" src="https://ajax.googleapis.com/ajax/libs/jquery/1.8.0/jquery.min.js"></script>
    <script type="text/javascript">
	$(document).ready(function() {
		
	});
	</script>
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
					<option value="1"> Never Gonna Give You Up (0.001953125 BTC)</option>
					<option value="2"> It's Tricky (0.00390625 BTC)</option>
					<option value="3"> Dragostea Din Tei (0.0078125 BTC)</option>
					<option value="4"> Nyan Cat (0.015625 BTC)</option>
					<option value="5"> Gangnam Style (0.03125 BTC)</option>
					<option value="6"> Call Me Maybe (0.0625 BTC)</option>
					<option value="7"> Peanut Butter Jelly Time (0.125 BTC)</option>
					<option value="8"> Friday (0.25 BTC)</option>
					<option value="9"> What Does The Fox Say? (0.5 BTC)</option>
					<option value="10"> YOU GET TO CHOOSE THE VIDEO! (1.0 BTC)</option>
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
