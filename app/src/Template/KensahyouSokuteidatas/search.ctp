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
//          echo $this->Form->create($kensahyouSokuteidatas, ['url' => ['action' => 'index']]);
?>

<div align="center">
     <?=$this->Form->create() ?>
     <fieldset>
            <?=$this->Form->create('TimeSearch', ['url' => ['action' => 'search', 'type' => 'post']])?>
            <?=$this->Form->input("start", array('type' => 'date')); ?>
            <?=$this->Form->input("end", array('type' => 'date')); ?>
            <?=$this->Form->hidden("product_code", array('type' => 'value', 'value' => $product_code)); ?>
<br>
     <?= $this->Form->button(__('検索')) ?>
     </fieldset>

<div align="center"><strong><font color="blue"><?php echo $mes;?></font></strong></div>

    <table align="center" border="2" bordercolor="#E6FFFF" cellpadding="0" cellspacing="0" style="border-bottom: solid;border-width: 1px">
        <thead>
            <tr  border="2" bordercolor="#E6FFFF" bgcolor="#FFFFFF">
                <th scope="col"><?= $this->Paginator->sort('product_code') ?></th>
                <th scope="col"><?= $this->Paginator->sort('product_name') ?></th>
                <th scope="col"><?= $this->Paginator->sort('manu_date') ?></th>
            </tr>
        </thead>
        <tbody border="2" bordercolor="#E6FFFF" bgcolor="#FFFFFF">
            <?php foreach ($kensahyouSokuteidatas as $KensahyouSokuteidata): ?>
            <tr>
                <?php
//                    $Productcode = $KensahyouSokuteidata->product_code;
//                    $Product = $this->Products->find()->where(['product_code' => $Productcode])->toArray();
                    $Product = $this->Products->find()->where(['product_code' => $product_code])->toArray();
        	    $Productname = $Product[0]->product_name;
                ?>
                <td><?php echo $this->Html->link($product_code, ['action'=>'view', 'name' => $product_code, 'value1' => $KensahyouSokuteidata->manu_date, 'value2' => $KensahyouSokuteidata->inspec_date]); ?></td>
                <td><?= h($Productname) ?></td>
                <td><?= h($KensahyouSokuteidata->manu_date) ?></td>
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
