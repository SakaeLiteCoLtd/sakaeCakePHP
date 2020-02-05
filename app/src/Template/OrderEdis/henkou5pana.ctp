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
   use Cake\ORM\TableRegistry;//独立したテーブルを扱う
   $this->Products = TableRegistry::get('products');//productsテーブルを使う
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
              <td style="padding: 0.1rem 0.1rem;"><a href="qr/index.php"><?php echo $this->Html->image('Labelimg/push_button_p.gif',array('width'=>'85','height'=>'33','url'=>array('controller'=>'OrderEdis','action'=>'henkou3pana')));?></td>
              <td style="padding: 0.1rem 0.1rem;"><a href="qr/index.php"><?php echo $this->Html->image('Labelimg/button_w.gif',array('width'=>'85','height'=>'33','url'=>array('controller'=>'OrderEdis','action'=>'misakusei')));?></td>
              <td style="padding: 0.1rem 0.1rem;"><a href="qr/index.php"><?php echo $this->Html->image('Labelimg/button_h.gif',array('width'=>'85','height'=>'33','url'=>array('controller'=>'OrderEdis','action'=>'misakusei')));?></td>
              <td style="padding: 0.1rem 0.1rem;"><a href="qr/index.php"><?php echo $this->Html->image('Labelimg/button_re.gif',array('width'=>'85','height'=>'33','url'=>array('controller'=>'OrderEdis','action'=>'misakusei')));?></td>
            </tr>
</table>
<br>
<hr size="5" style="margin: 0.5rem">
<table align="center" border="2" bordercolor="#E6FFFF" cellpadding="0" cellspacing="0">
  <tbody border="2" bordercolor="#E6FFFF" bgcolor="#FFFFCC">

<?php
      $dateYMD = date('Y-m-d');

      echo "<td width='150' colspan='3' style='border-bottom: solid;border-width: 1px'><div align='center'><strong style='font-size: 12pt; color:blue'>\n";
      echo "納期一括変更";
      echo "</strong></div></td>\n";
      echo "<td width='250' colspan='37' style='border-bottom: solid;border-width: 1px'><div align='center'>\n";
      echo "<input type='date' value=$dateYMD name=date_sta empty=Please select size='6'/>\n";
      echo "</div></td>\n";
      echo "</tr>\n";
 ?>
<br>
<table align="center" border="2" bordercolor="#E6FFFF" cellpadding="0" cellspacing="0">
<tr>
<br>
<td style="border-style: none;"><div align="center"><?= $this->Form->submit('一括変更', array('name' => 'kensaku')); ?></div></td>
</tr>
</table>
<br><br><br><br>

<table align="center" border="2" bordercolor="#E6FFFF" cellpadding="0" cellspacing="0">
  <tbody border="2" bordercolor="#E6FFFF" bgcolor="#FFFFCC" style="border-bottom: solid;border-width: 1px">
        <thead>
            <tr border="2" bordercolor="#E6FFFF" bgcolor="#FFFFCC">
              <td width="150" height="30" colspan="20" nowrap="nowrap"><div align="center"><strong style="font-size: 12pt; color:blue">注文ＮＯ</strong></div></td>
              <td width="150" height="30" colspan="20" nowrap="nowrap"><div align="center"><strong style="font-size: 12pt; color:blue">品番</strong></div></td>
              <td width="200" height="30" colspan="20" nowrap="nowrap"><div align="center"><strong style="font-size: 12pt; color:blue">品名</strong></div></td>
              <td width="50" height="30" colspan="20" nowrap="nowrap"><div align="center"><strong style="font-size: 12pt; color:blue">納品数</strong></div></td>
              <td width="200" height="30" colspan="20" nowrap="nowrap"><div align="center"><strong style="font-size: 12pt; color:blue">納期</strong></div></td>
              <td width="50" height="30" colspan="20" nowrap="nowrap"><div align="center"><strong style="font-size: 12pt; color:blue">納品場所</strong></div></td>
            </tr>
        </thead>
        <tbody border="2" bordercolor="#E6FFFF" bgcolor="#FFFFCC">
          <?php for ($i=0;$i<$i_num+1;$i++): ?>
            <?php foreach (${"orderEdis".$i} as ${"orderEdis".$i}): ?>
            <?php //foreach ($orderEdis as $orderEdis): ?>
            <tr style="border-bottom: solid;border-width: 1px">
              <td width="150" colspan="20" nowrap="nowrap"><?= h(${"orderEdis".$i}->num_order) ?></td>
              <td width="150" colspan="20" nowrap="nowrap"><?= h(${"orderEdis".$i}->product_code) ?></td>
                <?php
                  $product_code = ${"orderEdis".$i}->product_code;
              		$Product = $this->Products->find()->where(['product_code' => $product_code])->toArray();
              		$product_name = $Product[0]->product_name;
                ?>
              <td width="200" colspan="20" nowrap="nowrap"><?= h($product_name) ?></td>
              <td width="100" colspan="20" nowrap="nowrap"><?= h(${"orderEdis".$i}->amount) ?></td>
            <?php
                  $dateYMD = date('Y-m-d');
                  $date_deliver = ${"orderEdis".$i}->date_deliver->format('Y-m-d');
                  echo "<td width='200' colspan='20'><div align='center'>\n";
                  echo "<input type='date' value=$date_deliver name=date_deliver empty=Please select size='6'/>\n";
                  echo "</div></td>\n";
             ?>
              <td width="150" colspan="20" nowrap="nowrap"><?= h(${"orderEdis".$i}->amount) ?></td>
            </tr>
            <?php endforeach; ?>
          <?php endfor;?>

        </tbody>
    </table>
<br>
<table align="left" border="2" bordercolor="#E6FFFF" cellpadding="0" cellspacing="0">
<tr>
<td style="border-style: none;"><div align="center"><?= $this->Form->submit('納期変更確認', array('name' => 'nouki')); ?></div></td>
</tr>
</table>


<?=$this->Form->end() ?>
