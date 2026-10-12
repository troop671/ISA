<table width='100%'>
  <tr><td bgcolor='4F5A83'><font color='white'><div class='header'>&nbsp;Change Account Question</div></font></td></tr>
</table>
<form method='post' action='xaccount_menu.php'>
<?= $formToken ?>
<table>
  <tr><td>Your Question: </td><td><?= $escape($user->question) ?></td></tr>
  <tr><td>Your Answer: </td><td><?= $escape($user->answer) ?></td></tr>
  <tr><td>New Question: </td><td><input type='text' name='question_1' size='50' value='<?= $escape($first) ?>'></td></tr>
  <tr><td>Re-type New Question:</td><td><input type='text' name='question_2' size='50' value='<?= $escape($second) ?>'></td></tr>
</table>
<input type='submit' value='Set New Question' name='set_new_question'><br>
</form>
<?php if ($message !== null): ?>
<br><?= $escape($message) ?>
<?php endif ?>
