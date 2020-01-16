<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\PriceProduct[]|\Cake\Collection\CollectionInterface $priceProducts
 */
use Cake\ORM\TableRegistry;//独立したテーブルを扱う
$this->Customers = TableRegistry::get('customers');//productsテーブルを使う
$this->Products = TableRegistry::get('products');//productsテーブルを使う
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
<table width="800" border="0" bordercolor="#E6FFFF" align="center" cellpadding="0" cellspacing="0" bgcolor="#E6FFFF">
  <tr>
          <tr>
              <br>
              <p align="center"><?php echo $this->Html->image('ShinkiTourokuMenu/seihinnkakaku.gif',array('width'=>'125','height'=>'46'));?></p>
          </tr>
  </tr>
</table>
</body>
</html>

<hr size="5">

              <p align="center"><?php echo $this->Html->image('ShinkiTourokuMenu/sinnkitouroku.gif',array('url'=>array('controller'=>'priceProducts','action'=>'form')));?></p>

<hr size="5">

<br>
<table align="center" border="2" bordercolor="#E6FFFF" cellpadding="0" cellspacing="0" style="border-bottom: solid;border-width: 1px">
      <tbody border="2" bordercolor="#E6FFFF" bgcolor="#FFFFCC">
      <tr>
        <td width="100" ><div align="center"><strong><font color="blue" size="3"><?= h('製品') ?></font></strong></div></td>
        <td width="100" ><div align="center"><strong><font color="blue" size="3"><?= h('顧客') ?></font></strong></div></td>
        <td width="100" ><div align="center"><strong><font color="blue" size="3"><?= h('price') ?></font></strong></div></td>
        <td width="100" ><div align="center"><strong><font color="blue" size="3"><?= h('start') ?></font></strong></div></td>
        <td width="100" ><div align="center"><strong><font color="blue" size="3"><?= h('status') ?></font></strong></div></td>
        <td width="50" ><div align="center"><strong><font color="blue" size="3"><?= h('') ?></font></strong></div></td>
      </tr>

      <?php foreach ($priceProducts as $priceProduct): ?>
      <tr>
        <?php
          $product_id = $priceProduct->product_id;
          $Product = $this->Products->find()->where(['id' => $product_id])->toArray();
          $product_name = $Product[0]->product_name;
        ?>
          <td><?= h($product_name) ?></td>
        <?php
          $customer_id = $priceProduct->customer_id;
          $Customer = $this->Customers->find()->where(['id' => $customer_id])->toArray();
          $customer_name = $Customer[0]->name;
        ?>
          <td><?= h($customer_name) ?></td>
          <td><?= h($priceProduct->price) ?></td>
          <td><?= h($priceProduct->start) ?></td>
          <td><?= h($priceProduct->status) ?></td>
          <td class="actions">
              <?= $this->Html->link(__('編集'), ['action' => 'edit', $priceProduct->id]) ?>
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
