<?php
 use App\myClass\Zensumenus\htmlzensumenu;//myClassフォルダに配置したクラスを使用
 $htmlzensumenu = new htmlzensumenu();
 $htmlzensus = $htmlzensumenu->zensumenus();
 $htmlzensusubs = $htmlzensumenu->zensussubmenus();
 $htmlzensustartends = $htmlzensumenu->zensustartend();
 ?>
 <hr size="5" style="margin: 0.5rem">
 <table style="margin-bottom:0px" width="750" border="0" align="center" cellpadding="0" cellspacing="0" bordercolor="#CCCCCC">
 <?php
    echo $htmlzensus;
 ?>
 </table>
 <hr size="5" style="margin: 0.5rem">
 <table style="margin-bottom:0px" width="750" border="0" align="center" cellpadding="0" cellspacing="0" bordercolor="#CCCCCC">
 <?php
    echo $htmlzensustartends;
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
    <?= $this->Form->create($ResultZensuHeads, ['url' => ['action' => 'zensukennsatyuu']]) ?>
    <br><br>
    <legend align="center"><strong style="font-size: 11pt; color:blue"><?= __("製品ロット登録") ?></strong></legend>
    <fieldset>
<table align="center" border="2" bordercolor="#E6FFFF" cellpadding="0" cellspacing="0" style="border-bottom: solid;border-width: 1px">
  <tr>
    <td  width="150" bgcolor="#FFFFCC" style="font-size: 12pt;"><strong style="font-size: 11pt; color:blue">製品ロットNo.</strong></td>
		<td bgcolor="#FFFFCC"><?= $this->Form->control('text', array('type'=>'text', 'label'=>false, 'maxlength' => 100)) ?></td>
	</tr>
</table>
    </fieldset>
    <table align="center" border="2" bordercolor="#E6FFFF" cellpadding="0" cellspacing="0">
    <tr>
    <td style="border-style: none;"><div align="center"><?= $this->Form->submit('開始', array('name' => 'start')); ?></div></td>
  </tr>
  </table>
  <?= $this->Form->control('staff_id', array('type'=>'hidden', 'value'=>$Staffid, 'label'=>false)) ?>
  <?= $this->Form->control('created_staff', array('type'=>'hidden', 'value'=>$Staffcode, 'label'=>false)) ?>
  <?= $this->Form->control('datetime_start', array('type'=>'hidden', 'value'=>date('Y-m-d h:m:s'), 'label'=>false)) ?>

<br><br>
    <?= $this->Form->end() ?>
