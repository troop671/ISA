<font face='arial'>
<?php if ($request->withdrawal): ?>
<font size='+1'><b>BSA TROOP 671 ISA WITHDRAWAL REQUEST</b><br></font>
<table>
  <tr><td>Name:</td><td> &nbsp; &nbsp; </td><td> <?= $escape($name) ?></td></tr>
  <tr><td>Amount:</td><td> &nbsp; &nbsp; </td><td> $<?= $escape($request->amount) ?></td></tr>
  <tr><td>Payable to:</td><td> &nbsp; &nbsp; </td><td> <?= $escape($request->giveTo) ?></td></tr>
  <tr><td>For:</td><td> &nbsp; &nbsp; </td><td> <?= $escape($request->event) ?></td></tr>
</table>
<br>
<?php if ($request->commented): ?>
Comments:<br>
<?= $paragraphs($request->comments) ?><br>
<?php endif ?>
<br>
<?php else: ?>
name: <?= $escape($name) ?><br>
<br>
Comments:<br>
<?= $paragraphs($request->comments) ?><br>
<?php endif ?>
</font>
