<?php
 use App\myClass\Genryoumenu\htmlGenryoumenu;//myClassフォルダに配置したクラスを使用
 $htmlGenryoumenu = new htmlGenryoumenu();
 $htmlGenryou = $htmlGenryoumenu->Genryoumenus();
 $htmlcsvmenus = $htmlGenryoumenu->csvmenus();
 ?>
 <hr size="5" style="margin: 0.5rem">
 <table style="margin-bottom:0px" width="750" border="0" align="center" cellpadding="0" cellspacing="0" bordercolor="#CCCCCC">
 <?php
    echo $htmlGenryou;
 ?>
 </table>
 <hr size="5" style="margin: 0.5rem">
 <table style="margin-bottom:0px" width="750" border="0" align="center" cellpadding="0" cellspacing="0" bordercolor="#CCCCCC">
 <?php
    echo $htmlcsvmenus;
 ?>
 </table>
 <hr size="5" style="margin: 0.5rem">
 <?=$this->Form->create($OrderMaterials, ['url' => ['action' => 'csvtest1wsyuturyoku']]) ?>
 <br>
    <div align="left"><font color="blue" size="3"><?= __("　　　１週間分データ出力") ?></font></div>
 <br>
 <table align="center" border="2" bordercolor="#E6FFFF" cellpadding="0" cellspacing="0">
   <tbody border="2" bordercolor="#E6FFFF" bgcolor="#FFFFCC">
     <tr>
       <td width="350" colspan="20" nowrap="nowrap"><div align="center"><strong style="font-size: 15pt; color:blue">開始日選択</strong></div></td>
       <td rowspan="2" width="150" style="border-bottom: solid;border-width: 1px"><div align="center"><?= $this->Form->submit(__('決定'), array('name' => 'top')); ?></div></td>
     </tr>
       <td width="250" colspan="20" style="border-bottom: solid;border-width: 1px"><div align="center"><?= $this->Form->input("date1w", array('type' => 'date', 'monthNames' => false, 'label'=>false)); ?></div></td>
 </table>
 <br><br><br>
