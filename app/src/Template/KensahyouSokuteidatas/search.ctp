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
          $i = 0;
?>

<div align="center">
     <?=$this->Form->create() ?>
     <fieldset>
<div align="center"><strong><font color="blue"><?php echo "製造年月日";?></font></strong></div>
            <?=$this->Form->create('TimeSearch', ['url' => ['action' => 'search', 'type' => 'post']])?>
            <?=$this->Form->input("start", array('type' => 'date', 'monthNames' => false)); ?>
            <?=$this->Form->input("end", array('type' => 'date', 'monthNames' => false)); ?>
            <?=$this->Form->hidden("product_code", array('type' => 'value', 'value' => $product_code)); ?>
<br>
     <?= $this->Form->button(__('絞り込み')) ?>
     </fieldset>

<div align="center"><strong><font color="blue"><?php echo $mes;?></font></strong></div>

    <table align="center" border="2" bordercolor="#E6FFFF" cellpadding="0" cellspacing="0" style="border-bottom: solid;border-width: 1px">
        <thead>
            <tr  border="2" bordercolor="#E6FFFF" bgcolor="#FFFFFF">
              <th scope="col"><?= $this->Paginator->sort('ロット番号') ?></th>
              <th scope="col"><?= $this->Paginator->sort('manu_date') ?></th>
                <th scope="col"><?= $this->Paginator->sort('product_code') ?></th>
                <th scope="col"><?= $this->Paginator->sort('product_name') ?></th>
            </tr>
        </thead>
        <tbody border="2" bordercolor="#E6FFFF" bgcolor="#FFFFFF">
            <?php foreach ($uniquearrP as $uniquearrP): ?>
            <tr>
                <?php
                $Product = $this->Products->find()->where(['product_code' => $uniquearrP['product_code']])->toArray();
                $Productname = $Product[0]->product_name;
        //        $i = $i + 1;//表示する個数を調整できる
                ?>
                <?php if($i <= 20): ?>
                <td><?php echo $this->Html->link($uniquearrP['lot_num'], ['action'=>'view', 'name' => $uniquearrP['product_code'], 'value1' => $uniquearrP['lot_num'], 'value2' => $uniquearrP['manu_date']]); ?></td>
                <td><?= h($uniquearrP['manu_date']) ?></td>
                <td><?= h($uniquearrP['product_code']) ?></td>
                <td><?= h($Productname) ?></td>
                <?php else: ?>
                <?php endif; ?>
            <?php endforeach; ?>
        </tbody>
    </table>
     <?= $this->Form->end() ?>
</div>
<br><br><br><br><br><br><br><br><br><br>
