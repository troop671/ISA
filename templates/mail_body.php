<html>
<head>
<title><?= $escape($request->user->last) ?>, <?= $escape($request->user->first) ?></title>
</head>
<body bgcolor='FFFFFF'>
<font face='arial'>
<br>
server timestamp:	<?= $escape($sentAt) ?><br>
<br>
<table>
  <tr>
    <td><img src='cid:bsa-logo' height='40'></td><td valign='middle'><font size='+2' color='999999'><b>T R O O P &nbsp; 6 7 1</b></font></td>
  </tr>
</table>
</font>
<br>
<?= $summary ?>
<?php if ($request->withdrawal): ?>
<font face='arial'>
I,	<?= $escape($name) ?>, request that $<?= $escape($request->amount) ?> be withdrawn from my ISA Account and be made payable to <?= $request->giveTo === $name ? 'myself to reimburse me for the following scout related activity or item: ' . $escape($request->event) . '.' : $escape($request->giveTo) . ' for ' . $escape($request->event) . '.' ?><br>
<br>
Signed:<br>
<br>
<b>x___________________________________</b> &nbsp;	&nbsp; Date:<b>______/______/______</b><br>
<br>
</font>
<?php endif ?>
</body>
</html>
