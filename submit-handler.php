<?php
require_once "recaptchalib.php";
$secret = "#secret key goes here";
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

if ($response != null && $response->success && !empty($_POST['userName']) && !empty($_POST['phone']) && !empty($_POST['userEmail']) && !empty($_POST['SurfaceType'])) {

	$message=
	'Name:	'.$_POST['userName'].'<br /><br />
	Phone Number:	'.$_POST['phone'].'<br /><br />
	E-Mail:	'.$_POST['userEmail'].'<br /><br />
	ZIP:	'.$_POST['zip'].'<br /><br />
	Surface type:   '.implode(',  ' , $_POST['SurfaceType']).'<br /><br />
	Has the tub / surface been reglazed before?:	'.$_POST['ReglazedBefore'].'<br /><br />
	Is the tub covered with:	'.$_POST['TubCovered'].'<br /><br />
	Do you need caulking?:	'.$_POST['Caulking'].'<br /><br />
	Do you need Regrouting?:	'.$_POST['Regrouting'].'<br /><br />
	Do you need Anti Slip Application?:	'.$_POST['AntiSlip'].'<br /><br />
	Additional Comments:	'.$_POST['comments'].'<br /><br />
	Time:	'.date("M,d,Y h:i:s A").'<br /><br /><br /><br />Thanks.<br /><br />';


	require('phpmailer/class.phpmailer.php');

	$mail = new PHPMailer();
	$mail->isMail();
/*	$mail->SMTPDebug = 0;
	$mail->SMTPAuth = TRUE;
	$mail->SMTPSecure = "ssl";
	$mail->Port     = 465;  
	$mail->Username = "webwiz.developer@gmail.com";
	$mail->Password = "MunisH_1234567#";
	$mail->Host     = "smtp.gmail.com";*/
	$mail->Mailer   = "mail";
	$mail->SetFrom($_POST["userEmail"], $_POST["userName"]);
	$mail->AddReplyTo($_POST["userEmail"], $_POST["userName"]);
	$mail->AddAddress("info@shinytubreglazinghouston.com");	 
	$mail->Subject = "Contact Form Submission ShinyTubReglazingHouston.com:".$_POST['userName'];
	$mail->WordWrap   = 80;
	$mail->MsgHTML($message);
	foreach ($_FILES["attachment"]["name"] as $k => $v) {
		$mail->AddAttachment( $_FILES["attachment"]["tmp_name"][$k], $_FILES["attachment"]["name"][$k] );
	}
    $mail->addBcc("info@shinytubreglazinghouston.com");

if(!$mail->Send()) {
    /*echo 'Mailer Error: ' . $mail->ErrorInfo; die;*/
	echo "<meta http-equiv=\"refresh\" content=\"0;URL=error.html\">";
} else {
   
	echo "<meta http-equiv=\"refresh\" content=\"0;URL=thanks.html\">";
}

} else {
	echo "We are having errors to verify your inputs. Please double check your inputs and try again.";
}

?>