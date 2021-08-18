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
     <td style="padding: 0.1rem 0.1rem;"><a href="qr/index.php"><?php echo $this->Html->image('Labelimg/chokusouhensyuu.gif',array('width'=>'105','url'=>array('action'=>'editkensaku')));?></td>
   </tr>
 </table>
 <hr size="5" style="margin: 0.5rem">

<?=$this->Form->create($Materials, ['url' => ['action' => 'index']]) ?>
<br>
<div align="center"><font color="black" size="3"><?= __($mes) ?></font></div>
<br>
<table align="center" border="2" bordercolor="#E6FFFF" cellpadding="0" cellspacing="0">
  <tbody border="2" bordercolor="#E6FFFF" bgcolor="#FFFFCC" style="border-bottom: solid;border-width: 1px">
    <tr style="border-bottom: 0px;border-width: 0px">
      <td width="300" colspan="20" nowrap="nowrap"><div align="center"><strong style="font-size: 11pt; color:blue">原料グレード_色</strong></div></td>
      <td width="300" colspan="20" nowrap="nowrap"><div align="center"><strong style="font-size: 11pt; color:blue">代替名</strong></div></td>
    </tr>
    <tr style="border-bottom: 0px;border-width: 0px">
      <td rowspan='2'  height='6' colspan='20'>
        <?= h($materialgrade_color) ?>
      </td>
      <td rowspan='2'  height='6' colspan='20'>
        <?= h($name_substitute) ?>
      </td>
    </tr>
</table>
<br>
<table align="center">
  <tr bgcolor="#E6FFFF" >
    <td bgcolor="#E6FFFF" style="border: none"><?= $this->Form->submit(__('TOP'), array('name' => 'kensaku')); ?></td>
  </tr>
</table>
</fieldset>
<br><br>

<?=$this->Form->end() ?>
