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
   $this->OrderEdis = TableRegistry::get('orderEdis');
   echo $this->Form->create($orderEdis, ['url' => ['action' => 'henkoupanapreadd']]);
?>
<?php
header('Expires:-1');//この３行がなければ「戻る」をしたら「フォーム再送信の確認」が表示される。
header('Cache-Control:');
header('Pragma:');
  $data = $this->request->getData();
?>

 </table>
<hr size="5" style="margin: 0.5rem">

<?php if(isset($data["noukikakunin"])): ?>

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
          <?php for ($i=0;$i<$data["i_count"]+1;$i++): ?>
            <?php
              ${"orderEdis".$i} = $this->OrderEdis->find()//以下の条件を満たすデータをOrderEdisテーブルから見つける
                ->where(['id' => $data["orderEdis_".$i]]);
              ${"date_deliver_".$i} = $data["date_deliver_".$i];
            ?>
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
              <td width="200" colspan="20" nowrap="nowrap"><?= h(${"date_deliver_".$i}) ?></td>
              <td width="150" colspan="20" nowrap="nowrap"><?= h(${"orderEdis".$i}->amount) ?></td>
            </tr>
            <?php
            $session = $this->request->getSession();
            $_SESSION['orderEdis'][$i] = array(
              'id' => $data["orderEdis_".$i],
              'date_deliver' => ${"date_deliver_".$i}
            );
            ?>
            <?php endforeach; ?>
          <?php endfor;?>

          <?php
/*          echo "<pre>";
          print_r($_SESSION['orderEdis']);
          echo "</pre>";
*/          ?>

        </tbody>
    </table>
<br>
<table align="left" border="2" bordercolor="#E6FFFF" cellpadding="0" cellspacing="0">
<tr>
<td style="border-style: none;"><div align="center"><?= $this->Form->submit('変更決定', array('name' => 'henkou')); ?></div></td>
</tr>
</table>

<?=$this->Form->end() ?>

<?php elseif(isset($data["ikkatsu"])): ?>
  <?php
/*  echo "<pre>";
  print_r("ikkatsu");
  echo "</pre>";
*/  ?>

<br><br>

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
          <?php for ($i=0;$i<$data["i_count"]+1;$i++): ?>
            <?php
              ${"orderEdis".$i} = $this->OrderEdis->find()//以下の条件を満たすデータをOrderEdisテーブルから見つける
                ->where(['id' => $data["orderEdis_".$i]]);
              ${"date_deliver_".$i} = $data["date_ikkatsu"];
            ?>
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
              <td width="200" colspan="20" nowrap="nowrap"><?= h(${"date_deliver_".$i}) ?></td>
              <td width="150" colspan="20" nowrap="nowrap"><?= h(${"orderEdis".$i}->amount) ?></td>
            </tr>
            <?php
            $session = $this->request->getSession();

            $_SESSION['orderEdis'][$i] = array(
              'id' => $data["orderEdis_".$i],
              'date_deliver' => ${"date_deliver_".$i}
            );
            ?>
            <?php endforeach; ?>
          <?php endfor;?>

          <?php
/*          echo "<pre>";
          print_r($_SESSION['orderEdis']);
          echo "</pre>";
*/          ?>

        </tbody>
    </table>
<br>
<table align="left" border="2" bordercolor="#E6FFFF" cellpadding="0" cellspacing="0">
<tr>
<td style="border-style: none;"><div align="center"><?= $this->Form->submit('変更決定', array('name' => 'henkou')); ?></div></td>
</tr>
</table>

<?=$this->Form->end() ?>

<?php elseif(isset($data["bunnnou"])): ?>

  <br><br><br>
  <table align="left" border="2" bordercolor="#E6FFFF" cellpadding="0" cellspacing="0">
  <tr>
  <td style="border-style: none;"><div align="center"><?= $this->Form->submit('分納テスト', array('name' => 'nouki')); ?></div></td>
  </tr>
  </table>

<?php else: ?>

<?php endif; ?>
