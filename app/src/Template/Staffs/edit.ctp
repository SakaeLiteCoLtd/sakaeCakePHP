<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\Staff $staff
 */
?>
        <?php
            $options1 = [
	            '0' => '男性',
	            '1' => '女性'
                    ];
            $options2 = [
	            '0' => 'edit this data　',
	            '1' => 'delete this data' 
                    ];
        ?>
    <?= $this->Form->create($staff) ?>
    <fieldset>
 		<a align="center"><?= $this->Form->radio("delete_flag", $options2); ?></a>
<table align="center" border="2" bordercolor="#E6FFFF" cellpadding="0" cellspacing="0" style="border-bottom: solid;border-width: 1px">
        <tbody border="2" bordercolor="#E6FFFF" bgcolor="#FFFFCC">
            <th scope="row"><?= __('スタッフID') ?></th>
		<td><?= $this->Form->input("staff_code", array('type' => 'value', 'label'=>false)) ?></td>
	</tr>
        <tbody border="2" bordercolor="#E6FFFF" bgcolor="#FFFFCC">
            <th scope="row"><?= __('姓') ?></th>
		<td><?= $this->Form->input("f_name", array('type' => 'value', 'label'=>false)); ?></td>
	</tr>
        <tbody border="2" bordercolor="#E6FFFF" bgcolor="#FFFFCC">
            <th scope="row"><?= __('名') ?></th>
		<td><?= $this->Form->input("l_name", array('type' => 'value', 'label'=>false)); ?></td>
	</tr>
        <tbody border="2" bordercolor="#E6FFFF" bgcolor="#FFFFCC">
            <th scope="row"><?= __('性別') ?></th>
		<td><?= $this->Form->radio("sex", $options1); ?></td>
	</p>
        <tbody border="2" bordercolor="#E6FFFF" bgcolor="#FFFFCC">
            <th scope="row"><?= __('誕生日') ?></th>
		<td><?= $this->Form->input("birth", array('type' => 'date', 'minYear' => date('Y') - 70, 'label'=>false, 'empty'=>true)); ?></td>
	</tr>
        <tbody border="2" bordercolor="#E6FFFF" bgcolor="#FFFFCC">
            <th scope="row"><?= __('メール') ?></th>
		<td><?= $this->Form->input("mail", array('type' => 'value', 'label'=>false)); ?></td>
	</tr>
        <tbody border="2" bordercolor="#E6FFFF" bgcolor="#FFFFCC">
            <th scope="row"><?= __('電話番号') ?></th>
		<td><?= $this->Form->input("tel", array('type' => 'value', 'label'=>false)); ?></td>
	</tr>
        <tbody border="2" bordercolor="#E6FFFF" bgcolor="#FFFFCC">
            <th scope="row"><?= __('住所') ?></th>
		<td><?= $this->Form->input("address", array('type' => 'value', 'label'=>false)); ?></td>
	</tr>
        <tbody border="2" bordercolor="#E6FFFF" bgcolor="#FFFFCC">
            <th scope="row"><?= __('入社日') ?></th>
		<td><?= $this->Form->input("date_start", array('type' => 'date', 'minYear' => date('Y') - 70, 'label'=>false, 'empty'=>true)); ?></td>
	</tr>
        <tbody border="2" bordercolor="#E6FFFF" bgcolor="#FFFFCC">
            <th scope="row"><?= __('退社日') ?></th>
		<td><?= $this->Form->input("date_finish", array('type' => 'date', 'label'=>false, 'empty'=>true)); ?></td>
	</tr>
</table>
        <?php
            echo $this->Form->hidden('status');
//            echo $this->Form->hidden('delete_flag');
//            echo $this->Form->hidden('created_at') ;
            echo $this->Form->hidden('created_staff' ,['value'=>$staff->created_staff ]) ;
//            echo $this->Form->hidden('updated_at' ,['value'=>date('Y-m-d H:i:s')]) ;
//            echo $this->Form->hidden('updated_at', ['empty' => true]);
            echo $this->Form->hidden('updated_staff');
        ?>
    </fieldset>
    <center><?= $this->Form->button(__('OK'), array('name' => 'kakunin')) ?></center>
    <?= $this->Form->end() ?>
</div>
