<?php
 use App\myClass\Syukkakensa\htmlSyukkakensamenu;//myClassフォルダに配置したクラスを使用
 $htmlSyukkakensamenu = new htmlSyukkakensamenu();
 $htmlSyukkakensamenus = $htmlSyukkakensamenu->Syukkakensamenu();

 $username = $this->request->Session()->read('Auth.User.username');
 use Cake\ORM\TableRegistry;//独立したテーブルを扱う
 $this->Products = TableRegistry::get('products');//productsテーブルを使う
 $this->KensahyouSokuteidatas = TableRegistry::get('kensahyouSokuteidatas');//kensahyouSokuteidatasテーブルを使う
 $i = 1 ;

 header('Expires:-1');
 header('Cache-Control:');
 header('Pragma:');

 ?>
 <hr size="5" style="margin: 0.5rem">
 <table style="margin-bottom:0px" width="750" border="0" align="center" cellpadding="0" cellspacing="0" bordercolor="#CCCCCC">
 <?php
    echo $htmlSyukkakensamenus;
 ?>
 </table>
 <hr size="5" style="margin: 0.5rem">

<?= $this->Form->create($product, ['url' => ['action' => 'ichiran']]) ?>
<fieldset>

<?php
echo $this->Form->hidden('date_deliver' ,['value'=>$date_deliver]);
echo $this->Form->hidden('field' ,['value'=>$field]);
?>


<table align="center" border="2" bordercolor="#E6FFFF" cellpadding="0" cellspacing="0" style="border-bottom: solid;border-width: 1px">
  <tr>
    <td width="280" bgcolor="#FFFFCC" style="font-size: 8pt;padding: 0.2rem"><strong style="font-size: 11pt; color:blue">納期</strong></td>
    <td width="282" bgcolor="#FFFFCC" style="font-size: 8pt;padding: 0.2rem"><strong style="font-size: 11pt; color:blue">顧客</strong></td>
	</tr>
  <tr>
    <td width="280"  bgcolor="#FFFFCC" style="padding: 0.2rem"><?= h($date_deliver) ?></td>
    <td width="280"  bgcolor="#FFFFCC" style="padding: 0.2rem"><?= h($field) ?></td>
	</tr>
</table>
<br><br>
<table align="right" border="2" bordercolor="#E6FFFF" cellpadding="0" cellspacing="0">
<tr>
  <td style="border-style: none;"><div align="center"><?= $this->Form->submit('全てチェック', array('name' => 'allcheck')); ?></div></td>
  <td style="border-style: none;"><div align="center"><?= $this->Form->submit('全てチェックをはずす', array('name' => 'nocheck')); ?></div></td>
</tr>
</table>

<?php if($allcheck_flag != 1): ?>

  <table align="center" border="2" bordercolor="#E6FFFF" cellpadding="0" cellspacing="0">
    <tbody border="2" bordercolor="#E6FFFF" bgcolor="#FFFFCC" style="border-bottom: solid;border-width: 1px">
          <thead>
              <tr border="2" bordercolor="#E6FFFF" bgcolor="#FFFFCC">
                <td width="30" height="30" colspan="10" nowrap="nowrap"><div align="center"><strong style="font-size: 12pt; color:blue"></strong></div></td>
                <td width="150" height="30" colspan="20" nowrap="nowrap"><div align="center"><strong style="font-size: 12pt; color:blue">品番</strong></div></td>
                <td width="250" height="30" colspan="20" nowrap="nowrap"><div align="center"><strong style="font-size: 12pt; color:blue">品名</strong></div></td>
                <td width="50" height="30" colspan="20" nowrap="nowrap"><div align="center"><strong style="font-size: 12pt; color:blue">納品数</strong></div></td>
                <td width="50" height="30" colspan="20" nowrap="nowrap"><div align="center"><strong style="font-size: 12pt; color:blue">納品ID</strong></div></td>
                <td width="250" height="30" colspan="20" nowrap="nowrap"><div align="center"><strong style="font-size: 12pt; color:blue">製造年月日:ロット番号</strong></td>
              </tr>
          </thead>
          <tbody border="2" bordercolor="#E6FFFF" bgcolor="#FFFFCC">
              <?php foreach ($orderEdis as $orderEdis): ?>
                <?php
                $i = $i + 1 ;
                $this->set('i',$i);

                $product_code = $orderEdis->product_code;

                ${"manudateuniq".$i} = array();
                ${"manudate".$i} = array();
                $KensahyouSokuteidatas = $this->KensahyouSokuteidatas->find()->where(['product_code' => $product_code])->order(['manu_date' => 'DESC'])->limit(100)->toArray();

                for($k=0; $k<100; $k++){

                  if(isset($KensahyouSokuteidatas[$k])){
                    ${"manudateuniq".$i}[] = array($KensahyouSokuteidatas[$k]["manu_date"]->format('Y-m-d')." : ".$KensahyouSokuteidatas[$k]["lot_num"]);
                  }

                }
                ${"manudateuniq".$i} = array_unique(${"manudateuniq".$i}, SORT_REGULAR);
                ${"manudateuniq".$i} = array_values(${"manudateuniq".$i});

                for($k=0; $k<10; $k++){

                  if(isset(${"manudateuniq".$i}[$k])){
                    ${"manudate".$i}[] = array(${"manudateuniq".$i}[$k][0]=>${"manudateuniq".$i}[$k][0]);
                  }

                }

                 ?>
              <tr style="border-bottom: solid;border-width: 1px">
                <?php
                echo "<td colspan='10' nowrap='nowrap'>\n";
                echo "<input type='checkbox' name=check".$i." size='6'/>\n";
                echo "</td>\n";
                ?>
                <td width="150" colspan="20" nowrap="nowrap"><?= h($orderEdis->product_code) ?></td>
                  <?php
                    $product_code = $orderEdis->product_code;
                		$Product = $this->Products->find()->where(['product_code' => $product_code])->toArray();
                		$product_name = $Product[0]->product_name;

                    echo $this->Form->hidden('product_code'.$i ,['value'=>$orderEdis->product_code]);
                    echo $this->Form->hidden('product_name'.$i ,['value'=>$product_name]);
                    echo $this->Form->hidden('amount'.$i ,['value'=>$orderEdis->amount]);
                    echo $this->Form->hidden('place_line'.$i ,['value'=>$orderEdis->place_line]);
                  ?>
                <td width="250" colspan="20" nowrap="nowrap"><?= h($product_name) ?></td>
                <td width="100" colspan="20" nowrap="nowrap"><?= h($orderEdis->amount) ?></td>
                <td width="150" colspan="20" nowrap="nowrap"><?= h($orderEdis->place_line) ?></td>
                <td width="150" colspan="20" nowrap="nowrap"><?= $this->Form->input("manu_date".$i, ["type"=>"select", "options"=>${"manudate".$i}, 'label'=>false]) ?></td>
              </tr>
              <?php endforeach; ?>

             <?php
              echo "<input type='hidden' name='nummax' value=$i size='6'/>\n";
              ?>

          </tbody>
      </table>

<?php else: ?>

    <table align="center" border="2" bordercolor="#E6FFFF" cellpadding="0" cellspacing="0">
      <tbody border="2" bordercolor="#E6FFFF" bgcolor="#FFFFCC" style="border-bottom: solid;border-width: 1px">
            <thead>
                <tr border="2" bordercolor="#E6FFFF" bgcolor="#FFFFCC">
                  <td width="30" height="30" colspan="10" nowrap="nowrap"><div align="center"><strong style="font-size: 12pt; color:blue"></strong></div></td>
                  <td width="150" height="30" colspan="20" nowrap="nowrap"><div align="center"><strong style="font-size: 12pt; color:blue">品番</strong></div></td>
                  <td width="250" height="30" colspan="20" nowrap="nowrap"><div align="center"><strong style="font-size: 12pt; color:blue">品名</strong></div></td>
                  <td width="50" height="30" colspan="20" nowrap="nowrap"><div align="center"><strong style="font-size: 12pt; color:blue">納品数</strong></div></td>
                  <td width="50" height="30" colspan="20" nowrap="nowrap"><div align="center"><strong style="font-size: 12pt; color:blue">納品ID</strong></div></td>
                  <td width="250" height="30" colspan="20" nowrap="nowrap"><div align="center"><strong style="font-size: 12pt; color:blue">製造年月日:ロット番号</strong></td>
                </tr>
            </thead>
            <tbody border="2" bordercolor="#E6FFFF" bgcolor="#FFFFCC">
                <?php foreach ($orderEdis as $orderEdis): ?>
                  <?php
                  $i = $i + 1 ;
                  $this->set('i',$i);

                  $product_code = $orderEdis->product_code;

                  ${"manudateuniq".$i} = array();
                  ${"manudate".$i} = array();
                  $KensahyouSokuteidatas = $this->KensahyouSokuteidatas->find()->where(['product_code' => $product_code])->order(['manu_date' => 'DESC'])->limit(100)->toArray();

                  for($k=0; $k<100; $k++){

                    if(isset($KensahyouSokuteidatas[$k])){
                      ${"manudateuniq".$i}[] = array($KensahyouSokuteidatas[$k]["manu_date"]->format('Y-m-d')." : ".$KensahyouSokuteidatas[$k]["lot_num"]);
                    }

                  }
                  ${"manudateuniq".$i} = array_unique(${"manudateuniq".$i}, SORT_REGULAR);
                  ${"manudateuniq".$i} = array_values(${"manudateuniq".$i});

                  for($k=0; $k<10; $k++){

                    if(isset(${"manudateuniq".$i}[$k])){
        //              $manudate = substr(${"manudateuniq".$i}[$k][0], 0, 9);

                      ${"manudate".$i}[] = array(${"manudateuniq".$i}[$k][0]=>${"manudateuniq".$i}[$k][0]);
                    }

                  }

                   ?>
                <tr style="border-bottom: solid;border-width: 1px">
                  <?php
                  echo "<td colspan='10' nowrap='nowrap'>\n";
                  echo "<input type='checkbox' name=check".$i." checked='checked' size='6'/>\n";
                  echo "</td>\n";
                  ?>
                  <td width="150" colspan="20" nowrap="nowrap"><?= h($orderEdis->product_code) ?></td>
                    <?php
                      $product_code = $orderEdis->product_code;
                  		$Product = $this->Products->find()->where(['product_code' => $product_code])->toArray();
                  		$product_name = $Product[0]->product_name;

                      echo $this->Form->hidden('product_code'.$i ,['value'=>$orderEdis->product_code]);
                      echo $this->Form->hidden('product_name'.$i ,['value'=>$product_name]);
                      echo $this->Form->hidden('amount'.$i ,['value'=>$orderEdis->amount]);
                      echo $this->Form->hidden('place_line'.$i ,['value'=>$orderEdis->place_line]);
                    ?>
                  <td width="250" colspan="20" nowrap="nowrap"><?= h($product_name) ?></td>
                  <td width="100" colspan="20" nowrap="nowrap"><?= h($orderEdis->amount) ?></td>
                  <td width="150" colspan="20" nowrap="nowrap"><?= h($orderEdis->place_line) ?></td>
                  <td width="250" colspan="20" nowrap="nowrap"><?= $this->Form->input("manu_date".$i, ["type"=>"select", "options"=>${"manudate".$i}, 'label'=>false]) ?></td>
                </tr>
                <?php endforeach; ?>

               <?php
                echo "<input type='hidden' name='nummax' value=$i size='6'/>\n";
                ?>

            </tbody>
        </table>

<?php endif; ?>

    </fieldset>
    <table align="center" border="2" bordercolor="#E6FFFF" cellpadding="0" cellspacing="0">
    <tr>
      <td style="border-style: none;"><div align="center"><?= $this->Form->submit('戻る', ['onclick' => 'history.back()', 'type' => 'button']); ?></div></td>
      <td style="border-style: none;"><div align="center"><?= $this->Form->submit('登録確認', array('name' => 'kakunin')); ?></div></td>
    </tr>
    </table>
<br>
