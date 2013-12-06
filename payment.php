<?php
	include 'include.php';

	$item = $_POST['item'];
	$custom = strip_tags($_POST['custom']);

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
		$result = DB::query('INSERT INTO invoices (price_in_btc, video_code) values (%d,%s)', $price_in_btc, $video);
	    
		if (!$result) die('Database error.  Please go back and try again.');
		$invoice_id = DB::insertId();
		if(!$invoice_id) die('ERROR: No invoice ID.  Please try again.');
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
