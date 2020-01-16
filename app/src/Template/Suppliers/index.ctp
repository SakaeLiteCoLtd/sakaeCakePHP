<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\Supplier[]|\Cake\Collection\CollectionInterface $suppliers
 */
use Cake\ORM\TableRegistry;//独立したテーブルを扱う
$this->SupplierSections = TableRegistry::get('supplierSections');//productsテーブルを使う
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
<table width="1300" border="0" bordercolor="#E6FFFF" align="center" cellpadding="0" cellspacing="0" bgcolor="#E6FFFF">
  <tr>
          <tr>
              <br>
              <p align="center"><?php echo $this->Html->image('ShinkiTourokuMenu/touroku_supplier.gif',array('width'=>'125','height'=>'46'));?></p>
          </tr>
  </tr>
</table>
</body>
</html>

<hr size="5">

              <p align="center"><?php echo $this->Html->image('ShinkiTourokuMenu/sinnkitouroku.gif',array('url'=>array('controller'=>'suppliers','action'=>'form')));?></p>

<hr size="5">


<br>
<table align="center" border="2" bordercolor="#E6FFFF" cellpadding="0" cellspacing="0" style="border-bottom: solid;border-width: 1px">
      <tbody border="2" bordercolor="#E6FFFF" bgcolor="#FFFFCC">
      <tr>
        <td width="100" ><div align="center"><strong><font color="blue" size="3"><?= h('supplier_section_id') ?></font></strong></div></td>
        <td width="50" ><div align="center"><strong><font color="blue" size="3"><?= h('supplier_code') ?></font></strong></div></td>
        <td width="100" ><div align="center"><strong><font color="blue" size="3"><?= h('名前') ?></font></strong></div></td>
        <td width="50" ><div align="center"><strong><font color="blue" size="3"><?= h('zip') ?></font></strong></div></td>
        <td width="100" ><div align="center"><strong><font color="blue" size="3"><?= h('住所') ?></font></strong></div></td>
        <td width="50" ><div align="center"><strong><font color="blue" size="3"><?= h('電話') ?></font></strong></div></td>
        <td width="50" ><div align="center"><strong><font color="blue" size="3"><?= h('FAX') ?></font></strong></div></td>
        <td width="20" ><div align="center"><strong><font color="blue" size="3"><?= h('charge_p') ?></font></strong></div></td>
        <td width="20" ><div align="center"><strong><font color="blue" size="3"><?= h('status') ?></font></strong></div></td>
        <td width="20" ><div align="center"><strong><font color="blue" size="3"><?= h('') ?></font></strong></div></td>
      </tr>

      <?php foreach ($suppliers as $supplier): ?>
      <tr>
        <?php
          $supplierSection_id = $supplier->supplier_section_id;
          $SupplierSection = $this->SupplierSections->find()->where(['id' => $supplierSection_id])->toArray();
          $supplierSection_name = $SupplierSection[0]->name;
        ?>
          <td><?= h($supplierSection_name) ?></td>
          <td><?= h($supplier->supplier_code) ?></td>
          <td><?= h($supplier->name) ?></td>
          <td><?= h($supplier->zip) ?></td>
          <td><?= h($supplier->address) ?></td>
          <td><?= h($supplier->tel) ?></td>
          <td><?= h($supplier->fax) ?></td>
          <td><?= h($supplier->charge_p) ?></td>
          <td><?= $this->Number->format($supplier->status) ?></td>
          <td class="actions">
              <?= $this->Html->link(__('編集'), ['action' => 'edit', $supplier->id]) ?>
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
