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
 <?php
   $username = $this->request->Session()->read('Auth.User.username');

   header('Expires:-1');
   header('Cache-Control:');
   header('Pragma:');
   echo $this->Form->create($orderEdis, ['url' => ['action' => 'henkou4other']]);

//   $Data=$this->request->query();
//   $Pro=$Data["Pro"];
//   echo $this->Form->hidden('Pro' ,['value'=>$Pro]);

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
               <td style="padding: 0.1rem 0.1rem;"><a href="qr/index.php"><?php echo $this->Html->image('Labelimg/button_others.gif',array('width'=>'85','height'=>'33','url'=>array('controller'=>'OrderEdis','action'=>'henkou2other')));?></td>
             </tr>
 </table>

<br>
<hr size="5" style="margin: 0.5rem">
<table align="center" border="2" bordercolor="#E6FFFF" cellpadding="0" cellspacing="0">
  <tbody border="2" bordercolor="#E6FFFF" bgcolor="#FFFFCC" style="border-bottom: solid;border-width: 1px">
    <tr style="border-bottom: 0px;border-width: 0px">
      <td width="250" height="60" colspan="20" nowrap="nowrap"><div align="center"><strong style="font-size: 15pt; color:blue">品番</strong></div></td>
      <td width="500" colspan="40" nowrap="nowrap"><div align="center"><strong style="font-size: 15pt; color:blue">納期絞り込み</strong></div></td>
    </tr>

<?php
      $dateYMD = date('Y-m-d');

      echo "<tr style='border-bottom: 0px;border-width: 0px'>\n";
      echo "<td rowspan='2'  height='6' colspan='20'>\n";
      echo "<input type='text' name=product_code size='6'/>\n";
      echo "</td>\n";
      echo "<td width='50' colspan='3' style='border-bottom: 0px'><div align='center'><strong style='font-size: 15pt; color:blue'>\n";
      echo "開始";
      echo "</strong></div></td>\n";
      echo "<td width='350' colspan='37' style='border-bottom: 0px'><div align='center'>\n";
      echo "<input type='date' value=$dateYMD name=date_sta empty=Please select size='6'/>\n";
      echo "</div></td>\n";
      echo "</tr>\n";
      echo "<tr style='border-bottom: 0px;border-width: 0px'>\n";
      echo "<td colspan='3'><div align='center'><strong style='font-size: 15pt; color:blue'>\n";
      echo "終了";
      echo "</strong></div></td>\n";
      echo "<td colspan='37'><div align='center'>\n";
      echo "<input type='date' value=$dateYMD name=date_fin size='6'/>\n";
      echo "</div></td>\n";
      echo "</tr>\n";
 ?>
<br>
<table align="center" border="2" bordercolor="#E6FFFF" cellpadding="0" cellspacing="0">
<tr>
<br>
<td style="border-style: none;"><div align="center"><?= $this->Form->submit('検索', array('name' => 'kensaku')); ?></div></td>
</tr>
</table>
<br>



<?=$this->Form->end() ?>
