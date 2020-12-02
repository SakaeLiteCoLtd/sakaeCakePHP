<?php
$this->layout = "";//defaultのレイアウトを使わない
?>

 <?php if ($checkMobile == 1): ?>

    <br>
    <legend align="left"><font style="font-size: 15pt"><?= __("PCです") ?></font></legend>
    <br>

 <?php else : ?>

   <br>
   <legend align="left"><font style="font-size: 15pt"><?= __("モバイルです") ?></font></legend>
   <br>

 <?php endif; ?>

 <br><br><br>
 <legend align="center"><font style="font-size: 25pt"><?= __("作業時間計測") ?></font></legend>
 <br><br><br>
 <table style="margin-bottom:0px" width="750" border="0" align="center" cellpadding="0" cellspacing="0">
   <tr>
     <td style="padding: 0.1rem 0.1rem; text-align: center"><a href="qr/index.php"><?php echo $this->Html->image('Labelimg/processkatagae.gif',array('width'=>'180','height'=>'90','url'=>array('action'=>'menukatagae')));?></td>
     <td style="padding: 0.1rem 0.1rem; text-align: center"><a href="qr/index.php"><?php echo $this->Html->image('Labelimg/processkumitate.gif',array('width'=>'180','height'=>'90','url'=>array('action'=>'menu')));?></td>
   </tr>
 </table>
