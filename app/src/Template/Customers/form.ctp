<?php
/**
 * AuthHelper: Authの変数にアクセスできる
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\Customer $customer
 */
?>
        <?php
            $username = $this->request->Session()->read('Auth.User.username');
        ?>
<hr size="5">

              <p align="center"><?php echo $this->Html->image('ShinkiTourokuMenu/touroku.gif',array('width'=>'157','height'=>'50'));?></p>

<hr size="5">

    <?= $this->Form->create($customer, ['url' => ['action' => 'confirm']]) ?>
    <fieldset>
<table align="center" border="2" bordercolor="#E6FFFF" cellpadding="0" cellspacing="0" style="border-bottom: solid;border-width: 1px">
        <tbody border="2" bordercolor="#E6FFFF" bgcolor="#FFFFCC">
            <th scope="row"><?= __('顧客コード') ?></th>
		<td><?= $this->Form->input("customer_code", array('type' => 'value', 'label'=>false)) ?></td>
	</tr>
        <tbody border="2" bordercolor="#E6FFFF" bgcolor="#FFFFCC">
            <th scope="row"><?= __('社名') ?></th>
		<td><?= $this->Form->input("name", array('type' => 'value', 'label'=>false)); ?></td>
	</tr>
        <tbody border="2" bordercolor="#E6FFFF" bgcolor="#FFFFCC">
            <th scope="row"><?= __('zip') ?></th>
		<td><?= $this->Form->input("zip", array('type' => 'value', 'label'=>false)); ?></td>
	</tr>
        <tbody border="2" bordercolor="#E6FFFF" bgcolor="#FFFFCC">
            <th scope="row"><?= __('住所') ?></th>
		<td><?= $this->Form->input("address", array('type' => 'value', 'label'=>false)); ?></td>
	</tr>
        <tbody border="2" bordercolor="#E6FFFF" bgcolor="#FFFFCC">
            <th scope="row"><?= __('電話番号') ?></th>
		<td><?= $this->Form->input("tel", array('type' => 'value', 'label'=>false)); ?></td>
	</tr>
        <tbody border="2" bordercolor="#E6FFFF" bgcolor="#FFFFCC">
            <th scope="row"><?= __('ＦＡＸ') ?></th>
		<td><?= $this->Form->input("fax", array('type' => 'value', 'label'=>false)); ?></td>
	</tr>
        <tbody border="2" bordercolor="#E6FFFF" bgcolor="#FFFFCC">
            <th scope="row"><?= __('Status') ?></th>
		<td><?= $this->Form->input("status", array('type' => 'value', 'label'=>false)); ?></td>
	</p>
</table>

        <?php
            echo $this->Form->hidden('delete_flag');
            echo $this->Form->hidden('created_staff', ['empty' => true]);
            echo $this->Form->hidden('updated_staff');
        ?>
    </fieldset>
    <center><?= $this->Form->button(__('確認'), array('name' => 'kakunin')) ?></center>
    <?= $this->Form->end() ?>
<br>
