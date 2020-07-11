<?php
$this->layout = 'defaultaccount';
?>


<?= $this->Form->create($user, ['url' => ['action' => 'login']]) ?>
<fieldset>
<table align="center" border="2" bordercolor="#E6FFFF" cellpadding="0" cellspacing="0" style="border-bottom: solid;border-width: 1px">
<tr>
  <td bgcolor="#FFFFCC" style="font-size: 12pt;"><strong style="font-size: 11pt; color:blue">ID</strong></td>
  <td bgcolor="#FFFFCC"><?= $this->Form->control('username', array('type'=>'text', 'label'=>false)) ?></td>
</tr>
<tr>
  <td bgcolor="#FFFFCC" style="font-size: 12pt;"><strong style="font-size: 11pt; color:blue">パスワード</strong></td>
  <td bgcolor="#FFFFCC"><?= $this->Form->control('password', array('type'=>'password', 'label'=>false)) ?></td>
</tr>
</table>
</fieldset>

<table align="center" border="2" bordercolor="#E6FFFF" cellpadding="0" cellspacing="0">
<tr>
<td style="border-style: none;"><div align="center"><?= $this->Form->submit('ログイン', array('name' => 'login')); ?></div></td>
</tr>
</table>
<br><br>
<br><br>
