<html>
<head>
<title>Treasurer Menu</title>
<meta http-equiv='Refresh' content='<?= (int) $refreshSeconds ?>;url=logout.php?timeout=1'>
<style type='text/css'>
  .scrollpanel { height: 641px; overflow: auto; }
  .scrollinterface { width: 548px; height: 613px; overflow: auto; }
  .toppanel { vertical-align: bottom; height: 23px; width: 548px; }
  .opener { color: white; font-size: 15pt; font-family: arial; }
  body, td { font-size: 10pt; font-family: arial; }
</style>
</head>
<body bgcolor='4A4A4A'>
<br>
<div class='opener'> &nbsp;	 &nbsp;	.::Welcome Back <?= $escape($treasurer->first) ?>!</div>
<center>
<table cellpadding='0' cellspacing='1'>
  <tr>
    <td>
      <table cellpadding='0' cellspacing='1'>
        <tr>
          <td bgcolor='black'>
            <table cellpadding='0' cellspacing='1' border='0'>
              <tr>
                <td bgcolor='white'>
                  <div class='toppanel'>
                  <form method='post' action='treasurer_menu.php'>
                  <?= $formToken ?>
                  &nbsp;<input type='submit' name='create_account' value='create account'> <input type='submit' name='edit_all_balances' value='edit all balances'> <input type='submit' name='create_gm' value='create GM'> <a href='logout.php'>LOGOUT</a>
                  </form>
                  </div>
                </td>
              </tr>
            </table>
          </td>
        </tr>
        <tr>
          <td bgcolor='black'>
            <table cellpadding='0' cellspacing='1' border='0'>
              <tr>
                <td bgcolor='white'>
                  <div class='scrollinterface'>
<?php if ($generalMessage !== null): ?>
                  Send General Message<br>
                  <form method='post' action='treasurer_menu.php'>
                  <?= $formToken ?>
                  <textarea cols='60' rows='10' name='gm'><?= $escape($generalMessage) ?></textarea>
                  <input type='submit' name='send_gm' value='Send GM'>
                  </form>
<?php endif ?>
<?php if ($balances !== null): ?>
                  <form method='post' action='treasurer_menu.php'>
                  <?= $formToken ?>
                  <table>
<?php foreach ($balances as $index => $scout): ?>
                    <tr><td><?= $escape($scout->last) ?>, <?= $escape($scout->first) ?></td></tr>
                    <tr><td><input type='hidden' name='edit_all_id<?= $index ?>' value='<?= $scout->id ?>'>Balance: $<input type='text' name='edit_all_b<?= $index ?>' value='<?= $escape($scout->balance) ?>'></td></tr>
                    <tr><td><br></td></tr>
<?php endforeach ?>
                  </table>
                  <input type='hidden' name='cnt' value='<?= count($balances) ?>'>
                  <input type='submit' value='submit all' name='process_all_b'> <input type='submit' value='cancel'>
                  </form>
<?php endif ?>
<?php if ($creating): ?>
<?= $render('treasurer_account', [
  'values' => ['first' => $form->first, 'last' => $form->last, 'userId' => $form->userId, 'email' => $form->email, 'notice' => $form->notice, 'balance' => $form->balance, 'question' => $form->question, 'answer' => $form->answer, 'level' => $form->level, 'locked' => $form->locked],
  'lastUpdate' => null,
  'selectedId' => null,
  'nonUnique' => $createNonUnique,
  'emailInvalid' => $createEmailInvalid,
]) ?>
<?php endif ?>
<?php if ($editing !== null): ?>
<?= $render('treasurer_account', [
  'values' => ['first' => $editing->first, 'last' => $editing->last, 'userId' => $editing->userId, 'email' => $editing->email, 'notice' => $editing->notice, 'balance' => $editing->balance, 'question' => $editing->question, 'answer' => $editing->answer, 'level' => $editing->level, 'locked' => $editing->locked],
  'lastUpdate' => $editing->lastUpdate,
  'selectedId' => $editing->id,
  'nonUnique' => $updateNonUnique,
  'emailInvalid' => $updateEmailInvalid,
]) ?>
<?php endif ?>
                  </div>
                </td>
              </tr>
            </table>
          </td>
        </tr>
      </table>
    </td>
    <td bgcolor='black'>
      <table cellpadding='0' cellspacing='1' border='0'>
        <tr>
          <td bgcolor='white'>
            <div class='scrollpanel'>
            <table>
<?= $render('treasurer_roster', ['heading' => 'USERS', 'people' => $scouts]) ?>
<?= $render('treasurer_roster', ['heading' => 'TREASURERS', 'people' => $treasurers]) ?>
            </table>
            </div>
          </td>
        </tr>
      </table>
    </td>
  </tr>
</table>
</center>
</body>
</html>
