<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\Deliver $deliver
 */
?>
<?= $this->Form->create($deliver, ['url' => ['action' => 'preadd']]) ?>
        <?php
            $username = $this->request->Session()->read('Auth.User.username');
/*
            echo $this->Form->hidden('customer_id' ,['value'=>$_POST['customer_id'] ]) ;
            echo $this->Form->hidden('place_deliver_id' ,['value'=>$_POST['place_deliver_id'] ]) ;
            echo $this->Form->hidden('name' ,['value'=>$_POST['name'] ]) ;
            echo $this->Form->hidden('zip' ,['value'=>$_POST['zip'] ]) ;
            echo $this->Form->hidden('address' ,['value'=>$_POST['address'] ]) ;
            echo $this->Form->hidden('tel' ,['value'=>$_POST['tel'] ]) ;
            echo $this->Form->hidden('fax' ,['value'=>$_POST['fax'] ]) ;
            echo $this->Form->hidden('status' ,['value'=>$_POST['status'] ]) ;
            echo $this->Form->hidden('delete_flag' ,['value'=>$_POST['delete_flag'] ]) ;
            echo $this->Form->hidden('created_staff' ,['value'=>$_POST['created_staff'] ]) ;
            echo $this->Form->hidden('updated_staff' ,['value'=>null ]) ;
*/
            $session = $this->request->getSession();
            $session->write('deliverdata.customer_id', $_POST['customer_id']);
            $session->write('deliverdata.place_deliver_id', $_POST['place_deliver_id']);
            $session->write('deliverdata.name', $_POST['name']);
            $session->write('deliverdata.zip', $_POST['zip']);
            $session->write('deliverdata.address', $_POST['address']);
            $session->write('deliverdata.tel', $_POST['tel']);
            $session->write('deliverdata.fax', $_POST['fax']);
            $session->write('deliverdata.status', $_POST['status']);
            $session->write('deliverdata.delete_flag', $_POST['delete_flag']);
            $session->write('deliverdata.created_staff', $_POST['created_staff']);
            $session->write('deliverdata.updated_staff', null);
        ?>
<hr size="5">

              <p align="center"><?php echo $this->Html->image('ShinkiTourokuMenu/touroku.gif',array('width'=>'157','height'=>'50'));?></p>

<hr size="5">

    <table align="center" border="2" bordercolor="#E6FFFF" cellpadding="0" cellspacing="0" style="border-bottom: solid;border-width: 1px">
        <tbody border="2" bordercolor="#E6FFFF" bgcolor="#FFFFCC">
            <th scope="row"><?= __('customer_id') ?></th>
            <td><?= h($Customer) ?></td>
        </tr>
        <tbody border="2" bordercolor="#E6FFFF" bgcolor="#FFFFCC">
            <th scope="row"><?= __('place_deliver_id') ?></th>
            <td><?= h($this->request->getData('place_deliver_id')) ?></td>
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
            <th scope="row"><?= __('Status') ?></th>
            <td><?= h($this->request->getData('status')) ?></td>
    </table>
<br>
<br>
        <p align="center"><?= $this->Form->button('back', ['onclick' => 'history.back()', 'type' => 'button']) ?>
        <?= $this->Form->button(__('add'), array('name' => 'touroku')) ?></p>
        <?= $this->Form->end() ?>
