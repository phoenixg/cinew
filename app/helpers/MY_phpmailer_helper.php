<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');
require("phpmailer/class.phpmailer.php");

//error_reporting(E_ERROR);

function smtp_mail ( $sendto_email, $subject, $body ,$att=array()) {
	$mail = new PHPMailer(); 
	$mail->IsSMTP();   
	
	$mail->Host = "smtp.qq.com";
	$mail->Port = 25;//465 for ssl
	//$mail->SMTPSecure = "ssl";
	$mail->Username = "306761352@qq.com";   
	$mail->Password = "happyhuang";    

	$mail->FromName =  "";//爱业星辰 乱码
	$mail->SMTPAuth = true;          
	$mail->From = $mail->Username;
	$mail->CharSet = "utf8";           
	$mail->Encoding = "base64"; 
	$mail->AddAddress($sendto_email);  
	foreach($att as $key=>$val){
		if(!empty($val)){
			$mail->AddAttachment($val);  //注意要给绝对路径
		}
	}

	$mail->IsHTML(true); 
	$mail->Subject = $subject;
	$mail->Body = $body;
	$mail->AltBody ="text/html"; 
	if(!$mail->Send()) { 
		//echo "邮件错误信息: " . $mail->ErrorInfo;
		return FALSE; 
	}else{
		return TRUE; 
	}
}


