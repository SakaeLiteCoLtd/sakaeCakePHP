<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\Staff $staff
 */
?>
<?= $this->Form->create($staff, ['url' => ['action' => 'do']]) ?>
        <?php
            $username = $this->request->getSession()->read('Auth.User.username');

            $birthY = $_POST['birth']['year'];
            $birthM = $_POST['birth']['month'];
            $birthD = $_POST['birth']['day'];
            $birthYMD = array($birthY,$birthM,$birthD);
            $birth = implode("-",$birthYMD);

            $date_startY = $_POST['date_start']['year'];
            $date_startM = $_POST['date_start']['month'];
            $date_startD = $_POST['date_start']['day'];
            $date_startYMD = array($date_startY,$date_startM,$date_startD);
            $date_start = implode("-",$date_startYMD);

            $date_finish = '';

            echo $this->Form->hidden('id' ,['value'=>$_POST['id'] ]) ;
            echo $this->Form->hidden('staff_code' ,['value'=>$_POST['staff_code'] ]) ;
            echo $this->Form->hidden('f_name' ,['value'=>$_POST['f_name'] ]) ;
            echo $this->Form->hidden('l_name' ,['value'=>$_POST['l_name'] ]) ;
            echo $this->Form->hidden('sex' ,['value'=>$_POST['sex'] ]) ;
            echo $this->Form->hidden('birth' ,['value'=>$birth ]) ;
            echo $this->Form->hidden('mail' ,['value'=>$_POST['mail'] ]) ;
            echo $this->Form->hidden('tel' ,['value'=>$_POST['tel'] ]) ;
            echo $this->Form->hidden('address' ,['value'=>$_POST['address'] ]) ;
            echo $this->Form->hidden('status' ,['value'=>$_POST['status'] ]) ;
            echo $this->Form->hidden('date_start' ,['value'=>$date_start ]) ;
            echo $this->Form->hidden('date_finish' ,['value'=>$date_finish ]) ;
            echo $this->Form->hidden('delete_flag' ,['value'=>$_POST['delete_flag'] ]) ;
            echo $this->Form->hidden('created_at' ,['value'=>$_POST['created_at'] ]) ;
            echo $this->Form->hidden('created_staff' ,['value'=>$_POST['created_staff'] ]) ;
            echo $this->Form->hidden('updated_at' ,['value'=>date('Y-m-d H:i:s')]) ;
            echo $this->Form->hidden('updated_staff' ,['value'=>$_POST['updated_staff'] ]) ;
        ?>

	<?php
	if($this->request->getData('sex') == 0){
	$sex = '男';
	} else {
	$sex = '女';
	}
	 ?>

<table border="1" bordercolor="#E6FFFF" style="width: 250px">
        <tr>
		<td bgcolor="#FFDEAD"><p>登録者</p></td>
		<td bgcolor="#FFDEAD"><p><?php echo $username; ?></p></td>
	</tr>
</table>
    <table align="center" border="2" bordercolor="#E6FFFF" cellpadding="0" cellspacing="0">
        <tbody border="2" bordercolor="#E6FFFF" bgcolor="#FFFFCC">
            <th scope="row"><?= __('スタッフID') ?></th>
            <td><?= h($this->request->getData('staff_code')) ?></td>
        </tr>
        <tbody border="2" bordercolor="#E6FFFF" bgcolor="#FFFFCC">
            <th scope="row"><?= __('姓') ?></th>
            <td><?= h($this->request->getData('f_name')) ?></td>
        </tr>
        <tbody border="2" bordercolor="#E6FFFF" bgcolor="#FFFFCC">
            <th scope="row"><?= __('名') ?></th>
            <td><?= h($this->request->getData('l_name')) ?></td>
        </tr>
        <tbody border="2" bordercolor="#E6FFFF" bgcolor="#FFFFCC">
            <th scope="row"><?= __('性別') ?></th>
            <td><?= h($sex) ?></td>
        </tr>
        <tbody border="2" bordercolor="#E6FFFF" bgcolor="#FFFFCC">
            <th scope="row"><?= __('誕生日') ?></th>
            <td><?= h($birth) ?></td>
        </tr>
        <tbody border="2" bordercolor="#E6FFFF" bgcolor="#FFFFCC">
            <th scope="row"><?= __('メール') ?></th>
            <td><?= h($this->request->getData('mail')) ?></td>
        </tr>
        <tbody border="2" bordercolor="#E6FFFF" bgcolor="#FFFFCC">
            <th scope="row"><?= __('電話番号') ?></th>
            <td><?= h($this->request->getData('tel')) ?></td>
        </tr>
        <tbody border="2" bordercolor="#E6FFFF" bgcolor="#FFFFCC">
            <th scope="row"><?= __('入社日') ?></th>
            <td><?= h($date_start) ?></td>
        </tr>
    </table>
<br>
        <p align="center"><?= $this->Form->button('戻る', ['onclick' => 'history.back()', 'type' => 'button']) ?>
        <?= $this->Form->button(__('登録'), array('name' => 'touroku')) ?></p>
        <?= $this->Form->end() ?>
