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
 <br>
 <table style="margin-bottom:0px" width="750" border="0" align="center" cellpadding="0" cellspacing="0" bordercolor="#CCCCCC">
             <tr style="background-color: #E6FFFF">
               <td style="padding: 0.1rem 0.1rem;"><a href="qr/index.php"><?php echo $this->Html->image('Labelimg/edi_henkou_order.gif',array('width'=>'85','height'=>'36','url'=>array('controller'=>'OrderEdis','action'=>'henkou1sentaku')));?></td>
             </tr>
 </table>
 <br><br>
 <table style="margin-bottom:0px" width="750" border="0" align="center" cellpadding="0" cellspacing="0" bordercolor="#CCCCCC">
             <tr style="background-color: #E6FFFF">
               <td style="padding: 0.1rem 0.1rem;"><a href="qr/index.php"><?php echo $this->Html->image('Labelimg/button_pana.gif',array('width'=>'85','height'=>'33','url'=>array('controller'=>'OrderEdis','action'=>'henkou2pana')));?></td>
             </tr>
 </table>
<br><br>
<table style="margin-bottom:0px" width="750" border="0" align="center" cellpadding="0" cellspacing="0" bordercolor="#CCCCCC">
            <tr style="background-color: #E6FFFF">
              <td style="padding: 0.1rem 0.1rem;"><a href="qr/index.php"><?php echo $this->Html->image('Labelimg/button_p.gif',array('width'=>'85','height'=>'33','url'=>array('controller'=>'OrderEdis','action'=>'henkou3pana','Pro'=>'P')));?></td>
              <td style="padding: 0.1rem 0.1rem;"><a href="qr/index.php"><?php echo $this->Html->image('Labelimg/button_w.gif',array('width'=>'85','height'=>'33','url'=>array('controller'=>'OrderEdis','action'=>'henkou3pana','Pro'=>'W')));?></td>
              <td style="padding: 0.1rem 0.1rem;"><a href="qr/index.php"><?php echo $this->Html->image('Labelimg/button_h.gif',array('width'=>'85','height'=>'33','url'=>array('controller'=>'OrderEdis','action'=>'henkou3pana','Pro'=>'H')));?></td>
              <td style="padding: 0.1rem 0.1rem;"><a href="qr/index.php"><?php echo $this->Html->image('Labelimg/button_re.gif',array('width'=>'85','height'=>'33','url'=>array('controller'=>'OrderEdis','action'=>'henkou3pana','Pro'=>'R')));?></td>
            </tr>
</table>
<br>
