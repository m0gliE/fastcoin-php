<?php

	$adminemail = "m0gliEz@gmail.com"; // Your E-Mail Address

	$FSTaddress = "fmzFf7rCAzYFWnbzcLpoBBf1P9mzZfNmmm"; // Your Fastcoin Address


	/* ---- Do Not Edit Below This Line ---- */

	if (isset($_GET)) {
		foreach($_GET as $gkey => $gval) {
			$$gkey = trim(strip_tags($gval));
		}
	}
	if (isset($_POST)) {
		foreach($_POST as $pkey => $pval) {
			$$pkey = trim(strip_tags($pval));
		}
	}
	if ($ordernow) {

		$success = 0;
		if ((!empty($red_name)) && (!empty($red_address)) && (!empty($red_city)) && (!empty($red_zip)) && (!empty($red_country)) &&
		   (!empty($red_phone)) && (!empty($red_email))) {

			if (eregi("^[a-z0-9,!#\$%&'\*\+/=\?\^_`\{\|}~-]+(\.[a-z0-9,!#\$%&'\*\+/=\?\^_`\{\|}~-]+)*@[a-z0-9-]+(\.[a-z0-9-]+)*\.([a-z]{2,})$",
			   $red_email)) {

				$gen_mmss = date("is", time());

				$get_first_prefix_oid =  date("j", time());
				if (strlen($get_first_prefix_oid) != 1) {
					$prefix_first = substr($get_first_prefix_oid, 1, 2);
				}else{
					$prefix_first = $get_first_prefix_oid;
				}

				$get_second_prefix_oid =  date("G", time());
				if (strlen($get_second_prefix_oid) != 1) {
					$prefix_second = substr($get_second_prefix_oid, 1, 2);
				}else{
					$prefix_second = $get_second_prefix_oid;
				}

				$order_id = $prefix_first.$prefix_second.$gen_mmss;

				if (!empty($red_state)) {
					$formatted_addr = $red_address.", ".$red_city.", ".$red_state.", ".$red_zip." ".$red_country;
				}else{
					$formatted_addr = $red_address.", ".$red_city.", ".$red_zip." ".$red_country;
				}

				$msgemail = "Amount: ".str_replace(",", "", number_format($red_cost)).".".$order_id."\r\n\r\n";
				$msgemail .= "Description: ".$description."\r\n\r\n";
				$msgemail .= "Name: ".$red_name."\r";
				$msgemail .= "Address: ".$formatted_addr."\r";
				$msgemail .= "Phone: ".$red_phone."\r";
				$msgemail .= "E-Mail: ".$red_email."\r";

				$headers  = 'MIME-Version: 1.0' . "\r\n";
				$headers .= 'Content-type: text; charset=utf-8' . "\r\n";
				$headers .= 'From: '.$red_email."\r\n";
    			$headers .= 'Reply-To: '.$red_email."\r\n";
    			$headers .= 'X-Mailer: PHP/' . phpversion();

				if (mail($adminemail, "FASTCOIN ORDER ".$order_id, $msgemail, $headers)) {
					$success = 1;
				}else{
					$return_err = "ERROR : Unable To Send E-Mail!";
				}

				$mailtocustomer = "Your order number is : ".$order_id . "\r\n\r\n";
				$mailtocustomer .= "Please Pay Exactly ".str_replace(",", "", number_format($red_cost)).".".$order_id." Fastcoins To This Address"."\r\n\r\n";
				$mailtocustomer .= $FSTaddress."\r\n\r\n";
				$mailtocustomer .=  "We will email you once we receive payment"."\r\n\r\n";
				$mailtocustomer .=  "You can contact us at ".$adminemail."\r\n";

				$headers  = 'MIME-Version: 1.0' . "\r\n";
				$headers .= 'Content-type: text; charset=utf-8' . "\r\n";
				$headers .= 'From: '.$adminemail."\r\n";
    			$headers .= 'Reply-To: '.$adminemail."\r\n";
    			$headers .= 'X-Mailer: PHP/' . phpversion();

				if (mail($red_email, "FASTCOIN PAYMENT INSTRUCTIONS ".$order_id, $mailtocustomer, $headers)) {
					$success = 1;
				}else{
					$return_err = "ERROR : Unable To Send E-Mail!";
				}

			}else{
				$return_err = "ERROR : Invalid E-Mail Address!";
			}

		}else{
			$return_err = "ERROR : All Fields Are Required!";
		}

	}

	/* -------------------------------------------- */

	$hide_form = 0;
	if ((empty($description)) || (empty($cost))) {
		$return_err = "ERROR : No Price Or Description!";
		$hide_form = 1;
	}

	list($amntc, $amntd) = explode(".", $cost);
	if ($amntd != 0) {
		$display_cost_form = $cost;
	}else{
		$display_cost_form =  number_format($amntc);
	}


?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Pay with FASTCOINs</title>
<script type="text/javascript" src="http://code.jquery.com/jquery-1.10.2.min.js"></script>
<script type="text/javascript">
function checkinput() {
	var rname = $('#red_name').val();
	var raddr = $('#red_address').val();
	var rcity = $('#red_city').val();
	var rzipp = $('#red_zip').val();
	var rcntr = $('#red_country').val();
	var rphne = $('#red_phone').val();
	var remil = $('#red_email').val();
	if ((rname == "") || (raddr == "") || (rcity == "") || (rzipp == "") || (rcntr == "") || (rphne == "") || (remil == "")) {
		$('#error_ret').html('All Fields Are Required');
		setTimeout(function() {
			$('#error_ret').html('&nbsp;');
		}, 3000);
		return false;
	}else{
		return true;
	}
}
</script>
<style type="text/css">
body, table {
	margin: 0px auto; font-size: 14px; font-family: Verdana, Geneva, sans-serif; color: #000;
}
.title {
	margin: 0px auto; font-size: 20px; font-weight: bold; color: #C00; text-decoration: underline; text-align: center;
}
.box {
	margin: 0px auto; padding: 5px; width: 70%;	height: auto; border: 2px solid #C00; -webkit-border-radius: 5px; border-radius: 5px;
}
.error {
	font-size: 16px; color: #F00; font-weight: bold;
}
.btn {
	width: 217px; height: 40px;	-webkit-border-radius: 10px; border-radius: 10px; border: 0px; font-size: 16px;	font-weight: bold; color: #FFF;
	background: rgb(248,80,50); /* Old browsers */
	background: -moz-linear-gradient(top, rgba(248,80,50,1) 0%, rgba(241,111,92,1) 50%, rgba(246,41,12,1) 51%, rgba(240,47,23,1) 71%, rgba(231,56,39,1) 100%); /* FF3.6+ */
	background: -webkit-gradient(linear, left top, left bottom, color-stop(0%,rgba(248,80,50,1)), color-stop(50%,rgba(241,111,92,1)), color-stop(51%,rgba(246,41,12,1)), color-stop(71%,rgba(240,47,23,1)), color-stop(100%,rgba(231,56,39,1))); /* Chrome,Safari4+ */
	background: -webkit-linear-gradient(top, rgba(248,80,50,1) 0%,rgba(241,111,92,1) 50%,rgba(246,41,12,1) 51%,rgba(240,47,23,1) 71%,rgba(231,56,39,1) 100%); /* Chrome10+,Safari5.1+ */
	background: -o-linear-gradient(top, rgba(248,80,50,1) 0%,rgba(241,111,92,1) 50%,rgba(246,41,12,1) 51%,rgba(240,47,23,1) 71%,rgba(231,56,39,1) 100%); /* Opera 11.10+ */
	background: -ms-linear-gradient(top, rgba(248,80,50,1) 0%,rgba(241,111,92,1) 50%,rgba(246,41,12,1) 51%,rgba(240,47,23,1) 71%,rgba(231,56,39,1) 100%); /* IE10+ */
	background: linear-gradient(to bottom, rgba(248,80,50,1) 0%,rgba(241,111,92,1) 50%,rgba(246,41,12,1) 51%,rgba(240,47,23,1) 71%,rgba(231,56,39,1) 100%); /* W3C */
	filter: progid:DXImageTransform.Microsoft.gradient( startColorstr='#f85032', endColorstr='#e73827',GradientType=0 ); /* IE6-9 */
	text-shadow: 1px 1px 1px #333133;
    filter: dropshadow(color=#333133, offx=1, offy=1);
}
.inputtxt {
	height: 25px; font-size: 16px;
}
</style>
</head>
<body>

<br /><br />
<center><img src=fastcoin_payment.png></center>
<br /><br />
<div style="width: 70%; height: auto; margin: 0px auto; font-size: 12px;">
<strong>IMPORTANT:</strong> After you input your delivery details, We will provide you a FASTCOIN address to send your payment to, with an added fee of about 0.600000 FST, this is infact your order number and used to locate your order in the system, so you must send us the EXACT amount as requested.
</div>
<br /><br />

<div class="box">
  <form id="form1" name="form1" method="post" action="index.php?description=<?php echo $description; ?>&cost=<?php echo $cost; ?>" onsubmit="return checkinput();">
  <table width="100%" border="0" cellspacing="3" cellpadding="2" align="center">
  	<?php if ($success != 1) { ?>
    <?php if ($hide_form == 0) { ?>
    <tr>
      <td width="31%" height="43" align="right">You are ordering : </td>
      <td width="69%">
      	<span style="font-size: 16px; font-weight: bold;"><?php echo $description.", costing  ".str_replace(",", "", $display_cost_form)." FST"; ?></span>
      </td>
    </tr>
    <tr>
      <td colspan="2" style="text-indent: 50px;"><strong>Please Enter Your Details :</strong></td>
    </tr>
    <?php } ?>
    <tr id="input_error">
      <td colspan="2" align="center" class="error" id="error_ret">
      	<?php
			if (!empty($return_err)) {
				echo $return_err;
			}else{
				echo "&nbsp;";
			}
		?>
        </td>
    </tr>
    	<?php if ($hide_form == 0) { ?>
    <tr>
      <td align="right">Name : </td>
      <td><input type="text" id="red_name" name="red_name" size="50" class="inputtxt" value="<?php echo $red_name; ?>" /></td>
    </tr>
    <tr>
      <td align="right">Address : </td>
      <td><input type="text" id="red_address" name="red_address" size="50" class="inputtxt" value="<?php echo $red_address; ?>" /></td>
    </tr>
    <tr>
      <td align="right">City : </td>
      <td><input type="text" id="red_city" name="red_city" size="50" class="inputtxt" value="<?php echo $red_city; ?>" /></td>
    </tr>
    <tr>
      <td align="right">State : </td>
      <td><input type="text" id="red_state" name="red_state" size="50" class="inputtxt" value="<?php echo $red_state; ?>" /></td>
    </tr>
    <tr>
      <td align="right">Zip : </td>
      <td><input type="text" id="red_zip" name="red_zip" size="50" class="inputtxt" value="<?php echo $red_zip; ?>" /></td>
    </tr>
    <tr>
      <td align="right">Country : </td>
      <td><input type="text" id="red_country" name="red_country" size="50" class="inputtxt" value="<?php echo $red_country; ?>" /></td>
    </tr>
    <tr>
      <td align="right">Phone : </td>
      <td><input type="text" id="red_phone" name="red_phone" size="50" class="inputtxt" value="<?php echo $red_phone; ?>" /></td>
    </tr>
    <tr>
      <td align="right">E-Mail : </td>
      <td><input type="text" id="red_email" name="red_email" size="50" class="inputtxt" value="<?php echo $red_email; ?>" /></td>
    </tr>
    <tr>
      <td height="56" colspan="2" align="center">
      	<input type="hidden" name="red_cost" name="red_cost" value="<?php echo str_replace(",", "", $display_cost_form); ?>" />
        <input type="submit" name="ordernow" class="btn" value="Order Now" />
      </td>
    </tr>
    	<?php } ?>
    <?php  }else{ ?>
    <tr>
      <td width="31%" height="43" align="right">Your order number is : </td>
      <td width="69%"><span style="font-size: 16px; font-weight: bold;"><?php echo $order_id; ?></span></td>
    </tr>
    <tr>
      <td colspan="2" align="center">
      	<strong>
        Please Pay Exactly <span style="color: #F00; font-size: 16px;"><?php echo str_replace(",", "", number_format($red_cost)).".".$order_id; ?></span> Fastcoin To This Address
        </strong>
      </td>
    </tr>
    <tr>
      <td height="28" colspan="2" align="center">
      	 <h2 style="color: #F00;"><?php echo $FSTaddress; ?></h2>
      </td>
    </tr>
    <tr>
      <td height="28" colspan="2" align="center">
      	 We will email you once we receive payment
      </td>
    </tr>
    <tr>
      <td height="28" colspan="2" align="center">
      	You can contact us at <?php echo $adminemail; ?>
      </td>
    </tr>
    <?php  } ?>
  </table>
  </form>
</div>

</body>
</html>