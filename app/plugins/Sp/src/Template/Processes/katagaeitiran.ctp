<?php
$this->layout = "";//defaultのレイアウトを使わない
?>

<?= $this->Form->create($scheduleKouteis, ['url' => ['action' => 'katagaeitiran']]) ?>

 <br>
 <legend align="center"><font style="font-size: 25pt"><?= __("本日の型替え一覧") ?></font></legend>
 <br>
 <table style="margin-bottom:0px" width="750" align="center" cellpadding="0" cellspacing="0">
   <tr>
     <td style="border:solid;border-width: 1px; border-right-style: none"  width="100" height="60" colspan="20" nowrap="nowrap"><div align="center"><strong style="font-size: 15pt; color:#FF66FF">成形機</strong></div></td>
     <td style="border:solid;border-width: 1px; border-right-style: none"  width="230" height="30" colspan="20" nowrap="nowrap"><div align="center"><strong style="font-size: 15pt; color:#FF66FF">品番</strong></div></td>
     <td style="border:solid;border-width: 1px; border-right-style: none"  width="230" height="30" colspan="20" nowrap="nowrap"><div align="center"><strong style="font-size: 15pt; color:#FF66FF">品名</strong></div></td>
     <td style="border:solid;border-width: 1px; border-right-style: none"  width="200" height="30" colspan="20" nowrap="nowrap"><div align="center"><strong style="font-size: 15pt; color:#FF66FF">型替え予定時間</strong></div></td>
     <td style="border:solid;border-width: 1px"  width="80" height="30" colspan="20" nowrap="nowrap"><div align="center"><strong></strong></div></td>
   </tr>

   <?php for($i=0; $i<count($arrScheduleKouteis); $i++): ?>

   <tr>
     <td style="border:solid;border-width: 1px;border-top: 0.5px; border-right-style: none"  width="70" height="60" colspan="20" nowrap="nowrap"><font color="blue"><div align="center" style="font-size: 13pt;"><?= h($arrScheduleKouteis[$i]["seikeiki"]) ?>
     </font><font color="blue"><?= h("号機") ?></font></div></font></td>
     <td style="border:solid;border-width: 1px;border-top: 0.5px; border-right-style: none"  width="150" height="30" colspan="20" nowrap="nowrap"><font color="blue"><div align="center" style="font-size: 13pt;"><?= h($arrScheduleKouteis[$i]["product_code"]) ?></div></font></td>
     <td style="border:solid;border-width: 1px;border-top: 0.5px; border-right-style: none"  width="150" height="30" colspan="20" nowrap="nowrap"><font color="blue"><div align="center" style="font-size: 13pt;"><?= h($arrScheduleKouteis[$i]["product_name"]) ?></div></font></td>
     <td style="border:solid;border-width: 1px;border-top: 0.5px; border-right-style: none"  width="200" height="30" colspan="20" nowrap="nowrap"><font color="red"><div align="center" style="font-size: 13pt;"><?= h($arrScheduleKouteis[$i]->datetime->format('G:i')) ?>
     </font><font color="red"><?= h(" ～") ?></font></div></td>
     <?php
     echo "<td style='border:solid;border-width: 1px;border-top: 0.5px'><div align='center'>";
     echo $this->Form->submit("計測" , ['action'=>'menukatagae', 'name' => "test_".$arrScheduleKouteis[$i]["id"]]) ;
     echo "</div></td>";
     ?>
   </tr>

 <?php endfor;?>

 </table>

 <br>

 <table style="margin-bottom:0px" width="750" border="0" align="center" cellpadding="0" cellspacing="0">
   <tr>
     <td style="padding: 0.1rem 0.1rem; text-align: center"><a href="qr/index.php"><?php echo $this->Html->image('Labelimg/processkousin.gif',array('width'=>'100','height'=>'50','url'=>array('action'=>'katagaeitiran','kousin'=>'1')));?></td>
   </tr>
 </table>

 <br>

 <?php
 echo $this->Form->hidden('keisoku' ,['value'=>1]);
 ?>
