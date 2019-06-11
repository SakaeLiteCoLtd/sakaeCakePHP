<?php
/**
 * AuthHelper: Authの変数にアクセスできる
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\Material $material
 */
?>
        <?php
            $username = $this->request->Session()->read('Auth.User.username');
        ?>

              <p align="center"><?php echo $this->Html->image('ShinkiTourokuMenu/touroku.gif',array('width'=>'157','height'=>'50'));?></p>

<hr size="5">

    <?= $this->Form->create($material, ['url' => ['action' => 'confirm']]) ?>
    <fieldset>
<table align="center" border="2" bordercolor="#E6FFFF" cellpadding="0" cellspacing="0" style="border-bottom: solid;border-width: 1px">
        <tbody border="2" bordercolor="#E6FFFF" bgcolor="#FFFFCC">
            <th scope="row"><?= __('grade') ?></th>
		<td><?= $this->Form->input("grade", array('type' => 'value', 'label'=>false)); ?></td>
	</tr>
        <tbody border="2" bordercolor="#E6FFFF" bgcolor="#FFFFCC">
            <th scope="row"><?= __('color') ?></th>
		<td><?= $this->Form->input("color", array('type' => 'value', 'label'=>false)); ?></td>
	</tr>
        <tbody border="2" bordercolor="#E6FFFF" bgcolor="#FFFFCC">
            <th scope="row"><?= __('material_type_id') ?></th>
		<td><?= $this->Form->input("material_type_id", ["type"=>"select","empty"=>"Please select", "options"=>$arrMaterialType, 'label'=>false]); ?></td>
	</tr>
        <tbody border="2" bordercolor="#E6FFFF" bgcolor="#FFFFCC">
            <th scope="row"><?= __('tani') ?></th>
		<td><?= $this->Form->input("tani", array('type' => 'value', 'label'=>false)); ?></td>
	</tr>
        <tbody border="2" bordercolor="#E6FFFF" bgcolor="#FFFFCC">
            <th scope="row"><?= __('multiple_sup') ?></th>
		<td><?= $this->Form->input("multiple_sup", array('type' => 'value', 'label'=>false)); ?></td>
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
    <center><?= $this->Form->button(__('confirm'), array('name' => 'kakunin')) ?></center>
    <?= $this->Form->end() ?>
<br>
