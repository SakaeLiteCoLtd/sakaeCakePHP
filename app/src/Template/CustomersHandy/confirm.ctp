<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\CustomersHandy $customersHandy
 */
?>
<?= $this->Form->create($customersHandy, ['url' => ['action' => 'preadd']]) ?>
        <?php
            $username = $this->request->Session()->read('Auth.User.username');
/*
            echo $this->Form->hidden('customer_id' ,['value'=>$_POST['customer_id'] ]) ;
            echo $this->Form->hidden('place_deliver_id' ,['value'=>$_POST['place_deliver_id'] ]) ;
            echo $this->Form->hidden('name' ,['value'=>$_POST['name'] ]) ;
            echo $this->Form->hidden('delete_flag' ,['value'=>$_POST['delete_flag'] ]) ;
            echo $this->Form->hidden('created_staff' ,['value'=>$_POST['created_staff'] ]) ;
            echo $this->Form->hidden('updated_staff' ,['value'=>null ]) ;
*/
            $session = $this->request->getSession();
            $session->write('customershandydata.customer_id', $_POST['customer_id']);
            $session->write('customershandydata.place_deliver_id', $_POST['place_deliver_id']);
            $session->write('customershandydata.name', $_POST['name']);
            $session->write('customershandydata.delete_flag', $_POST['delete_flag']);
            $session->write('customershandydata.created_staff', $_POST['created_staff']);
            $session->write('customershandydata.updated_staff', null);

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
            <td><?= h($Deliver) ?></td>
        </tr>
        <tbody border="2" bordercolor="#E6FFFF" bgcolor="#FFFFCC">
            <th scope="row"><?= __('name') ?></th>
            <td><?= h($this->request->getData('name')) ?></td>
        </tr>
    </table>
<br>
<br>
        <p align="center"><?= $this->Form->button('back', ['onclick' => 'history.back()', 'type' => 'button']) ?>
        <?= $this->Form->button(__('add'), array('name' => 'touroku')) ?></p>
        <?= $this->Form->end() ?>
