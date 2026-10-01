<?php
include 'config.php';

session_start();

$update = "1";
$result = "new";
$progress = "1";

if($_POST['cycled']){
  $cycled = $_POST['cycled'];
	$_SESSION['cycled'] = $cycled;
}else{
   $cycled = "0";
 }

if($_POST['user_id']){
  $user_id = $_POST['user_id'];
	$_SESSION['user_id'] = $user_id;
}

if($_POST['password_1']){
  $password_1 = $_POST['password_1'];
}else{
   $password_1 = "0";
 }

if($_POST['password_2']){
  $password_2 = $_POST['password_2'];
}else{
   $password_2 = "0";
 }

if($_POST['answer_entered']){
  $answer_entered = $_POST['answer_entered'];
}else{
   $answer_entered = "0";
 }

$db = new mysqli($mysql_host,$mysql_user,$mysql_passwd);
if (!$db){
  echo("<b>Error connecting to database! Please try again later...</b>");
}

$db->select_db($mysql_dbname);
$login_info = $db->query("SELECT * FROM `users` WHERE user_id='$user_id'");
$result = $login_info->num_rows;
$user_row = $login_info->fetch_array();
$q_and_a_check_info = $db->query("SELECT * FROM `users` WHERE user_id='$user_id' AND `answer`!=''");
$q_and_a_check = $q_and_a_check_info->num_rows;
if(($result == "1") &&  ($user_row['locked'] == "no") && ($q_and_a_check == '1')){
  $progress = "2";
}
if(($q_and_a_check != '1') && ($cycled != "0")){
  $error = 'no_q_and_a';
}
if(($result != "1") && ($result < "2") && ($cycled != "0")){
  $error = "wrong_id";
}
if($user_row['locked'] == "yes"){
  $progress = "id_breach";
}

if($answer_entered != "0"){
  if(($user_row['answer'] == $answer_entered) && $answer_entered != "0"){
    $progress = "3";
  }
}

if(($password_1 == $password_2) && $password_1 != "0"){
  $new_password = SHA1($password_1);
  if(!$db){
    echo("<b>Error connecting to database! Please try again later...</b>");
  }
  $db->select_db($mysql_dbname);
  $user_info = $db->query("UPDATE `users` SET `password_hash` = '$new_password' WHERE `user_id`='$user_id' LIMIT 1");
  $progress = "4";
}
if(($_SESSION['id_try'] == "3") && ($progress != "3") && ($progress != "4")){
	  $progress = "id_breach";
}

if($progress <= "3"){
  echo("
	  <html>
    <head>
    <title>Untitled</title>
		<STYLE type='text/css'>
  		.events{
  		          color: white;
  							font-size: 10pt;
  							font-family: arial;
  		}
     	.title{
  		          color: white;
  							font-size: 15pt;
  							font-family: arial;
  		}
		</STYLE>
    </head>
    <body bgcolor='4A4A4A'>
		<table bgcolor='4A4A4A' width='100%' height='100%'>  <!-- outer page table -->
    <tr>
      <td>
        <center>
        <table cellpadding='0' cellspacing='2' bgcolor='black'>  <!-- outline table black matte -->
          <tr>
            <td>
              <table bgcolor='white' border='0'>  <!-- cell 1 table -->
                <tr>
                  <td>
									  <table width='100%' cellspacing='0'>
										<tr><td bgcolor='4F5A83'><font color='white'><div class='title'>Forgot Password</div></font></td></tr>
										</table>
										<br>
                          <!-- cell 1 here -->
  ");
}

if($progress == "1"){
  echo("
	  <form method='post' action='forgot_password.php'>
		<table>
    <tr><td>user id: </td><td><input type='edit' name='user_id'></td></tr>
		</table>
		<input type='hidden' name='cycled' value='1'>
	  <input type='submit' value='submit'>
	  </form>
  		            </td>
                </tr>
              </table>
            </td>
          </tr>
        </table>
        <table>  <!-- event message table -->
          <tr>
            <td>
                          <!-- event messages here -->
  ");
	if($error == "wrong_id"){
	  echo("
		  <div class='events'>Error:  User ID not found.</div>
		");
  }
	if($error == 'no_q_and_a'){
	  echo("
		  <div class='events'>Account has no available Question and Answer.</div>
		");
	}
}

if($progress == "2"){
  echo("
    <form method='post' action='forgot_password.php'>
		<table>
    <tr><td>Question: </td><td> ". $user_row['question'] . " </td></tr>
    <tr><td>Answer:  </td><td><input type='password' name='answer_entered'></td></tr>
		</table>
    <input type='submit' value='submit'>
	  </form>
                  </td>
                </tr>
              </table>
            </td>
          </tr>
        </table>
        <table>  <!-- event message table -->
          <tr>
            <td>
                          <!-- event messages here -->
	");
	if(!(($_SESSION['id_try'] == "1") | ($_SESSION['id_try'] == "2") || ($_SESSION['id_try'] == "3"))){
	  $_SESSION['id_try'] = "0";
	}
	if(($_SESSION['id_try'] == "0") || ($_SESSION['id_try'] == "1") || ($_SESSION['id_try'] == "2")){
	   $cnt = $_SESSION['id_try'];
		 ++$cnt;
		 $_SESSION['id_try'] = $cnt;
	}
}

if($progress == "3"){
  echo("<form method='post' action='forgot_password.php'>
	<table>
	<tr><td>New Password: </td><td><input type='password' name='password_1'></td></tr>
  <tr><td>Re-type New Password: </td><td><input type='password' name='password_2'></td></tr>
	</table>
  <input type='submit' value='Set new password'><br></form>
                  </td>
                </tr>
              </table>
            </td>
          </tr>
        </table>
        <table>  <!-- event message table -->
          <tr>
            <td>
                          <!-- event messages here -->

  ");
}
if($progress <= "3"){
  echo("
              </td>
            </tr>
          </table>
          </center>
          <!-- copyright table -->
          <tr>
            <td valign='bottom' align='right'>
                          <!-- copyright here -->
    			  <div class='events'>&#169;2006 Brad Wilson</div>
            </td>
          </tr>
			  </td>
		  </tr>
    </table>
    </body>
    </html>
	");
}
if($progress == "4"){
  echo("<html>
    <head>
    <title>Untitled</title>
		<meta http-equiv='Refresh' content='2;url=logout.php?pass_change=1'>
		<STYLE type='text/css'>
  		.events{
  		          color: white;
  							font-size: 10pt;
  							font-family: arial;
  		}
		</STYLE>
    </head>
    <body bgcolor='4A4A4A'>
		<table bgcolor='4A4A4A' width='100%' height='100%'>
		<tr>
		<td align='center'>
    <div class='events'>Password successfully changed.  You are being redirected to login.</div>
		</td>
		</tr>
		<td valign='bottom' align='right'>
		<div class='events'>&#169;2006 Brad Wilson</div>
		</td>
		</tr>
		</table>
	");
}
if($progress == "id_breach"){
  $db->query("UPDATE `users` SET `locked` = 'yes' WHERE `user_id`='$user_id' LIMIT 1");
	echo("<html>
    <head>
    <title>Untitled</title>
		<meta http-equiv='Refresh' content='0;url=logout.php?locked=1'>
    </head>
    <body>
		</body>
		</html>
	");
}

if($progress == "4"){
  echo("
    </body>
    </html>
  ");
}

?>
