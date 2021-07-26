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
<table style="margin-bottom:0px" width="500" border="0" align="center" cellpadding="0" cellspacing="0" bordercolor="#CCCCCC">
  <tr style="background-color: #E6FFFF">
    <td style="padding: 0.1rem 0.1rem;"><a href="qr/index.php"><?php echo $this->Html->image('Labelimg/chokusouhensyuu.gif',array('width'=>'105','url'=>array('action'=>'addform')));?></td>
  </tr>
</table>
<hr size="5" style="margin: 0.5rem">

    <?= $this->Form->create($materialTypes, ['url' => ['action' => 'editconfirm']]) ?>
    <fieldset>

      <br>
      <div align="center"><font color="red" size="3"><?= __($mess) ?></font></div>
      <div align="center"><font color="black" size="3"><?= __("修正してください。") ?></font></div>
      <br>

<table align="center" border="2" bordercolor="#E6FFFF" cellpadding="0" cellspacing="0" style="border-bottom: solid;border-width: 1px">
  <tr>
    <td width="200" bgcolor="#FFFFCC" style="font-size: 8pt;padding: 0.2rem"><strong style="font-size: 11pt; color:blue">原料種類</strong></td>
	</tr>
  <tr>
    <td bgcolor="#FFFFCC" style="padding: 0.2rem"><?= $this->Form->control('name', array('type'=>'text', 'label'=>false, 'autofocus'=>true, 'required'=>true)) ?></td>
	</tr>
</table>
<br>

<table align="center">
<tbody>
  <tr>
    <td><?= $this->Form->control('check', array('type'=>'checkbox', 'label'=>false)) ?></td>
    <td><div><strong style="font-size: 11pt; color:blue">データを削除する場合はチェックを入れてください。</strong></div></td>
  </tr>
</tbody>
</table>
<br>

<table align="center" border="2" bordercolor="#E6FFFF" cellpadding="0" cellspacing="0">
  <tr>
    <td style="border-style: none;"><div align="center"><?= $this->Form->submit('確認', array('name' => 'next')); ?></div></td>
  </tr>
</table>
<br><br><br><br><br><br><br>
<?= $this->Form->control('MaterialTypeId', array('type'=>'hidden', 'value'=>$MaterialTypeId, 'label'=>false)) ?>
