<html>
 <head>
  <title>test_mail_sendmail - PHPMailer</title>
 </head>
 <body>
 <?php

 //include the file
require_once('PHPMailer/class.phpmailer.php');

$phpmailer          = new PHPMailer();

$phpmailer->IsSendmail(); // telling the class to use SendMail transport

//$phpmailer->IsSMTP(); // telling the class to use SMTP
//$phpmailer->SMTPDebug  = 1;     // enables SMTP debug information (for testing)
                                // 1 = errors and messages
                                // 2 = messages only
//$phpmailer->Host       = "ssl://smtp.gmail.com"; // SMTP server
//$phpmailer->SMTPAuth   = true;                  // enable SMTP authentication
//$phpmailer->Port       = 465;          // set the SMTP port for the GMAIL server; 465 for ssl and 587 for tls
//$phpmailer->Username   = "rx.n.cx@gmail.com"; // Gmail account username
//$phpmailer->Password   = "bxxxx23";        // Gmail account password

$phpmailer->SetFrom('advisor@crew671bsa.org', 'test_mail_sendmail.php'); //set from name

$phpmailer->Subject    = "Test PHPMailer Message using sendmail";
$phpmailer->MsgHTML("<html>Sample HTML text</html>");

$phpmailer->AddAddress("advisor@crew671bsa.org", "Crew Advisor");

if(!$phpmailer->Send()) {
  echo "<BR>Mailer Error: " . $phpmailer->ErrorInfo;
} else {
  echo "<BR>Message sent!";
}

 ?> 
 </body>
</html>



