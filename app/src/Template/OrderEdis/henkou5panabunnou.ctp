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
?>
<?php
header('Expires:-1');
header('Cache-Control:');
header('Pragma:');

  $data = $this->request->getData();
?>
 </table>
 <hr size="5" style="margin: 0.5rem">
<br>

  <?php
  if(isset($data["touroku"])){
    $data = $this->request->getData();
    (int)$amount_total = 0;
    for ($j=0;$j<$data["tsuikanum"];$j++){
      (int)$amount_total = (int)$amount_total + (int)$data["amount_".$j];
    }
    $OrderEdi = $this->OrderEdis->find()->where(['id' => $data['orderEdis_0']])->toArray();
    $amount_moto = $OrderEdi[0]->amount;
/*
    echo "<pre>";
    print_r("合計：".$amount_total);
    echo "</pre>";
    echo "<pre>";
    print_r("元々：".$amount_moto);
    echo "</pre>";
*/
  }else{
  }
  ?>


<?php if((isset($data["touroku"]))&&($amount_total == $amount_moto)): ?>
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

        <?php for ($j=0;$j<1;$j++): ?>
          <tr style="border-bottom: solid;border-width: 1px">
            <td width="150" colspan="20" nowrap="nowrap"><?= h($j+1) ?></td>
            <td width="150" colspan="20" nowrap="nowrap"><?= h($data["date_deliver_".$j]) ?></td>
            <td width="150" colspan="20" nowrap="nowrap"><?= h($data["amount_".$j]) ?></td>
          </tr>

          <?php
          $session = $this->request->getSession();
          $_SESSION['orderEdis'][$j] = array(
            'id' => $data["orderEdis_".$j],
            'date_deliver' => $data["date_deliver_".$j],
            'amount' => $data["amount_".$j]
          );
          ?>

      <?php endfor;?>
        <?php for ($j=1;$j<$data["tsuikanum"];$j++): ?>
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
          $date_bunnou = $OrderEdi[0]->date_bunnou;
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

<?php
/*
echo "<pre>";
print_r($_SESSION['orderEdis']);
echo "</pre>";
*/
?>

</form>

<?=$this->Form->end() ?>


<?php elseif(isset($data["touroku"])): ?>
  <br><br>
  <legend align="center"><strong style="font-size: 11pt; color:blue"><?= "入力間違いがあります。ブラウザの「戻る」で戻ってください。" ?></strong></legend>
  <br>
  <legend align="center"><strong style="font-size: 11pt; color:red"><?= "合計数量が合いません！" ?></strong></legend>
  <br><br><br>

<?php else: ?>
  <form method="post" action="henkou5panabunnou" enctype="multipart/form-data">

      <?php
        $data = $this->request->getData();
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
