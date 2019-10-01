<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\Supplier $supplier
 */
?>
<?= $this->Form->create($supplier, ['url' => ['action' => 'preadd']]) ?>
        <?php
            $username = $this->request->Session()->read('Auth.User.username');
/*
            echo $this->Form->hidden('supplier_section_id' ,['value'=>$_POST['supplier_section_id'] ]) ;
            echo $this->Form->hidden('supplier_code' ,['value'=>$_POST['supplier_code'] ]) ;
            echo $this->Form->hidden('name' ,['value'=>$_POST['name'] ]) ;
            echo $this->Form->hidden('zip' ,['value'=>$_POST['zip'] ]) ;
            echo $this->Form->hidden('address' ,['value'=>$_POST['address'] ]) ;
            echo $this->Form->hidden('tel' ,['value'=>$_POST['tel'] ]) ;
            echo $this->Form->hidden('fax' ,['value'=>$_POST['fax'] ]) ;
            echo $this->Form->hidden('charge_p' ,['value'=>$_POST['charge_p'] ]) ;
            echo $this->Form->hidden('status' ,['value'=>$_POST['status'] ]) ;
            echo $this->Form->hidden('delete_flag' ,['value'=>$_POST['delete_flag'] ]) ;
            echo $this->Form->hidden('created_staff' ,['value'=>$_POST['created_staff'] ]) ;
//            echo $this->Form->hidden('updated_staff' ,['value'=>null ]) ;
*/

            $session = $this->request->getSession();
            $session->write('supplierdata.supplier_section_id', $_POST['supplier_section_id']);
            $session->write('supplierdata.supplier_code', $_POST['supplier_code']);
            $session->write('supplierdata.name', $_POST['name']);
            $session->write('supplierdata.zip', $_POST['zip']);
            $session->write('supplierdata.address', $_POST['address']);
            $session->write('supplierdata.tel', $_POST['tel']);
            $session->write('supplierdata.fax', $_POST['fax']);
            $session->write('supplierdata.charge_p', $_POST['charge_p']);
            $session->write('supplierdata.status', $_POST['status']);
            $session->write('supplierdata.delete_flag', $_POST['delete_flag']);
            $session->write('supplierdata.created_staff', $_POST['created_staff']);
            $session->write('supplierdata.updated_staff', null);
        ?>
<hr size="5">

              <p align="center"><?php echo $this->Html->image('ShinkiTourokuMenu/touroku.gif',array('width'=>'157','height'=>'50'));?></p>

<hr size="5">

    <table align="center" border="2" bordercolor="#E6FFFF" cellpadding="0" cellspacing="0" style="border-bottom: solid;border-width: 1px">
        <tbody border="2" bordercolor="#E6FFFF" bgcolor="#FFFFCC">
            <th scope="row"><?= __('supplier_section_id') ?></th>
            <td><?= h($SupplierSection) ?></td>
        </tr>
        <tbody border="2" bordercolor="#E6FFFF" bgcolor="#FFFFCC">
            <th scope="row"><?= __('supplier_code') ?></th>
            <td><?= h($this->request->getData('supplier_code')) ?></td>
        </tr>
        <tbody border="2" bordercolor="#E6FFFF" bgcolor="#FFFFCC">
            <th scope="row"><?= __('name') ?></th>
            <td><?= h($this->request->getData('name')) ?></td>
        </tr>
        <tbody border="2" bordercolor="#E6FFFF" bgcolor="#FFFFCC">
            <th scope="row"><?= __('zip') ?></th>
            <td><?= h($this->request->getData('zip')) ?></td>
        </tr>
        <tbody border="2" bordercolor="#E6FFFF" bgcolor="#FFFFCC">
            <th scope="row"><?= __('address') ?></th>
            <td><?= h($this->request->getData('address')) ?></td>
        </tr>
        <tbody border="2" bordercolor="#E6FFFF" bgcolor="#FFFFCC">
            <th scope="row"><?= __('tel') ?></th>
            <td><?= h($this->request->getData('tel')) ?></td>
        </tr>
        <tbody border="2" bordercolor="#E6FFFF" bgcolor="#FFFFCC">
            <th scope="row"><?= __('fax') ?></th>
            <td><?= h($this->request->getData('fax')) ?></td>
        </tr>
        <tbody border="2" bordercolor="#E6FFFF" bgcolor="#FFFFCC">
            <th scope="row"><?= __('charge_p') ?></th>
            <td><?= h($this->request->getData('charge_p')) ?></td>
	</tr>
        <tbody border="2" bordercolor="#E6FFFF" bgcolor="#FFFFCC">
            <th scope="row"><?= __('Status') ?></th>
            <td><?= h($this->request->getData('status')) ?></td>
    </table>
<br>
<br>
        <p align="center"><?= $this->Form->button('back', ['onclick' => 'history.back()', 'type' => 'button']) ?>
        <?= $this->Form->button(__('add'), array('name' => 'touroku')) ?></p>
        <?= $this->Form->end() ?>
