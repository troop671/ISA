<tr>
  <td bgcolor='4F5A83'>
    <center><font color='white'><?= $escape($heading) ?></font></center>
  </td>
</tr>
<?php foreach ($people as $person): ?>
<tr>
  <td>
    <?= $escape($person->last) ?>, <?= $escape($person->first) ?><br>
    Status: <?= $person->locked === 'yes' ? "<font color='red'>LOCKED</font>" : ($person->locked === 'no' ? 'Unlocked' : '') ?><br>
    Last Update: <?= $escape($person->lastUpdate) ?><br>
    Balance: $<?= $escape($person->balance) ?><br>
    <form method='post' action='treasurer_menu.php'>
    <?= $formToken ?>
    <input type='hidden' name='selected_user' value='<?= $person->id ?>'>
    <input type='submit' value='edit' name='panel_selection'>
    </form>
    <hr width='100%'>
  </td>
</tr>
<?php endforeach ?>
