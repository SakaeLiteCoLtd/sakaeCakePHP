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
    <td style="padding: 0.1rem 0.1rem;"><a href="qr/index.php"><?php echo $this->Html->image('Labelimg/stafftouroku.gif',array('width'=>'105','url'=>array('action'=>'staffmenu')));?></td>
  </tr>
</table>
<hr size="5" style="margin: 0.5rem">
<table style="margin-bottom:0px" width="500" border="0" align="center" cellpadding="0" cellspacing="0" bordercolor="#CCCCCC">
  <tr style="background-color: #E6FFFF">
    <td style="padding: 0.1rem 0.1rem;"><a href="qr/index.php"><?php echo $this->Html->image('Labelimg/chokusoushinki.gif',array('width'=>'105','url'=>array('action'=>'staffaddform')));?></td>
    <td style="padding: 0.1rem 0.1rem;"><a href="qr/index.php"><?php echo $this->Html->image('Labelimg/chokusouhensyuu.gif',array('width'=>'105','url'=>array('action'=>'staffeditkensaku')));?></td>
  </tr>
</table>
<hr size="5" style="margin: 0.5rem">

    <?= $this->Form->create($user, ['url' => ['action' => 'staffaddconfirm']]) ?>
    <fieldset>

<table align="center" border="2" bordercolor="#E6FFFF" cellpadding="0" cellspacing="0" style="border-bottom: solid;border-width: 1px">
  <tr>
    <td width="280" bgcolor="#FFFFCC" style="font-size: 8pt;padding: 0.2rem"><strong style="font-size: 11pt; color:blue">姓</strong></td>
    <td width="282" bgcolor="#FFFFCC" style="font-size: 8pt;padding: 0.2rem"><strong style="font-size: 11pt; color:blue">名</strong></td>
	</tr>
  <tr>
    <td bgcolor="#FFFFCC" style="padding: 0.2rem"><?= $this->Form->control('f_name', array('type'=>'text', 'label'=>false, 'autofocus'=>true, 'required'=>true)) ?></td>
    <td bgcolor="#FFFFCC" style="padding: 0.2rem"><?= $this->Form->control('l_name', array('type'=>'text', 'label'=>false, 'required'=>true)) ?></td>
	</tr>
</table>
<br>
<table align="center" border="2" bordercolor="#E6FFFF" cellpadding="0" cellspacing="0" style="border-bottom: solid;border-width: 1px">
  <tr>
    <td width="280" bgcolor="#FFFFCC" style="font-size: 8pt;padding: 0.2rem"><strong style="font-size: 11pt; color:blue">スタッフＩＤ</strong></td>
    <td width="282" colspan="2" bgcolor="#FFFFCC" style="font-size: 8pt;padding: 0.2rem"><strong style="font-size: 11pt; color:blue">性別</strong></td>
	</tr>
  <tr>
    <td bgcolor="#FFFFCC" style="padding: 0.2rem"><?= $this->Form->control('staff_code', array('type'=>'text', 'pattern'=>'^[0-9.-]+$', 'title'=>'半角数字で入力して下さい。', 'label'=>false, 'required'=>true)) ?></td>
    <td bgcolor="#FFFFCC" style="border-right-style: none"><input type="radio" name="sex" value="0" required><strong style="font-size: 11pt; color:blue">男</strong></td>
    <td bgcolor="#FFFFCC" style="border-left-style: none"><input type="radio" name="sex" value="1" required><strong style="font-size: 11pt; color:blue">女</strong></td>
	</tr>
</table>
<br>
<table align="center" border="2" bordercolor="#E6FFFF" cellpadding="0" cellspacing="0" style="border-bottom: solid;border-width: 1px">
  <tr>
    <td width="280" bgcolor="#FFFFCC" style="font-size: 8pt;padding: 0.2rem"><strong style="font-size: 11pt; color:blue">電話番号</strong></td>
    <td width="282" bgcolor="#FFFFCC" style="font-size: 8pt;padding: 0.2rem"><strong style="font-size: 11pt; color:blue">誕生日</strong></td>
	</tr>
  <tr>
    <td bgcolor="#FFFFCC" style="padding: 0.2rem"><?= $this->Form->control('tel', array('type'=>'text', 'pattern'=>'^[0-9.-]+$', 'title'=>'半角数字で入力して下さい。', 'label'=>false)) ?></td>
    <td bgcolor="#FFFFCC" style="padding: 0.2rem"><?= $this->Form->input("birth", array('type' => 'date', 'monthNames' => false, 'minYear' => date('Y') - 70, 'label'=>false, 'empty'=>true)); ?></td>
	</tr>
</table>
<br>
<table align="center" border="2" bordercolor="#E6FFFF" cellpadding="0" cellspacing="0" style="border-bottom: solid;border-width: 1px">
  <tr>
    <td width="282" bgcolor="#FFFFCC" style="font-size: 8pt;padding: 0.2rem"><strong style="font-size: 11pt; color:blue">入社日</strong></td>
    <td width="282" bgcolor="#FFFFCC" style="font-size: 8pt;padding: 0.2rem"><strong style="font-size: 11pt; color:blue">住所</strong></td>
	</tr>
  <tr>
    <td bgcolor="#FFFFCC" style="padding: 0.2rem"><?= $this->Form->input("date_start", array('type' => 'date', 'monthNames' => false, 'minYear' => date('Y') - 70, 'label'=>false, 'empty'=>true)); ?></td>
    <td bgcolor="#FFFFCC" style="padding: 0.2rem"><?= $this->Form->control('address', array('type'=>'text', 'label'=>false)) ?></td>
	</tr>
</table>

    </fieldset>
    <table align="center" border="2" bordercolor="#E6FFFF" cellpadding="0" cellspacing="0">
    <tr>
      <td style="border-style: none;"><div align="center"><?= $this->Form->submit(__('次へ'), array('name' => 'kakunin')); ?></div></td>
    </tr>
  </table>
<br>
