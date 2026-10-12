<table width='100%'>
  <tr><td bgcolor='4F5A83'><font color='white'><div class='header'>&nbsp;Change Account User ID</div></font></td></tr>
</table>
<form method='post' action='xaccount_menu.php'>
<?= $formToken ?>
<table>
  <tr><td>New User ID: </td><td><input type='text' name='user_id_1' value='<?= $escape($first) ?>'></td></tr>
  <tr><td>Re-type New User ID: </td><td><input type='text' name='user_id_2' value='<?= $escape($second) ?>'></td></tr>
</table>
<input type='submit' value='Set New User ID' name='set_new_user_id'><br>
</form>
<?php if ($message !== null): ?>
<br><?= $escape($message) ?>
<?php endif ?>
