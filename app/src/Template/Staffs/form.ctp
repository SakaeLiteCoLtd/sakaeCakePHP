<?php
/**
 * AuthHelper: Authの変数にアクセスできる
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\Staff $staff
 */
?>
        <?php
            $username = $this->request->Session()->read('Auth.User.username');
            $options = [
	            '0' => 'M',
	            '1' => 'F'
                    ];
        ?>

              <p align="center"><?php echo $this->Html->image('ShinkiTourokuMenu/touroku.gif',array('width'=>'157','height'=>'50'));?></p>

<hr size="5">

    <?= $this->Form->create($staff, ['url' => ['action' => 'confirm']]) ?>
    <fieldset>
<table bgcolor="#FFFFCC" align="center" border="2" bordercolor="#E6FFFF" cellpadding="0" cellspacing="0">
	<tr bgcolor="#FFFFCC">
            <th bgcolor="#FFFFCC" scope="row"><?= __('staff_code') ?></th>
		<td bgcolor="#FFFFCC"><?= $this->Form->input("staff_code", array('type' => 'value', 'label'=>false)) ?></td>
	</tr>
	<tr bgcolor="#FFFFCC">
            <th bgcolor="#FFFFCC" scope="row"><?= __('f_name') ?></th>
		<td bgcolor="#FFFFCC"><?= $this->Form->input("f_name", array('type' => 'value', 'label'=>false)); ?></td>
	</tr>
	<tr bgcolor="#FFFFCC">
            <th scope="row"><?= __('l_name') ?></th>
		<td><?= $this->Form->input("l_name", array('type' => 'value', 'label'=>false)); ?></td>
	</tr>
	<tr bgcolor="#FFFFCC">
            <th scope="row" bgcolor="#FFFFCC"><?= __('sex') ?></th>
		<td bgcolor="#FFFFCC"><?= $this->Form->radio("sex", $options); ?></td>
	</tr>
	<tr bgcolor="#FFFFCC">
            <th scope="row"><?= __('birth') ?></th>
		<td><?= $this->Form->input("birth", array('type' => 'date', 'minYear' => date('Y') - 70, 'label'=>false)); ?></td>
	</tr>
	<tr bgcolor="#FFFFCC">
            <th scope="row" bgcolor="#FFFFCC"><?= __('mail') ?></th>
		<td bgcolor="#FFFFCC"><?= $this->Form->input("mail", array('type' => 'value', 'label'=>false)); ?></td>
	</tr>
	<tr bgcolor="#FFFFCC">
            <th scope="row"><?= __('tel') ?></th>
		<td><?= $this->Form->input("tel", array('type' => 'value', 'label'=>false)); ?></td>
	</tr>
	<tr bgcolor="#FFFFCC">
            <th scope="row" bgcolor="#FFFFCC"><?= __('address') ?></th>
		<td bgcolor="#FFFFCC"><?= $this->Form->input("address", array('type' => 'value', 'label'=>false)); ?></td>
	</tr>
	<tr bgcolor="#FFFFCC">
            <th scope="row"><?= __('date_start') ?></th>
		<td style="border-bottom: solid;border-width: 1px"><?= $this->Form->input("date_start", array('type' => 'date', 'label'=>false)); ?></td>
	</tr>
</table>

        <?php
            echo $this->Form->hidden('status');
            echo $this->Form->hidden('date_finish', ['label' => 'date_finish']);
            echo $this->Form->hidden('delete_flag');
            echo $this->Form->hidden('created_staff', ['empty' => true]);
            echo $this->Form->hidden('updated_staff');
        ?>
    </fieldset>
    <center><?= $this->Form->button(__('confirm'), array('name' => 'kakunin')) ?></center>
    <?= $this->Form->end() ?>
<br>
