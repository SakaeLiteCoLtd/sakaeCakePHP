<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\User $user
 */
?>
        <?php
            $role_id = $user->role_id;
            $options = [
	            '1' => 'edit this data　',
	            '0' => 'delete this data'
                    ];
        ?>

    <?= $this->Form->create($user) ?>
    <?= $this->Form->create($user, ['url' => ['action' => 'confirm']]) ?>

    <fieldset>
      <form method="post" action="confirm" enctype="multipart/form-data">

 		<a align="center"><?= $this->Form->radio("delete_flag", $options); ?></a>

<table align="center" border="2" bordercolor="#E6FFFF" cellpadding="0" cellspacing="0" style="border-bottom: solid;border-width: 1px">
        <tbody border="2" bordercolor="#E6FFFF" bgcolor="#FFFFCC">
            <th scope="row"><?= __('ユーザーID') ?></th>
		<td><?= $this->Form->input("username", array('type' => 'value', 'pattern' => '^[0-9A-Za-z]+$', 'label'=>false)) ?></td>
	</tr>
        <tbody border="2" bordercolor="#E6FFFF" bgcolor="#FFFFCC">
            <th scope="row"><?= __('パスワード') ?></th>
		<td><?= $this->Form->input("password", array('type' => '', 'label'=>false, 'autocomplete' => 'off')); ?></td>
	</tr>
        <tbody border="2" bordercolor="#E6FFFF" bgcolor="#FFFFCC">
            <th scope="row"><?= __('ロールID') ?></th>
		<td><?= $this->Form->input("role_id", ["type"=>"select","empty"=>"選択してください", "options"=>$arrRole, 'label'=>false]); ?></td>
	</tr>
</table>

        <?php
        echo $this->Form->hidden('id' ,['value'=>$user->id ]) ;
        echo $this->Form->hidden('staff_id' ,['value'=>$user->staff_id ]) ;
//            echo $this->Form->hidden('delete_flag');
//            echo $this->Form->hidden('created_at') ;
            echo $this->Form->hidden('created_staff' ,['value'=>$user->created_staff ]) ;
//            echo $this->Form->hidden('updated_at', ['empty' => true]);
            echo $this->Form->hidden('updated_staff');
        ?>
    </fieldset>
    <table align="center" border="2" bordercolor="#E6FFFF" cellpadding="0" cellspacing="0">
    <tr>
      <td style="border-style: none;"><div align="center"><?= $this->Form->submit(__('確認'), array('name' => 'kakunin')); ?></div></td>
    </tr>
  </table>
    <?= $this->Form->end() ?>
</div>
</form>
