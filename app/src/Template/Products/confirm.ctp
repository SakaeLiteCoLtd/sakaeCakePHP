<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\Deliver $product
 */
 use App\myClass\Shinkimenus\htmlShinkimenu;//myClassフォルダに配置したクラスを使用

 $htmlShinkimenu = new htmlShinkimenu();
 $htmlShinkis = $htmlShinkimenu->Shinkimenus();
 ?>
<?= $this->Form->create($product, ['url' => ['action' => 'preadd']]) ?>
        <?php
            $username = $this->request->Session()->read('Auth.User.username');

            $session = $this->request->getSession();
            $session->write('productdata.product_code', $_POST['product_code']);
            $session->write('productdata.product_name', $_POST['product_name']);
            $session->write('productdata.customer_id', $_POST['customer_id']);
            $session->write('productdata.multiple_cs', $_POST['multiple_cs']);
            $session->write('productdata.material_id', $_POST['material_id']);
            $session->write('productdata.weight', $_POST['weight']);
    //        $session->write('productdata.torisu', $_POST['torisu']);
    //        $session->write('productdata.cycle', $_POST['cycle']);
            $session->write('productdata.primary_p', 0);
            $session->write('productdata.gaityu', 0);
            $session->write('productdata.status', 0);
            $session->write('productdata.delete_flag', 0);
            $session->write('productdata.created_staff', $_POST['created_staff']);
    //        $session->write('productdata.updated_staff', null);

            $session->write('pricedata.product_code', $_POST['product_code']);
            $session->write('pricedata.price', $_POST['price']);
            $session->write('pricedata.date_koushin', date('Y-m-d'));
            $session->write('pricedata.tourokubi', date('Y-m-d H:i:s'));
            $session->write('pricedata.delete_flag', 0);
            $session->write('pricedata.created_staff', $_POST['created_staff']);
            $session->write('pricedata.created_at', date('Y-m-d H:i:s'));
        ?>
        <hr size="5">
        <table style="margin-bottom:0px" width="750" border="0" align="center" cellpadding="0" cellspacing="0" bordercolor="#CCCCCC">
        <?php
           echo $htmlShinkis;
        ?>
        </table>
        <hr size="5">

              <p align="center"><?php echo $this->Html->image('ShinkiTourokuMenu/touroku.gif',array('width'=>'157','height'=>'50'));?></p>

<hr size="5">

    <table align="center" border="2" bordercolor="#E6FFFF" cellpadding="0" cellspacing="0" style="border-bottom: solid;border-width: 1px">
        <tbody border="2" bordercolor="#E6FFFF" bgcolor="#FFFFCC">
            <th scope="row"><?= __('product_code') ?></th>
            <td><?= h($this->request->getData('product_code')) ?></td>
        </tr>
        <tbody border="2" bordercolor="#E6FFFF" bgcolor="#FFFFCC">
            <th scope="row"><?= __('product_name') ?></th>
            <td><?= h($this->request->getData('product_name')) ?></td>
        </tr>
        <tbody border="2" bordercolor="#E6FFFF" bgcolor="#FFFFCC">
            <th scope="row"><?= __('customer_id') ?></th>
            <td><?= h($Customer) ?></td>
        </tr>
        <tbody border="2" bordercolor="#E6FFFF" bgcolor="#FFFFCC">
            <th scope="row"><?= __('multiple_cs') ?></th>
            <td><?= h($this->request->getData('multiple_cs')) ?></td>
        </tr>
        <tbody border="2" bordercolor="#E6FFFF" bgcolor="#FFFFCC">
            <th scope="row"><?= __('material_id') ?></th>
            <td><?= h($Material) ?></td>
        </tr>
        <tbody border="2" bordercolor="#E6FFFF" bgcolor="#FFFFCC">
            <th scope="row"><?= __('weight') ?></th>
            <td><?= h($this->request->getData('weight')) ?></td>
        </tr>
        <tbody border="2" bordercolor="#E6FFFF" bgcolor="#FFFFCC">
            <th scope="row"><?= __('torisu') ?></th>
            <td><?= h($this->request->getData('torisu')) ?></td>
        </tr>
        <tbody border="2" bordercolor="#E6FFFF" bgcolor="#FFFFCC">
            <th scope="row"><?= __('cycle') ?></th>
            <td><?= h($this->request->getData('cycle')) ?></td>
        </tr>
        <tbody border="2" bordercolor="#E6FFFF" bgcolor="#FFFFCC">
            <th scope="row"><?= __('primary_p') ?></th>
            <td><?= h($this->request->getData('primary_p')) ?></td>
        </tr>
        <tbody border="2" bordercolor="#E6FFFF" bgcolor="#FFFFCC">
            <th scope="row"><?= __('gaityu') ?></th>
            <td><?= h($this->request->getData('gaityu')) ?></td>
        </tr>
        <tbody border="2" bordercolor="#E6FFFF" bgcolor="#FFFFCC">
            <th scope="row"><?= __('status') ?></th>
            <td><?= h($this->request->getData('status')) ?></td>
        </tr>
    </table>
<br>
<br>
<table align="center" border="2" bordercolor="#E6FFFF" cellpadding="0" cellspacing="0">
<tr>
  <td style="border-style: none;"><div align="center"><?= $this->Form->submit('戻る', ['onclick' => 'history.back()', 'type' => 'button']); ?></div></td>
  <td style="border-style: none;"><div align="center"><?= $this->Form->submit('追加', array('name' => 'kakunin')); ?></div></td>
</tr>
</table>
<br>
<?= $this->Form->end() ?>
