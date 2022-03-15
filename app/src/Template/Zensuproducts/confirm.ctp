<?php
 use App\myClass\Zensumenus\htmlzensumenu;//myClassフォルダに配置したクラスを使用
 $htmlzensumenu = new htmlzensumenu();
 $htmlzensus = $htmlzensumenu->zensumenus();
 $htmlzensusubs = $htmlzensumenu->zensussubmenus();
 ?>
 <hr size="5" style="margin: 0.5rem">
 <table style="margin-bottom:0px" width="750" border="0" align="center" cellpadding="0" cellspacing="0" bordercolor="#CCCCCC">
 <?php
    echo $htmlzensus;
 ?>
 </table>
 <hr size="5" style="margin: 0.5rem">
 <table style="margin-bottom:0px" width="750" border="0" align="center" cellpadding="0" cellspacing="0" bordercolor="#CCCCCC">
   <tr style="background-color: #E6FFFF">
     <td style="padding: 0.1rem 0.1rem;"><a href="qr/index.php"><?php echo $this->Html->image('Labelimg/seihin_touroku.gif',array('width'=>'85','url'=>array('action'=>'preadd')));?></td>
   </tr>
 </table>
 <hr size="5" style="margin: 0.5rem">
 <table style="margin-bottom:0px" width="750" border="0" align="center" cellpadding="0" cellspacing="0" bordercolor="#CCCCCC">
   <tr style="background-color: #E6FFFF">
     <td style="padding: 0.1rem 0.1rem;"><a href="qr/index.php"><?php echo $this->Html->image('ShinkiTourokuMenu/zensuseihintouroku.gif',array('width'=>'105','url'=>array('action'=>'form')));?></td>
   </tr>
 </table>
 <hr size="5" style="margin: 0.5rem">
<br>
<br>
<legend align="center"><strong style="font-size: 13pt; color:blue"><?= __("全数検査製品登録") ?></strong></legend>
<br>
<legend align="center"><font color="red" size="3"><?= __($mess) ?></font></legend>
<br>

<?= $this->Form->create($zensuProducts, ['url' => ['action' => 'do']]) ?>

<?php
echo $this->Form->hidden('staff_id' ,['value'=>$staff_id]);
echo $this->Form->hidden('product_code' ,['value'=>$product_code]);
echo $this->Form->hidden('shot_cycle' ,['value'=>$shot_cycle]);
echo $this->Form->hidden('kijyun' ,['value'=>$kijyun]);
?>

<table align="center" border="2" bordercolor="#E6FFFF" cellpadding="0" cellspacing="0">
 <tbody border="2" bordercolor="#E6FFFF" bgcolor="#FFFFCC" style="border-bottom: solid;border-width: 1px">
   <tr style="border-bottom: 0px;border-width: 0px">
     <td width="400" colspan="40" nowrap="nowrap"><div align="center"><strong style="font-size: 12pt; color:blue">品番</strong></div></td>
   </tr>
  <tr style='border-bottom: 0px;border-width: 0px'>
    <td height="30" bgcolor="#FFFFCC" style="padding: 0.2rem">
    <?= h($product_code) ?>
  </td>
  </tr>
</table>
 <br>
 <table align="center" border="2" bordercolor="#E6FFFF" cellpadding="0" cellspacing="0">
 <tbody border="2" bordercolor="#E6FFFF" bgcolor="#FFFFCC" style="border-bottom: solid;border-width: 1px">
   <tr style="border-bottom: 0px;border-width: 0px">
     <td width="200"><div align="center"><strong style="font-size: 12pt; color:blue">ショットサイクル</strong></div></td>
     <td width="200"><div align="center"><strong style="font-size: 12pt; color:blue">外観検査基準時間</strong></div></td>
   </tr>
<tr style='border-bottom: 0px;border-width: 0px'>
  <td height="30" bgcolor="#FFFFCC" style="padding: 0.2rem">
    <?= h($shot_cycle) ?>
  </td>
  <td height="30" bgcolor="#FFFFCC" style="padding: 0.2rem">
    <?= h($kijyun) ?>
  </td>
</tr>
</table>
<br>

 <table align="center" border="2" bordercolor="#E6FFFF" cellpadding="0" cellspacing="0">
   <tr>
     <td style="border-style: none;"><div align="center"><?= $this->Form->submit('戻る', ['onclick' => 'history.back()', 'type' => 'button']); ?></div></td>
     <td style="border-style: none;"><div align="center"><?= $this->Form->submit('追加', array('name' => 'kakunin')); ?></div></td>
   </tr>
 </table>

<br><br><br>
