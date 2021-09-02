<?php
 use App\myClass\Genryoumenu\htmlGenryoumenu;//myClassフォルダに配置したクラスを使用
 $htmlGenryoumenu = new htmlGenryoumenu();
 $htmlGenryou = $htmlGenryoumenu->Genryoumenus();
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
      <td style="padding: 0.1rem 0.1rem;"><a href="qr/index.php"><?php echo $this->Html->image('Labelimg/hazaisiyoukensakublue.gif',array('width'=>'85','url'=>array('action'=>'kensakuform')));?></td>
        <td style="padding: 0.1rem 0.1rem;"><a href="qr/index.php"><?php echo $this->Html->image('Labelimg/hazaimishiyoukensakublue.gif',array('width'=>'85','url'=>array('action'=>'mishiyoukensakuform')));?></td>
  </tr>
</table>
