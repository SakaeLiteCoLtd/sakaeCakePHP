<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\CustomersHandy[]|\Cake\Collection\CollectionInterface $customersHandy
 */
use Cake\ORM\TableRegistry;//独立したテーブルを扱う
$this->Customers = TableRegistry::get('customers');//productsテーブルを使う
$this->Delivers = TableRegistry::get('delivers');//productsテーブルを使う
?>
<!DOCTYPE html>
<html>
<head>
    <?= $this->Html->charset() ?>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>
        <?= $cakeDescription ?>:
        <?= $this->fetch('title') ?>
    </title>
    <?= $this->Html->meta('icon') ?>

    <?= $this->Html->css('base2.css') ?>
    <?= $this->Html->css('cake.css') ?>

    <?= $this->fetch('meta') ?>
    <?= $this->fetch('css') ?>
    <?= $this->fetch('script') ?>
</head>
<body>
<table width="1500" border="0" bordercolor="#E6FFFF" align="center" cellpadding="0" cellspacing="0" bgcolor="#E6FFFF">
  <tr>
          <tr>
              <br>
              <p align="center"><?php echo $this->Html->image('ShinkiTourokuMenu/kanikakyaku.gif',array('width'=>'125','height'=>'46'));?></p>
          </tr>
  </tr>
</table>
</body>
</html>

<hr size="5">

              <p align="center"><?php echo $this->Html->image('ShinkiTourokuMenu/menu_csv.gif',array('url'=>array('controller'=>'customersHandy','action'=>'confirmcsv')));?></p>

<hr size="5">

              <p align="center"><?php echo $this->Html->image('ShinkiTourokuMenu/sinnkitouroku.gif',array('url'=>array('controller'=>'customersHandy','action'=>'form')));?></p>

<hr size="5">

    <table align="center" border="2" bordercolor="#E6FFFF" cellpadding="0" cellspacing="0" style="border-bottom: solid;border-width: 1px">
        <thead>
            <tr  border="2" bordercolor="#E6FFFF" bgcolor="#FFDEAD">
                <th scope="col"><?= $this->Paginator->sort('customer_id') ?></th>
                <th scope="col"><?= $this->Paginator->sort('place_deliver_id') ?></th>
                <th scope="col"><?= $this->Paginator->sort('name') ?></th>
                <th scope="col" class="actions"><?= __('') ?></th>
            </tr>
        </thead>
        <tbody border="2" bordercolor="#E6FFFF" bgcolor="#FFEFD5">
            <?php foreach ($customersHandy as $customersHandy): ?>
            <tr>
            	<?php
                    $customer_id = $customersHandy->customer_id;//$userのrole_idに$role_idと名前をつける
            		$Customer = $this->Customers->find()->where(['id' => $customer_id])->toArray();//'id' => $role_idとなるデータをRolesテーブルから配列で取得
            		$customer_name = $Customer[0]->name;//配列の0番目（0番目しかない）のnameに$user_roleと名前を付ける
            	?>
                <td><?= h($customer_name) ?></td>
            	<?php
                    $place_deliver_id = $customersHandy->place_deliver_id;//$userのrole_idに$role_idと名前をつける
            		$Deliver = $this->Delivers->find()->where(['id' => $place_deliver_id])->toArray();//'id' => $role_idとなるデータをRolesテーブルから配列で取得
            		$deliver_name = $Deliver[0]->name;//配列の0番目（0番目しかない）のnameに$user_roleと名前を付ける
            	?>
                <td><?= h($deliver_name) ?></td>
                <td><?= h($customersHandy->name) ?></td>
                <td class="actions">
                    <?= $this->Html->link(__('edit'), ['action' => 'edit', $customersHandy->id]) ?>
                </td>
            </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
    <div class="paginator">
        <ul class="pagination">
            <?= $this->Paginator->first('<< ' . __('first')) ?>
            <?= $this->Paginator->prev('< ' . __('previous')) ?>
            <?= $this->Paginator->numbers() ?>
            <?= $this->Paginator->next(__('next') . ' >') ?>
            <?= $this->Paginator->last(__('last') . ' >>') ?>
        </ul>
        <p><?= $this->Paginator->counter(['format' => __('Page {{page}} of {{pages}}, showing {{current}} record(s) out of {{count}} total')]) ?></p>
    </div>


