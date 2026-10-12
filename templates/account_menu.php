<html>
<head>
<title>Account Menu</title>
<meta http-equiv='Refresh' content='<?= (int) $refreshSeconds ?>;url=logout.php?timeout=1'>
<style type='text/css'>
  .events { color: white; font-size: 10pt; font-family: arial; }
  .header { font-size: 14pt; font-family: arial; }
  .opener { color: white; font-size: 15pt; font-family: arial; }
  body, td { font-size: 10pt; font-family: arial; }
</style>
</head>
<body bgcolor='4A4A4A'>
<table bgcolor='4A4A4A' width='100%' height='100%'>
  <tr>
    <td>
      <div class='opener'>.::Welcome Back <?= $escape($user->first) ?>!</div>
      <center>
      <table bgcolor='4A4A4A' cellspacing='0'>
        <tr>
          <td>
            <table bgcolor='black' border='0' cellpadding='0' cellspacing='2' height='600' valign='top'>
              <tr>
                <td bgcolor='white' valign='top'>
                  <table width='100%'>
                    <tr><td bgcolor='4F5A83' align='center'><font color='white'><div class='header'>Control Panel</div></font></td></tr>
                  </table>
                  <br>
                  <form method='post' action='xaccount_menu.php'>
                  <?= $formToken ?>
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
            <table bgcolor='black' border='0' cellpadding='0' cellspacing='2' height='600' width='600' valign='top'>
              <tr>
                <td bgcolor='white' valign='top'>
<?= $panel ?>
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
      <div class='events'>&#169;2006 Brad Wilson</div>
    </td>
  </tr>
</table>
</body>
</html>
