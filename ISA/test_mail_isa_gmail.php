<html>
 <head>
  <title>test_mail_isa_gmail - PHPMailer</title>
 </head>
 <body>
 <?php

 //include the file
require_once('PHPMailer/class.phpmailer.php');
//require_once "Mail.php";

$phpmailer          = new PHPMailer();


$phpmailer->IsSMTP(); // telling the class to use SMTP

$phpmailer->SMTPDebug  = 1;     // enables SMTP debug information (for testing)
                                // 1 = errors and messages
                                // 2 = messages only

$phpmailer->Host       = "ssl://smtp.dreamhost.com"; // SMTP server
//$phpmailer->Host       = "tls://smtp.gmail.com"; // SMTP server
$phpmailer->SMTPAuth   = true;                  // enable SMTP authentication
$phpmailer->Port       = 465;          // set the SMTP port for the GMAIL server; 465 for ssl and 587 for tls
//$phpmailer->Port       = 587;          // set the SMTP port for the GMAIL server; 465 for ssl and 587 for tls
$phpmailer->Username   = "ISA.Troop671@Troop671.com"; // Gmail account username
$phpmailer->Password   = "mstr0671";        // Gmail account password

$phpmailer->SetFrom('ISA.Troop671@Troop671.com', 'ISA.Troop671'); //set from name

$phpmailer->Subject    = "Test PHPMailer Message";
$phpmailer->MsgHTML("<html>This is a test email triggered by the URL <a href=http://www.troop671.com/ISA/test_mail_isa_gmail.php></a></html>");

$phpmailer->AddAddress("allan@theshortpeople.com", "Allan Short");

if(!$phpmailer->Send()) {
  echo "Mailer Error: " . $phpmailer->ErrorInfo;
} else {
  echo "Message sent!";
}

 ?> 
 </body>
</html>



