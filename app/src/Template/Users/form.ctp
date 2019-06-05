<?php
/**
 * AuthHelper: Authの変数にアクセスできる
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\User $user
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

    <?= $this->Form->create($user, ['url' => ['action' => 'confirm']]) ?>
    <fieldset>
<table align="center" border="2" bordercolor="#E6FFFF" cellpadding="0" cellspacing="0" style="border-bottom: solid;border-width: 1px">
        <tbody border="2" bordercolor="#E6FFFF" bgcolor="#FFFFCC">
            <th scope="row"><?= __('username') ?></th>
		<td><?= $this->Form->input("username", array('type' => 'value', 'pattern' => '^[0-9A-Za-z]+$', 'label'=>false)) ?></td>
	</tr>
        <tbody border="2" bordercolor="#E6FFFF" bgcolor="#FFFFCC">
            <th scope="row"><?= __('password') ?></th>
		<td><?= $this->Form->input("password", array('type' => 'password', 'label'=>false)); ?></td>
	</tr>
        <tbody border="2" bordercolor="#E6FFFF" bgcolor="#FFFFCC">
            <th scope="row"><?= __('role') ?></th>
		<td><?= $this->Form->input("role_id", ["type"=>"select","empty"=>"Please select", "options"=>$arrRole, 'label'=>false]); ?></td>
	</tr>
        <tbody border="2" bordercolor="#E6FFFF" bgcolor="#FFFFCC">
            <th scope="row"><?= __('staff') ?></th>
		<td><?= $this->Form->input("staff_id", ["type"=>"select","empty"=>"Please select", "options"=>$arrStaff, 'label'=>false]); ?></td>
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
