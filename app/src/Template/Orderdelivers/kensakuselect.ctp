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
   use Cake\ORM\TableRegistry;//独立したテーブルを扱う
   $this->PlaceDelivers = TableRegistry::get('placeDelivers');
   $this->Customers = TableRegistry::get('customers');//customersテーブルを使う
   $this->Products = TableRegistry::get('products');//productsテーブルを使う
   $this->OrderEdis = TableRegistry::get('orderEdis');//productsテーブルを使う
   $this->DnpTotalAmounts = TableRegistry::get('dnpTotalAmounts');
   $this->DenpyouDnpMinoukannous = TableRegistry::get('denpyouDnpMinoukannous');
?>

</table>
<hr size="5" style="margin: 0.5rem">
<br>
<table style="margin-bottom:0px" width="750" border="0" align="center" cellpadding="0" cellspacing="0" bordercolor="#CCCCCC">
            <tr style="background-color: #E6FFFF">
              <td style="padding: 0.1rem 0.1rem;"><a href="qr/index.php"><?php echo $this->Html->image('Labelimg/orderdeliver.gif',array('width'=>'85','height'=>'36','url'=>array('controller'=>'Orderdelivers','action'=>'kensakuform')));?></td>
            </tr>
</table>

    <?= $this->Form->create($OrderEdis, ['url' => ['action' => 'editform']]) ?>
    <fieldset>
      <?php
      $i = 0 ;
       ?>

       <br>
       <div align="center"><font color="black" size="3"><?= __("行先変更するデータにチェックを入れてください。") ?></font></div>
       <br>

      <table width="1000" align="center" border="2" bordercolor="#E6FFFF" cellpadding="0" cellspacing="0">
        <tbody border="2" bordercolor="#E6FFFF" bgcolor="#FFFFCC" style="border-bottom: solid;border-width: 1px">
              <thead>
                  <tr border="2" bordercolor="#E6FFFF" bgcolor="#FFFFCC">
                    <td width="30" height="30" colspan="10" nowrap="nowrap"><div align="center"><strong style="font-size: 12pt; color:blue"></strong></div></td>
                    <td width="150" height="30" colspan="20" nowrap="nowrap"><div align="center"><strong style="font-size: 12pt; color:blue">注文ＮＯ</strong></div></td>
                    <td width="200" height="30" colspan="20" nowrap="nowrap"><div align="center"><strong style="font-size: 12pt; color:blue">品番</strong></div></td>
                    <td width="50" height="30" colspan="20" nowrap="nowrap"><div align="center"><strong style="font-size: 12pt; color:blue">納品数</strong></div></td>
                    <td width="150" height="30" colspan="20" nowrap="nowrap"><div align="center"><strong style="font-size: 12pt; color:blue">納期</strong></div></td>
                    <td width="150" height="30" colspan="20" nowrap="nowrap"><div align="center"><strong style="font-size: 12pt; color:blue">行先名</strong></div></td>
                    <td width="150" height="30" colspan="20" nowrap="nowrap"><div align="center"><strong style="font-size: 12pt; color:blue">納品場所</strong></div></td>
                  </tr>
              </thead>
              <tbody border="2" bordercolor="#E6FFFF" bgcolor="#FFFFCC">
                  <?php foreach ($orderEdis as $orderEdis): ?>
                    <?php
                    $i = $i + 1 ;
                    $this->set('i',$i);
                     ?>
                  <tr style="border-bottom: solid;border-width: 1px">
                    <?php
                    echo "<td colspan='10' nowrap='nowrap'>\n";
                    echo "<input type='checkbox' name=check".$i."  size='6'/>\n";
                    echo "<input type='hidden' name=".$i." value=$orderEdis->id size='6'/>\n";//チェックされたもののidをキープする
                    echo "</td>\n";
                    ?>
                    <td width="150" colspan="20" nowrap="nowrap"><?= h($orderEdis->num_order) ?></td>
                    <td width="200" colspan="20" nowrap="nowrap"><?= h($orderEdis->product_code) ?></td>
                    <td width="100" colspan="20" nowrap="nowrap"><?= h($orderEdis->amount) ?></td>
                  <?php
                        $dateYMD = date('Y-m-d');
                        $date_deliver = $orderEdis->date_deliver->format('Y-m-d');
    //                    echo "<td width='200' colspan='20'><div align='center'>\n";
      //                  echo "<input type='date' value=$date_deliver name=date_deliver empty=Please select size='6'/>\n";
        //                echo "</div></td>\n";

                        $place_deliver_code = $orderEdis->place_deliver_code;
                        $PlaceDeliver = $this->PlaceDelivers->find()->where(['id_from_order' => $place_deliver_code])->toArray();
                        if(isset($PlaceDeliver[0])){
                          $PlaceDelivername = $PlaceDeliver[0]->name;
                        }else{
                          $PlaceDelivername = "";
                        }
                   ?>
                   <td width="150" colspan="20" nowrap="nowrap"><?= h($date_deliver) ?></td>
                   <td width="150" colspan="20" nowrap="nowrap"><?= h($PlaceDelivername) ?></td>
                   <td width="150" colspan="20" nowrap="nowrap"><?= h($orderEdis->place_line) ?></td>
                  </tr>
                  <?php endforeach; ?>

                 <?php
                  echo "<input type='hidden' name='nummax' value=$i size='6'/>\n";
                  ?>

              </tbody>
          </table>
      <br>
      <table align="center" border="2" bordercolor="#E6FFFF" cellpadding="0" cellspacing="0">
      <tr>
      <td style="border-style: none;"><div align="center"><?= $this->Form->submit('次へ', array('name' => 'next')); ?></div></td>
      </tr>
      </table>
      <?=$this->Form->end() ?>
    </form>
