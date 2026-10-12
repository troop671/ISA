<script type='text/javascript'>
  function check_box() { document.getElementById('linked').checked = true; }
</script>
<table width='100%'>
  <tr><td bgcolor='4F5A83'><font color='white'><div class='header'>&nbsp;Contact Treasurer Form</div></font></td></tr>
</table>
<?php if ($nothingEntered): ?>
<font face='arial' color='red'><b>Error: You must complete Section 1, or Section 2, or Both.</b></font><br>
<?php endif ?>
<?php if (!$cycled): ?>
*You must complete Section 1, or Section 2, or Both.<br>
<?php endif ?>
<br>
<form action='xaccount_menu.php' method='post' name='email'>
<?= $formToken ?>
<table width='100%'>
  <tr><td bgcolor='4F5A83'><font color='white'>Your e-mail: (required)</font></td></tr>
</table>
<input type='radio' name='use_email' value='account' <?= $checked($useAccount) ?>>Use account e-mail: <?= $escape($user->email) ?>.<br>
<input type='radio' name='use_email' value='given' id='linked' <?= $checked($useGiven) ?>>Use following account: <input type='text' name='user_email_given' value='<?= $escape($given) ?>' onclick='check_box()'> (<input type='checkbox' name='store_email_given' value='yes'>make this my account e-mail)<br>
<?php if ($emailError): ?>
<font face='arial' color='red'><b>Error: Please enter in a valid e-mail.</b></font><br>
<?php endif ?>
<br>
<table width='100%'>
  <tr><td bgcolor='4F5A83'><font color='white'>Section 1:</font></td></tr>
</table>
Individual Scout Account Withdrawl REQUEST:<br>
<br>
Pay: $<input type='text' name='amount' value='<?= $escape($amount) ?>'> &nbsp; <i>to</i> &nbsp; <input type='radio' name='give_to' value='Troop 671' <?= $checked($giveTo === 'Troop 671') ?>>Troop 671 &nbsp; or &nbsp; <input type='radio' name='give_to' value='<?= $escape($name) ?>' <?= $checked($giveTo === $name) ?>><?= $escape($name) ?> &nbsp; <br>
(receipt needed for reimbursement)<br>
<br>
<?php if ($toError): ?>
<font face='arial' color='red'><b>Error: Please complete TO selection.</b></font><br>
<?php endif ?>
<?php if ($amountError): ?>
<font face='arial' color='red'><b>Error: Please complete Amount field.</b></font><br>
<?php endif ?>
For: <input type='text' name='event' size='50' value='<?= $escape($event) ?>'> &nbsp; <i>from</i> &nbsp; My BSA Troop 671 ISA.<br>
<?php if ($forError): ?>
<font face='arial' color='red'><b>Error: Please complete FOR field.</b></font><br>
<?php endif ?>
<br>
<table width='100%'>
  <tr><td bgcolor='4F5A83'><font color='white'>Section 2:</font></td></tr>
</table>
Comments: <br>
<textarea name='comments' rows='12' cols='70'><?= $escape($comments) ?></textarea><br>
<input type='hidden' name='cycled' value='yes'>
<input type='hidden' name='contact_treas' value='Contact Treasurer'>
<p align='right'><input type='submit' value='Send Mail' name='send_mail'></p>
</form>
