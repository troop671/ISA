<?php
  include 'config.php';

  session_start();
  $_SESSION['progress'] = "1";


  $name = "0";
  $wrong_auth = "0";
  $result = "0";

  if($_GET['pass_change']){
    $pass_change = $_GET['pass_change'];
  }else{
     $pass_change = "0";
  }

  if($_GET['locked']){
    $locked = $_GET['locked'];
  }else{
     $locked = "0";
  }

  if($_GET['timeout']){
    $timeout = $_GET['timeout'];
  }else{
     $timeout = "0";
  }

  if($_GET['logout']){
    $logout = $_GET['logout'];
  }else{
     $logout = "0";
  }

  if($_POST['user_id']){
    $user_id = $_POST['user_id'];
    $_SESSION['user_id'] = $user_id;
  }else{
     $user_id = "0";
  }

  if($_POST['password']){
    $password_hash = SHA1($_POST['password']);
  }else{
     $password_hash = "0";
  }

  echo("
    <html>
    <head>
    <title>Account Login</title>
    <style type='text/css'>
        .title{
                  color: white;
                  font-size: 15pt;
                  font-family: arial;
        }
        .events{
                  color: white;
                  font-size: 10pt;
                  font-family: arial;
        }
        body, td {
                  font-size: 10pt;
                  font-family: arial;
        }
    </style>
  ");


  if($user_id != "0" && $password_hash != "0"){
    $db = new mysqli($mysql_host,$mysql_user,$mysql_passwd);
    if (!$db){
      echo("<b>Error connecting to database! Please try again later...</b>");
    }

    $db->select_db($mysql_dbname);
    $login_info = $db->query("SELECT * FROM `users` WHERE user_id='$user_id' AND password_hash='$password_hash'");
    $result = $login_info->num_rows;
    $user_row = $login_info->fetch_array();
    $db->close;

    if($user_row['locked'] == "yes"){
      $locked = "1";
    }

    if($pass_change){
      $_SESSION['id_try'] = "0";
    }

    if(!(($_SESSION['id_try'] == "1") | ($_SESSION['id_try'] == "2") || ($_SESSION['id_try'] == "3"))){
      $_SESSION['id_try'] = "0";
    }

    if(($result == "0")){
      $cnt = $_SESSION['id_try'];
      ++$cnt;
      $_SESSION['id_try'] = $cnt;
    }

    if(($_SESSION['id_try'] == '4') && ($result != "1")){
      $db->query("UPDATE `users` SET `locked` = 'yes' WHERE `user_id`='$user_id' LIMIT 1");
      echo("<meta http-equiv='Refresh' content='0;url=logout.php?locked=1'>");
    }

    if($result == "1" && ($user_row['locked'] == "no")){
      $_SESSION['password_hash'] = $password_hash;
      $login_time = time();
      $last_active = time();
      $_SESSION['login_time'] = $login_time;
      $_SESSION['last_active'] = $last_active;
      $user_name = $user_id;

      if($user_row['level'] == 'user'){
        echo("<meta http-equiv='Refresh' content='2;url=xaccount_menu.php'>
        ");
      }

      if($user_row['level'] == 'treasurer'){
        echo("<meta http-equiv='Refresh' content='2;url=treasurer_menu.php'>");
      }
    }

    if($result > "1"){
      $error = "1";
    }

    if($result == "0"){
      $wrong_auth = "1";
    }
  }

  echo("
    </head>
    <body bgcolor='4A4A4A'>
    <table width='100%' height='100%'>
      <tr>
        <td>
      <center>
      <table bgcolor='black' cellspacing='1'>
      <tr>
      <td>
      <table bgcolor='white' border='0'>
        <tr>
          <td>
            <form method='post' action='login.php'>
            <table cellpadding='0' cellspacing='0'>
            <tr><td bgcolor='4F5A83' align='center'><div class='title'>Troop 671 User Login<br></div></td></tr>
            <tr>
            <td>
            <table>
            <tr><td>User ID:</td><td><input type='edit' name='user_id'></td></tr>
            <tr><td>Password:</td><td><input type='password' name='password'></td></tr>
            </table>
            </td>
            </tr>
            </table>
            <table width='100%'>
            <tr><td align='right'><input type='submit' value='login'></td><tr>
            </table>
            <a href='forgot_password.php'>Forgot Password?</a><br>
            <a href='mailto:treasurer@troop671bsa.org'>Contact Treasurer</a>
          </td>
        </tr>
      </table>
      </tr>
      </td>
      </table><br>
      <div class='events'>
  ");

  if($user_name){
    echo("
      Welcome back " . $user_row['first'] . "!
    ");
  }

  if($wrong_auth){
    echo("Wrong user id or password.
    ");
  }

  if($error == "1"){
    echo("Fatal System Error.  Please contact the Treasurer.
    ");
  }

  if($locked){
    echo("Your account has been locked.  For more information please contact the Treasurer.
    ");
  }

  if($timeout){
    echo("Your session has timed out.  Please login to view account.
    ");
  }

  if($logout){
    echo("You have been successfully logged out.
    ");
  }

  echo("
      </div>
      </center>
        </td>
      </tr>
      <tr>
        <td valign='bottom' align='right'>
        <div class='events'>&#169;2006 Brad Wilson</div>
        </td>
      </tr>
    </table>
    </body>
    </html>
  ");
?>
