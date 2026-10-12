<?php use Troop671\Isa\RecoveryStep; ?>
<html>
<head>
<title>Forgot Password</title>
<?php if ($step === RecoveryStep::Changed): ?>
<meta http-equiv='Refresh' content='2;url=logout.php?pass_change=1'>
<?php endif ?>
<style type='text/css'>
  .events { color: white; font-size: 10pt; font-family: arial; }
  .title { color: white; font-size: 15pt; font-family: arial; }
</style>
</head>
<body bgcolor='4A4A4A'>
<?php if ($step === RecoveryStep::Changed): ?>
<table bgcolor='4A4A4A' width='100%' height='100%'>
  <tr><td align='center'><div class='events'>Password successfully changed.  You are being redirected to login.</div></td></tr>
  <tr><td valign='bottom' align='right'><div class='events'>&#169;2006 Brad Wilson</div></td></tr>
</table>
<?php else: ?>
<table bgcolor='4A4A4A' width='100%' height='100%'>
  <tr>
    <td>
      <center>
      <table cellpadding='0' cellspacing='2' bgcolor='black'>
        <tr>
          <td>
            <table bgcolor='white' border='0'>
              <tr>
                <td>
                  <table width='100%' cellspacing='0'>
                    <tr><td bgcolor='4F5A83'><font color='white'><div class='title'>Forgot Password</div></font></td></tr>
                  </table>
                  <br>
<?php if ($step === RecoveryStep::IdentifyUser): ?>
                  <form method='post' action='forgot_password.php'>
                  <?= $formToken ?>
                  <table>
                    <tr><td>user id: </td><td><input type='text' name='user_id'></td></tr>
                  </table>
                  <input type='hidden' name='cycled' value='1'>
                  <input type='submit' value='submit'>
                  </form>
<?php elseif ($step === RecoveryStep::AnswerQuestion): ?>
                  <form method='post' action='forgot_password.php'>
                  <?= $formToken ?>
                  <table>
                    <tr><td>Question: </td><td> <?= $escape($question) ?> </td></tr>
                    <tr><td>Answer:  </td><td><input type='password' name='answer_entered'></td></tr>
                  </table>
                  <input type='submit' value='submit'>
                  </form>
<?php else: ?>
                  <form method='post' action='forgot_password.php'>
                  <?= $formToken ?>
                  <table>
                    <tr><td>New Password: </td><td><input type='password' name='password_1'></td></tr>
                    <tr><td>Re-type New Password: </td><td><input type='password' name='password_2'></td></tr>
                  </table>
                  <input type='submit' value='Set new password'><br>
                  </form>
<?php endif ?>
                </td>
              </tr>
            </table>
          </td>
        </tr>
      </table>
      <table>
        <tr>
          <td>
<?php if ($error !== null): ?>
            <div class='events'><?= $error === 'User ID not found.' ? 'Error:  User ID not found.' : $escape($error) ?></div>
<?php endif ?>
          </td>
        </tr>
      </table>
      </center>
    </td>
  </tr>
  <tr>
    <td valign='bottom' align='right'><div class='events'>&#169;2006 Brad Wilson</div></td>
  </tr>
</table>
<?php endif ?>
</body>
</html>
