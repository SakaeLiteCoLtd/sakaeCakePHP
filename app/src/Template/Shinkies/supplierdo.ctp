<?php
$this->layout = 'defaultshinki';
?>
<?php
use App\myClass\Shinkimenus\htmlShinkimenu;//myClassフォルダに配置したクラスを使用

$htmlShinkimenu = new htmlShinkimenu();
$htmlShinkis = $htmlShinkimenu->Shinkimenus();
?>

<hr size="5" style="margin: 0.5rem">
<table style="margin-bottom:0px" width="750" border="0" align="center" cellpadding="0" cellspacing="0" bordercolor="#CCCCCC">
<?php
   echo $htmlShinkis;
?>
</table>
<hr size="5" style="margin: 0.5rem">

<table style="margin-bottom:0px" width="750" border="0" align="center" cellpadding="0" cellspacing="0" bordercolor="#CCCCCC">
<tr style="background-color: #E6FFFF">
  <td style="padding: 0.1rem 0.1rem;"><a href="qr/index.php"><?php echo $this->Html->image('Labelimg/subTourokuShiire.gif',array('width'=>'105','height'=>'36','url'=>array('action'=>'supplierform')));?></td>
</tr>
</table>

<hr size="5" style="margin: 0.5rem">

    <?= $this->Form->create($suppliers, ['url' => ['action' => 'menu']]) ?>

    <br>
      <legend align="center"><font color="red"><?= __($mes) ?></font></legend>
      <fieldset>

        <table align="center" border="2" bordercolor="#E6FFFF" cellpadding="0" cellspacing="0" style="border-bottom: solid;border-width: 1px">
                <tbody border="2" bordercolor="#E6FFFF" bgcolor="#FFFFCC">
                  <td><div align="center"><strong style="font-size: 12pt; color:blue">会社名</strong></div></td>
                  <td style="border-left-style: none;"><div align="center"><strong style="font-size: 12pt; color:blue">担当者名</strong></div></td>
                <tbody border="2" bordercolor="#E6FFFF" bgcolor="#FFFFCC">
                  <td bgcolor="#FFFFCC" style="padding: 0.2rem"><?= h($this->request->getData('name')) ?></td>
                  <td bgcolor="#FFFFCC" style="border-left-style: none;padding: 0.2rem"><?= h($this->request->getData('charge_p')) ?></td>
                <tbody border="2" bordercolor="#E6FFFF" bgcolor="#FFFFCC">
                  <td colspan="2" style="padding: 0.2rem"><div align="center"><strong style="font-size: 12pt; color:blue">住所</strong></div></td>
                <tbody border="2" bordercolor="#E6FFFF" bgcolor="#FFFFCC">
                  <td colspan="2" bgcolor="#FFFFCC" style="padding: 0.2rem"><?= h($this->request->getData('address')) ?></td>
                <tbody border="2" bordercolor="#E6FFFF" bgcolor="#FFFFCC">
                  <td><div align="center"><strong style="font-size: 12pt; color:blue">電話番号</strong></div></td>
                  <td style="border-left-style: none;"><div align="center"><strong style="font-size: 12pt; color:blue">FAX</strong></div></td>
                <tbody border="2" bordercolor="#E6FFFF" bgcolor="#FFFFCC">
                  <td bgcolor="#FFFFCC" style="padding: 0.2rem"><?= h($this->request->getData('tel')) ?></td>
                  <td bgcolor="#FFFFCC" style="border-left-style: none;padding: 0.2rem"><?= h($this->request->getData('fax')) ?></td>
        </table>

    </fieldset>

    <table align="center" border="2" bordercolor="#E6FFFF" cellpadding="0" cellspacing="0">
    <tr>
      <td style="border-style: none;"><div align="center"><?= $this->Form->submit(__('メニュー'), array('name' => 'kakunin')); ?></div></td>
    </tr>
    </table>

<br>
