<?php
	include 'include.php';

	mysql_connect($mysql_host, $mysql_username, $mysql_password) or die(__LINE__ . ' Invalid connect: ' . mysql_error());
	mysql_select_db($mysql_database) or die( "Unable to select database.");

	$item = $_POST['item'];
	$custom = strip_tags($_POST['custom']);

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

	switch($item) {
		case 1:
			$price_in_btc = 0.001953125;
			$video = 'dQw4w9WgXcQ'; // Never Gonna Give You Up
			break;
		case 2:
			$price_in_btc = 0.00390625;
			$video = 'l-O5IHVhWj0'; // It's Tricky
			break;
		case 3:
			$price_in_btc = 0.0078125;
			$video = 'jRx5PrAlUdY'; // Dragostea Din Tei
			break;
		case 4:
			$price_in_btc = 0.015625;
			$video = 'QH2-TGUlwu4'; // Nyan Cat
			break;
		case 5:
			$price_in_btc = 0.03125;
			$video = '9bZkp7q19f0'; // Gangnam Style
			break;
		case 6:
			$price_in_btc = 0.0625;
			$video = 'fWNaR-rxAic'; // Call Me Maybe
			break;
		case 7:
			$price_in_btc = 0.125;
			$video = 'Z3ZAGBL6UBA'; // Peanut Butter Jelly Time
			break;
		case 8:
			$price_in_btc = 0.25;
			$video = 'kfVsfOSbJY0'; // Friday
			break;
		case 9:
			$price_in_btc = 0.5;
			$video = 'jofNR_WkoCE'; // What Does The Fox Say?
			break;
		case 10:
			$price_in_btc = 1.0;
			$video = $custom; // USER CHOICE!  ( Pending validation of the video code.  Obvs. )
			break;
		default:
			die('Invalid form.  Please go back and try again.');
	}

	if ($price_in_btc != 0 && $video != '') {
		$query = "INSERT INTO invoices (price_in_btc, video_code) values('".$price_in_btc."','".$video."')";
		$result = mysql_query($query);
	    
		if (!$result) {
		    die('Database error.  Please go back and try again.');
		}

		$invoice_id = mysql_insert_id();
	} else {
		die('Invoice error.  Please go back and try again.');
	}
?>
<html>
<head>
	<title>Rickroll Me</title>
    <script type="text/javascript" src="https://ajax.googleapis.com/ajax/libs/jquery/1.8.0/jquery.min.js"></script>
    <script type="text/javascript" src="<? echo $blockchain_root ?>Resources/wallet/pay-now-button-v2.js"></script>
    <script type="text/javascript">
	$(document).ready(function() {
		$('.stage-paid').on('show', function() {
			window.location.href = './order_status.php?invoice_id=<?=$invoice_id?>';
		});
</head>
    <body>
       <div style="margin: 100px auto 40px auto; width: 525px; text-align: center;">
			<div class="blockchain-btn" style="width:auto" data-create-url="create.php"> 
				<div class="blockchain stage-begin">
					<img src="<?php echo $blockchain_root ?>Resources/buttons/pay_now_64.png">
				</div>
				<div class="blockchain stage-loading" style="text-align:center">
					<img src="<?php echo $blockchain_root ?>Resources/loading-large.gif">
				</div>
				<div class="blockchain stage-ready" style="text-align:center">
					Please send <?=$price_in_btc?> BTC to <br /> <b>[[address]]</b> <br /> 
					<img style="margin:5px" id="qrsend" src="<?=$blockchain_root?>qr?data=bitcoin:<?=$my_bitcoin_address?>%3Famount=<?=$price_in_btc?>%26label=Rickroll&size=425" alt=""/>
				</div>
				<div class="blockchain stage-paid">
					<p>Payment Received <b>[[value]] BTC</b>. Thank You.</p>
					<p>Check out the results <a href="rickroll.php">here</a>.
				</div>
				<div class="blockchain stage-error">
					<font color="red">[[error]]</font>
				</div>
			</div>
		</div>
    </body>
</html>