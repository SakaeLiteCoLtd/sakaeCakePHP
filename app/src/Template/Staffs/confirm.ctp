<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\Staff $staff
 */
?>
<?= $this->Form->create($staff, ['url' => ['action' => 'do']]) ?>
        <?php
            $username = $this->request->Session()->read('Auth.User.username');

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
            echo $this->Form->hidden('delete_flag' ,['value'=>$_POST['delete_flag'] ]) ;
            echo $this->Form->hidden('created_staff' ,['value'=>$_POST['created_staff'] ]) ;
            echo $this->Form->hidden('updated_staff' ,['value'=>null ]) ;
        ?>

	<?php
	if($this->request->getData('sex') == 0){
	$sex = 'M';
	} else {
	$sex = 'F';
	}

	if($_POST['date_finish'] == null){
	$date_finish = '';
	echo $this->Form->hidden('date_finish' ,['value'=>$date_finish ]) ;
	} else {
	$date_finishY = $_POST['date_finish']['year'];
	$date_finishM = $_POST['date_finish']['month'];
	$date_finishD = $_POST['date_finish']['day'];
	$date_finishYMD = array($date_finishY,$date_finishM,$date_finishD);
	$date_finish = implode("-",$date_finishYMD);
	echo $this->Form->hidden('date_finish' ,['value'=>$date_finish ]) ;
	}

	 ?>
              <p align="center"><?php echo $this->Html->image('ShinkiTourokuMenu/touroku.gif',array('width'=>'157','height'=>'50'));?></p>

<hr size="5">

    <table align="center" border="2" bordercolor="#E6FFFF" cellpadding="0" cellspacing="0" style="border-bottom: solid;border-width: 1px">
        <tbody border="2" bordercolor="#E6FFFF" bgcolor="#FFFFCC">
            <th scope="row"><?= __('staff_code') ?></th>
            <td><?= h($this->request->getData('staff_code')) ?></td>
        </tr>
        <tbody border="2" bordercolor="#E6FFFF" bgcolor="#FFFFCC">
            <th scope="row"><?= __('f_name') ?></th>
            <td><?= h($this->request->getData('f_name')) ?></td>
        </tr>
        <tbody border="2" bordercolor="#E6FFFF" bgcolor="#FFFFCC">
            <th scope="row"><?= __('l_name') ?></th>
            <td><?= h($this->request->getData('l_name')) ?></td>
        </tr>
        <tbody border="2" bordercolor="#E6FFFF" bgcolor="#FFFFCC">
            <th scope="row"><?= __('sex') ?></th>
            <td><?= h($sex) ?></td>
        </tr>
        <tbody border="2" bordercolor="#E6FFFF" bgcolor="#FFFFCC">
            <th scope="row"><?= __('birth') ?></th>
            <td><?= h($birth) ?></td>
        </tr>
        <tbody border="2" bordercolor="#E6FFFF" bgcolor="#FFFFCC">
            <th scope="row"><?= __('mail') ?></th>
            <td><?= h($this->request->getData('mail')) ?></td>
        </tr>
        <tbody border="2" bordercolor="#E6FFFF" bgcolor="#FFFFCC">
            <th scope="row"><?= __('tel') ?></th>
            <td><?= h($this->request->getData('tel')) ?></td>
        </tr>
        <tbody border="2" bordercolor="#E6FFFF" bgcolor="#FFFFCC">
            <th scope="row"><?= __('date_start') ?></th>
            <td><?= h($date_start) ?></td>
        </tr>
    </table>
<br>
<br>
        <p align="center"><?= $this->Form->button('back', ['onclick' => 'history.back()', 'type' => 'button']) ?>
        <?= $this->Form->button(__('add'), array('name' => 'touroku')) ?></p>
        <?= $this->Form->end() ?>
