<?php if ($popup !== null): ?>
<script type='text/javascript'>
  window.open('<?= $escape($popup) ?>', '_blank', 'height=200,width=500,resizable=0,menubar=0,toolbar=0,location=0,directories=0,scrollbars=0,status=0');
</script>
<?php endif ?>
<table width='100%'>
  <tr><td bgcolor='4F5A83'><font color='white'><div class='header'>Confirmation</div></font></td></tr>
</table><br>
<?php foreach ($failures as $failure): ?>
<font color='red'><b>Send Error:</b> <?= $escape($failure) ?></font><br>
<?php endforeach ?>
<?php if ($succeeded): ?>
Thank you. Your message has been sent to the Treasurer.<br>
<?php if ($withdrawal): ?>
<br>
You will receive a reply from the Treasurer pertaining to your pending request.<br>
<br>
<b>NOTE: If you do not receive a reply within a few days please contact the Treasurer to ensure they have received the request.</b><br>
<?php endif ?>
<?php else: ?>
<b>A problem was encountered trying to send your request.<br>Please contact the Treasurer directly.<br><br>Copy the "MESSAGE SUMMARY" section below and email it to <?= $escape($treasurerAddress) ?><br>with the subject line of "<?= $escape($subject) ?>"<br></b>
<?php endif ?>
<br>
<table width='100%'>
  <tr><td bgcolor='4F5A83'><font color='white'>MESSAGE SUMMARY:</font></td></tr>
</table>
<?= $succeeded ? 'Sent' : 'Failed' ?> on: <?= $escape($sentAt) ?><br>
<br>
<?= $summary ?><br><br>
