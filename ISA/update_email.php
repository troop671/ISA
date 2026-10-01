<?php
include 'config.php';

session_start();


$redundant = "no";
$expire_time = "997"; /*in seconds*/
$refresh = $expire_time + "3";

$db = new mysqli($mysql_host,$mysql_user,$mysql_passwd);
if (!$db){
  echo("<b>Error connecting to database! Please try again later...</b>");
}
$db->select_db($mysql_dbname);
$login_info = $db->query("SELECT * FROM `users` WHERE user_id='$user_id' AND password_hash='$password_hash'");
$result = $login_info->num_rows;
if($result){
  $user_row = $login_info->fetch_array();
}

$time_now = time();
$expire_check = ($time_now - $last_active);
if($expire_check > $expire_time){
  $expire = "yes";
}
if($expire_check <= $expire_time){
  $expire = "no";
}

if(($result == "1") && ($expire == "no") && ($user_row['locked'] == "no")){
  $last_active = time();
  $_SESSION['last_active'] = $last_active;

	//start variable retreival
  if($_GET['close']){
    $close = $_GET['close'];
  }else{
     $close = "0";
   }
	if($_POST['close']){
    $close = $_POST['close'];
  }
	if($_GET['user_email_given']){
    $user_email_given = $_GET['user_email_given'];
  }else{
     $user_email_given = "0";
   }
	if($_POST['user_email_given']){
    $user_email_given = $_POST['user_email_given'];
  }
  if($_POST['yes']){
    $yes = $_POST['yes'];
  }else{
     $yes = "0";
   }
	if($_GET['pass']){
    $pass = $_GET['pass'];
  }else{
	   $pass = "0";
	 }
  if($_POST['no']){
    $no = $_POST['no'];
  }else{
     $no = "0";
   }
	//end variable retreival

  if($yes == "yes"){
	  if($user_email_given != ""){
  	  if(preg_match('#^[a-z0-9.!\#$%&\'*+-/=?^_`{}~]+@([0-9.]+|([^\s]+\.+[a-z]{2,6}))$#si', $user_email_given)){
  		  if(!(preg_match('(bcc:|cc:)', $user_email_given))){
  			  $db->query("UPDATE `users` SET `email` = '$user_email_given' WHERE `user_id`='$user_id'");
  			}
  			if((preg_match('(bcc:|cc:)', $user_email_given))){
  			   $db->query("UPDATE `users` SET `locked` = 'yes' WHERE `user_id`='$user_id' LIMIT 1");
  			   $email_to_check = "spam";
  			}
			}
  	}
  }

	if($close == "0"){
    echo("
		  <html>
      <head>
    	<title>Update Email</title>
			<meta http-equiv='Refresh' content=' " . $refresh . " ;url=logout.php?timeout=1'>
    ");
    echo("
		  <style type='text/css'>
        body, td {
	            font-size: 10pt;
							font-family: arial;
        }
      </style>
    	</head>
    	<body>
			<br>
			<br>
			<br>
			<center>
      $user_email_given is not your account e-mail: $user_row[email].<br>
    	<br>
    	Would you like to make $user_email_given your account e-mail?
    	<form method='post' action='update_email.php'>
			<input type='hidden' name='close' value='1'>
			<input type='hidden' name='user_email_given' value='$user_email_given'>
			<br>
     	<input type='submit' name='yes' value='yes'> &nbsp; &nbsp; <input type='submit' name='no' value='no'><br>
    	</form>
    	</center>
    ");
	}
	if(($yes == "yes") || ($pass == "1")){
	  echo("<html>
		  <head>
			<title></title>
			<meta http-equiv='Refresh' content='2;url=update_email.php?close=2'>
  	  <style type='text/css'>
        body, td {
	            font-size: 10pt;
							font-family: arial;
        }
      </style>
			</head>
			<body>
			<br>
			<br>
			<br>
			<center>
			Account e-mail updated succesfully.
			</center>
			</body>
			<html>
		");
	}
	if($no == "no"){
	  echo("<html>
		  <head>
			<title></title>
			<meta http-equiv='Refresh' content='2;url=update_email.php?close=2'>
  	  <style type='text/css'>
        body, td {
	            font-size: 10pt;
							font-family: arial;
        }
      </style>
			</head>
			<body>
			<br>
			<br>
			<br>
      <center>
			Account e-mail not updated.
			</center>
			</body>
			<html>
		");
	}
	if($close == "2"){
	  echo("<html>
		  <head>
			<title></title>
			<script language='JavaScript'>
      window.self.close();
  	  </script>
			</head>
			<body>
			</body>
			<html>
		");
	}
}

if($result != "1"){
  echo("
	  <html>
	  <head>
	  <title>Transfering</title>
    <meta http-equiv='Refresh' content='1;url=login.php'>
    </head>
    <body>
	  Transfering . . .
    ");
	$redundant = "yes";
}
if(($expire == "yes") && ($redundant == "no")){
  echo("
	  <html>
	  <head>
	  <title>Transfering</title>
    <meta http-equiv='Refresh' content='1;url=logout.php?timeout=1'>
    </head>
    <body>
	  Session Timed Out.  Transfering . . .
    ");
	$redundant = "yes";
}
if((($user_row['locked'] == "yes") || ($email_to_check == 'spam')) && ($redundant == "no")){
  echo("
	  <html>
	  <head>
	  <title>Transfering</title>
    <meta http-equiv='Refresh' content='0;url=logout.php?locked=1'>
    </head>
    <body>
	  Transfering . . .
    ");
}

$db->close;
?>

