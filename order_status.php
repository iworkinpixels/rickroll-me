<?php

	include 'include.php';

	$invoice_id = intval($_GET['invoice_id']);
	$product_url = '';
	$price_in_usd = 0;
	$price_in_btc = 0;
	$amount_paid_btc = 0;
	$amount_pending_btc = 0;

	mysql_connect($mysql_host, $mysql_username, $mysql_password) or die(__LINE__ . ' Invalid connect: ' . mysql_error());

	mysql_select_db($mysql_database) or die( "Unable to select database. Run setup first.");

	//find the invoice form the database
	$result = DB::query("select invoice_id, price_in_btc, video_code from invoices where invoice_id = %i", $invoice_id);
	        
	if (!$result) {
	    die(__LINE__ . ' Invalid query: Please verify invoice id.');
	}

	$price_in_btc = $result['invoice_id'];  
	$price_in_btc = $result['price_in_btc'];  
	$video_code = $result['video_code'];

	//find the pending amount paid
	$result = DB::query("select sum(value) from pending_invoice_payments where invoice_id = %i", $invoice_id");

	if ($result) $amount_pending_btc += $result['value'];   

	//find the confirmed amount paid
	$result = mysql_query("select sum(value) from invoice_payments where invoice_id = $invoice_id");
	         
	if ($result) $amount_paid_btc += $row['value']; 

?>

<html>
	<head>
	</head>
	<body>
		<img src="invoice.png">

		<h2>Invoice <?php echo $invoice_id ?> </h2>
		<p>
			Amount Due : <?php echo $price_in_usd ?> USD (<?php echo $price_in_btc ?> BTC) 
		</p>

		<p>
			Amount Pending : <?php echo $amount_pending_btc ?> BTC
		</p>

		<p>
			Amount Confirmed : <?php echo $amount_paid_btc ?> BTC
		</p>
		<?php if ($amount_paid_btc  == 0 && $amount_pending_btc == 0) { ?> 
			Payment not received.
		<?php } else if ($amount_paid_btc < $price_in_btc) { ?> 
			<p>
			Waiting for Payment Confirmation: <a href="./order_status.php?invoice_id=<?php echo $invoice_id ?>">Refresh</a>
			</p>
		<?php } else { ?>
			<p>
				Thank You for your purchase.  <a href="rickroll.php">Click here</a> to watch the fun and sing along.
			</p>
		<?php } ?>

	</body>
</html>
