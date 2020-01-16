<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\CustomersHandy[]|\Cake\Collection\CollectionInterface $customersHandy
 */
use Cake\ORM\TableRegistry;//独立したテーブルを扱う
$this->Customers = TableRegistry::get('customers');//productsテーブルを使う
$this->Delivers = TableRegistry::get('delivers');//productsテーブルを使う
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
              <p align="center"><?php echo $this->Html->image('ShinkiTourokuMenu/kanikakyaku.gif',array('width'=>'125','height'=>'46'));?></p>
          </tr>
  </tr>
</table>
</body>
</html>

<hr size="5">

              <p align="center"><?php echo $this->Html->image('ShinkiTourokuMenu/sinnkitouroku.gif',array('url'=>array('controller'=>'customersHandy','action'=>'form')));?></p>

<hr size="5">

<br>
<table align="center" border="2" bordercolor="#E6FFFF" cellpadding="0" cellspacing="0" style="border-bottom: solid;border-width: 1px">
      <tbody border="2" bordercolor="#E6FFFF" bgcolor="#FFFFCC">
      <tr>
        <td width="200" ><div align="center"><strong><font color="blue" size="3"><?= h('顧客') ?></font></strong></div></td>
        <td width="200" ><div align="center"><strong><font color="blue" size="3"><?= h('place_deliver_id') ?></font></strong></div></td>
        <td width="200" ><div align="center"><strong><font color="blue" size="3"><?= h('name') ?></font></strong></div></td>
        <td width="50" ><div align="center"><strong><font color="blue" size="3"><?= h('') ?></font></strong></div></td>
      </tr>

      <?php foreach ($customersHandy as $customersHandy): ?>
      <tr>
        <?php
          $customer_id = $customersHandy->customer_id;
          $Customer = $this->Customers->find()->where(['id' => $customer_id])->toArray();
          $customer_name = $Customer[0]->name;
        ?>
          <td><?= h($customer_name) ?></td>
        <?php
          $place_deliver_id = $customersHandy->place_deliver_id;
          $Deliver = $this->Delivers->find()->where(['id' => $place_deliver_id])->toArray();
          $deliver_name = $Deliver[0]->name;
        ?>
          <td><?= h($deliver_name) ?></td>
          <td><?= h($customersHandy->name) ?></td>
          <td class="actions">
              <?= $this->Html->link(__('編集'), ['action' => 'edit', $customersHandy->id]) ?>
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
