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
   $this->OrderEdis = TableRegistry::get('orderEdis');//productsテーブルを使う
   $this->DnpTotalAmounts = TableRegistry::get('dnpTotalAmounts');
   $this->DenpyouDnpMinoukannous = TableRegistry::get('denpyouDnpMinoukannous');
?>
<?php
header('Expires:-1');
header('Cache-Control:');
header('Pragma:');

$data = $this->request->getData();
/*
  echo "<pre>";
  print_r($data);
  echo "</pre>";
*/
?>
 </table>
 <hr size="5" style="margin: 0.5rem">
<br>

  <?php
  if(isset($data["touroku"])){
    $data = $this->request->getData();
    (int)$amount_total = 0;
    $arrdate_deliver = array();//空の配列を作る
    for ($j=0;$j<$data["tsuikanum"]+$num;$j++){
      (int)$amount_total = (int)$amount_total + (int)$data["amount_".$j];
      $arrdate_deliver[] = $data["date_deliver_".$j];//配列に追加する
    }
    $OrderEdi = $this->OrderEdis->find()->where(['id' => $data['orderEdis_0']])->toArray();
    $date_order_moto = $OrderEdi[0]->date_order;
    $num_order_moto = $OrderEdi[0]->num_order;
    $product_code_moto = $OrderEdi[0]->product_code;
    $DnpTotalAmount = $this->DnpTotalAmounts->find()->where(['date_order' => $date_order_moto, 'num_order' => $num_order_moto, 'product_code' => $product_code_moto])->toArray();
//    $amount_moto = $DnpTotalAmount[0]->amount;
//    $DnpTotalAmountId = $DnpTotalAmount[0]->id;
//    $DnpTotalAmountNameOrder = $DnpTotalAmount[0]->name_order;
//    $DenpyouDnpMinoukannous = $this->DenpyouDnpMinoukannous->find()->where(['order_edi_id' => $data['orderEdis_0']])->toArray();
//    $DenpyouDnpMinoukannousPlaceDeliver = $DenpyouDnpMinoukannous[0]->place_deliver;

    //納期がかぶっているかチェック
    $uniquearrdate_deliver = array_unique($arrdate_deliver, SORT_REGULAR);//重複削除
    $cntdate_deliver = count($arrdate_deliver);
    $cntuniquearrdate_deliver = count($uniquearrdate_deliver);

    for ($j=1;$j<$data["tsuikanum"]+$num;$j++){
      $k = $j-1;
      if($data["date_deliver_".$k] < $data["date_deliver_".$j]){
        $deliver_check = 0;
      }else{
        $deliver_check = 1;
        break;
      }
    }
  }else{
  }
  ?>


<?php if((isset($data["touroku"]))&&($amount_total == $Totalamount)&&($cntdate_deliver == $cntuniquearrdate_deliver)&&($deliver_check == 0)): //分納伝票登録を押されて、合計数量が合っていて、納期がかぶっていない場合?>
  <?php
  $data = $this->request->getData();
  ?>
  <form method="post" action="henkoupanabunnnoupreadd" enctype="multipart/form-data">
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
                <?php
          //        $product_code = ${"orderEdis".$i}->product_code;
          //        $DnpTotalAmount = $this->DnpTotalAmounts->find()->where(['num_order' => ${"orderEdis".$i}->num_order, 'date_order' => ${"orderEdis".$i}->date_order, 'product_code' => $product_code])->toArray();
          //        $Dnpdate_deliver = $DnpTotalAmount[0]->date_deliver;
                ?>
                <td width="200" colspan="20" nowrap="nowrap"><?= h($Dnpdate_deliver) ?></td>
              <?php
               echo $this->Form->hidden("orderEdis_".$i ,['value'=>${"orderEdis".$i}->id]);
              ?>
                <td width="150" colspan="20" nowrap="nowrap"><?= h($Totalamount) ?></td>

              </tr>
              <?php endforeach; ?>
            <?php endfor;?>

          </tbody>
      </table>
  <br><br>
      <table align="left" border="2" bordercolor="#E6FFFF" cellpadding="0" cellspacing="0">
        <tr>
          <td style="border-style: none;"><div align="center"><?= $this->Form->submit('以下登録', array('name' => 'kousindo')); ?></div></td>
          <td style="border-style: none;"><div align="center"><?= $this->Form->submit('戻る', ['onclick' => 'history.back()', 'type' => 'button']); ?></div></td>
        </tr>
      </table>
<br><br><br>
      <table align="left" border="2" bordercolor="#E6FFFF" cellpadding="0" cellspacing="0">
        <tbody border="2" bordercolor="#E6FFFF" bgcolor="#FFFFCC" style="border-bottom: solid;border-width: 1px">
              <thead>
                  <tr border="2" bordercolor="#E6FFFF" bgcolor="#FFFFCC">
                    <td width="150" height="30" colspan="20" nowrap="nowrap"><div align="center"><strong style="font-size: 12pt; color:blue">分納回数</strong></div></td>
                    <td width="150" height="30" colspan="20" nowrap="nowrap"><div align="center"><strong style="font-size: 12pt; color:blue">納期</strong></div></td>
                    <td width="200" height="30" colspan="20" nowrap="nowrap"><div align="center"><strong style="font-size: 12pt; color:blue">数量</strong></div></td>
                  </tr>
              </thead>
              <tbody border="2" bordercolor="#E6FFFF" bgcolor="#FFFFCC">

        <?php for ($j=0;$j<=$num;$j++): ?>
          <tr style="border-bottom: solid;border-width: 1px">
            <td width="150" colspan="20" nowrap="nowrap"><?= h($j+1) ?></td>
            <td width="150" colspan="20" nowrap="nowrap"><?= h($data["date_deliver_".$j]) ?></td>
            <td width="150" colspan="20" nowrap="nowrap"><?= h($data["amount_".$j]) ?></td>
          </tr>

          <?php
          $session = $this->request->getSession();
          if(isset($data["orderEdis_".$j])){
            $_SESSION['orderEdis'][$j] = array(
              'id' => $data["orderEdis_".$j],
              'date_deliver' => $data["date_deliver_".$j],
              'amount' => $data["amount_".$j]
            );
          }else{
            $_SESSION['orderEdis'][$j] = array(
              'date_deliver' => $data["date_deliver_".$j],
              'amount' => $data["amount_".$j]
            );
          }
    //      $_SESSION['total_amount'] = array(
    //        'id' => $DnpTotalAmountId,
    //        'name_order' => $DnpTotalAmountNameOrder
    //      );
    //      $_SESSION['minoukannou'] = array(
    //        'name_order' => $DnpTotalAmountNameOrder,
    //        'place_deliver' => $DenpyouDnpMinoukannousPlaceDeliver,
    //        'conf_print' => 0,
    //        'minoukannou' => 0,
    //        'delete_flag' =>  0
    //      );
/*
          $_SESSION['orderEdis'][$j] = array(
            'id' => $data["orderEdis_".$j],
            'date_deliver' => $data["date_deliver_".$j],
            'amount' => $data["amount_".$j]
          );
*/
          ?>

      <?php endfor;?>
        <?php for ($j=$num+1;$j<$data["tsuikanum"]+$num;$j++): ?>
          <tr style="border-bottom: solid;border-width: 1px">
            <td width="150" colspan="20" nowrap="nowrap"><?= h($j+1) ?></td>
            <td width="150" colspan="20" nowrap="nowrap"><?= h($data["date_deliver_".$j]) ?></td>
            <td width="150" colspan="20" nowrap="nowrap"><?= h($data["amount_".$j]) ?></td>
          </tr>

          <?php
          $session = $this->request->getSession();
          $OrderEdi = $this->OrderEdis->find()->where(['id' => $data['orderEdis_0']])->toArray();
          $place_deliver_code = $OrderEdi[0]->place_deliver_code;
          $date_order = $OrderEdi[0]->date_order->format('Y-m-d');
          $price = $OrderEdi[0]->price;
          $product_code = $OrderEdi[0]->product_code;
          $line_code = $OrderEdi[0]->line_code;
          $num_order = $OrderEdi[0]->num_order;
          if(isset($OrderEdi[0]->first_date_deliver)){
            $first_date_deliver = $OrderEdi[0]->first_date_deliver->format('Y-m-d');
          }else{
            $first_date_deliver = $OrderEdi[0]->first_date_deliver;
          }
          $customer_code = $OrderEdi[0]->customer_code;
          $place_line = $OrderEdi[0]->place_line;
          $check_denpyou = $OrderEdi[0]->check_denpyou;
          $gaityu = $OrderEdi[0]->gaityu;
          $bunnou = 1;
          $kannou = $OrderEdi[0]->kannou;
    //      $date_bunnou = $OrderEdi[0]->date_bunnou;
          $date_bunnou = date('Y-m-d');
          $check_kannou = $OrderEdi[0]->check_kannou;
          $delete_flag = $OrderEdi[0]->delete_flag;

          $_SESSION['orderEdis'][$j] = array(
            'place_deliver_code' => $place_deliver_code,
            'date_order' => $date_order,
            'price' => $price,
            'amount' => $data["amount_".$j],
            'product_code' => $product_code,
            'line_code' => $line_code,
            'date_deliver' => $data["date_deliver_".$j],
            'num_order' => $num_order,
            'first_date_deliver' => $first_date_deliver,
            'customer_code' => $customer_code,
            'place_line' => $place_line,
            'check_denpyou' => $check_denpyou,
            'gaityu' => $gaityu,
            'bunnou' => $bunnou,
            'kannou' => $kannou,
            'date_bunnou' => $date_bunnou,
            'check_kannou' => $check_kannou,
            'delete_flag' => $delete_flag
          );
          ?>

        <?php endfor;?>
      </tbody>
  </table>
  <br><br><br><br><br><br><br><br>
  <br><br><br>

<?php
/*
echo "<pre>";
print_r($_SESSION['orderEdis']);
echo "</pre>";
*/
?>

</form>

<?=$this->Form->end() ?>


<?php elseif(isset($data["touroku"])): //分納伝票登録を押されて、合計数量が合わないまたは納期がかぶっている場合?>
  <?php
  if(($cntdate_deliver == $cntuniquearrdate_deliver) && ($amount_total != $Totalamount) && ($deliver_check == 0)){
    $errmesdeliver1 = "";
    $errmesdeliver2 = "";
    $errmesamount = "合計数量が合いません！";
  }elseif(($cntdate_deliver != $cntuniquearrdate_deliver) && ($amount_total == $Totalamount) && ($deliver_check == 0)){
    $errmesdeliver1 = "納期が被っているものがあります。納期を変更してください。";
    $errmesdeliver2 = "";
    $errmesamount = "";
  }elseif(($cntdate_deliver == $cntuniquearrdate_deliver) && ($amount_total == $Totalamount) && ($deliver_check == 1)){
    $errmesdeliver1 = "";
    $errmesdeliver2 = "納期は日程の若い順に入力してください";
    $errmesamount = "";
  }else{
    $errmesdeliver1 = "納期が被っているものがないか確認してください　　　　　　　";
    $errmesdeliver2 = "納期は日程の若い順に入力してください　　　　　　　　　　　";
    $errmesamount = "合計数量を確認してください　　　　　　　　　　　　　　　　";
  }
  ?>
  <br><br>
  <legend align="center"><strong style="font-size: 11pt; color:blue"><?= "入力間違いがあります。ブラウザの「戻る」で戻ってください。" ?></strong></legend>
  <br>
  <legend align="center"><strong style="font-size: 11pt; color:red"><?= $errmesdeliver1 ?></strong></legend>
  <br>
  <legend align="center"><strong style="font-size: 11pt; color:red"><?= $errmesdeliver2 ?></strong></legend>
  <br>
  <legend align="center"><strong style="font-size: 11pt; color:red"><?= $errmesamount ?></strong></legend>
  <br><br><br>

<?php else: //分納追加（削除）を押された場合?>
  <form method="post" action="henkou5panabunnou" enctype="multipart/form-data">

      <?php
        $data = $this->request->getData();

        $OrderEdi = $this->OrderEdis->find()->where(['id' => $data['orderEdis_0']])->toArray();
        $date_order_moto = $OrderEdi[0]->date_order;
        $num_order_moto = $OrderEdi[0]->num_order;
        $product_code_moto = $OrderEdi[0]->product_code;
    //    $DnpTotalAmount = $this->DnpTotalAmounts->find()->where(['date_order' => $date_order_moto, 'num_order' => $num_order_moto, 'product_code' => $product_code_moto])->toArray();
    //    $amount_moto = $DnpTotalAmount[0]->amount;

      ?>

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
                  <td width="200" colspan="20" nowrap="nowrap"><?= h($Dnpdate_deliver) ?></td>
                <?php
                echo $this->Form->hidden("orderEdis_".$i ,['value'=>$data["orderEdis_".$i]]);
                ?>
                  <td width="150" colspan="20" nowrap="nowrap"><?= h($Totalamount) ?></td>
                  <?php
                  echo $this->Form->hidden("Dnpdate_deliver" ,['value'=>$Dnpdate_deliver]);
                  echo $this->Form->hidden("Totalamount" ,['value'=>$Totalamount]);
                  ?>
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
              <?php for ($j=0;$j<=$num;$j++): ?>
                <tr style="border-bottom: solid;border-width: 1px">
                  <td width="150" colspan="20" nowrap="nowrap"><?= h($j+1) ?></td>
                  <?php
                   $dateYMD = date('Y-m-d');
            //       $date_deliver = ${"orderEdis".$j}->date_deliver->format('Y-m-d');
                   $date_deliver = $data["date_deliver_{$j}"];
            //       $amount = ${"orderEdis".$j}->amount;
                   $amount = $data["amount_{$j}"];
                   $kannou = $data["kannou_{$j}"];

                   if($kannou == 0){
                     $meskannou = "変更可";
                     echo "<td width='200' colspan='20'><div align='center'>\n";
                     echo "<input type='date' value=$date_deliver name=date_deliver_{$j} empty=Please select size='6'/>\n";
                     echo "</div></td>\n";
                     echo "<td width='200' colspan='20'><div align='center'>\n";
                     echo "<input type='text' value=$amount name=amount_{$j} empty=Please select size='6'/>\n";
                     echo "<input type='hidden' value=$kannou name=kannou_{$j} empty=Please select size='6'/>\n";
                     echo "</div></td>\n";
                   }else{
                     $meskannou = "変更不可";
                     echo "<td width='200' colspan='20'><div align='center'>\n";
                     echo $date_deliver;
                     echo "<input type='hidden' value=$date_deliver name=date_deliver_{$j} empty=Please select size='6'/>\n";
                     echo "</div></td>\n";
                     echo "<td width='200' colspan='20'><div align='center'>\n";
                     echo $amount;
                     echo "<input type='hidden' value=$amount name=amount_{$j} empty=Please select size='6'/>\n";
                     echo "<input type='hidden' value=$kannou name=kannou_{$j} empty=Please select size='6'/>\n";
                     echo "</div></td>\n";
                   }
    /*               echo "<td width='200' colspan='20'><div align='center'>\n";
                   echo "<input type='date' value=$date_deliver name=date_deliver_{$j} empty=Please select size='6'/>\n";
                   echo "</div></td>\n";
                   echo "<td width='200' colspan='20'><div align='center'>\n";
                   echo "<input type='text' value=$amount name=amount_{$j} empty=Please select size='6'/>\n";
                   echo "</div></td>\n";
      */            ?>
                  <?php
                  if(isset($data["orderEdis_".$j])){
                    echo $this->Form->hidden("orderEdis_".$j ,['value'=>$data["orderEdis_".$j]]);
                  }
                  ?>

                  <td width="200" colspan="20" nowrap="nowrap"><?= h($meskannou) ?></td>
                </tr>
              <?php endfor;?>
              <?php for ($j=$num+1;$j<$num+$tsuikanum;$j++): ?>
                <tr style="border-bottom: solid;border-width: 1px">
                  <td width="150" colspan="20" nowrap="nowrap"><?= h($j+1) ?></td>
                  <?php
                   $dateYMD = date('Y-m-d');
                   if(isset($data["orderEdis_{$j}"])){
                     ${"id".$j} = $data["orderEdis_{$j}"];
                     echo "<input type='hidden' value=${"id".$j} name=orderEdis_{$j} empty=Please select size='6'/>\n";
                   }
                   echo "<td width='200' colspan='20'><div align='center'>\n";
                   echo "<input type='date' value=$date_deliver name=date_deliver_{$j} empty=Please select size='6'/>\n";
                   echo "</div></td>\n";
                   echo "<td width='200' colspan='20'><div align='center'>\n";
                   echo "<input type='text' name=amount_{$j} empty=Please select size='6'/>\n";
                   echo "</div></td>\n";
                  ?>
                  <?php
                  if(isset($data["orderEdis_".$j])){
                    echo $this->Form->hidden("orderEdis_".$j ,['value'=>$data["orderEdis_".$j]]);
                  }
                  ?>
                  <td width="200" colspan="20" nowrap="nowrap"><?= h("変更可") ?></td>
                </tr>
              <?php endfor;?>
            </tbody>
        </table>
        <br>
        <legend align="center"><strong style="font-size: 11pt; color:red"><?= "元々あった分納を削除する場合は数量を空にしてください。" ?></strong></legend>

  <br><br><br>

  <?php
  echo $this->Form->hidden('tsuikanum' ,['value'=>$tsuikanum]);
  ?>

    <?=$this->Form->end() ?>

  </form>

<?php endif; ?>
