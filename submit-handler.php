<?php

require_once "recaptchalib.php";
$secret = "###Secret Recaptcha code goes here";
$response = null;
$reCaptcha = new ReCaptcha($secret);

if ($_POST["g-recaptcha-response"]) {
	$response = $reCaptcha->verifyResponse(
		$_SERVER["REMOTE_ADDR"],
		$_POST["g-recaptcha-response"]
	);

}
?>


<?php

if ($response != null && $response->success && !empty($_POST['name']) && !empty($_POST['email']) && !empty($_POST['phone']) && !empty($_POST['country'])) {

	$message=
	'Full Name:	'.$_POST['name'].'<br /><br />
	Email Address:	'.$_POST['email'].'<br /><br />
	Phone Number:	'.$_POST['phone'].'<br /><br />
	Country:	'.$_POST['country'].'<br /><br />
	Name of the company who scammed:	'.$_POST['scam_company'].'<br /><br />
	Amount lost:	'.$_POST['amount-lost'].'<br /><br />
	Currency lost:	'.$_POST['currency'].'<br /><br />
	Transfer method:	'.$_POST['transfer_method'].'<br /><br />
	Last transaction date:	'.$_POST['date'].'<br /><br />
	Reference code:	'.$_POST['reference_code'].'<br /><br />
	Short description message:	'.$_POST['notes-message'].'<br /><br />
	Time:	'.date("M,d,Y h:i:s A").'<br /><br /><br /><br />Thanks.<br /><br />';


	require('phpmailer/class.phpmailer.php');


	$mail = new PHPMailer();
	$mail->IsMail();
	/*$mail->SMTPDebug = 0;
	$mail->SMTPAuth = TRUE;
	$mail->SMTPSecure = "ssl";
	$mail->Port     = 465;  
	$mail->Username = "webwiz.developer@gmail.com";
	$mail->Password = "MunisH_1234567#";
	$mail->Host     = "smtp.gmail.com";*/
	$mail->Mailer   = "mail";
	$mail->SetFrom($_POST["email"], $_POST["name"]);
	$mail->AddAddress("Reciving email adress goes here"); 
	$mail->Subject = "Romance Scam Form Submission: ".$_POST['name'];
	$mail->WordWrap   = 80;
	$mail->MsgHTML($message);


	if(!$mail->Send()) {
		echo "<meta http-equiv=\"refresh\" content=\"0;URL=error.html\">";
	} else {
		echo "<meta http-equiv=\"refresh\" content=\"0;URL=thanks.html\">";
	}

} else {
	echo "We are having errors to verify your inputs. Please double check your inputs and try again.";
}

?>