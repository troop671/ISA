<table width='100%'>
  <tr><td bgcolor='4F5A83'><font color='white'><div class='header'> &nbsp;My BSA Troop 671 ISA Information:</div></font></td></tr>
  <tr><td><br></td></tr>
  <tr>
    <td>
      <table cellspacing='0' cellpadding='0'>
        <tr><td>Account Balance: &nbsp;</td><td>$<?= $escape($user->balance) ?></td></tr>
        <tr><td>Last Update: &nbsp;</td><td><?= $escape($user->lastUpdate) ?></td></tr>
        <tr><td>Account E-mail: &nbsp;</td><td><?= $escape($user->email) ?></td></tr>
        <tr><td><br></td><td></td></tr>
      </table>
    </td>
  </tr>
<?php if ($user->gm !== ''): ?>
  <tr><td bgcolor='4F5A83'><font color='white'>General Message: </font></td></tr>
  <tr><td></td></tr>
  <tr><td><?= $paragraphs($user->gm) ?></td></tr>
  <tr><td><br></td></tr>
<?php endif ?>
<?php if ($user->notice !== ''): ?>
  <tr><td bgcolor='4F5A83'><font color='white'>Personal Message: </font></td></tr>
  <tr><td></td></tr>
  <tr><td><?= $paragraphs($user->notice) ?></td></tr>
<?php endif ?>
</table>
