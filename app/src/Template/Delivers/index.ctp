<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\Deliver[]|\Cake\Collection\CollectionInterface $delivers
 */
use Cake\ORM\TableRegistry;//独立したテーブルを扱う
$this->Customers = TableRegistry::get('customers');//productsテーブルを使う
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
              <p align="center"><?php echo $this->Html->image('ShinkiTourokuMenu/teikyougif.gif',array('width'=>'125','height'=>'46'));?></p>
          </tr>
  </tr>
</table>
</body>
</html>

<hr size="5">

              <p align="center"><?php echo $this->Html->image('ShinkiTourokuMenu/sinnkitouroku.gif',array('url'=>array('controller'=>'delivers','action'=>'form')));?></p>

<hr size="5">

<br>
<table align="center" border="2" bordercolor="#E6FFFF" cellpadding="0" cellspacing="0" style="border-bottom: solid;border-width: 1px">
      <tbody border="2" bordercolor="#E6FFFF" bgcolor="#FFFFCC">
      <tr>
        <td width="200" ><div align="center"><strong><font color="blue" size="3"><?= h('顧客') ?></font></strong></div></td>
        <td width="100" ><div align="center"><strong><font color="blue" size="3"><?= h('place_deliver_id') ?></font></strong></div></td>
        <td width="50" ><div align="center"><strong><font color="blue" size="3"><?= h('名前') ?></font></strong></div></td>
        <td width="50" ><div align="center"><strong><font color="blue" size="3"><?= h('zip') ?></font></strong></div></td>
        <td width="100" ><div align="center"><strong><font color="blue" size="3"><?= h('住所') ?></font></strong></div></td>
        <td width="50" ><div align="center"><strong><font color="blue" size="3"><?= h('電話') ?></font></strong></div></td>
        <td width="50" ><div align="center"><strong><font color="blue" size="3"><?= h('FAX') ?></font></strong></div></td>
        <td width="50" ><div align="center"><strong><font color="blue" size="3"><?= h('status') ?></font></strong></div></td>
        <td width="50" ><div align="center"><strong><font color="blue" size="3"><?= h('') ?></font></strong></div></td>
      </tr>

      <?php foreach ($delivers as $deliver): ?>
      <tr>
        <?php
          $customer_id = $deliver->customer_id;
          $Customer = $this->Customers->find()->where(['id' => $customer_id])->toArray();
          $customer_name = $Customer[0]->name;
        ?>
          <td><?= h($customer_name) ?></td>
          <td><?= h($deliver->place_deliver_id) ?></td>
          <td><?= h($deliver->name) ?></td>
          <td><?= h($deliver->zip) ?></td>
          <td><?= h($deliver->address) ?></td>
          <td><?= h($deliver->tel) ?></td>
          <td><?= h($deliver->fax) ?></td>
          <td><?= $this->Number->format($deliver->status) ?></td>
          <td class="actions">
              <?= $this->Html->link(__('編集'), ['action' => 'edit', $deliver->id]) ?>
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
