<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\Customer $customer
 */
?>
<?= $this->Form->create($customer, ['url' => ['action' => 'preadd']]) ?>
        <?php
            $username = $this->request->Session()->read('Auth.User.username');

            $session = $this->request->getSession();
            $session->write('customerdata.customer_code', $_POST['customer_code']);
            $session->write('customerdata.name', $_POST['name']);
            $session->write('customerdata.zip', $_POST['zip']);
            $session->write('customerdata.address', $_POST['address']);
            $session->write('customerdata.tel', $_POST['tel']);
            $session->write('customerdata.fax', $_POST['fax']);
            $session->write('customerdata.status', $_POST['status']);
            $session->write('customerdata.delete_flag', $_POST['delete_flag']);
            $session->write('customerdata.created_staff', $_POST['created_staff']);
            $session->write('customerdata.updated_staff', null);

        ?>

<hr size="5">

              <p align="center"><?php echo $this->Html->image('ShinkiTourokuMenu/touroku.gif',array('width'=>'157','height'=>'50'));?></p>

<hr size="5">

    <table align="center" border="2" bordercolor="#E6FFFF" cellpadding="0" cellspacing="0" style="border-bottom: solid;border-width: 1px">
        <tbody border="2" bordercolor="#E6FFFF" bgcolor="#FFFFCC">
            <th scope="row"><?= __('顧客コード') ?></th>
            <td><?= h($this->request->getData('customer_code')) ?></td>
        </tr>
        <tbody border="2" bordercolor="#E6FFFF" bgcolor="#FFFFCC">
            <th scope="row"><?= __('社名') ?></th>
            <td><?= h($this->request->getData('name')) ?></td>
        </tr>
        <tbody border="2" bordercolor="#E6FFFF" bgcolor="#FFFFCC">
            <th scope="row"><?= __('zip') ?></th>
            <td><?= h($this->request->getData('zip')) ?></td>
        </tr>
        <tbody border="2" bordercolor="#E6FFFF" bgcolor="#FFFFCC">
            <th scope="row"><?= __('住所') ?></th>
            <td><?= h($this->request->getData('address')) ?></td>
        </tr>
        <tbody border="2" bordercolor="#E6FFFF" bgcolor="#FFFFCC">
            <th scope="row"><?= __('電話番号') ?></th>
            <td><?= h($this->request->getData('tel')) ?></td>
        </tr>
        <tbody border="2" bordercolor="#E6FFFF" bgcolor="#FFFFCC">
            <th scope="row"><?= __('ＦＡＸ') ?></th>
            <td><?= h($this->request->getData('fax')) ?></td>
        </tr>
        <tbody border="2" bordercolor="#E6FFFF" bgcolor="#FFFFCC">
            <th scope="row"><?= __('Status') ?></th>
            <td><?= h($this->request->getData('status')) ?></td>
    </table>
<br>
<br>
        <p align="center"><?= $this->Form->button('戻る', ['onclick' => 'history.back()', 'type' => 'button']) /*history.back()セッションの値を保持して戻る*/?>
        <?= $this->Form->button(__('登録'), array('name' => 'touroku')) ?></p>
        <?= $this->Form->end() ?>
