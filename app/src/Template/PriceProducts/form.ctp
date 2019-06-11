<?php
/**
 * AuthHelper: Authの変数にアクセスできる
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\PriceProduct $priceProduct
 */
?>
        <?php
            $username = $this->request->Session()->read('Auth.User.username');
        ?>

              <p align="center"><?php echo $this->Html->image('ShinkiTourokuMenu/touroku.gif',array('width'=>'157','height'=>'50'));?></p>

<hr size="5">

    <?= $this->Form->create($priceProduct, ['url' => ['action' => 'confirm']]) ?>
    <fieldset>
<table align="center" border="2" bordercolor="#E6FFFF" cellpadding="0" cellspacing="0" style="border-bottom: solid;border-width: 1px">
        <tbody border="2" bordercolor="#E6FFFF" bgcolor="#FFFFCC">
            <th scope="row"><?= __('product_id') ?></th>
		<td><?= $this->Form->input("product_id", ["type"=>"select","empty"=>"Please select", "options"=>$arrProduct, 'label'=>false]); ?></td>
	</tr>
        <tbody border="2" bordercolor="#E6FFFF" bgcolor="#FFFFCC">
            <th scope="row"><?= __('customer_id') ?></th>
		<td><?= $this->Form->input("customer_id", ["type"=>"select","empty"=>"Please select", "options"=>$arrCustomer, 'label'=>false]); ?></td>
	</tr>
        <tbody border="2" bordercolor="#E6FFFF" bgcolor="#FFFFCC">
            <th scope="row"><?= __('price') ?></th>
		<td><?= $this->Form->input("price", array('type' => 'value', 'label'=>false)); ?></td>
	</tr>
        <tbody border="2" bordercolor="#E6FFFF" bgcolor="#FFFFCC">
            <th scope="row"><?= __('start') ?></th>
		<td><?= $this->Form->input("start", array('type' => 'date', 'label'=>false)); ?></td>
	</tr>
        <tbody border="2" bordercolor="#E6FFFF" bgcolor="#FFFFCC">
            <th scope="row"><?= __('status') ?></th>
		<td><?= $this->Form->input("status", array('type' => 'value', 'label'=>false)); ?></td>
	</tr>
</table>

        <?php
            echo $this->Form->hidden('delete_flag');
            echo $this->Form->hidden('created_staff', ['empty' => true]);
            echo $this->Form->hidden('updated_staff');
        ?>
    </fieldset>
    <center><?= $this->Form->button(__('confirm'), array('name' => 'kakunin')) ?></center>
    <?= $this->Form->end() ?>
<br>
