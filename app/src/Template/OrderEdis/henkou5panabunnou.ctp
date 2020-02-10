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
<?php
  $data = $this->request->getData();
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

<?php if(isset($data["touroku"])): ?>

<?php else: ?>
  <form method="post" action="henkou5panabunnou" enctype="multipart/form-data">

      <?php
        $data = $this->request->getData();
      ?>

  <br>
    <table align="center" border="2" bordercolor="#E6FFFF" cellpadding="0" cellspacing="0">
      <tbody border="2" bordercolor="#E6FFFF" bgcolor="#FFFFCC" style="border-bottom: solid;border-width: 1px">
            <thead>
                <tr border="2" bordercolor="#E6FFFF" bgcolor="#FFFFCC">
                  <td width="150" height="30" colspan="20" nowrap="nowrap"><div align="center"><strong style="font-size: 12pt; color:blue">注文ＮＯ</strong></div></td>
                  <td width="150" height="30" colspan="20" nowrap="nowrap"><div align="center"><strong style="font-size: 12pt; color:blue">品番</strong></div></td>
                  <td width="200" height="30" colspan="20" nowrap="nowrap"><div align="center"><strong style="font-size: 12pt; color:blue">品名</strong></div></td>
                  <td width="200" height="30" colspan="20" nowrap="nowrap"><div align="center"><strong style="font-size: 12pt; color:blue">納期</strong></div></td>
                  <td width="50" height="30" colspan="20" nowrap="nowrap"><div align="center"><strong style="font-size: 12pt; color:blue">数量</strong></div></td>
                </tr>
            </thead>
            <tbody border="2" bordercolor="#E6FFFF" bgcolor="#FFFFCC">
              <?php for ($i=0;$i<1;$i++): ?>
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
                  <td width="200" colspan="20" nowrap="nowrap"><?= h(${"orderEdis".$i}->date_deliver) ?></td>
                <?php
                 echo $this->Form->hidden("orderEdis_".$i ,['value'=>${"orderEdis".$i}->id]);
                ?>

                  <td width="150" colspan="20" nowrap="nowrap"><?= h(${"orderEdis".$i}->amount) ?></td>
                </tr>
                <?php endforeach; ?>
              <?php endfor;?>

            </tbody>
        </table>
    <br><br>
    <table align="left" border="2" bordercolor="#E6FFFF" cellpadding="0" cellspacing="0">
      <tr>
      <td style="border-style: none;"><div align="center"><?= $this->Form->submit('分納追加', array('name' => 'tsuika')); ?></div></td>
      <td style="border-style: none;"><div align="center"><?= $this->Form->submit('分納削除', array('name' => 'sakujo')); ?></div></td>
      <td style="border-style: none;"><div align="center"><?= $this->Form->submit('分納伝票登録', array('name' => 'touroku')); ?></div></td>
      </tr>
    </table>

    <table align="center" border="2" bordercolor="#E6FFFF" cellpadding="0" cellspacing="0">
      <tbody border="2" bordercolor="#E6FFFF" bgcolor="#FFFFCC" style="border-bottom: solid;border-width: 1px">
            <thead>
                <tr border="2" bordercolor="#E6FFFF" bgcolor="#FFFFCC">
                  <td width="150" height="30" colspan="20" nowrap="nowrap"><div align="center"><strong style="font-size: 12pt; color:blue">分納回数</strong></div></td>
                  <td width="150" height="30" colspan="20" nowrap="nowrap"><div align="center"><strong style="font-size: 12pt; color:blue">納期</strong></div></td>
                  <td width="200" height="30" colspan="20" nowrap="nowrap"><div align="center"><strong style="font-size: 12pt; color:blue">数量</strong></div></td>
                  <td width="200" height="30" colspan="20" nowrap="nowrap"><div align="center"><strong style="font-size: 12pt; color:blue">登録</strong></div></td>
                </tr>
            </thead>
            <tbody border="2" bordercolor="#E6FFFF" bgcolor="#FFFFCC">

              <?php for ($j=0;$j<1;$j++): ?>
                <tr style="border-bottom: solid;border-width: 1px">
                  <td width="150" colspan="20" nowrap="nowrap"><?= h($j+1) ?></td>
                  <?php
                   $dateYMD = date('Y-m-d');
                   $date_deliver = ${"orderEdis".$j}->date_deliver->format('Y-m-d');
                   $amount = ${"orderEdis".$j}->amount;
                   echo "<td width='200' colspan='20'><div align='center'>\n";
                   echo "<input type='date' value=$date_deliver name=date_deliver_{$j} empty=Please select size='6'/>\n";
                   echo "</div></td>\n";
                   echo "<td width='200' colspan='20'><div align='center'>\n";
                   echo "<input type='text' value=$amount name=amount_{$j} empty=Please select size='6'/>\n";
                   echo "</div></td>\n";
                  ?>
                  <td width="200" colspan="20" nowrap="nowrap"><?= h("変更可") ?></td>
                </tr>
              <?php endfor;?>
              <?php for ($j=1;$j<$tsuikanum;$j++): ?>
                <tr style="border-bottom: solid;border-width: 1px">
                  <td width="150" colspan="20" nowrap="nowrap"><?= h($j+1) ?></td>
                  <?php
                   $dateYMD = date('Y-m-d');
                   echo "<td width='200' colspan='20'><div align='center'>\n";
                   echo "<input type='date' value=$date_deliver name=date_deliver_{$j} empty=Please select size='6'/>\n";
                   echo "</div></td>\n";
                   echo "<td width='200' colspan='20'><div align='center'>\n";
                   echo "<input type='text' name=amount_{$j} empty=Please select size='6'/>\n";
                   echo "</div></td>\n";
                  ?>
                  <td width="200" colspan="20" nowrap="nowrap"><?= h("変更可") ?></td>
                </tr>
              <?php endfor;?>
            </tbody>
        </table>
  <br><br><br>

  <?php
  echo $this->Form->hidden('tsuikanum' ,['value'=>$tsuikanum]);
  ?>

    <?=$this->Form->end() ?>

  </form>

<?php endif; ?>