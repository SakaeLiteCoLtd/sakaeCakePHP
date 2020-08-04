<?php
$this->layout = 'defaultshinki';
?>
<?php
use App\myClass\Shinkimenus\htmlShinkimenu;//myClassフォルダに配置したクラスを使用

$htmlShinkimenu = new htmlShinkimenu();
$htmlShinkis = $htmlShinkimenu->Shinkimenus();
$htmlgaityumenus = $htmlShinkimenu->gaityumenus();
?>

<hr size="5" style="margin: 0.5rem">
<table style="margin-bottom:0px" width="750" border="0" align="center" cellpadding="0" cellspacing="0" bordercolor="#CCCCCC">
<?php
   echo $htmlShinkis;
?>
</table>
<hr size="5" style="margin: 0.5rem">
<table style="margin-bottom:0px" width="750" border="0" align="center" cellpadding="0" cellspacing="0" bordercolor="#CCCCCC">
<table style="margin-bottom:0px" width="750" border="0" align="center" cellpadding="0" cellspacing="0" bordercolor="#CCCCCC">
<tr style="background-color: #E6FFFF">
  <td style="padding: 0.1rem 0.1rem;"><a href="qr/index.php"><?php echo $this->Html->image('Labelimg/subUrikakeGaityu.gif',array('width'=>'85','height'=>'36','url'=>array('action'=>'gaityuurikakeform')));?></td>
</tr>
</table>

<hr size="5" style="margin: 0.5rem">
<br>
<legend align="center"><font color="red"><?= __($mes) ?></font></legend>

    <?= $this->Form->create($accountUrikakePriceMaterials, ['url' => ['action' => 'menu']]) ?>
    <fieldset>

<table align="center" border="2" bordercolor="#E6FFFF" cellpadding="0" cellspacing="0" style="border-bottom: solid;border-width: 1px">
  <tr>
    <td width="280" bgcolor="#FFFFCC" style="font-size: 8pt;padding: 0.2rem"><strong style="font-size: 11pt; color:blue">グレード</strong></td>
    <td width="280" bgcolor="#FFFFCC" style="font-size: 8pt;padding: 0.2rem"><strong style="font-size: 11pt; color:blue">色番号</strong></td>
	</tr>
  <tr>
    <td bgcolor="#FFFFCC" style="padding: 0.2rem"><?= h($this->request->getData('grade')) ?></td>
    <td bgcolor="#FFFFCC" style="padding: 0.2rem"><?= h($this->request->getData('color')) ?></td>
	</tr>
</table>
<table align="center" border="2" bordercolor="#E6FFFF" cellpadding="0" cellspacing="0" style="border-bottom: solid;border-width: 1px">
  <tr>
    <td width="280" colspan="2" bgcolor="#FFFFCC" style="font-size: 12pt;padding: 0.2rem"><strong style="font-size: 11pt; color:blue">単価（円/kg）</strong></td>
    <td width="280" bgcolor="#FFFFCC" style="font-size: 12pt;padding: 0.2rem"><strong style="font-size: 11pt; color:blue">売掛先</strong></td>
	</tr>
  <tr>
    <td width="220" bgcolor="#FFFFCC" style="border-right-style: none;padding: 0.2rem"><?= h($this->request->getData('price')) ?></td>
    <td width="60" bgcolor="#FFFFCC" style="border-left-style: none;padding: 0.2rem"><strong style="font-size: 11pt; color:blue">円/kg</strong></td>
    <td width="280"  bgcolor="#FFFFCC" style="padding: 0.2rem"><?= h($company) ?></td>
	</tr>
</table>

    </fieldset>
    <table align="center" border="2" bordercolor="#E6FFFF" cellpadding="0" cellspacing="0">
    <tr>
      <td style="border-style: none;"><div align="center"><?= $this->Form->submit(__('TOP'), array('name' => 'kakunin')); ?></div></td>
    </tr>
  </table>
<br>
