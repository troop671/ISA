<?php
  include 'config.php';

  session_start();

  $result = "0";
  $redundant ="no";
  $expire_time = "997"; /*in seconds*/
  $refresh = $expire_time + "3";
  $side_panel_head_color = '4F5A83';
  $table_outline_color = 'black';
  $user_id = $_SESSION['user_id'];
  $password_hash = $_SESSION['password_hash'];
  $last_active = $_SESSION['last_active'];

  $db= new mysqli($mysql_host,$mysql_user,$mysql_passwd);

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

  if(($result >= "1")	&& ($expire == "no") && ($user_row['locked'] == "no")){
    $last_active = time();
    $_SESSION['last_active'] = $last_active;
    echo("
      <html>
      <head>
      <title>Treasurer Menu</title>
      <meta http-equiv='Refresh' content=' " . $refresh . " ;url=logout.php?timeout=1'>
      <STYLE type='text/css'>
      .scrollpanel{
                height: 641px;
                overflow: auto;
      }
      .scrollinterface{
                width: 548px;
                height: 613px;
                overflow: auto;
      }
      .toppanel{
                vertical-align: bottom;
                height: 23px;
                width: 548px;
      }
      .opener{
                color: white;
                font-size: 15pt;
                font-family: arial;
      }
      body, td {
                font-size: 10pt;
                font-family: arial;
      }
      </STYLE>
      </head>
      <body bgcolor='4A4A4A'>
      <br>
      <div class='opener'> &nbsp;	 &nbsp;	.::Welcome Back $user_row[first]!</div>
    ");

	// Uncomment the below block to debug variables
/* ?>
	<table>
<?php 


    foreach ($_POST as $key => $value) {
        echo "<tr>";
        echo "<td>";
        echo $key;
        echo "</td>";
        echo "<td>";
        echo $value;
        echo "</td>";
        echo "</tr>";
    }


?>
</table>
<?
// end debug variables black
*/
    //start top panel form variable retrieval
    if($_POST['create_account']){
        $create_account = $_POST['create_account'];
    }else{
         $create_account = "";
     }

    if($_POST['create']){
        $create = $_POST['create'];
    }else{
         $create = "";
     }

    if($_POST['create_gm']){
        $create_gm = $_POST['create_gm'];
    }else{
         $create_gm = "";
     }
    //end top panel form variable retrieval

    //start send general message form variable retrieval
    if($_POST['send_gm']){
        $send_gm = $_POST['send_gm'];
    }else{
         $send_gm = "";
     }

    if($_POST['gm']){
        $gm = $_POST['gm'];
    }else{
         $gm = "";
     }
    //end send general message form variable retrieval

    //start account update form variable retrieval
    if($_POST['first']){
        $first = $_POST['first'];
    }else{
         $first = "";
     }

    if($_POST['last']){
        $last = $_POST['last'];
    }else{
         $last = "";
     }

    if($_POST['edit_user_id']){
        $edit_user_id = $_POST['edit_user_id'];
    }else{
         $edit_user_id = "";
     }

    if($_POST['password']){
        $password = $_POST['password'];
    }else{
         $password = "";
     }

    if($_POST['email']){
        $email = $_POST['email'];
    }else{
         $email = "";
     }

    if($_POST['notice']){
        $notice = $_POST['notice'];
    }else{
         $notice = "";
     }

    if($_POST['balance']){
        $balance = $_POST['balance'];
    }else{
         $balance = "";
     }

    if($_POST['question']){
        $question = $_POST['question'];
    }else{
         $question = "";
     }

    if($_POST['answer']){
        $answer = $_POST['answer'];
    }else{
         $answer = "";
     }

    if($_POST['level']){
        $level = $_POST['level'];
    }else{
         $level = "";
     }

    if($_POST['locked']){
        $locked = $_POST['locked'];
    }else{
         $locked = "";
     }

    if($_POST['selected_user_id']){
        $selected_user_id = $_POST['selected_user_id'];
    }else{
         $selected_user_id = "";
     }

    if($_POST['delete_acc']){
        $delete_acc = $_POST['delete_acc'];
    }else{
         $delete_acc = "";
     }

    if($_POST['cancel']){
        $cancel = $_POST['cancel'];
    }else{
         $cancel = "";
     }

    if($_POST['update']){
        $update = $_POST['update'];
    }else{
         $update = "";
     }
    //end account update form variable retrieval

	//set edit all balances variable
	 if ($_POST['edit_all_balances']) {
        $edit_all_balances = $_POST['edit_all_balances'];
    } else {
        $edit_all_balances = "";
    }
	//end edit all balances variable

    //start panel form variable retrieval
    if($_POST['panel_selection']){
        $panel_selection = $_POST['panel_selection'];
    }else{
         $panel_selection = "";
     }

    if($_POST['selected_user']){
        $selected_user = $_POST['selected_user'];
    }else{
         $selected_user = "";
     }
    //end panel form variable retrieval

    //start edit all balances form retrieval and data processing
    if($_POST['cnt']){
      $count = $_POST['cnt'];
    }else{
       $count = "0";
     }

    if($_POST['process_all_b']){
      $process_all_b = $_POST['process_all_b'];
    }else{
       $process_all_b = "0";
     }

    if(($count != "0")	&& ($process_all_b == "submit all")){
      while($count >= "0"){
        $dummy = "edit_all_b$count";
        $dummer = "edit_all_id$count";
	//	mysql_query("UPDATE `users` SET `balance`='$_POST[$dummy]', `last_update`=NOW() WHERE `user_id`='$_POST[$dummer]'",$db);
		$db->query("UPDATE `users` SET `balance`='$_POST[$dummy]', `last_update`=NOW() WHERE `user_id`='$_POST[$dummer]'");
//        `last_update`=NOW(->query("UPDATE `users` SET `balance`='$_POST[$dummy]') WHERE `user_id`='$_POST[$dummer]'",$db);
        --$count;
      }
    }
    //end edit all balances form retrieval and data processing

    //start data processing
    //start create general messsage data processing
    if($send_gm == 'Send GM'){
      $db->query("UPDATE `users` SET `gm`='$gm'	WHERE `user_id` != ''");
    }
    //end create general message data processing

    //start unique user id verification
    if($edit_user_id != ''){
      $user_id_info = $db->query("SELECT * FROM `users` WHERE `user_id`='$edit_user_id'");
      $id_check = $user_id_info->num_rows;

      if(($id_check) && ($create == 'create account')){
        $user_id_check = 'non-unique';
      }

      if(($id_check == '0') | (($id_check == '1') && ($selected_user_id == $edit_user_id))){
        $user_id_check = 'ok';
      }

      if(($id_check >= '1') && ($selected_user_id != $edit_user_id) && ($update == 'update')){
        $user_id_check = 'non-unique';
      }
    }
    //end start unique user id verification

    //start email verification
    if($use_email == "account"){
      $email_to_check = "ok";
      $user_email = $user_row['email'];
    }

    if($email){
      if(preg_match('#^[a-z0-9.!\#$%&\'*+-/=?^_`{|}~]+@([0-9.]+|([^\s]+\.+[a-z]{2,6}))$#si', $email)){
        if(!(preg_match('(bcc:|cc:)', $email))){
          $email_to_check = "ok";
        }

        if((preg_match('(bcc:|cc:)', $email))){
           $db->query("UPDATE `users` SET `locked` = 'yes' WHERE `user_id`='$user_id' LIMIT 1");
           $email_to_check = "spam";
        }
      }else{
         $email_to_check = "invalid";
      }

    }else{
       $email_to_check = 'invalid';
    }
    //end email verification

    //start create account data processing
    if(($create == 'create account') && ($email_to_check == "ok") && ($user_id_check == 'ok')){
      $password_hash = SHA1($password);
//      `last`->query("INSERT INTO `users` (`first`) VALUES ('$first','$last','$edit_user_id','$password_hash','$email', '$balance',NOW(),'$question','$answer','$notice','$level','$locked')");
	  $db->query("INSERT INTO `users` (`first`, `last`, `user_id`, `password_hash`, `email`, `balance`, `last_update`, `question`, `answer`, `notice`, `level`, `locked`) VALUES ('$first','$last','$edit_user_id','$password_hash','$email', '$balance',NOW(),'$question','$answer','$notice','$level','$locked')");
      // Record to send log
      $logFile = "AccountUpdate.log";
      $fh = fopen($logFile, 'a') or die("can't open file");
      fwrite($fh, date("Y-m-d,H:i:s").",\"".$first."\",\"".$last."\",\"".$edit_user_id."\",\"".$email."\",".$balance.",\"".$notice."\"\n");
      fclose($fh);
    }
    //end create account data processing

    //start account update data processing
    if(($update == 'update') && ($email_to_check == "ok") && ($user_id_check == 'ok')){
      if($password != ''){
        $password_hash = SHA1($password);
        $db->query("UPDATE `users` SET `password_hash`='$password_hash' WHERE `user_id`='$selected_user_id'");
      }

//      `last`='$last'->query("UPDATE `users` SET `first`='$first'), `question`='$question', `answer`='$answer', `level`='$level', `locked`='$locked' WHERE `user_id`='$selected_user_id'",$db);
     $db->query("UPDATE `users` SET `first`='$first', `last`='$last',	`user_id`='$edit_user_id', `email`='$email', `notice`='$notice', `balance`='$balance', `last_update`=NOW(), `question`='$question', `answer`='$answer', `level`='$level', `locked`='$locked' WHERE `user_id`='$selected_user_id'");

      // Record to send log
      $logFile = "AccountUpdate.log";
      $fh = fopen($logFile, 'a') or die("can't open file");
      fwrite($fh, date("Y-m-d,H:i:s").",\"".$first."\",\"".$last."\",\"".$edit_user_id."\",\"".$email."\",".$balance.",\"".$notice."\",\"".$locked."\"\n");
      fclose($fh);
    }

    if(($delete_acc == 'delete') && ($update == 'update')){
      $db->query("DELETE FROM `users` WHERE `user_id`='$selected_user_id'");
    }
    //end	account update data processing
    //end data processing

    echo("
      <center>
      <table cellpadding='0' cellspacing='1'>
        <tr>
          <td>
            <table cellpadding='0' cellspacing='1'>
              <tr>
                <td bgcolor='$table_outline_color'>
                <table cellpadding='0' cellspacing='1' border='0' valign='middle'>
                <center>
                <td bgcolor='white'>
    ");

    // Start Top Panel
    echo("
      <div class='toppanel'>
      <form method='post' action='treasurer_menu.php'> &nbsp;<input type='submit' name='create_account' value='create account'> <input type='submit' name='edit_all_balances' value='edit all balances'> <input type='submit' name='create_gm' value='create GM'> <a href='logout.php'>LOGOUT</a></form>
      </div>
    ");
    // End Top Panel

    echo("
                </td>
                </table>
                </center
                </td>
              </tr>
              <tr>
                <td bgcolor='$table_outline_color'>
                <table cellpadding='0' cellspacing='1' border='0'>
                <center>
                <td bgcolor='white'>
                <div class='scrollinterface'>
    ");

    //start interface

    //start create general message interface
    if($create_gm == 'create GM'){
      $gm_result = $db->query("SELECT * FROM `users` ORDER BY `gm` ASC LIMIT 1");
      $gm = $gm_result->fetch_array();
      echo("
        Send General Message<br>
        <form method='post' action='treasurer_menu.php'>
        <textarea cols='60' rows='10' name='gm'>$gm[gm]</textarea>
        <input type='submit' name='send_gm' value='Send GM'>
        </form>
      ");
    }
    //end create genreal message inteface

    //start edit all balances interface
    if($edit_all_balances == "edit all balances"){
      $edit_all_result = $db->query("SELECT * FROM `users` WHERE `level`='user' ORDER BY `last` ASC, `first` ASC");
      $cnt = "0";
      echo("
        <form method='post' action='treasurer_menu.php'>
        <table>
      ");

      while($edit_all_row = $edit_all_result->fetch_array()){
        echo("
          <tr><td>$edit_all_row[last], $edit_all_row[first]</td></tr>
          <input type='hidden' name='edit_all_id$cnt' value='$edit_all_row[user_id]'>
          <tr><td>Balance: $<input type='text' name='edit_all_b$cnt' value='$edit_all_row[balance]'></td></tr>
          <tr><td><br></td></tr>
        ");
        ++$cnt;
      }

      echo("
        </table>
        <input type='hidden' name='cnt' value='$cnt'>
        <input type='submit' value='submit all' name='process_all_b'> <input type='submit' value='cancel'>
        </form>
      ");
    }
    //end edit all balances interface

    //start create account interface
    if(($create_account == 'create account')	|| ((($email_to_check == 'invalid') || ($user_id_check == 'non-unique')) && ($create == 'create account'))){
      if($level == 'user'){
        $user_checked = 'checked';
      }else{
         $user_checked = '';
      }

      if($level != 'treasurer'){
         $user_checked = 'checked';
      }else{
         $user_checked = '';
      }

      if($level == 'treasurer'){
        $treas_checked = 'checked';
      }else{
         $treas_checked = '';
      }

      if($locked == 'no'){
        $lock_no = 'checked';
      }else{
         $lock_no = '';
      }

      if($locked != 'yes'){
        $lock_no = 'checked';
      }else{
         $lock_no = '';
      }

      if($locked == 'yes'){
        $lock_yes = 'checked';
      }else{
         $lock_yes = '';
      }

      echo("
        <form method='post' action='treasurer_menu.php'>
        <table>
        <tr><td>First:</td><td><input type='text' name='first' value='$first'></td></tr>
        <tr><td>Last:</td><td><input type='text' name='last' value='$last'></td></tr>
        <tr><td>User ID:</td><td><input type='text' name='edit_user_id' value='$edit_user_id'></td></tr>
      ");

      if(($user_id_check == 'non-unique') && ($create == 'create account')){
        echo("
          <tr><td><font color='red'>Non-unique User ID, please try again.</font></td></tr>
        ");
      }

      echo("
        <tr><td>Password:</td><td><input type='text' name='password'></td></tr>
        <tr><td>E-mail:</td><td><input type='text' name='email' value='$email'></td></tr>
      ");

      if(($email_to_check == 'invalid') && ($create == 'create account')){
        echo("
          <tr><td><font color='red'>Please enter a valid e-mail.</font></td></tr>
        ");
      }

      echo("
        <tr><td>Personal Message:</td><td><textarea name='notice'>$notice</textarea></td></tr>
        <tr><td>Balance:</td><td>$<input type='text' name='balance' value='$balance'></td></tr>
        <tr><td>Question:</td><td><input type='text' name='question' value='$question'></td></tr>
        <tr><td>Answer:</td><td><input type='text' name='answer' value='$answer'></td></tr>
        <tr><td>level:</td><td><input name='level' value='user' type='radio' $user_checked>user</td><td><input value='treasurer' name='level' type='radio' $treas_checked>treasurer</td></tr>
        <tr><td>locked:</td><td><input value='no' name='locked' type='radio' $lock_no>no</td><td><input name='locked' value='yes' type='radio' $lock_yes>yes</td></tr>
        </table>
        <input type='submit' value='cancel' name='cancel'> <input type='submit' value='create account' name='create'>
        </form>
      ");
    }
    //end create account interface

    // start account update interface
    if(($panel_selection == 'edit') || (($email_to_check == 'invalid' || ($user_id_check == 'non-unique')) && ($update == 'update'))){
      if($selected_user == ''){
        $selected_user = $selected_user_id;
      }

      $select_user_result = $db->query("SELECT * FROM `users` WHERE `user_id`='$selected_user'");
      $selected_user = $select_user_result->fetch_array();

      if($selected_user['level'] == 'user'){
        $user_checked = 'checked';
      }else{
         $user_cheked = '';
       }

      if($selected_user['level'] == 'treasurer'){
        $treas_checked = 'checked';
      }else{
         $treas_cheked = '';
       }

      if($selected_user['locked'] == 'no'){
        $lock_no = 'checked';
      }else{
         $lock_no = '';
       }

      if($selected_user['locked'] == 'yes'){
        $lock_yes = 'checked';
      }else{
         $lock_yes = '';
       }

      echo("
        <form method='post' action='treasurer_menu.php'>
        <table>
        <tr><td>First:</td><td><input type='text' name='first' value='$selected_user[first]'></td><td>last updated: $selected_user[last_update]</td></tr>
        <tr><td>Last:</td><td><input type='text' name='last' value='$selected_user[last]'></td></tr>
        <tr><td>User ID:</td><td><input type='text' name='edit_user_id' value='$selected_user[user_id]'></td></tr>
      ");

      if(($user_id_check == 'non-unique') && ($update == 'update')){
        echo("
          <tr><td><font color='red'>Non-unique User ID, please try again.</font></td></tr>
        ");
      }

      echo("
        <tr><td>New password:</td><td><input type='text' name='password'></td></tr>
        <tr><td>E-mail:</td><td><input type='text' name='email' value='$selected_user[email]'></td></tr>
      ");

      if(($email_to_check == 'invalid') && ($update == 'update'))		{
        echo("
          <tr><td><font color='red'>Please enter a valid e-mail.</font></td></tr>
        ");
      }

      echo("
        <tr><td>Personal Message:</td><td><textarea name='notice'>$selected_user[notice]</textarea></td></tr>
        <tr><td>Balance:</td><td>$<input type='text' name='balance' value='$selected_user[balance]'></td></tr>
        <tr><td>Question:</td><td><input type='text' name='question' value='$selected_user[question]'></td></tr>
        <tr><td>Answer:</td><td><input type='text' name='answer' value='$selected_user[answer]'></td></tr>
        <tr><td>level:</td><td><input name='level' value='user' type='radio' $user_checked>user</td><td><input value='treasurer' name='level' type='radio' $treas_checked>treasurer</td></tr>
        <tr><td>locked:</td><td><input value='no' name='locked' type='radio' $lock_no>no</td><td><input name='locked' value='yes' type='radio' $lock_yes>yes</td></tr>
        </table><br>
        <br>
        <input type='hidden' name='selected_user_id' value='$selected_user[user_id]'>
        To delete account type 'delete' in the box:<input type='text' name='delete_acc'> <input type='submit' value='cancel' name='cancel'> <input type='submit' value='update' name='update'>
        </form>
      ");
    }
    // end account update interface

    // end interface

    echo("
            </div>
            </td>
            </table>
            </center>
            </td>
          </tr>
        </table>
      </td>
      <td bgcolor='$table_outline_color'>
      <center>
      <table cellpadding='0' cellspacing='1' border='0'>
      <td bgcolor='white'>
      <div class='scrollpanel'>
    ");

    // start side panel

    // start side panel 'users'
    echo("
      <table>
        <tr>
          <td bgcolor='$side_panel_head_color'>
            <center><font color='white'>USERS</font></center>
          </td>
        </tr>
    ");

    $panel_result = $db->query("SELECT * FROM `users` WHERE `level`='user' ORDER BY `last` ASC, `first` ASC");

    while($panel_row = $panel_result->fetch_array()){
      if($panel_row['locked'] == 'no'){
        $status = 'Unlocked';
      }

      if($panel_row['locked'] == 'yes'){
        $status = "<font color='red'>LOCKED</font>";
      }

      echo("
        <tr>
           <td>
            $panel_row[last], $panel_row[first]<br>
            Status: $status<br>
            Last Update: $panel_row[last_update]<br>
            Balance: $$panel_row[balance]<br>
            <form method='post' action='treasurer_menu.php'>
            <input type='hidden' name='selected_user' value='$panel_row[user_id]'>
            <input type='submit' value='edit' name='panel_selection'>
            </form>
            <hr width='100%'>
      ");
    }
    //end side panel 'users'

    //start side panel 'treasurers'
    echo("
          <tr>
            <td bgcolor='$side_panel_head_color'>
              <center><font color='white'>TREASURERS</font></center>
            </td>
          </tr>
    ");

    $panel_result = $db->query("SELECT * FROM `users` WHERE `level`='treasurer' ORDER BY `last` ASC, `first` ASC");

    while($panel_row = $panel_result->fetch_array()){
      if($panel_row['locked'] == 'no'){
        $status = 'Unlocked';
      }

		if($panel_row['locked'] == 'yes'){
        $status = "<font color='red'>LOCKED</font>";
      }

      echo("
      <tr>
         <td>
          $panel_row[last], $panel_row[first]<br>
          Status: $status<br>
          Last Update: $panel_row[last_update]<br>
          Balance: $$panel_row[balance]<br>
          <form method='post' action='treasurer_menu.php'>
          <input type='hidden' name='selected_user' value='$panel_row[user_id]'>
          <input type='submit' value='edit' name='panel_selection'>
          </form>
          <hr width='100%'>
      ");
    }
    // end side panel 'treasurers'

    // end side panel

    echo("
          </div>
          </td>
          </table>
          </center>
          </td>
        </tr>
      </table>
      </center>
      </body>
      </html>
    ");
  }

  if($result != "1"){
    echo("
      <html>
      <head>
      <title>Transferring</title>
      <meta http-equiv='Refresh' content='1;url=login.php'>
      </head>
      <body>
      Transferring . . .
    ");
    $redundant = "yes";
  }

  if(($expire == "yes") && ($redundant == "no")){
    echo("
      <html>
      <head>
      <title>Transferring</title>
      <meta http-equiv='Refresh' content='1;url=logout.php?timeout=1'>
      </head>
      <body>
      Session Timed Out.	Transferring . . .
    ");
    $redundant = "yes";
  }

  if((($user_row['locked'] == "yes") || ($email_to_check == "spam")) && ($redundant == "no")){
	echo("
		<html>
		<head>
		<title>Transferring</title>
		<meta http-equiv='Refresh' content='0;url=logout.php?locked=1'>
		</head>
		<body>
		Transferring . . .
  ");
}
?>

