<html>
 <head>
  <title>PHP Test</title>
 </head>
 <body>
 <?php

 //include the file
require_once('PHPMailer/class.phpmailer.php');

$phpmailer          = new PHPMailer();


$phpmailer->IsSMTP(); // telling the class to use SMTP

$phpmailer->SMTPDebug  = 1;     // enables SMTP debug information (for testing)
                                // 1 = errors and messages
                                // 2 = messages only

$phpmailer->Host       = "smtp.gmail.com"; // SMTP server
$phpmailer->SMTPAuth   = true;                  // enable SMTP authentication
$phpmailer->SMTPSecure = 'tls';     // ssl for 465; tls for 587
$phpmailer->Port       = 587;          // set the SMTP port for the GMAIL server; 465 for ssl and 587 for tls
$phpmailer->Username   = "richard.n.carver@gmail.com"; // Gmail account username
$phpmailer->Password   = "bisque2023";        // Gmail account password

$phpmailer->SetFrom('richard.n.carver@gmail.com', 'Richard Carver'); //set from name

$phpmailer->Subject    = "Test PHPMailer Message";
$phpmailer->MsgHTML("<html>Sample HTML text</html>");

$phpmailer->AddAddress("advisor@crew671bsa.org", "Crew Advisor");

if(!$phpmailer->Send()) {
  echo "Mailer Error: " . $phpmailer->ErrorInfo;
} else {
  echo "Message sent!";
}

 ?> 
 </body>
</html>



