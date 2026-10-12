<html>
<head>
<title>Account Login</title>
<style type='text/css'>
  .title { color: white; font-size: 15pt; font-family: arial; }
  .events { color: white; font-size: 10pt; font-family: arial; }
  body, td { font-size: 10pt; font-family: arial; }
</style>
<?php if ($refresh !== null): ?>
<meta http-equiv='Refresh' content='<?= (int) $refresh['seconds'] ?>;url=<?= $escape($refresh['url']) ?>'>
<?php endif ?>
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
                  <?= $formToken ?>
                  <table cellpadding='0' cellspacing='0'>
                    <tr><td bgcolor='4F5A83' align='center'><div class='title'>Troop 671 User Login<br></div></td></tr>
                    <tr>
                      <td>
                        <table>
                          <tr><td>User ID:</td><td><input type='text' name='user_id'></td></tr>
                          <tr><td>Password:</td><td><input type='password' name='password'></td></tr>
                        </table>
                      </td>
                    </tr>
                  </table>
                  <table width='100%'>
                    <tr><td align='right'><input type='submit' value='login'></td></tr>
                  </table>
                  </form>
                  <a href='forgot_password.php'>Forgot Password?</a><br>
                  <a href='mailto:<?= $escape($treasurerAddress) ?>'>Contact Treasurer</a>
                </td>
              </tr>
            </table>
          </td>
        </tr>
      </table><br>
      <div class='events'>
<?php if ($welcome !== null): ?>
        Welcome back <?= $escape($welcome) ?>!
<?php endif ?>
<?php if ($wrongAuthentication): ?>
        Wrong user id or password.
<?php endif ?>
<?php if ($locked): ?>
        Your account has been locked.  For more information please contact the Treasurer.
<?php endif ?>
<?php if ($timeout): ?>
        Your session has timed out.  Please login to view account.
<?php endif ?>
<?php if ($logout): ?>
        You have been successfully logged out.
<?php endif ?>
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
