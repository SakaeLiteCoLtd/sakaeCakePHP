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

               <?php
             /*
               <td style="padding: 0.1rem 0.1rem;"><a href="qr/index.php"><?php echo $this->Html->image('Labelimg/edi_henkou_zaiko.gif',array('width'=>'85','height'=>'36','url'=>array('controller'=>'OrderEdis','action'=>'misakusei')));?></td>
*/
               ?>
               <td style="padding: 0.1rem 0.2rem;"><a href='http://192.168.4.1/edi/top_henkou_stock.php'><?php echo $this->Html->image('Labelimg/edi_henkou_zaiko.gif',array('width'=>'85','height'=>'36'));?></a></td>

               <td style="padding: 0.1rem 0.1rem;"><a href="qr/index.php"><?php echo $this->Html->image('Labelimg/edi_henkou_order.gif',array('width'=>'85','height'=>'36','url'=>array('controller'=>'OrderEdis','action'=>'henkousentakucustomer')));?></td>
                 <td style="padding: 0.1rem 0.1rem;"><a href="qr/index.php"><?php echo $this->Html->image('Labelimg/orderdeliver.gif',array('width'=>'85','height'=>'36','url'=>array('controller'=>'Orderdelivers','action'=>'kensakuform')));?></td>
             </tr>
 </table>
 <br><br><br><br>
