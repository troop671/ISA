<?php
session_start();
unset($_SESSION['auth']);
unset($_SESSION['user_id']);
unset($_SESSION['password_hash']);
session_destroy();

$logout = "1";
if($_GET['locked']){
  $locked = $_GET['locked'];
}else{
   $locked = "0";
 }
if($_GET['pass_change']){
  $pass_change = $_GET['pass_change'];
}else{
   $pass_change = "0";
 }
if($_GET['timeout']){
  $timeout = $_GET['timeout'];
}else{
   $timeout = "0";
 }

echo("
  <html>
  <head>
  <title>Untitled</title>
");
if($pass_change){
  echo("<meta http-equiv='Refresh' content='0;url=login.php?pass_change=1'>");
	$logout = "0";
}
if($locked){
  echo("<meta http-equiv='Refresh' content='0;url=login.php?locked=1'>");
	$logout = "0";
}
if($timeout){
  echo("<meta http-equiv='Refresh' content='0;url=login.php?timeout=1'>");
	$logout = "0";
}
if($logout){
   echo("<meta http-equiv='Refresh' content='0;url=login.php?logout=1'>");
 }

echo("
  </head>
  <body bgcolor='4A4A4A'>
  </body>
  </html>
");
?>
