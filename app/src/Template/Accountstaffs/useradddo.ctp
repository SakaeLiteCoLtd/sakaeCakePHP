<?php
$this->layout = 'defaultaccount';
?>

<?php
use App\myClass\Shinkimenus\htmlShinkimenu;//myClassフォルダに配置したクラスを使用
?>
<?php
    $htmlShinkimenu = new htmlShinkimenu();
    $htmlaccountmenus = $htmlShinkimenu->accountmenus();
?>
<hr size="5" style="margin: 0.5rem">
<table style="margin-bottom:0px" width="750" border="0" align="center" cellpadding="0" cellspacing="0" bordercolor="#CCCCCC">
  <?php
       echo $htmlaccountmenus;
  ?>
</table>
<hr size="5" style="margin: 0.5rem">
<table style="margin-bottom:0px" width="500" border="0" align="center" cellpadding="0" cellspacing="0" bordercolor="#CCCCCC">
  <tr style="background-color: #E6FFFF">
    <td style="padding: 0.1rem 0.1rem;"><a href="qr/index.php"><?php echo $this->Html->image('Labelimg/usertouroku.gif',array('width'=>'105','url'=>array('action'=>'staffmenu')));?></td>
  </tr>
</table>
<hr size="5" style="margin: 0.5rem">
<table style="margin-bottom:0px" width="500" border="0" align="center" cellpadding="0" cellspacing="0" bordercolor="#CCCCCC">
  <tr style="background-color: #E6FFFF">
    <td style="padding: 0.1rem 0.1rem;"><a href="qr/index.php"><?php echo $this->Html->image('Labelimg/chokusoushinki.gif',array('width'=>'105','url'=>array('action'=>'useraddform')));?></td>
    <td style="padding: 0.1rem 0.1rem;"><a href="qr/index.php"><?php echo $this->Html->image('Labelimg/yobidashiyellow.gif',array('width'=>'105','url'=>array('action'=>'userichiran')));?></td>
  </tr>
</table>
<hr size="5" style="margin: 0.5rem">

<?= $this->Form->create($user, ['url' => ['action' => 'menu']]) ?>
<fieldset>

  <br>
  <div align="center"><font color="black" size="3"><?= __($mes) ?></font></div>
  <br>

  <table align="center" border="2" bordercolor="#E6FFFF" cellpadding="0" cellspacing="0" style="border-bottom: solid;border-width: 1px">
    <tr>
      <td width="280" bgcolor="#FFFFCC" style="font-size: 8pt;padding: 0.2rem"><strong style="font-size: 11pt; color:blue">社員</strong></td>
    </tr>
    <tr>
      <td bgcolor="#FFFFCC" style="padding: 0.2rem"><?= h($staff_name) ?></td>
    </tr>
  </table>
<br>
<table align="center" border="2" bordercolor="#E6FFFF" cellpadding="0" cellspacing="0" style="border-bottom: solid;border-width: 1px">
  <tr>
    <td width="280" bgcolor="#FFFFCC" style="font-size: 8pt;padding: 0.2rem"><strong style="font-size: 11pt; color:blue">ユーザー名</strong></td>
	</tr>
  <tr>
    <td bgcolor="#FFFFCC" style="padding: 0.2rem"><?= h($username) ?></td>
	</tr>
</table>
<br>
<table align="center" border="2" bordercolor="#E6FFFF" cellpadding="0" cellspacing="0" style="border-bottom: solid;border-width: 1px">
  <tr>
    <td width="282" bgcolor="#FFFFCC" style="font-size: 8pt;padding: 0.2rem"><strong style="font-size: 11pt; color:blue">パスワード</strong></td>
	</tr>
  <tr>
    <td bgcolor="#FFFFCC" style="padding: 0.2rem"><?= h("----") ?></td>
	</tr>
</table>

    </fieldset>
    <table align="center" border="2" bordercolor="#E6FFFF" cellpadding="0" cellspacing="0">
    <tr>
      <td style="border-style: none;"><div align="center"><?= $this->Form->submit(__('TOP'), array('name' => 'kakunin')); ?></div></td>
    </tr>
  </table>
<br>
