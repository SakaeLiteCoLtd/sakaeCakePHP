<?php
 use App\myClass\Labelmenus\htmlLabelmenu;//myClassフォルダに配置したクラスを使用
 $htmlLabelmenu = new htmlLabelmenu();
 $htmlLabels = $htmlLabelmenu->Labelmenus();
 ?>
 <hr size="5" style="margin: 0.5rem">
 <table style="margin-bottom:0px" width="750" border="0" align="center" cellpadding="0" cellspacing="0" bordercolor="#CCCCCC">
 <?php
    echo $htmlLabels;
 ?>
 </table>
 <hr size="5" style="margin: 0.5rem">
<br>
<?php
 $htmlLabelLotsubmenu = new htmlLabelmenu();
 $htmlLabelhasulotmenus = $htmlLabelLotsubmenu->Labelhasulotmenus();
?>
 <table style="margin-bottom:0px" width="750" border="0" align="center" cellpadding="0" cellspacing="0" bordercolor="#CCCCCC">
 <?php
    echo $htmlLabelhasulotmenus;
 ?>
 </table>
 <br><br>
 <table align="center" border="2" bordercolor="#E6FFFF" cellpadding="0" cellspacing="0" style="border-bottom: solid;border-width: 1px">
   <tr>
     <td  width="150" bgcolor="#FFFFCC" style="font-size: 12pt;"><strong style="font-size: 11pt; color:blue">登録社員名</strong></td>
     <td  width="150" bgcolor="#FFFFCC" style="font-size: 12pt;"><strong style="font-size: 10pt"><?= __($Staff) ?></strong></td>
 	</tr>
 </table>
 <br>
    <?= $this->Flash->render() ?>
    <?= $this->Form->create($MotoLots, ['url' => ['action' => 'hasulotmoto']]) ?>
    <br><br>
    <legend align="center"><strong style="font-size: 11pt; color:blue"><?= __("端数登録　製品登録") ?></strong></legend>
    <fieldset>
<table align="center" border="2" bordercolor="#E6FFFF" cellpadding="0" cellspacing="0" style="border-bottom: solid;border-width: 1px">
  <tr>
    <td  width="150" bgcolor="#FFFFCC" style="font-size: 12pt;"><strong style="font-size: 11pt; color:blue">製品QRコード読込</strong></td>
		<td bgcolor="#FFFFCC"><?= $this->Form->control('text', array('type'=>'text', 'label'=>false, 'maxlength' => 100)) ?></td>
	</tr>
</table>
    </fieldset>
    <table align="center" border="2" bordercolor="#E6FFFF" cellpadding="0" cellspacing="0">
    <tr>
    <td style="border-style: none;"><div align="center"><?= $this->Form->submit('取り込み', array('name' => 'torikomi')); ?></div></td>
  </tr>
  </table>
  <?= $this->Form->control('staff_id', array('type'=>'hidden', 'value'=>$Staffid, 'label'=>false)) ?>
  <?= $this->Form->control('created_staff', array('type'=>'hidden', 'value'=>$Staffcode, 'label'=>false)) ?>

<br><br>
    <?= $this->Form->end() ?>
