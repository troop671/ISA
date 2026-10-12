<form method='post' action='treasurer_menu.php'>
<?= $formToken ?>
<table>
  <tr><td>First:</td><td><input type='text' name='first' value='<?= $escape($values['first']) ?>'></td><?php if ($lastUpdate !== null): ?><td>last updated: <?= $escape($lastUpdate) ?></td><?php endif ?></tr>
  <tr><td>Last:</td><td><input type='text' name='last' value='<?= $escape($values['last']) ?>'></td></tr>
  <tr><td>User ID:</td><td><input type='text' name='edit_user_id' value='<?= $escape($values['userId']) ?>'></td></tr>
<?php if ($nonUnique): ?>
  <tr><td><font color='red'>Non-unique User ID, please try again.</font></td></tr>
<?php endif ?>
  <tr><td><?= $lastUpdate === null ? 'Password:' : 'New password:' ?></td><td><input type='text' name='password'></td></tr>
  <tr><td>E-mail:</td><td><input type='text' name='email' value='<?= $escape($values['email']) ?>'></td></tr>
<?php if ($emailInvalid): ?>
  <tr><td><font color='red'>Please enter a valid e-mail.</font></td></tr>
<?php endif ?>
  <tr><td>Personal Message:</td><td><textarea name='notice'><?= $escape($values['notice']) ?></textarea></td></tr>
  <tr><td>Balance:</td><td>$<input type='text' name='balance' value='<?= $escape($values['balance']) ?>'></td></tr>
  <tr><td>Question:</td><td><input type='text' name='question' value='<?= $escape($values['question']) ?>'></td></tr>
  <tr><td>Answer:</td><td><input type='text' name='answer' value='<?= $escape($values['answer']) ?>'></td></tr>
  <tr><td>level:</td><td><input name='level' value='user' type='radio' <?= $checked($values['level'] === 'user') ?>>user</td><td><input value='treasurer' name='level' type='radio' <?= $checked($values['level'] === 'treasurer') ?>>treasurer</td></tr>
  <tr><td>locked:</td><td><input value='no' name='locked' type='radio' <?= $checked($values['locked'] === 'no') ?>>no</td><td><input name='locked' value='yes' type='radio' <?= $checked($values['locked'] === 'yes') ?>>yes</td></tr>
</table>
<?php if ($selectedId === null): ?>
<input type='submit' value='cancel' name='cancel'> <input type='submit' value='create account' name='create'>
<?php else: ?>
<br>
<br>
<input type='hidden' name='selected_id' value='<?= (int) $selectedId ?>'>
To delete account type 'delete' in the box:<input type='text' name='delete_acc'> <input type='submit' value='cancel' name='cancel'> <input type='submit' value='update' name='update'>
<?php endif ?>
</form>
