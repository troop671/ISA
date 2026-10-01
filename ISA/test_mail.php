<html>
 <head>
  <title>test_mail - mail()</title>
 </head>
 <body>
 <?php

// The message
$message = "Line 1\r\nLine 2\r\nLine 3";

// In case any of our lines are larger than 70 characters, we should use wordwrap()
$message = wordwrap($message, 70, "\r\n");

// Send
if(!mail('advisor@crew671bsa.org', 'Test mail from test_mail', $message, null,
   '-fTroop671bsa.org')) {
  echo "<BR>Message Send Failed: advisor@crew671bsa.org";
} else {
  echo "<BR>Message sent: advisor@crew671bsa.org";
}

// Send
if(!mail('carverrn@runbox.com', 'Test mail from test_mail', $message, null,
   '-fTroop671bsa.org')) {
  echo "<BR>Message Send Failed: carverrn@runbox.com";
} else {
  echo "<BR>Message sent: carverrn@runbox.com";
}
 ?> 
 </body>
</html>



