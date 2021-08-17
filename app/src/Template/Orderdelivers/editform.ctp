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
<?php
   use Cake\ORM\TableRegistry;//独立したテーブルを扱う
   $this->Products = TableRegistry::get('products');//productsテーブルを使う
   $this->DnpTotalAmounts = TableRegistry::get('dnpTotalAmounts');
   $this->PlaceDelivers = TableRegistry::get('placeDelivers');
?>
<?php
header('Expires:-1');
header('Cache-Control:');
header('Pragma:');
?>
<hr size="5" style="margin: 0.5rem">
<br>
<table style="margin-bottom:0px" width="750" border="0" align="center" cellpadding="0" cellspacing="0" bordercolor="#CCCCCC">
            <tr style="background-color: #E6FFFF">
              <td style="padding: 0.1rem 0.1rem;"><a href="qr/index.php"><?php echo $this->Html->image('Labelimg/orderdeliver.gif',array('width'=>'85','height'=>'36','url'=>array('controller'=>'Orderdelivers','action'=>'kensakuform')));?></td>
            </tr>
</table>

<?= $this->Form->create($OrderEdis, ['url' => ['action' => 'editconfirm']]) ?>

<br>
<table align="center" border="2" bordercolor="#E6FFFF" cellpadding="0" cellspacing="0">
  <tbody border="2" bordercolor="#E6FFFF" bgcolor="#FFFFCC">

<?php
echo "<tr style='border-bottom: 0px;border-width: 0px'>\n";
echo "<td width='100' rowspan='2'  height='6' colspan='20'>\n";
echo "行先名\n";
echo "</td>\n";
 ?>

 <td width="250" rowspan='2'  height='6' colspan='20'><div align="center">
     <?= $this->Form->input("PlaceDeliverikkatsu", array('type' => 'select', "options"=>$arrPlaceDeliver, 'label'=>false)); ?>
   </div></td>

<?php
echo "</tr>\n";
echo "<tr style='border-bottom: 0px;border-width: 0px'>\n";
echo "<td width='100' rowspan='2'  height='6' colspan='20'>\n";
echo "納品場所\n";
echo "</td>\n";
echo "<td width='150' rowspan='2'  height='6' colspan='20'>\n";
echo "<input type='text' name=place_lineikkatsu size='6'/>\n";
echo "</td>\n";
echo "</tr>\n";
 ?>
<br>
<table align="center" border="2" bordercolor="#E6FFFF" cellpadding="0" cellspacing="0">
<tr>
<br>
<td style="border-style: none;"><div align="center"><?= $this->Form->submit('一括変更', array('name' => 'ikkatsu')); ?></div></td>
</tr>
</table>
<br>

<br>
<table width="1000" align="center" border="2" bordercolor="#E6FFFF" cellpadding="0" cellspacing="0">
  <tbody border="2" bordercolor="#E6FFFF" bgcolor="#FFFFCC" style="border-bottom: solid;border-width: 1px">
        <thead>
            <tr border="2" bordercolor="#E6FFFF" bgcolor="#FFFFCC">
              <td width="150" height="30" colspan="20" nowrap="nowrap"><div align="center"><strong style="font-size: 12pt; color:blue">注文ＮＯ</strong></div></td>
              <td width="200" height="30" colspan="20" nowrap="nowrap"><div align="center"><strong style="font-size: 12pt; color:blue">品番</strong></div></td>
              <td width="50" height="30" colspan="20" nowrap="nowrap"><div align="center"><strong style="font-size: 12pt; color:blue">納品数</strong></div></td>
              <td width="150" height="30" colspan="20" nowrap="nowrap"><div align="center"><strong style="font-size: 12pt; color:blue">納期</strong></div></td>
              <td width="250" height="30" colspan="20" nowrap="nowrap"><div align="center"><strong style="font-size: 12pt; color:blue">行先名</strong></div></td>
              <td width="150" height="30" colspan="20" nowrap="nowrap"><div align="center"><strong style="font-size: 12pt; color:blue">納品場所</strong></div></td>
            </tr>
        </thead>
        <tbody border="2" bordercolor="#E6FFFF" bgcolor="#FFFFCC">
          <?php for ($i=0;$i<$i_num+1;$i++): ?>
            <?php foreach (${"orderEdis".$i} as ${"orderEdis".$i}): ?>
            <?php //foreach ($orderEdis as $orderEdis): ?>
            <tr style="border-bottom: solid;border-width: 1px">
              <td width="150" colspan="20" nowrap="nowrap"><?= h(${"orderEdis".$i}->num_order) ?></td>
              <td width="150" colspan="20" nowrap="nowrap"><?= h(${"orderEdis".$i}->product_code) ?></td>
              <td width="100" colspan="20" nowrap="nowrap"><?= h(${"orderEdis".$i}->amount) ?></td>
              <?php
                    $date_deliver = ${"orderEdis".$i}->date_deliver->format('Y-m-d');

                    $place_deliver_code = ${"orderEdis".$i}->place_deliver_code;
                    $PlaceDeliver = $this->PlaceDelivers->find()->where(['id_from_order' => $place_deliver_code])->toArray();
                    if(isset($PlaceDeliver[0])){
                      $PlaceDelivername = $PlaceDeliver[0]->name;
                    }else{
                      $PlaceDelivername = "";
                    }
               ?>
               <td width="150" colspan="20" nowrap="nowrap"><?= h($date_deliver) ?></td>
               <td width="250" colspan="20" nowrap="nowrap">
                 <?= $this->Form->input("place_deliver_code".$i, array('type' => 'select', "options"=>$arrPlaceDeliver, "value"=>${"orderEdis".$i}->place_deliver_code, 'label'=>false)); ?>
               </td>

            <?php
             $i_count = $i;
             echo $this->Form->hidden('i_count' ,['value'=>$i_count]);
             echo $this->Form->hidden("orderEdis_".$i ,['value'=>${"orderEdis".$i}->id]);
            ?>

              <td width="150" colspan="20" nowrap="nowrap">
                <?= $this->Form->input("place_line".$i, array('type' => 'text', "value"=>${"orderEdis".$i}->place_line, 'label'=>false)); ?>
              </td>
            </tr>
            <?php endforeach; ?>
          <?php endfor;?>

        </tbody>
    </table>
<br>
<table align="center" border="2" bordercolor="#E6FFFF" cellpadding="0" cellspacing="0">
<tr>
<td style="border-style: none;"><div align="center"><?= $this->Form->submit('行先変更確認', array('name' => 'noukikakunin')); ?></div></td>
</tr>
</table>
<br><br><br>
<?=$this->Form->end() ?>
