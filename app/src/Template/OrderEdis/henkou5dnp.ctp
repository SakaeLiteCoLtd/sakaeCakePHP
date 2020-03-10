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
   $this->DnpTotalAmounts = TableRegistry::get('dnpTotalAmounts');
//   echo $this->Form->create($orderEdis, ['url' => ['action' => 'henkou5pana']]);
?>
<?php
header('Expires:-1');
header('Cache-Control:');
header('Pragma:');

  $data = $this->request->getData();

  $bunnoucheck = 0;
  for($i=0; $i<=100; $i++){
    if(isset(${"bunnou".$i})){
      $bunnoucheck = $bunnoucheck + ${"bunnou".$i};
    }else{
      break;
    }
  }
?>

 </table>
<hr size="5" style="margin: 0.5rem">

<?php if(isset($data["nouki"]) && $bunnoucheck==0)://日付変更を押したとき ?>

<form method="post" action="henkou6dnp" enctype="multipart/form-data">

<table align="center" border="2" bordercolor="#E6FFFF" cellpadding="0" cellspacing="0">
  <tbody border="2" bordercolor="#E6FFFF" bgcolor="#FFFFCC">

<?php
      $dateYMD = date('Y-m-d');

      echo "<td width='150' colspan='3' style='border-bottom: solid;border-width: 1px'><div align='center'><strong style='font-size: 12pt; color:blue'>\n";
      echo "納期一括変更";
      echo "</strong></div></td>\n";
      echo "<td width='250' colspan='37' style='border-bottom: solid;border-width: 1px'><div align='center'>\n";
      echo "<input type='date' value=$dateYMD name=date_ikkatsu empty=Please select size='6'/>\n";
      echo "</div></td>\n";
      echo "</tr>\n";
 ?>
<br>
<table align="center" border="2" bordercolor="#E6FFFF" cellpadding="0" cellspacing="0">
<tr>
<br>
<td style="border-style: none;"><div align="center"><?= $this->Form->submit('一括変更', array('name' => 'ikkatsu')); ?></div></td>
</tr>
</table>
<br><br><br>

<br>
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
                   echo "<input type='date' value=$date_deliver name=date_deliver_{$i} empty=Please select size='6'/>\n";
                   echo "</div></td>\n";
                 ?>

            <?php
             $i_count = $i;
             echo $this->Form->hidden('i_count' ,['value'=>$i_count]);
             echo $this->Form->hidden("orderEdis_".$i ,['value'=>${"orderEdis".$i}->id]);
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
<td style="border-style: none;"><div align="center"><?= $this->Form->submit('納期変更確認', array('name' => 'noukikakunin')); ?></div></td>
</tr>
</table>

<?=$this->Form->end() ?>

</form>

<?php elseif(isset($data["nouki"]) && $bunnoucheck!=0)://日付変更を押したとき ?>
  <br>
  <legend align="center"><strong style="font-size: 12pt; color:red"><?= "分納済みの注文が選択されています。" ?></strong></legend>
  <legend align="center"><strong style="font-size: 12pt; color:red"><?= "分納済みの注文は納期変更できません。" ?></strong></legend>
  <br><br><br>

<?php elseif(isset($data["bunnnou"]))://分納を押したとき ?>

<form method="post" action="henkou5dnpbunnou" enctype="multipart/form-data">

    <?php
      $data = $this->request->getData();
/*      echo "<pre>";
      print_r("bunnou");
      echo "</pre>";
*/
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
                  $product_code = ${"orderEdis".$i}->product_code;
                  $DnpTotalAmount = $this->DnpTotalAmounts->find()->where(['num_order' => ${"orderEdis".$i}->num_order, 'date_order' => ${"orderEdis".$i}->date_order, 'product_code' => $product_code])->toArray();
                  $Dnpdate_deliver = $DnpTotalAmount[0]->date_deliver;
                ?>
                <td width="200" colspan="20" nowrap="nowrap"><?= h($Dnpdate_deliver) ?></td>
              <?php
              echo $this->Form->hidden("orderEdis_".$i ,['value'=>${"orderEdis".$i}->id]);
              ?>
              <?php
                $product_code = ${"orderEdis".$i}->product_code;
                $DnpTotalAmount = $this->DnpTotalAmounts->find()->where(['num_order' => ${"orderEdis".$i}->num_order, 'date_order' => ${"orderEdis".$i}->date_order, 'product_code' => $product_code])->toArray();
                $TotalAmount = $DnpTotalAmount[0]->amount;
              ?>
                <td width="150" colspan="20" nowrap="nowrap"><?= h($TotalAmount) ?></td>
              </tr>
              <?php endforeach; ?>
            <?php endfor;?>

          </tbody>
      </table>
  <br><br>


  <table align="left" border="2" bordercolor="#E6FFFF" cellpadding="0" cellspacing="0">
    <tr>
    <td style="border-style: none;"><div align="center"><?= $this->Form->submit('分納追加', array('name' => 'tsuika')); ?></div></td>
    <td style="border-style: none;"><div align="center"><?= $this->Form->submit('分納伝票登録', array('name' => 'touroku')); ?></div></td>
    <td style="border-style: none;"><legend align="center"><font color="red"><?= __($meschecknum) ?></font></legend></td>
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

            <?php for ($j=0;$j<$bunnou_num;$j++): ?>
              <tr style="border-bottom: solid;border-width: 1px">
                <td width="150" colspan="20" nowrap="nowrap"><?= h($j+1) ?></td>
                <?php
                 $dateYMD = date('Y-m-d');
          //       $date_deliver = ${"orderEdis".$j}->date_deliver->format('Y-m-d');
          //       $amount = ${"orderEdis".$j}->amount;
                 echo "<td width='200' colspan='20'><div align='center'>\n";
                 echo "<input type='date' value=${"date_deliver".$j} name=date_deliver_{$j} empty=Please select size='6'/>\n";
                 echo "</div></td>\n";
                 echo "<td width='200' colspan='20'><div align='center'>\n";
                 echo "<input type='text' value=${"amount".$j} name=amount_{$j} empty=Please select size='6'/>\n";
                 echo "<input type='hidden' value=${"id".$j} name=orderEdis_{$j} empty=Please select size='6'/>\n";
                 echo "</div></td>\n";
                ?>
                <td width="200" colspan="20" nowrap="nowrap"><?= h("変更可") ?></td>
              </tr>
            <?php endfor;?>
          </tbody>
      </table>
      <br>
      <legend align="center"><strong style="font-size: 11pt; color:red"><?= "元々あった分納を削除する場合は数量を空にしてください。" ?></strong></legend>

<br><br>
<?php
 echo $this->Form->hidden('tsuikanum' ,['value'=>1]);
?>

  <?=$this->Form->end() ?>

</form>

<?php elseif(isset($data["tsuika"])): ?>

  <?php
    $data = $this->request->getData();
    echo "<pre>";
    print_r("tuika");
    echo "</pre>";

  ?>

<?php elseif($bunnoucheck==0): ?>

  <form method="post" action="henkou6dnp" enctype="multipart/form-data">

  <table align="center" border="2" bordercolor="#E6FFFF" cellpadding="0" cellspacing="0">
    <tbody border="2" bordercolor="#E6FFFF" bgcolor="#FFFFCC">

  <?php
        $dateYMD = date('Y-m-d');

        echo "<td width='150' colspan='3' style='border-bottom: solid;border-width: 1px'><div align='center'><strong style='font-size: 12pt; color:blue'>\n";
        echo "納期一括変更";
        echo "</strong></div></td>\n";
        echo "<td width='250' colspan='37' style='border-bottom: solid;border-width: 1px'><div align='center'>\n";
        echo "<input type='date' value=$dateYMD name=date_ikkatsu empty=Please select size='6'/>\n";
        echo "</div></td>\n";
        echo "</tr>\n";
   ?>
  <br>
  <table align="center" border="2" bordercolor="#E6FFFF" cellpadding="0" cellspacing="0">
  <tr>
  <br>
  <td style="border-style: none;"><div align="center"><?= $this->Form->submit('一括変更', array('name' => 'ikkatsu')); ?></div></td>
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
                echo "<input type='date' value=$date_deliver name=date_deliver_{$i} empty=Please select size='6'/>\n";
                echo "</div></td>\n";
               ?>
              <?php
               $i_count = $i;
               echo $this->Form->hidden('i_count' ,['value'=>$i_count]);
               echo $this->Form->hidden("orderEdis_".$i ,['value'=>${"orderEdis".$i}->id]);
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
  <td style="border-style: none;"><div align="center"><?= $this->Form->submit('納期変更確認', array('name' => 'noukikakunin')); ?></div></td>
  </tr>
  </table>

  <?=$this->Form->end() ?>

  </form>
<?php else: ?>
  <br>
  <legend align="center"><strong style="font-size: 12pt; color:red"><?= "分納済みの注文が選択されています。" ?></strong></legend>
  <legend align="center"><strong style="font-size: 12pt; color:red"><?= "分納済みの注文は納期変更できません。" ?></strong></legend>
  <br><br><br>


<?php endif; ?>
