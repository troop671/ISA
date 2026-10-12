<html>
<head>
<title>Update Email</title>
<?php if ($view === 'question'): ?>
<meta http-equiv='Refresh' content='<?= (int) $refreshSeconds ?>;url=logout.php?timeout=1'>
<?php elseif ($view === 'updated' || $view === 'unchanged'): ?>
<meta http-equiv='Refresh' content='2;url=update_email.php?close=2'>
<?php else: ?>
<script type='text/javascript'>
  window.self.close();
</script>
<?php endif ?>
<style type='text/css'>
  body, td { font-size: 10pt; font-family: arial; }
</style>
</head>
<body>
<br>
<br>
<br>
<center>
<?php if ($view === 'question'): ?>
<?= $escape($given) ?> is not your account e-mail: <?= $escape($user->email) ?>.<br>
<br>
Would you like to make <?= $escape($given) ?> your account e-mail?
<form method='post' action='update_email.php'>
<?= $formToken ?>
<input type='hidden' name='close' value='1'>
<input type='hidden' name='user_email_given' value='<?= $escape($given) ?>'>
<br>
<input type='submit' name='yes' value='yes'> &nbsp; &nbsp; <input type='submit' name='no' value='no'><br>
</form>
<?php elseif ($view === 'updated'): ?>
Account e-mail updated succesfully.
<?php elseif ($view === 'unchanged'): ?>
Account e-mail not updated.
<?php endif ?>
</center>
</body>
</html>
