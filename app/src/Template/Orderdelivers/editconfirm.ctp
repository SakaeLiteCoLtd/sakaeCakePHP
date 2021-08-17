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

<?= $this->Form->create($OrderEdis, ['url' => ['action' => 'preadd']]) ?>

<br>
<div align="center"><font color="black" size="3"><?= __($mess) ?></font></div>
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

          <?php for ($i=0;$i<=$count;$i++): ?>

            <?php foreach (${"orderEdis".$i} as ${"orderEdis".$i}): ?>
            <tr style="border-bottom: solid;border-width: 1px">
              <td width="150" colspan="20" nowrap="nowrap"><?= h(${"orderEdis".$i}->num_order) ?></td>
              <td width="150" colspan="20" nowrap="nowrap"><?= h(${"orderEdis".$i}->product_code) ?></td>
              <td width="100" colspan="20" nowrap="nowrap"><?= h(${"orderEdis".$i}->amount) ?></td>
              <?php
                    $date_deliver = ${"orderEdis".$i}->date_deliver->format('Y-m-d');
               ?>
               <td width="150" colspan="20" nowrap="nowrap">
                 <?= h($date_deliver) ?>
               </td>
               <td width="250" colspan="20" nowrap="nowrap">
                 <?= h(${"PlaceDelivername".$i}) ?>
               </td>

            <?php
             $i_count = $i;
             echo $this->Form->hidden('i_count' ,['value'=>$i_count]);
             echo $this->Form->hidden('place_deliver_code' ,['value'=>${"place_deliver_code".$i}]);
             echo $this->Form->hidden("orderEdis_".$i ,['value'=>${"orderEdis".$i}->id]);
            ?>

              <td width="150" colspan="20" nowrap="nowrap">
                <?= h(${"place_line".$i}) ?>
              </td>
            </tr>
            <?php endforeach; ?>
          <?php endfor;?>

        </tbody>
    </table>
<br>
<table align="center" border="2" bordercolor="#E6FFFF" cellpadding="0" cellspacing="0">
<tr>
  <td style="border-style: none;"><div align="center"><?= $this->Form->submit('戻る', ['onclick' => 'history.back()', 'type' => 'button']); ?></div></td>
  <td style="border-style: none;"><div align="center"><?= $this->Form->submit('決定', array('name' => 'noukikakunin')); ?></div></td>
</tr>
</table>
<br><br><br>
<?=$this->Form->end() ?>
