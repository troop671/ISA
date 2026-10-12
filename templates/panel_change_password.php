<table width='100%'>
  <tr><td bgcolor='4F5A83'><font color='white'><div class='header'>&nbsp;Change Account Password</div></font></td></tr>
</table>
<form method='post' action='xaccount_menu.php'>
<?= $formToken ?>
<table>
  <tr><td>New Password: </td><td><input type='password' name='password_1'></td></tr>
  <tr><td>Re-type New Password: </td><td><input type='password' name='password_2'></td></tr>
</table>
<input type='submit' value='Set New Password' name='set_new_password'><br>
</form>
<?php if ($message !== null): ?>
<br><?= $escape($message) ?>
<?php endif ?>
