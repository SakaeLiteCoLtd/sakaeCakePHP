<?php
$this->layout = "";//defaultのレイアウトを使わない
?>

 <br><br><br>
 <legend align="center"><font style="font-size: 25pt"><?= __("本日の型替え一覧") ?></font></legend>
 <br><br><br>
 <table style="margin-bottom:0px" width="750" align="center" cellpadding="0" cellspacing="0">
   <tr>
     <td style="border:solid;border-width: 1px" width="70" height="60" colspan="20" nowrap="nowrap"><div align="center"><strong style="font-size: 15pt; color:#FF66FF">成形機</strong></div></td>
   </tr>
 </table>

 <br> <br>

 <table style="margin-bottom:0px" width="750" border="0" align="center" cellpadding="0" cellspacing="0">
   <tr>
     <td style="padding: 0.1rem 0.1rem; text-align: center"><a href="qr/index.php"><?php echo $this->Html->image('Labelimg/processkousin.gif',array('width'=>'100','height'=>'50','url'=>array('action'=>'katagaeitiran','kousin'=>'1')));?></td>
   </tr>
 </table>
