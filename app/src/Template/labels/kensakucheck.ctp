<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\Staff[]|\Cake\Collection\CollectionInterface $staffs
 */
 use Cake\ORM\TableRegistry;//独立したテーブルを扱う
 $this->Products = TableRegistry::get('products');//productsテーブルを使う
?>
        <?php
          $username = $this->request->Session()->read('Auth.User.username');

          header('Expires:-1');
          header('Cache-Control:');
          header('Pragma:');

          $i = 0;
        ?>

<hr size="5">
<?=$this->Form->create($checkLots, ['url' => ['action' => 'kensakucheck']]) ?>
<br><br>
<table align="center" border="2" bordercolor="#E6FFFF" cellpadding="0" cellspacing="0">
  <tbody border="2" bordercolor="#E6FFFF" bgcolor="#FFFFCC" style="border-bottom: solid;border-width: 1px">
        <thead>
            <tr border="2" bordercolor="#E6FFFF" bgcolor="#FFFFCC">
              <td width="10" colspan="10" nowrap="nowrap"><div align="center"></div></td>
              <td width="150" height="30" colspan="20" nowrap="nowrap"><div align="center"><strong style="font-size: 12pt; color:blue">品番</strong></div></td>
              <td width="200" height="30" colspan="20" nowrap="nowrap"><div align="center"><strong style="font-size: 12pt; color:blue">品名</strong></div></td>
              <td width="150" height="30" colspan="20" nowrap="nowrap"><div align="center"><strong style="font-size: 12pt; color:blue">ロットNo.</strong></div></td>
              <td width="150" height="30" colspan="20" nowrap="nowrap"><div align="center"><strong style="font-size: 12pt; color:blue">数量</strong></div></td>
              <td width="200" height="30" colspan="20" nowrap="nowrap"><div align="center"><strong style="font-size: 12pt; color:blue">出荷状態</strong></div></td>
            </tr>
        </thead>
        <tbody border="2" bordercolor="#E6FFFF" bgcolor="#FFFFCC">
          <?php foreach ($checkLots as $checkLot): ?>
            <?php
            $i = $i + 1 ;
            $this->set('i',$i);
             ?>
            <tr style="border-bottom: solid;border-width: 1px">
              <?php
              echo "<td colspan='10' nowrap='nowrap'>\n";
              echo "<input type='checkbox' name=check".$i." size='6'/>\n";
              echo "</td>\n";
              ?>
                  <td width="150" colspan="20" nowrap="nowrap"><?= h($checkLot->product_code) ?></td>
                <?php
                  $product_code = $checkLot->product_code;
              		$Product = $this->Products->find()->where(['product_code' => $product_code])->toArray();
              		$product_name = $Product[0]->product_name;
                ?>
                <td width="200" colspan="20" nowrap="nowrap"><?= h($product_name) ?></td>
                <td width="150" colspan="20" nowrap="nowrap"><?= h($checkLot->lot_num) ?></td>
                <td width="150" colspan="20" nowrap="nowrap"><?= h($checkLot->amount) ?></td>
            <?php
            	if($checkLot->flag_used == 0){
            	$flag_used = '出荷待ち';
            	} elseif($checkLot->flag_used == 1) {
            	$flag_used = '出荷済み';
            	} else {
            	$flag_used = '不明';
            	}
            ?>
                <td width="200" colspan="20" nowrap="nowrap"><?= h($flag_used) ?></td>
            </tr>
            <?php endforeach; ?>
        </tbody>
    </table>

    <tr bgcolor="#E6FFFF" >
      <td align="right" rowspan="2" width="50" bgcolor="#E6FFFF" style="border: none"><div align="center"><?= $this->Form->submit(__('確認'), array('name' => 'touroku', 'value'=>"1")); ?></div></td>
    </tr>

<br><br>
