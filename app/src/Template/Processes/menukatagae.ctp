<?php
$this->layout = "";//defaultのレイアウトを使わない
?>

 <br><br><br>
 <legend align="center"><font style="font-size: 25pt"><?= __("型替え時間") ?></font></legend>
 <br><br><br>
 <table style="margin-bottom:0px" width="750" border="0" align="center" cellpadding="0" cellspacing="0">
   <tr>
     <td style="padding: 0.1rem 0.1rem; text-align: center"><a href="qr/index.php"><?php echo $this->Html->image('Labelimg/processkeisoku.gif',array('width'=>'180','height'=>'90','url'=>array('action'=>'katagaeitiran')));?></td>
     <td style="padding: 0.1rem 0.1rem; text-align: center"><a href="qr/index.php"><?php echo $this->Html->image('Labelimg/processsansyou.gif',array('width'=>'180','height'=>'90','url'=>array('action'=>'menu')));?></td>
   </tr>
 </table>
