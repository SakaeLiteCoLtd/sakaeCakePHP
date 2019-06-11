<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\PriceMaterial[]|\Cake\Collection\CollectionInterface $priceMaterials
 */
use Cake\ORM\TableRegistry;//独立したテーブルを扱う
$this->Materials = TableRegistry::get('materials');//productsテーブルを使う
$this->Suppliers = TableRegistry::get('suppliers');//productsテーブルを使う
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

    <?= $this->Html->css('base1.css') ?>
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
              <p align="center"><?php echo $this->Html->image('ShinkiTourokuMenu/genryoukakaku.gif',array('width'=>'125','height'=>'46'));?></p>
          </tr>
  </tr>
</table>
</body>
</html>

<hr size="5">

              <p align="center"><?php echo $this->Html->image('ShinkiTourokuMenu/menu_csv.gif',array('url'=>array('controller'=>'priceMaterials','action'=>'confirmcsv')));?></p>

<hr size="5">

              <p align="center"><?php echo $this->Html->image('ShinkiTourokuMenu/sinnkitouroku.gif',array('url'=>array('controller'=>'priceMaterials','action'=>'form1')));?></p>

<hr size="5">

    <table align="center" border="2" bordercolor="#E6FFFF" cellpadding="0" cellspacing="0" style="border-bottom: solid;border-width: 1px">
        <thead>
            <tr  border="2" bordercolor="#E6FFFF" bgcolor="#FFDEAD">
                <th scope="col" style="width: 150px"><?= $this->Paginator->sort('material_id') ?></th>
                <th scope="col" style="width: 150px"><?= $this->Paginator->sort('supplier_id') ?></th>
                <th scope="col"><?= $this->Paginator->sort('lot_low') ?></th>
                <th scope="col"><?= $this->Paginator->sort('lot_upper') ?></th>
                <th scope="col"><?= $this->Paginator->sort('price') ?></th>
                <th scope="col"><?= $this->Paginator->sort('start') ?></th>
                <th scope="col"><?= $this->Paginator->sort('finish') ?></th>
                <th scope="col"><?= $this->Paginator->sort('status') ?></th>
                <th scope="col" class="actions"><?= __('') ?></th>
            </tr>
        </thead>
        <tbody border="2" bordercolor="#E6FFFF" bgcolor="#FFEFD5">
            <?php foreach ($priceMaterials as $priceMaterial): ?>
            <tr>
            	<?php
                    $material_id = $priceMaterial->material_id;//$userのrole_idに$role_idと名前をつける
            		$Material = $this->Materials->find()->where(['id' => $material_id])->toArray();//'id' => $role_idとなるデータをRolesテーブルから配列で取得
            		$material_name = $Material[0]->grade.'='.$Material[0]->color;//配列の0番目（0番目しかない）のnameに$user_roleと名前を付ける
            	?>
                <td><?= h($material_name) ?></td>
            	<?php
                    $supplier_id = $priceMaterial->supplier_id;//$userのrole_idに$role_idと名前をつける
            		$Supplier = $this->Suppliers->find()->where(['id' => $supplier_id])->toArray();//'id' => $role_idとなるデータをRolesテーブルから配列で取得
            		$supplier_name = $Supplier[0]->name;//配列の0番目（0番目しかない）のnameに$user_roleと名前を付ける
            	?>
                <td><?= h($supplier_name) ?></td>
                <td><?= h($priceMaterial->lot_low) ?></td>
                <td><?= h($priceMaterial->lot_upper) ?></td>
                <td><?= h($priceMaterial->price) ?></td>
                <td><?= h($priceMaterial->start) ?></td>
                <td><?= h($priceMaterial->finish) ?></td>
                <td><?= h($priceMaterial->status) ?></td>
                <td class="actions">
                    <?= $this->Html->link(__('edit'), ['action' => 'edit', $priceMaterial->id]) ?>
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

