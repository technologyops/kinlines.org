<?php if ( !isset( $_SESSION ) ) session_start();

if ( !$_POST ) exit;

if ( !defined( "PHP_EOL" ) ) define( "PHP_EOL", "\r\n" );

///////////////////////////////////////////////////////////////////////////
//
// Do not edit the following lines
//
///////////////////////////////////////////////////////////////////////////

$postValues = array();
foreach ( $_POST as $name => $value ) {
	$postValues[$name] = strip_tags(trim( $value ));
	//echo $value . "<br>";
}
extract( $postValues );



// Important Variables
$posted_verify = isset( $postValues['verify'] ) ? md5( $postValues['verify'] ) : '';
$session_verify = !empty($_SESSION['jigowatt']['ajax-extended-form']['verify']) ? $_SESSION['jigowatt']['ajax-extended-form']['verify'] : '';

$error = '';

///////////////////////////////////////////////////////////////////////////
//
// Begin verification process
//
///////////////////////////////////////////////////////////////////////////

// strip_tags(trim($_POST["name"]));
$name = str_replace(array("\r","\n"),array(" "," "),$name);

////////////////////////
// Name field is required
if ( empty( $name ) ) {
	$error .= '<li>Your name is <strong>required</strong>.</li>';
}
////////////////////////


if ( !preg_match("/^[0-9]{10}$/", $contactno) ) {
	$error .= '<li>You must <strong>enter a valid 10 digit Mobile No</strong>.</li>';
}


////////////////////////
// Email field is required
if ( empty( $email ) ) {
	$error .= '<li>Your e-mail address is <strong>required</strong>.</li>';
} elseif ( !isEmail( $email ) ) {
	$error .= '<li>You have entered an <strong>invalid e-mail</strong> address.</li>';
}
////////////////////////



//category
if ( empty( $maincat ) ) {
	$error .= '<li>Please select product from <strong>Product Category</strong> list.</li>';
}elseif(empty( $subcat ) ) {
	$error .= '<li>Please select product from <strong>Category list</strong>.</li>';
}

if ( empty( $packingcat ) ) {
	$error .= '<li>Please select your <strong>Packing Type</strong> from list.</li>';
}

//quantity
if ( empty( $quantity ) ) {
	$error .= '<li>Your must <strong>enter a product quantity</strong>.</li>';
}


////////////////////////
// Comments field is required
$comments = str_replace(array("\r","\n"),array(" "," "),$comments);
if ( empty( $comments ) ) {
	$error .= '<li>You must <strong>enter a message</strong> to send.</li>';
}
////////////////////////


////////////////////////
// Verification code is required
if( $session_verify != $posted_verify ) {
	$error .= '<li>The <strong>verification code</strong> you entered is incorrect.</li>';
}
////////////////////////

if ( !empty($error) ) {
	echo '<div class="error_message">Attention! Please correct the errors below and try again.';
	echo '<ul class="error_messages cross">' . $error . '</ul>';
	echo '</div>';

	// Important to have return false in here.
	return false;
}


// Advanced Configuration Option.


$email_content	=	"
<html>
<head>
	<style>
		table, th, td {
			border: 1px solid black;
		}
	</style>
</head>
<body style='max-width: 1140px;'>

<h3><b>Request for Quote from GKBExporters Website</b></h3>

<table cellpadding='10'>
	
	<tr>
		<td><b>Name:</b></td>
		<td>$name</td>
	</tr>
	<tr>
		<td><b>Contact No:</b></td>
		<td>$contactno</td>
	</tr>
	<tr>
		<td><b>Email Id:</b></td>
		<td>$email</td>
	</tr>
	<tr>
		<td><b>Address:</b></td>
		<td>$address</td>
	</tr>
	<tr>
		<td><b>Country:</b></td>
		<td>$country</td>
	</tr>
	<tr>
		<td><b>Product Category:</b></td>
		<td>$maincat</td>
	</tr>
	<tr>
		<td><b>Sub Category:</b></td>
		<td>$subcat</td>
	</tr>
	<tr>
		<td><b>Packing Type:</b></td>
		<td>$packingcat</td>
	</tr>
	<tr>
		<td><b>Quantity:</b></td>
		<td>$quantity</td>
	</tr>
	<tr>
		<td><b>Comments:</b></td>
		<td>$comments</td>
	</tr>

</table>

</body>
</html>
		";

		
	// error_reporting(E_ALL);
	require("PHPMailer_5.2.4/class.phpmailer.php");
	$mail = new PHPMailer();
	$mail->IsSMTP(); // set mailer to use SMTP
	// $mail->SMTPDebug  = 2; 
	
	$mail->From = "sendmail.gkbexporters@gmail.com";
	$mail->FromName = "GKBExporters";
	$mail->Host = "smtp.gmail.com"; // specif smtp server
	$mail->SMTPSecure= "ssl"; // Used instead of ssl/TLS when only POP mail is selected
	$mail->Port = 465; // Used instead of 465/587 when only POP mail is selected
	$mail->SMTPAuth = true;
	
	$mail->Username = "sendmail.gkbexporters@gmail.com"; // SMTP username
	$mail->Password = "gkbexporters123"; // SMTP password
	
	$mail->AddAddress("gkbexporters@yeshprabha.com");
	
	$mail->WordWrap = 50; // set word wrap

	$mail->IsHTML(true); // set email format to HTML
	
	$mail->CharSet = 'UTF-8';
	
	$mail->Subject = 'You got new enquiry from GKBExporters Website';
	/* $mail->Body = 'test on server'; */
	$mail->Body = $email_content;

	
	if(!$mail->Send())
	{
	   echo "<div class='error_message'>Message could not be sent. <br>";
	   echo "Mailer Error: " . $mail->ErrorInfo . "</div>";
	   return false;
	   die();
	}

	echo "<div class='success'>Thank you, We will contact you soon.</div>";
	// Important to have return false in here.
	return false;
		




///////////////////////////////////////////////////////////////////////////
//
// Do not edit below this line
//
///////////////////////////////////////////////////////////////////////////
echo "<div class='error_message'>ERROR! Please confirm PHP mail() is enabled.</div>";
return false;




function isEmail( $email ) { // Email address verification, do not edit.

	return preg_match( "/^[-_.[:alnum:]]+@((([[:alnum:]]|[[:alnum:]][[:alnum:]-]*[[:alnum:]])\.)+(ad|ae|aero|af|ag|ai|al|am|an|ao|aq|ar|arpa|as|at|au|aw|az|ba|bb|bd|be|bf|bg|bh|bi|biz|bj|bm|bn|bo|br|bs|bt|bv|bw|by|bz|ca|cc|cd|cf|cg|ch|ci|ck|cl|cm|cn|co|com|coop|cr|cs|cu|cv|cx|cy|cz|de|dj|dk|dm|do|dz|ec|edu|ee|eg|eh|er|es|et|eu|fi|fj|fk|fm|fo|fr|ga|gb|gd|ge|gf|gh|gi|gl|gm|gn|gov|gp|gq|gr|gs|gt|gu|gw|gy|hk|hm|hn|hr|ht|hu|id|ie|il|in|info|int|io|iq|ir|is|it|jm|jo|jp|ke|kg|kh|ki|km|kn|kp|kr|kw|ky|kz|la|lb|lc|li|lk|lr|ls|lt|lu|lv|ly|ma|mc|md|me|mg|mh|mil|mk|ml|mm|mn|mo|mp|mq|mr|ms|mt|mu|museum|mv|mw|mx|my|mz|na|name|nc|ne|net|nf|ng|ni|nl|no|np|nr|nt|nu|nz|om|org|pa|pe|pf|pg|ph|pk|pl|pm|pn|pr|pro|ps|pt|pw|py|qa|re|ro|ru|rw|sa|sb|sc|sd|se|sg|sh|si|sj|sk|sl|sm|sn|so|sr|st|su|sv|sy|sz|tc|td|tf|tg|th|tj|tk|tm|tn|to|tp|tr|tt|tv|tw|tz|ua|ug|uk|um|us|uy|uz|va|vc|ve|vg|vi|vn|vu|wf|ws|ye|yt|yu|za|zm|zw)$|(([0-9][0-9]?|[0-1][0-9][0-9]|[2][0-4][0-9]|[2][5][0-5])\.){3}([0-9][0-9]?|[0-1][0-9][0-9]|[2][0-4][0-9]|[2][5][0-5]))$/i", $email );

}
?>
