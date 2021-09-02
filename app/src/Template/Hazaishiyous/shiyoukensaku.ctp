<?php
 use App\myClass\Genryoumenu\htmlGenryoumenu;//myClassフォルダに配置したクラスを使用
 $htmlGenryoumenu = new htmlGenryoumenu();
 $htmlGenryou = $htmlGenryoumenu->Genryoumenus();

 echo $this->Form->create($stockEndMaterials, ['url' => ['action' => 'shiyouichiran']]);

 ?>
 <hr size="5" style="margin: 0.5rem">
 <table style="margin-bottom:0px" width="750" border="0" align="center" cellpadding="0" cellspacing="0" bordercolor="#CCCCCC">
 <?php
    echo $htmlGenryou;
 ?>
 </table>
 <hr size="5" style="margin: 0.5rem">
<table style="margin-bottom:0px" width="1000" border="0" align="center" cellpadding="0" cellspacing="0" bordercolor="#CCCCCC">
  <tr style="background-color: #E6FFFF">
    <td style="padding: 0.1rem 0.1rem;"><a href="qr/index.php"><?php echo $this->Html->image('Labelimg/hazaisiyousuuryou.gif',array('width'=>'85','url'=>array('controller'=>'Hazaishiyous', 'action'=>'menu')));?></td>
  </tr>
</table>
<hr size="5" style="margin: 0.5rem">
 <table style="margin-bottom:0px" width="750" border="0" align="center" cellpadding="0" cellspacing="0" bordercolor="#CCCCCC">
  <tr style="background-color: #E6FFFF">
    <td style="padding: 0.1rem 0.1rem;"><a href="qr/index.php"><?php echo $this->Html->image('Labelimg/hazaisiyouichiranblue.gif',array('width'=>'85','url'=>array('action'=>'shiyoukensaku')));?></td>
  </tr>
</table>
<hr size="5" style="margin: 0.5rem">
<br>
<table align="center" border="2" bordercolor="#E6FFFF" cellpadding="0" cellspacing="0">
  <tbody border="2" bordercolor="#E6FFFF" bgcolor="#FFFFCC">
    <tr>
      <td width="350" colspan="20" nowrap="nowrap"><div align="center"><strong style="font-size: 15pt; color:blue">使用端材呼出日</strong></div></td>
      <td rowspan="2" width="150"  style="border-bottom: solid;border-width: 1px"><div align="center"><?= $this->Form->submit(__('呼出'), array('name' => 'top')); ?></div></td>
    </tr>
      <td width="250" colspan="20" style="border-bottom: solid;border-width: 1px"><div align="center"><?= $this->Form->input("manu_date", array('type' => 'date', 'monthNames' => false, 'label'=>false)); ?></div></td>
</table>
<br><br><br>
