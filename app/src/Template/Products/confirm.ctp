<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\Deliver $product
 */
?>
<?= $this->Form->create($product, ['url' => ['action' => 'preadd']]) ?>
        <?php
            $username = $this->request->Session()->read('Auth.User.username');
/*
            echo $this->Form->hidden('product_code' ,['value'=>$_POST['product_code'] ]) ;
            echo $this->Form->hidden('product_name' ,['value'=>$_POST['product_name'] ]) ;
            echo $this->Form->hidden('customer_id' ,['value'=>$_POST['customer_id'] ]) ;
            echo $this->Form->hidden('multiple_cs' ,['value'=>$_POST['multiple_cs'] ]) ;
            echo $this->Form->hidden('material_id' ,['value'=>$_POST['material_id'] ]) ;
            echo $this->Form->hidden('weight' ,['value'=>$_POST['weight'] ]) ;
            echo $this->Form->hidden('torisu' ,['value'=>$_POST['torisu'] ]) ;
            echo $this->Form->hidden('cycle' ,['value'=>$_POST['cycle'] ]) ;
            echo $this->Form->hidden('primary_p' ,['value'=>$_POST['primary_p'] ]) ;
            echo $this->Form->hidden('gaityu' ,['value'=>$_POST['gaityu'] ]) ;
            echo $this->Form->hidden('status' ,['value'=>$_POST['status'] ]) ;
            echo $this->Form->hidden('delete_flag' ,['value'=>$_POST['delete_flag'] ]) ;
            echo $this->Form->hidden('created_staff' ,['value'=>$_POST['created_staff'] ]) ;
            echo $this->Form->hidden('updated_staff' ,['value'=>null ]) ;
*/
            $session = $this->request->getSession();
            $session->write('productdata.product_code', $_POST['product_code']);
            $session->write('productdata.product_name', $_POST['product_name']);
            $session->write('productdata.customer_id', $_POST['customer_id']);
            $session->write('productdata.multiple_cs', $_POST['multiple_cs']);
            $session->write('productdata.material_id', $_POST['material_id']);
            $session->write('productdata.weight', $_POST['weight']);
            $session->write('productdata.torisu', $_POST['torisu']);
            $session->write('productdata.cycle', $_POST['cycle']);
            $session->write('productdata.primary_p', $_POST['primary_p']);
            $session->write('productdata.gaityu', $_POST['gaityu']);
            $session->write('productdata.status', $_POST['status']);
            $session->write('productdata.delete_flag', $_POST['delete_flag']);
            $session->write('productdata.created_staff', $_POST['created_staff']);
            $session->write('productdata.updated_staff', null);
        ?>
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
        <p align="center"><?= $this->Form->button('back', ['onclick' => 'history.back()', 'type' => 'button']) ?>
        <?= $this->Form->button(__('add'), array('name' => 'touroku')) ?></p>
        <?= $this->Form->end() ?>
