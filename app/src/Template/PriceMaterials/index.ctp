<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\PriceMaterial[]|\Cake\Collection\CollectionInterface $priceMaterials
 */
use Cake\ORM\TableRegistry;//独立したテーブルを扱う
$this->Materials = TableRegistry::get('materials');//productsテーブルを使う
$this->Suppliers = TableRegistry::get('suppliers');//productsテーブルを使う
use App\myClass\Shinkimenus\htmlShinkimenu;//myClassフォルダに配置したクラスを使用

$htmlShinkimenu = new htmlShinkimenu();
$htmlShinkis = $htmlShinkimenu->Shinkimenus();
?>
<hr size="5">
<table style="margin-bottom:0px" width="750" border="0" align="center" cellpadding="0" cellspacing="0" bordercolor="#CCCCCC">
<?php
   echo $htmlShinkis;
?>
</table>
<hr size="5">
<table width="1000" border="0" bordercolor="#E6FFFF" align="center" cellpadding="0" cellspacing="0" bgcolor="#E6FFFF">
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

              <p align="center"><?php echo $this->Html->image('ShinkiTourokuMenu/sinnkitouroku.gif',array('url'=>array('controller'=>'priceMaterials','action'=>'form1')));?></p>

<hr size="5">

<br>
<table align="center" border="2" bordercolor="#E6FFFF" cellpadding="0" cellspacing="0" style="border-bottom: solid;border-width: 1px">
      <tbody border="2" bordercolor="#E6FFFF" bgcolor="#FFFFCC">
      <tr>
        <td width="120" ><div align="center"><strong><font color="blue" size="3"><?= h('material_id') ?></font></strong></div></td>
        <td width="120" ><div align="center"><strong><font color="blue" size="3"><?= h('supplier_id') ?></font></strong></div></td>
        <td width="100" ><div align="center"><strong><font color="blue" size="3"><?= h('lot_low') ?></font></strong></div></td>
        <td width="100" ><div align="center"><strong><font color="blue" size="3"><?= h('lot_upper') ?></font></strong></div></td>
        <td width="100" ><div align="center"><strong><font color="blue" size="3"><?= h('price') ?></font></strong></div></td>
        <td width="100" ><div align="center"><strong><font color="blue" size="3"><?= h('start') ?></font></strong></div></td>
        <td width="100" ><div align="center"><strong><font color="blue" size="3"><?= h('finish') ?></font></strong></div></td>
        <td width="50" ><div align="center"><strong><font color="blue" size="3"><?= h('status') ?></font></strong></div></td>
        <td width="50" ><div align="center"><strong><font color="blue" size="3"><?= h('') ?></font></strong></div></td>
      </tr>

      <?php foreach ($priceMaterials as $priceMaterial): ?>
      <tr>
        <?php
              $material_id = $priceMaterial->material_id;
          $Material = $this->Materials->find()->where(['id' => $material_id])->toArray();
          $material_name = $Material[0]->grade.'='.$Material[0]->color;
        ?>
          <td><?= h($material_name) ?></td>
        <?php
          $supplier_id = $priceMaterial->supplier_id;
          $Supplier = $this->Suppliers->find()->where(['id' => $supplier_id])->toArray();
          $supplier_name = $Supplier[0]->name;
        ?>
          <td><?= h($supplier_name) ?></td>
          <td><?= h($priceMaterial->lot_low) ?></td>
          <td><?= h($priceMaterial->lot_upper) ?></td>
          <td><?= h($priceMaterial->price) ?></td>
          <td><?= h($priceMaterial->start) ?></td>
          <td><?= h($priceMaterial->finish) ?></td>
          <td><?= h($priceMaterial->status) ?></td>
          <td class="actions">
              <?= $this->Html->link(__('編集'), ['action' => 'edit', $priceMaterial->id]) ?>
          </td>
      </tr>
      <?php endforeach; ?>
</table>
<br>

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
