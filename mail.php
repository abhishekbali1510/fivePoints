<?php
include('smtp/PHPMailerAutoload.php');

// $tmp='vs96462.ab@gmail.com';
// $html="hy";

function smtp_mailer($to,$subject, $msg){
	$mail = new PHPMailer(); 
	// $mail->SMTPDebug  = 3;
	$mail->IsSMTP(); 
	$mail->SMTPAuth = true; 
	$mail->SMTPSecure = 'tls'; 
	$mail->Host = "smtp.gmail.com";
	$mail->Port = 587; 
	$mail->IsHTML(true);
	$mail->CharSet = 'UTF-8';
	$mail->Username = "fivepointse1@gmail.com";
	$mail->Password = "";
	$mail->SetFrom("fivepointse1@gmail.com");
	$mail->Subject = $subject;
	$mail->Body =$msg;
	$mail->AddAddress($to);
	$mail->SMTPOptions=array('ssl'=>array(
		'verify_peer'=>false,
		'verify_peer_name'=>false,
		'allow_self_signed'=>false
	));
	$mail->send();
	// if(!$mail->Send()){
	// 	echo $mail->ErrorInfo;
	// }else{
	// 	return 'Sent';
	// }
}

?>
