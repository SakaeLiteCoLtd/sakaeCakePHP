<?php
 use App\myClass\EDImenus\htmlEDImenu;//myClassフォルダに配置したクラスを使用
 $htmlEDImenu = new htmlEDImenu();
 $htmlEDIs = $htmlEDImenu->EDImenus();
 ?>
 <hr size="5" style="margin: 0.5rem">
 <table style="margin-bottom:0px" width="750" border="0" align="center" cellpadding="0" cellspacing="0" bordercolor="#CCCCCC">
 <?php
    echo $htmlEDIs;
 ?>
 </table>
 <hr size="5" style="margin: 0.5rem">
 <table style="margin-bottom:0px" width="750" border="0" align="center" cellpadding="0" cellspacing="0" bordercolor="#CCCCCC">

  <td style="padding: 0.1rem 0.1rem; text-align: center"><a href="qr/index.php"><?php echo $this->Html->image('Labelimg/subTouroku.gif',array('width'=>'85','height'=>'36','url'=>array('action'=>'addpreadd')));?></td>
  <td style="padding: 0.1rem 0.1rem; text-align: center"><a href="qr/index.php"><?php echo $this->Html->image('Labelimg/subYobidashi.gif',array('width'=>'85','height'=>'36','url'=>array('action'=>'kensakuform')));?></td>

 </table>
 <hr size="5" style="margin: 0.5rem">
 <br>
  <div align="center"><font color="red" size="2"><?= __($mess) ?></font></div>
  <br>
