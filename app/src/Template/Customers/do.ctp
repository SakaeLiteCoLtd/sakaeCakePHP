<?php
/**
 * AuthHelper: Authの変数にアクセスできる
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\Customer $customer
 */
?>
<?= $this->Form->create($customer, ['url' => ['action' => 'index']]) ?>

<?php
            $username = $this->request->Session()->read('Auth.User.username');
            $session = $this->request->getSession();
            $customer_code = $session->read('customerdata.customer_code');
            $name = $session->read('customerdata.name');
            $zip = $session->read('customerdata.zip');
            $address = $session->read('customerdata.address');
            $tel = $session->read('customerdata.tel');
            $fax = $session->read('customerdata.fax');
            $status = $session->read('customerdata.status');
?>
<hr size="5">
              <p align="center"><?php echo $this->Html->image('ShinkiTourokuMenu/touroku.gif',array('width'=>'157','height'=>'50'));?></p>

<hr size="5">

<legend align="center"><font color="red"><?= __('＊下記のように登録されました。') ?></font></legend>
    <table align="center" border="2" bordercolor="#E6FFFF" cellpadding="0" cellspacing="0" style="border-bottom: solid;border-width: 1px">
        <tbody border="2" bordercolor="#E6FFFF" bgcolor="#FFFFCC">
            <th scope="row"><?= __('顧客コード') ?></th>
            <td><?= h($customer_code) ?></td>
        </tr>
        <tbody border="2" bordercolor="#E6FFFF" bgcolor="#FFFFCC">
            <th scope="row"><?= __('社名') ?></th>
            <td><?= h($name) ?></td>
        </tr>
        <tbody border="2" bordercolor="#E6FFFF" bgcolor="#FFFFCC">
            <th scope="row"><?= __('ZIP') ?></th>
            <td><?= h($zip) ?></td>
        </tr>
        <tbody border="2" bordercolor="#E6FFFF" bgcolor="#FFFFCC">
            <th scope="row"><?= __('住所') ?></th>
            <td><?= h($address) ?></td>
        </tr>
        <tbody border="2" bordercolor="#E6FFFF" bgcolor="#FFFFCC">
            <th scope="row"><?= __('電話番号') ?></th>
            <td><?= h($tel) ?></td>
        </tr>
        <tbody border="2" bordercolor="#E6FFFF" bgcolor="#FFFFCC">
            <th scope="row"><?= __('ＦＡＸ') ?></th>
            <td><?= h($fax) ?></td>
        </tr>
        <tbody border="2" bordercolor="#E6FFFF" bgcolor="#FFFFCC">
            <th scope="row"><?= __('Status') ?></th>
            <td><?= h($status) ?></td>
        </tr>
        <tbody border="2" bordercolor="#E6FFFF" bgcolor="#FFEFD5">
            <th scope="row"><?= __('登録日時') ?></th>
            <td><?= h($customer->created_at) ?></td>
        </tr>
        <tbody border="2" bordercolor="#E6FFFF" bgcolor="#FFEFD5">
            <th scope="row"><?= __('登録者') ?></th>
            <td><?= h($CreatedStaff) ?></td>
    </table>
<br>
<br>
        <p align="center"><?= $this->Form->button(__('トップ'), array('name' => 'top')) ?></p>
        <?= $this->Form->end() ?>
