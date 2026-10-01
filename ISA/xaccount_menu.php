<?php
  include 'config.php';
//  set_include_path(get_include_path() . PATH_SEPARATOR . '/home/troop671/php'  . PATH_SEPARATOR . '/home/troop671/php/Mail' . PATH_SEPARATOR . '/home/troop671/php/Net');
set_include_path("." . PATH_SEPARATOR . ($UserDir = dirname($_SERVER['DOCUMENT_ROOT'])) . "/pear/php" . PATH_SEPARATOR . get_include_path());
  require_once "Mail.php";

  session_start();

  $redundant = "no";
  $expire_time = "997"; /*in seconds*/
  $refresh = $expire_time + "3";
  $user_id = $_SESSION['user_id'];
  $password_hash = $_SESSION['password_hash'];
  $last_active = $_SESSION['last_active'];

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

  if($result == "1" && ($expire == "no") && ($user_row['locked'] == "no")){
    $last_active = time();
    $_SESSION['last_active'] = $last_active;

    //start variable retrieval
    if($_POST['main']){
      $main = $_POST['main'];
    }else{
       $main = 'Main';
    }

    if(($_POST['contact_treas']) || ($_POST['send_mail'] == 'Send Mail')){
      $contact_treas = 'Contact Treasurer';
      $no_main = 'yes';
    }else{
       $contact_treas = '';
    }

    if(($_POST['change_email']) || ($_POST['set_new_email'] == 'Set New E-mail')){
      $change_email = 'Change E-mail';
      $no_main = 'yes';
    }else{
       $change_email = '';
    }

    if(($_POST['change_password']) || ($_POST['set_new_password'] == 'Set New Password')){
      $change_password = 'Change Password';
      $no_main = 'yes';
    }else{
       $change_password = '';
    }

    if(($_POST['change_user_id'] == 'Change User ID') || ($_POST['set_new_user_id'] == 'Set New User ID')){
      $change_user_id = 'Change User ID';
      $no_main = 'yes';
    }else{
       $change_user_id = '';
    }

    if(($_POST['change_question'] == 'Change Question') || ($_POST['set_new_question'] == 'Set New Question')){
      $change_question = 'Change Question';
      $no_main = 'yes';
    }else{
       $change_question = '';
    }

    if(($_POST['change_answer'] == 'Change Answer') || ($_POST['set_new_answer'] == 'Set New Answer')){
      $change_answer = 'Change Answer';
      $no_main = 'yes';
    }else{
       $change_answer = '';
    }

    if($no_main == 'yes'){
      $main = '';
    }
    //end variable retrieval

    echo("
      <html>
      <head>
      <title>Account Menu</title>
      <meta http-equiv='Refresh' content=' " . $refresh . " ;url=logout.php?timeout=1'>
      <STYLE type='text/css'>
        .events{
                  color: white;
                  font-size: 10pt;
                  font-family: arial;
        }
        .header{
                 font-size: 14pt;
                 font-family: arial;
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
      </style>
      </head>
      <body bgcolor='4A4A4A'>
    ");

    //start GUI
    echo("
      <table bgcolor='4A4A4A' width='100%' height='100%'>	<!-- outer page table -->
        <tr>
          <td>
            <div class='opener'>.::Welcome Back $user_row[first]!</div>
            <center>
            <table bgcolor='4A4A4A' cellspacing='0'>	<!-- GUI table black matte -->
              <tr>
                <td>
                  <table bgcolor='black' border='0' cellpadding='0' cellspacing='2' height='600' vailgn='top'>	<!-- cell 1 table black matte -->
                    <tr>
                      <td bgcolor='white' valign='top'>
                                      <!-- cell 1 here -->
                      <table width='100%'>
                      <tr><td bgcolor='4F5A83' align='center'><font color='white'><div class='header'>Control Panel</div></font></td></tr>
                      </table>
                      <br>
                      <form method='post' action='xaccount_menu.php'>
                      <input type='submit' name='main' value='Main'><br>
                      <input type='submit' name='contact_treas' value='Contact Treasurer'><br>
                      <input type='submit' name='change_email' value='Change E-mail'><br>
                      <input type='submit' name='change_password' value='Change Password'><br>
                      <input type='submit' name='change_user_id' value='Change User ID'><br>
                      <input type='submit' name='change_question' value='Change Question'><br>
                      <input type='submit' name='change_answer' value='Change Answer'><br>
                      &nbsp;<a href='logout.php'>LOGOUT</a>
                      </form>
                      </td>
                    </tr>
                  </table>
                </td>
                <td>
                  <table bgcolor='black' border='0' cellpadding='0' cellspacing='2' height='600' width='600' valign='top'>	<!-- cell 2 table black matte -->
                    <tr>
                      <td bgcolor='white' valign='top'>
                                      <!-- cell 2 here -->
    ");

    //start cell 2
    //start main
    if ($main == 'Main') {
        echo("
        <table width='100%'>
          <tr><td bgcolor='4F5A83'><font color='white'><div class='header'> &nbsp;My BSA Troop 671 ISA Information:</div></font></td></tr>
          <tr><td><br></td></tr>
          <td>
          <table cellspacing='0' cellpadding='0'>
          <tr><td>Account Balance: &nbsp;</td><td>$" . $user_row['balance'] . "</td></tr>
          <tr><td>Last Update: &nbsp;</td><td>" . $user_row['last_update'] . "</td></tr>
          <tr><td>Account E-mail: &nbsp;</td><td>" . $user_row['email'] . "</td></tr>
          <tr><td><br></td><td></td></tr>
          </table>
          </tr>
          </td>
      ");

        if ($user_row['gm']) {
            echo("
          <tr><td bgcolor='4F5A83'><font color='white'>General Message: </font></td></tr>
          <tr><td></td></tr>
          <tr><td>" . $user_row['gm'] . "</td></tr>
          <tr><td><br></td></tr>
        ");
        }

        if ($user_row['notice']) {
            echo("
          <tr><td bgcolor='4F5A83'><font color='white'>Personal Message: </font></td></tr>
          <tr><td></td></tr>
          <tr><td>" . $user_row['notice'] . "</td></tr>
        ");
        }

        echo("
        </td>
        </tr>
        </table>
      ");
    }
    //end main

    //start contact treasurer
    if($contact_treas == 'Contact Treasurer'){
      //start general variable setting
      $email_info ="0";
      $email_sent = "no";
      $email_to_check = "0";
      $user_name = "$user_row[first] $user_row[last]";
      //end general variable setting

      //start form variable retrieval
      if($_POST['use_email']){
          $use_email = $_POST['use_email'];
          if($use_email == "account"){
            $account = "checked";
          }else{
             $account = "";
          }

          if($use_email == "given"){
            $given = "checked";
          }else{
             $given = "";
          }
      }else{
           $use_email = "0";
           $account = "checked";
      }

      if($_POST['user_email_given']){
          $user_email_given = $_POST['user_email_given'];
      }else{
           $user_email_given = "";
      }

      if($_POST['store_email_given']){
        $store_email_given = $_POST['store_email_given'];
      }else{
           $store_email_given = "new";
      }

      if($_POST['amount']){
          $amount = $_POST['amount'];
      }else{
           $amount = "";
      }

      if($_POST['give_to']){
          $give_to = $_POST['give_to'];
          if($give_to == 'Troop 671'){
            $troop = "checked";
          }else{
             $troop = "";
          }

          if($give_to == $user_name){
            $name = "checked";
          }else{
             $name = "";
          }
      }else{
           $give_to = "0";
      }

      if($_POST['event']){
          $event = $_POST['event'];
      }else{
           $event = "";
      }

      if($_POST['comments']){
          $comments = $_POST['comments'];
      }else{
           $comments = "";
      }

      if($_POST['cycled']){
          $cycled = $_POST['cycled'];
      }else{
           $cycled = "0";
      }
      //end form variable retrieval

      //start user email verification
      if($use_email == "account"){
        $email_to_check = "ok";
        $user_email = $user_row['email'];
      }

      if(($use_email == "given") && ($use_email != "0") && ($user_email_given != "")){
        if(preg_match('#^[a-z0-9.!\#$%&\'*+-/=?^_`{|}~]+@([0-9.]+|([^\s]+\.+[a-z]{2,6}))$#si', $user_email_given)){
          if(!(preg_match('(bcc:|cc:)', $user_email_given))){
            $email_to_check = "ok";
            $user_email = $user_email_given;
          }

          if((preg_match('(bcc:|cc:)', $user_email_given))){
             $db->query("UPDATE `users` SET `locked` = 'yes' WHERE `user_id`='$user_id' LIMIT 1");
             $email_to_check = "spam";
          }
        }else{
           $email_to_check = "invalid";
        }
      }
      //end user email verification

      //start section completion verification
      if((($amount != "") && ($give_to != "") && ($event != "")) && ($cycled == "yes")){
        $section_1 = "complete";
      }

      if(($amount == "") && ($give_to == "") && ($event == "")){
        $section_1 = "empty";
      }

      if((($amount == "") || ($give_to == "") || ($event == "")) && (($amount != "") || ($give_to != "0") || ($event != "")) && ($cycled == "yes")){
        $section_1 = "incomplete";
      }

      if(($comments != "") && ($cycled == "yes")){
        $section_2 = "complete";
      }

      if($comments == ""){
        $section_2 = "empty";
      }
      //end section completion verification

      //start mail function processing
      if(($email_to_check == "ok") && (($section_1 == "complete") || ($section_2 == "complete")) && ($section_1 != "incomplete")){
        $subject = "re: $user_name's BSA TROOP 671 ISA ACCOUNT";
        $sent_time = getdate();

        $time_stamp = "<html>
                       <head>
                       <title>$user_row[last], $user_row[first]</title>
                       </head>
                       <body bgcolor='FFFFFF'>
                       <font face='arial'>
                       <br>
                       server timestamp:	$sent_time[weekday] $sent_time[month] $sent_time[mday], $sent_time[year] at $sent_time[hours]:$sent_time[minutes]:$sent_time[seconds]<br>
                       <br>
                       <table>
                       <tr>
                       <td><img src='/ISA/BSA_Logo.jpg' height='40'></td><td valign='middle'><font size='+2' color='999999'><b>T R O O P &nbsp; 6 7 1</b></font></td>
                       </tr>
                       </table>
                       </font>
                       <br>";

        if(($section_1 == "complete") && ($section_2 != "complete")){
          $message = "<font face='arial'>
                      <font size='+1'><b>BSA TROOP 671 ISA WITHDRAWAL REQUEST</b><br></font>
                      <table>
                      <tr><td>
                      <tr><td>Name:</td><td> &nbsp; &nbsp; </td><td> $user_name<td></tr>
                      <tr><td>Amount:</td><td> &nbsp; &nbsp; </td><td> $$amount</td></tr>
                      <tr><td>Payable to:</td><td> &nbsp; &nbsp; </td><td> $give_to</td></tr>
                      <tr><td>For:</td><td> &nbsp; &nbsp; </td><td> $event</td></tr>
                      </td></tr>
                      </table>
                      <br>
                      <br></font>";
        }

        if(($section_1 != "complete") && ($section_2 == "complete")){
          $message = "<font face='arial'>
                      name: $user_name<br>
                      <br>
                      Comments:<br>
                      $comments<br>
                      </font>";
        }

        if(($section_1 == "complete") && ($section_2 == "complete")){
          $message = "<font face='arial'>
                      <font size='+1'><b>BSA TROOP 671 ISA WITHDRAWAL REQUEST</b><br></font>
                      <table>
                      <tr><td>
                      <tr><td>Name:</td><td> &nbsp; &nbsp; </td><td> $user_name<td></tr>
                      <tr><td>Amount:</td><td> &nbsp; &nbsp; </td><td> $$amount</td></tr>
                      <tr><td>Payable to:</td><td> &nbsp; &nbsp; </td><td> $give_to</td></tr>
                      <tr><td>For:</td><td> &nbsp; &nbsp; </td><td> $event</td></tr>
                      </td></tr>
                      </table>
                      <br>
                      Comments:<br>
                      $comments<br>
                      <br>
                      <br></font>";
        }

        if($give_to == $user_name){
          $inside_footer = "myself to reimburse me for the following scout related activity or item: $event.";
        }else{
           $inside_footer = "$give_to for $event.";
        }

        $footer = "<font face='arial'>
                   I,	$user_name, request that $$amount be withdrawn from my ISA Account and be made payable to $inside_footer<br>
                   <br>
                   Signed:<br>
                   <br>
                   <b>x___________________________________</b> &nbsp;	&nbsp; Date:<b>______/______/______</b><br>
                   <br>
                   <table bgcolor='E4EAF1'><tr>
                   <td bgcolor='E4EAF1'>
                   <font size='-1'>
                   <img src='".$path_to_phpISA_root."images/bottom_2.jpg'>
                   </font>
                   </td></tr>
                   </table>
                   </body>
                   </html>";

        if($section_1 == 'complete'){
          $message_sent = "$time_stamp $message $footer";
        }else{
           $message_sent = "$time_stamp $message";
        }

        $headers = "From: $user_name <$user_email>\nMIME-Version: 1.0\nContent-type: text/html; charset=iso-8859-1";
        $treas_info = $db->query("SELECT * FROM `users` WHERE level='treasurer'");
        $treas_check = $treas_info->num_rows;

        // Record to send log
        $logFile = "RequestSend.log";
        $fh = fopen($logFile, 'a') or die("can't open file");
        fwrite($fh, "========== $sent_time[weekday] $sent_time[month] $sent_time[mday], $sent_time[year] at $sent_time[hours]:$sent_time[minutes]:$sent_time[seconds] ==========\n");
        fwrite($fh, "Subject: ".$subject."\n");

        if($treas_check)
        {
          $all_sends_successful = "yes";

          while($treas_row = $treas_info->fetch_array())
          {
            $treas_email = $treas_row['email'];
            
            $mail_method = "SMTP";  // NONE, LOCAL, SMTP
            
            if ($mail_method == "LOCAL")
            {
                $sent_ok = mail($treas_email, $subject, $message_sent, $headers);
                fwrite($fh, "Using mail() to send to: \"".$treas_email."\", Status: ");
                if (!$sent_ok) {
                    echo("<font color=red><b>Send Error:</b> Failed to send</font><br>");
                    fwrite($fh, "Failed to send!\n");
                    $all_sends_successful = "no";
                } else {
                    fwrite($fh, "Successfully sent!\n");
                }
            }
            else if ($mail_method == "SMTP")
            {
                $from = "ISA.Troop671@Troop671.com";
                //$to = "Advisor@Crew671BSA.org";
                $to = $treas_email;
                
                $headers = array ('From' => $from,
                  'To' => $to,
                  'Subject' => $subject,
                  'MIME-Version' => "1.0",
                  'Content-type' => "text/html; charset=iso-8859-1"
                  );          
                
                $smtp = Mail::factory('smtp',
                  array ('host' => $host,
                    'port' => $port,
                    'auth' => true,
                    'debug' => false,
                    'username' => $username,
                    'password' => $password));
                
                $mail = $smtp->send($to, $headers, $message_sent);
                
                fwrite($fh, "Using ".$username." to send to: \"".$treas_email."\", Status: ");
                if (PEAR::isError($mail)) {
                    echo("<font color=red><b>Send Error:</b> ". $mail->getMessage() . "</font><br>");
                    fwrite($fh, $mail->getMessage() . "\n");
                    $all_sends_successful = "no";
                } else {
                    fwrite($fh, "Successfully sent!\n");
                }
            }
            else
            {
                echo("<font color=red><b>Send Error:</b> Sorry, but we are unable to send your request at this time.</font><br>");
                fwrite($fh, "Send Disabled!\n");
                $all_sends_successful = "no";
            }
          }
        }
        $email_sent = "yes";
        
        fwrite($fh, "========== $sent_time[weekday] $sent_time[month] $sent_time[mday], $sent_time[year] at $sent_time[hours]:$sent_time[minutes]:$sent_time[seconds] ==========\n");
        fclose($fh);

      }


      //end mail function processing

      if($email_sent == "no"){
        echo("<html>
          <head>
          <title>Contact Treasurer</title>
          <meta http-equiv='Refresh' content=' " . $refresh . " ;url=logout.php?timeout=1'>
        ");

        echo("
          <script language='JavaScript'>
            function check_box(){
              document.getElementById('linked').checked=true
            }
          </script>
          </head>
          <body>
        ");

        //start form processing
        echo("
          <table width='100%'>
          <tr><td bgcolor='4F5A83'><font color='white'><div class='header'>&nbsp;Contact Treasurer Form</div></font></td></tr>
          </table>
        ");

        if(((($amount == "") && ($give_to == "0") && ($event == "")) && ($comments == "")) && ($cycled == "yes")){
          echo("<font face='arial' color='red'><b>Error: You must complete Section 1, or Section 2, or Both.</b></font><br>");
        }

        if($cycled == "0"){
           echo("*You must complete Section 1, or Section 2, or Both.<br>");
        }

        echo("<br>
          <form action='xaccount_menu.php' method='post' name='email'>
          <table width='100%'>
          <tr><td bgcolor='4F5A83'><font color='white'>Your e-mail</u></b>: (required)</font></td></tr>
          </table>
          <input type='radio' name='use_email' value='account' $account>Use account e-mail: $user_row[email].<br>
          <input type='radio' name='use_email' value='given' id='linked' $given>Use following account: <input type='text' name='user_email_given' value='$user_email_given' onclick='check_box()'> (<input type='checkbox' name='store_email_given' value='yes'>make this my account e-mail)<br>
        ");

        if((($use_email == "given") && ($user_email_given == "")) || ($email_to_check == "invalid")){
          echo("<font face='arial' color='red'><b>Error: Please enter in a valid e-mail.</b></font><br>");
        }

        echo("<br>
          <table width='100%'>
          <tr><td bgcolor='4F5A83'><font color='white'>Section 1:</font></td></tr>
          </table>
          Individual Scout Account Withdrawl REQUEST:<br>
          <br>
          Pay: $<input type='text' name='amount' value='$amount'> &nbsp; <i>to</i> &nbsp; <input type='radio' name='give_to' value='Troop 671' $troop>Troop 671 &nbsp; or &nbsp; <input type='radio' name='give_to' value='$user_name' $name>$user_name &nbsp; <br>
          (receipt needed for reimbursement)<br>
          <br>
        ");

        if(($give_to == "0") && ($cycled == "yes") && (($amount != "") || ($give_to != "0") || ($event != ""))){
          echo("<font face='arial' color='red'><b>Error: Please complete TO selection.</b></font><br>");
        }

        if(($amount == "") && ($cycled == "yes") && (($amount != "") || ($give_to != "0") || ($event != ""))){
          echo("<font face='arial' color='red'><b>Error: Please complete Amount field.</b></font><br>");
        }

        echo("For: <input type='text' name='event' size='50' value='$event'> &nbsp; <i>from</i> &nbsp; My BSA Troop 671 ISA.<br>");

        if(($event == "") && ($cycled == "yes") && (($amount != "") || ($give_to != "0") || ($event != ""))){
          echo("<font face='arial' color='red'><b>Error: Please complete FOR field.</b></font><br>");
        }

        echo("
          <br>
          <table width='100%'>
          <tr><td bgcolor='4F5A83'><font color='white'>Section 2:</font></td></tr>
          </table>
          Comments: <br>
          <textarea name='comments' rows='12' cols='70'>$comments</textarea><br>
          <input type='hidden' name='cycled' value='yes'>
          <p align='right'><input type='submit' value='Send Mail' name='send_mail'></p>
          </form>
          </font>
        ");
        //end form processing

        echo("
          </body>
          </html>
        ");
      }

      //start email_sent handling
      if($email_sent == "yes"){
        echo("<html>
          <head>
          <title>Email Sent</title>
        ");

        if(($use_email == 'given') && ($store_email_given == 'yes')){
          $db->query("UPDATE `users` SET `email` = '$user_email_given' WHERE `user_id`='$user_id' AND `password_hash` = '$password_hash' LIMIT 1");
          echo("
              <SCRIPT language='JavaScript'>
              window.open('update_email.php?pass=1&close=1','_blank','height=200,width=500,resizable=0,menubar=0,toolbar=0,location=0,directories=0,scrollbars=0,status=0');
              </SCRIPT>
          ");
        }

        if(($use_email == 'given') && ($store_email_given == 'new')){
          $email_info = $db->query("SELECT * FROM `users` WHERE user_id = '$user_id' AND email = '$user_email_given'");
          $same_email = $email_info->num_rows;
          if($same_email == "0"){
            echo("
              <SCRIPT language='JavaScript'>
              window.open('update_email.php?user_email_given=" . $user_email_given . "','_blank','height=200,width=500,resizable=0,menubar=0,toolbar=0,location=0,directories=0,scrollbars=0,status=0');
              </SCRIPT>
            ");
          }
        }

        echo("</head>
          <body>
          <table width='100%'>
          <tr><td bgcolor='4F5A83'><font color='white'><div class='header'>Confirmation</div></font></td></tr>
          </table><br>
        ");


        if ($all_sends_successful == "yes")
        {
            $status_text = "Sent";
            echo("Thank you. Your message has been sent to the Treasurer.<br>");

            if($section_1 == 'complete'){
                echo("<br>");
                echo("You will receive a reply from the Treasurer pertaining to your pending request.<br>");
                echo("<br>");
                echo("<b>NOTE: If you do not receive a reply within a few days please contact the Treasurer to ensure they have received the request.</b><br>");
            }
        }
        else
        {
            $status_text = "Failed";
            echo("<b>A problem was encountered trying to send your request.<br>Please contact the Treasurer directly.<br><br>".
            "Copy the \"MESSAGE SUMMARY\" section below and email it to treasurer@troop671bsa.org<br>with the subject line of \"".
            $subject."\"<br></b>");
        }
        
        echo("
          <br>
          <table width='100%'>
          <tr><td bgcolor='4F5A83'><font color='white'>MESSAGE SUMMARY:</font></td></tr>
          </table>
          $status_text on: $sent_time[weekday] $sent_time[month] $sent_time[mday], $sent_time[year] at $sent_time[hours]:$sent_time[minutes]:$sent_time[seconds]<br>
          <br>
          $message<br><br>
          </body>
          </html>
        ");
      }
      //end email_sent handling
    }
    //end contact treasurer

    //start change e-mail
    if($change_email == 'Change E-mail'){
      $new_email = '0';
      $updated = 'new';

      if(empty($email_to_check)){
        $email_to_check = "new";
      }

      //start variable retreival
      if($_POST['email_1']){
        $email_1 = $_POST['email_1'];
      }else{
         $email_1 = "0";
      }

      if($_POST['email_2']){
        $email_2 = $_POST['email_2'];
      }else{
         $email_2 = "0";
      }
      //end variable retreival

      //start user email verification
      if(($email_1 == $email_2) && ($email_2 != "0")){
        if(preg_match('#^[a-z0-9.!\#$%&\'*+-/=?^_`{|}~]+@([0-9.]+|([^\s]+\.+[a-z]{2,6}))$#si', $email_1)){
          if(!(preg_match('(bcc:|cc:)', $email_1))){
            $email_to_check = "ok";
          }

          if((preg_match('(bcc:|cc:)', $email_1))){
             $db->query("UPDATE `users` SET `locked` = 'yes' WHERE `user_id`='$user_id' LIMIT 1");
             $email_to_check = "spam";
          }
        }else{
           $email_to_check = "invalid";
           $updated = "2";
        }
      }
      //end user email verification

      if($email_to_check != "spam"){
        echo("
          <html>
          <head>
          <title>Change E-mail</title>
          <meta http-equiv='Refresh' content=' " . $refresh . " ;url=logout.php?timeout=1'>
          </head>
          <body>
          <table width='100%'>
          <tr><td bgcolor='4F5A83'><font color='white'><div class='header'>&nbsp;Change Account E-mail</div></font></td></tr>
          </table>
        ");

        if(($email_1 == $email_2) && ($email_1 != "0") && ($email_to_check == "ok")){
          $new_email = $email_1;
          if (!$db){
            echo("<b>Error connecting to database! Please try again later...</b>");
          }

          $db->select_db($mysql_dbname);
          $user_info = $db->query("UPDATE `users` SET `email` = '$new_email' WHERE `user_id`='$user_id' LIMIT 1");
          $updated = "1";
        }

        if(($email_1 != $email_2)	&& ($email_1 != "0")){
           $updated = "0";
        }

        echo("
          <form method='post' action='xaccount_menu.php'>
          <table>
          <tr><td>New E-mail:</td><td><input type='text' name='email_1'></td></tr>
          <tr><td>Re-type New E-mail:</td><td><input type='text' name='email_2'></td></tr>
          </table>
          <input type='submit' value='Set New E-mail' name='set_new_email'><br>
          <p>
        ");

        if($updated == "2"){
          echo("Please enter a valid email.");
        }

        if($updated == "1"){
          echo("<br>E-mail successfully updated.");
        }

        if($updated == "0"){
          echo("<br>Error; Please try again..");
        }
      }

      if($email_to_check == "spam"){
        echo("<html>
          <head>
          <title>Transfering</title>
          <meta http-equiv='Refresh' content='1;url=logout.php?locked=1'>
          </head>
          <body>
          Transfering . . .
        ");
      }
    }
    //end change e-mail

    //start change password
    if($change_password == 'Change Password'){
      $updated = "new";

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

      if(($password_1 == $password_2) && $password_1 != "0"){
        $new_password = SHA1($password_1);
        if (!$db){
          echo("<b>Error connecting to database! Please try again later...</b>");
        }

        $db->select_db($mysql_dbname);
        $user_info = $db->query("UPDATE `users` SET `password_hash` = '$new_password' WHERE `user_id`='$user_id' LIMIT 1");
        $updated = "1";
        $_SESSION['password_hash'] = $new_password;
      }

      if(($password_1 != $password_2)	&& $password_1 != "0"){
         $updated = "0";
      }

      echo("
        <table width='100%'>
        <tr><td bgcolor='4F5A83'><font color='white'><div class='header'>&nbsp;Change Account Password</div></font></td></tr>
        </table>
        <form method='post' action='xaccount_menu.php'>
        <table>
        <tr><td>New Password: </td><td><input type='password' name='password_1'></td></tr>
        <tr><td>Re-type New Password: </td><td><input type='password' name='password_2'></td></tr>
        </table>
        <input type='submit' value='Set New Password' name='set_new_password'><br>
        <p>
      ");

      if($updated == "1"){
        echo("<br>Password successfully updated.");
      }

      if($updated == "0"){
        echo("<br>Error; Please try again.");
      }
    }
    //end change password

    //start change user id
    if($change_user_id == 'Change User ID'){
      $updated = "new";
      $new_user_id = "0";

      if($_POST['user_id_1']){
        $user_id_1 = $_POST['user_id_1'];
      }else{
         $user_id_1 = "";
      }

      if($_POST['user_id_2']){
        $user_id_2 = $_POST['user_id_2'];
      }else{
         $user_id_2 = "";
      }

      if(($user_id_1 == $user_id_2) && $user_id_1 != ""){
        $new_user_id = $user_id_1;
        $dup_check = $db->query("SELECT * FROM `users` WHERE user_id='$user_id_1'");
        $duplicate = $dup_check->num_rows;

        if($duplicate == "0"){
          if (!$db){
            echo("<b>Error connecting to database! Please try again later...</b>");
          }

          $db->select_db($mysql_dbname);
          $user_info = $db->query("UPDATE `users` SET `user_id` = '$new_user_id' WHERE `password_hash`='$password_hash' LIMIT 1");
          $updated = "1";
          $_SESSION['user_id'] = $new_user_id;
        }

        if($duplicate >= "1"){
          $updated = "2";
        }
      }

      if(($user_id_1 != $user_id_2)	&& $user_id_1 != ""){
         $updated = "0";
      }

      if($updated == '1'){
        $user_id_1 = '';
        $user_id_2 = '';
      }

      echo("
        <table width='100%'>
        <tr><td bgcolor='4F5A83'><font color='white'><div class='header'>&nbsp;Change Account User ID</div></font></td></tr>
        </table>
        <form method='post' action='xaccount_menu.php'>
        <table>
        <tr><td>New User ID: </td><td><input type='edit' name='user_id_1' value='$user_id_1'></td></tr>
        <tr><td>Re-type New User ID: </td><td><input type='edit' name='user_id_2' value='$user_id_2'></td></tr>
        </table>
        <input type='submit' value='Set New User ID' name='set_new_user_id'><br>
        </form>
      ");

      if($updated == "1"){
        echo("<br>User ID successfully updated.");
      }

      if($updated == "0"){
        echo("<br>Error; Please try again...");
      }

      if($updated == "2"){
        echo("<br>Non-Unique User ID; Please try again...");
      }
    }
    //end change user id

    //start change question
    if($change_question == 'Change Question'){
      $updated = "new";
      $new_question = "0";

      if($_POST['question_1']){
        $question_1 = $_POST['question_1'];
      }else{
         $question_1 = "";
      }

      if($_POST['question_2']){
        $question_2 = $_POST['question_2'];
      }else{
         $question_2 = "";
      }

      if(($question_1 == $question_2) && $question_1 != ""){
        $new_question = $question_1;
        if (!$db){
          echo("<b>Error connecting to database! Please try again later...</b>");
        }

        $db->select_db($mysql_dbname);
        $user_info = $db->query("UPDATE `users` SET `question` = '$new_question' WHERE `user_id`='$user_id' LIMIT 1");
        $updated = "1";
        $_SESSION['new_question'] = $new_question;
        $login_info = $db->query("SELECT * FROM `users` WHERE user_id='$user_id' AND password_hash='$password_hash'");
        $user_row = $login_info->fetch_array();
      }

      if(($question_1 != $question_2)	&& $question_1 != ""){
         $updated = "0";
      }

      if($updated == '1'){
        $question_1 = '';
        $question_2 = '';
      }

      echo("
        <table width='100%'>
        <tr><td bgcolor='4F5A83'><font color='white'><div class='header'>&nbsp;Change Account Question</div></font></td></tr>
        </table>
        <table>
        <tr><td>Your Question: </td><td>" . $user_row['question']. " </td></tr>
        <tr><td>Your Answer: </td><td>" . $user_row['answer'] . " </td></tr>
        <form method='post' action='xaccount_menu.php'>
        <tr><td>New Question: </td><td><input type='edit' name='question_1' size='50' value='$question_1'></td></tr>
        <tr><td>Re-type New Question:</td><td><input type='edit' name='question_2' size='50' value='$question_2'></td></tr>
        </table>
        <input type='submit' value='Set New Question' name='set_new_question'><br>
        </form>
      ");

      if($updated == "1"){
        echo("<br>Question successfully updated.");
      }

      if($updated == "0"){
        echo("<br>Error; Please try again..");
      }
    }
    //end change question

    //start change answer
    if($change_answer == 'Change Answer'){
      $updated = "new";
      $new_answer = "0";

      if($_POST['answer_1']){
        $answer_1 = $_POST['answer_1'];
      }else{
         $answer_1 = "";
      }

      if($_POST['answer_2']){
        $answer_2 = $_POST['answer_2'];
      }else{
         $answer_2 = "";
      }

      if(($answer_1 == $answer_2) && $answer_1 != ""){
        $new_answer = $answer_1;
        if (!$db){
          echo("<b>Error connecting to database! Please try again later...</b>");
        }

        $db->select_db($mysql_dbname);
        $user_info = $db->query("UPDATE `users` SET `answer` = '$new_answer' WHERE `user_id`='$user_id' LIMIT 1");
        $updated = "1";
        $_SESSION['new_answer'] = $new_answer;
        $login_info = $db->query("SELECT * FROM `users` WHERE user_id='$user_id' AND password_hash='$password_hash'");
        $user_row = $login_info->fetch_array();
      }

      if(($answer_1 != $answer_2)	&& $answer_1 != ""){
         $updated = "0";
      }

      echo("
        <table width='100%'>
        <tr><td bgcolor='4F5A83'><font color='white'><div class='header'>&nbsp;Change Account Answer</div></font></td></tr>
        </table>
        <table>
        <table>
        <tr><td>Your Question: </td><td>" . $user_row['question'] . "</td></tr>
        <tr><td>Your Answer: </td><td>" . $user_row['answer'] . "</td></tr>
        <form method='post' action='xaccount_menu.php'>
        <tr><td>New Answer: </td><td><input type='password' name='answer_1'></td></tr>
        <tr><td>Re-type New Answer: </td><td><input type='password' name='answer_2'></td></tr>
        </table>
        <input type='submit' value='Set New Answer' name='set_new_answer'><br>
        </form>
      ");

      if($updated == "1"){
        echo("<br>Answer successfully updated.");
      }

      if($updated == "0"){
        echo("<br>Error; Please try again...");
      }
    }
    //end change answer
    //end cell 2

    echo("
                      </td>
                    </tr>
                  </table>
                </td>
              </tr>
            </table>
            </center>
          </td>
        </tr>
        <tr>
          <td align='right' valign='bottom'>
                   <!-- copyright here -->
          <div class='events'>&#169;2006 Brad Wilson</div>
          </td>
        </tr>
      </table>
    ");
    //end GUI
  }

  if($result != "1"){
    echo("
      <html>
      <head>
      <title>Transfering</title>
      <meta http-equiv='Refresh' content='1;url=login.php'>
      <STYLE type='text/css'>
        .events{
                  color: white;
                  font-size: 10pt;
                  font-family: arial;
        }
      </STYLE>
      </head>
      <body bgcolor='4A4A4A'>
      <table width='100%' height='100%'>
      <tr>
      <td>
      <center>
      <table>
      <tr><td><div class='events'>Transfering . . .</div></td></tr>
      </table>
      </center>
      </td>
      </tr>
      </table>
      ");
    $redundant = "yes";
  }

  if($expire == "yes" && ($redundant == "no")){
    echo("
      <html>
      <head>
      <title>Transfering</title>
      <meta http-equiv='Refresh' content='1;url=login.php?timeout=1'>
      <STYLE type='text/css'>
        .events{
                  color: white;
                  font-size: 10pt;
                  font-family: arial;
        }
      </STYLE>
      </head>
      <body bgcolor='4A4A4A'>
      <table width='100%' height='100%'>
      <tr>
      <td>
      <center>
      <table>
      <tr><td><div class='events'>Session Timed Out.	Transfering . . .</div></td></tr>
      </table>
      </center>
      </td>
      </tr>
      </table>
      ");
    $redundant = "yes";
  }

  if((($user_row['locked'] == "yes") || ($email_to_check == 'spam')) && ($redundant == "no")){
    echo("
      <html>
      <head>
      <title>Transfering</title>
      <meta http-equiv='Refresh' content='1;url=logout.php?locked=1'>
      </head>
      <body>
      Transfering . . .
      ");
  }

  $db->close;

  echo("
    </body>
    </html>
  ");
?>
