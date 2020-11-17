<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\Staff[]|\Cake\Collection\CollectionInterface $staffs
 */
 use Cake\ORM\TableRegistry;//独立したテーブルを扱う
 $this->Products = TableRegistry::get('products');//productsテーブルを使う
 $this->NameLotFlagUseds = TableRegistry::get('nameLotFlagUseds');
?>
        <?php
          $username = $this->request->Session()->read('Auth.User.username');

          header('Expires:-1');
          header('Cache-Control:');
          header('Pragma:');
        ?>

<hr size="5">
<?=$this->Form->create($checkLots, ['url' => ['action' => 'kensakuview']]) ?>
<br><br>
<table align="center" border="2" bordercolor="#E6FFFF" cellpadding="0" cellspacing="0">
  <tbody border="2" bordercolor="#E6FFFF" bgcolor="#FFFFCC" style="border-bottom: solid;border-width: 1px">
        <thead>
            <tr border="2" bordercolor="#E6FFFF" bgcolor="#FFFFCC">
              <td width="150" height="30" colspan="20" nowrap="nowrap"><div align="center"><strong style="font-size: 12pt; color:blue">品番</strong></div></td>
              <td width="200" height="30" colspan="20" nowrap="nowrap"><div align="center"><strong style="font-size: 12pt; color:blue">品名</strong></div></td>
              <td width="150" height="30" colspan="20" nowrap="nowrap"><div align="center"><strong style="font-size: 12pt; color:blue">ロットNo.</strong></div></td>
              <td width="150" height="30" colspan="20" nowrap="nowrap"><div align="center"><strong style="font-size: 12pt; color:blue">数量</strong></div></td>
              <td width="200" height="30" colspan="20" nowrap="nowrap"><div align="center"><strong style="font-size: 12pt; color:blue">出荷状態</strong></div></td>
            </tr>
        </thead>
        <tbody border="2" bordercolor="#E6FFFF" bgcolor="#FFFFCC">
            <?php for($i=0; $i<$countlot; $i++): ?>
            <tr style="border-bottom: solid;border-width: 1px">
                <td width="150" colspan="20" nowrap="nowrap"><?= h($checkLot[$i]["product_id"]) ?></td>
                <?php
                  $product_code = $checkLot[$i]["product_id"];
              		$Product = $this->Products->find()->where(['product_code' => $product_code])->toArray();
              		$product_name = $Product[0]->product_name;
                ?>
                <td width="200" colspan="20" nowrap="nowrap"><?= h($product_name) ?></td>
                <td width="150" colspan="20" nowrap="nowrap"><?= h($checkLot[$i]["lot_num"]) ?></td>
                <td width="150" colspan="20" nowrap="nowrap"><?= h($checkLot[$i]["amount"]) ?></td>
            <?php
            //flag_usedの数=name_lot_flag_usedsのidとなるname_lot_flag_usedsのnameを表示する
            //$checkLot->flag_deliverがnullでないとき、「flag_deliver（の日付）納品済み」とする
              $f_used = $checkLot[$i]["flag_used"];
              $flag_deliver = $checkLot[$i]["flag_deliver"];
              if($flag_deliver != null){
                $flag_used = $flag_deliver." 納品済み";
              }elseif($f_used == 0){
                $flag_used = "検査済み";
              }else{
                $NameLotFlagUsed = $this->NameLotFlagUseds->find()->where(['id' => $f_used])->toArray();
                $flag_used = $NameLotFlagUsed[0]->name;
              }
            ?>
                <td width="200" colspan="20" nowrap="nowrap"><?= h($flag_used) ?></td>
            </tr>
          <?php endfor;?>
        </tbody>
    </table>
<br><br>
