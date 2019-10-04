<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\Staff[]|\Cake\Collection\CollectionInterface $staffs
 */
use Cake\ORM\TableRegistry;//独立したテーブルを扱う
$this->Products = TableRegistry::get('products');//productsテーブルを使う
$this->KensahyouSokuteidatas = TableRegistry::get('kensahyouSokuteidatas');//kensahyouHeadsテーブルを使う
?>
<?php
          $username = $this->request->Session()->read('Auth.User.username');

          header('Expires:-1');
          header('Cache-Control:');
          header('Pragma:');
//          echo $this->Form->create($kensahyouSokuteidatas, ['url' => ['action' => 'index']]);
          $product_code = substr($product_code, 1, -1);
//          $Sokutei_lot_num = $KensahyouSokuteidata->lot_num;
?>

<div align="center">
     <?=$this->Form->create() ?>
     <fieldset>
<div align="center"><strong><font color="blue"><?php echo "製造年月日";?></font></strong></div>
            <?=$this->Form->create('TimeSearch', ['url' => ['action' => 'search', 'type' => 'post']])?>
            <?=$this->Form->input("start", array('type' => 'date')); ?>
            <?=$this->Form->input("end", array('type' => 'date')); ?>
            <?=$this->Form->hidden("product_code", array('type' => 'value', 'value' => $product_code)); ?>
<br>
     <?= $this->Form->button(__('絞り込み')) ?>
     </fieldset>

<div align="center"><strong><font color="blue"><?php echo $mes;?></font></strong></div>

    <table align="center" border="2" bordercolor="#E6FFFF" cellpadding="0" cellspacing="0" style="border-bottom: solid;border-width: 1px">
        <thead>
            <tr  border="2" bordercolor="#E6FFFF" bgcolor="#FFFFFF">
                <th scope="col"><?= $this->Paginator->sort('product_code') ?></th>
                <th scope="col"><?= $this->Paginator->sort('product_name') ?></th>
                <th scope="col"><?= $this->Paginator->sort('manu_date') ?></th>
                <th scope="col"><?= $this->Paginator->sort('lot_num') ?></th>
            </tr>
        </thead>
        <tbody border="2" bordercolor="#E6FFFF" bgcolor="#FFFFFF">
            <?php foreach ($kensahyouSokuteidatas as $KensahyouSokuteidata): ?>
            <tr>
                <?php
                $Product = $this->Products->find()->where(['product_code' => $product_code])->toArray();
                $Productname = $Product[0]->product_name;
                $Sokutei_lot_num = $KensahyouSokuteidata->lot_num;
                $KensahyouSokutei = $this->KensahyouSokuteidatas->find()->where(['lot_num' => $Sokutei_lot_num, 'product_code' => $product_code])->toArray();
                ?>
            <?php if(isset($KensahyouSokutei[0])): ?>
                <?php
                $lot_num = $KensahyouSokutei[0]->lot_num;
                $manu_date = $KensahyouSokutei[0]->manu_date;
                ?>
                <td><?php echo $this->Html->link($product_code, ['action'=>'view', 'name' => $product_code, 'value1' => $lot_num, 'value2' => $manu_date]); ?></td>
                <td><?= h($Productname) ?></td>
                <td><?= h($manu_date) ?></td>
                <td><?= h($lot_num) ?></td>
              <?php else: ?>
              <?php endif; ?>

            <?php endforeach; ?>
        </tbody>
    </table>
     <?= $this->Form->end() ?>
</div>
<br>
<br>
<br>
<br>
<br>
<br>
<br>
<br>
<br>
<br>
