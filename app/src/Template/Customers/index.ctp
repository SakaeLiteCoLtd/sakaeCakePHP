<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\Customer[]|\Cake\Collection\CollectionInterface $customers
 */
 use App\myClass\Shinkimenus\htmlShinkimenu;//myClassフォルダに配置したクラスを使用

 $htmlShinkimenu = new htmlShinkimenu();
 $htmlShinkis = $htmlShinkimenu->Shinkimenus();
 ?>
 <hr size="5" style="margin: 0.5rem">
 <table style="margin-bottom:0px" width="750" border="0" align="center" cellpadding="0" cellspacing="0" bordercolor="#CCCCCC">
 <?php
    echo $htmlShinkis;
 ?>
 </table>
 <hr size="5" style="margin: 0.5rem">
 <table width="1300" border="0" bordercolor="#E6FFFF" align="center" cellpadding="0" cellspacing="0" bgcolor="#E6FFFF">
  <tr>
          <tr>
              <br>
              <p align="center"><?php echo $this->Html->image('ShinkiTourokuMenu/TourokuCustomer.gif',array('width'=>'125','height'=>'46'));?></p>
          </tr>
  </tr>
</table>

<hr size="5" style="margin: 0.5rem">

<p align="center"><?php echo $this->Html->image('ShinkiTourokuMenu/sinnkitouroku.gif',array('url'=>array('controller'=>'customers','action'=>'form')));?></p>

<hr size="5" style="margin: 0.5rem">

<br>
<table align="center" border="2" bordercolor="#E6FFFF" cellpadding="0" cellspacing="0" style="border-bottom: solid;border-width: 1px">
      <tbody border="2" bordercolor="#E6FFFF" bgcolor="#FFFFCC">
      <tr>
        <td width="80" ><div align="center"><strong><font color="blue" size="2"><?= h('顧客コード') ?></font></strong></div></td>
        <td width="200" ><div align="center"><strong><font color="blue" size="3"><?= h('社名') ?></font></strong></div></td>
        <td width="200" ><div align="center"><strong><font color="blue" size="3"><?= h('住所') ?></font></strong></div></td>
        <td width="90" ><div align="center"><strong><font color="blue" size="3"><?= h('電話番号') ?></font></strong></div></td>
        <td width="90" ><div align="center"><strong><font color="blue" size="3"><?= h('ＦＡＸ') ?></font></strong></div></td>
        <td width="50" ><div align="center"><strong><font color="blue" size="2"><?= h('zip') ?></font></strong></div></td>
        <td width="60" ><div align="center"><strong><font color="blue" size="2"><?= h('status') ?></font></strong></div></td>
        <td width="20" ><div align="center"><strong><font color="blue" size="3"><?= h('') ?></font></strong></div></td>
      </tr>

      <?php foreach ($customers as $customer): ?>
      <tr>
          <td><?= h($customer->customer_code) ?></td>
          <td><?= h($customer->name) ?></td>
          <td><?= h($customer->address) ?></td>
          <td><?= h($customer->tel) ?></td>
          <td><?= h($customer->fax) ?></td>
          <td><?= h($customer->zip) ?></td>
          <td><?= $this->Number->format($customer->status) ?></td>
          <td class="actions">
              <?= $this->Html->link(__('編集'), ['action' => 'edit', $customer->id]) ?>
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
