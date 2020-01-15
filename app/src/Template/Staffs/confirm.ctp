<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\Staff $staff
 */
 use App\myClass\Shinkimenus\htmlShinkimenu;//myClassフォルダに配置したクラスを使用

 $htmlShinkimenu = new htmlShinkimenu();
 $htmlShinkis = $htmlShinkimenu->Shinkimenus();
 ?>
<?= $this->Form->create($staff, ['url' => ['action' => 'preadd']]) ?>
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
/*
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
*/
            $session = $this->request->getSession();
            $session->write('staffdata.staff_code', $_POST['staff_code']);
            $session->write('staffdata.f_name', $_POST['f_name']);
            $session->write('staffdata.l_name', $_POST['l_name']);
            $session->write('staffdata.sex', $_POST['sex']);
            $session->write('staffdata.birth', $birth);
            $session->write('staffdata.mail', $_POST['mail']);
            $session->write('staffdata.tel', $_POST['tel']);
            $session->write('staffdata.address', $_POST['address']);
            $session->write('staffdata.status', $_POST['status']);
            $session->write('staffdata.date_start', $date_start);
            $session->write('staffdata.delete_flag', $_POST['delete_flag']);
            $session->write('staffdata.created_staff', $_POST['created_staff']);
            $session->write('staffdata.updated_staff', null);
            ?>

	<?php
	if($this->request->getData('sex') == 0){
	$sex = '男';
	} else {
	$sex = '女';
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
   <hr size="5">
   <table style="margin-bottom:0px" width="750" border="0" align="center" cellpadding="0" cellspacing="0" bordercolor="#CCCCCC">
   <?php
      echo $htmlShinkis;
   ?>
   </table>
   <hr size="5">
              <p align="center"><?php echo $this->Html->image('ShinkiTourokuMenu/touroku.gif',array('width'=>'157','height'=>'50'));?></p>

<hr size="5">

    <table align="center" border="2" bordercolor="#E6FFFF" cellpadding="0" cellspacing="0" style="border-bottom: solid;border-width: 1px">
        <tbody border="2" bordercolor="#E6FFFF" bgcolor="#FFFFCC">
            <th scope="row"><?= __('スタッフＩＤ') ?></th>
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
<br>
<table align="center" border="2" bordercolor="#E6FFFF" cellpadding="0" cellspacing="0">
<tr>
  <td style="border-style: none;"><div align="center"><?= $this->Form->submit('戻る', ['onclick' => 'history.back()', 'type' => 'button']); ?></div></td>
  <td style="border-style: none;"><div align="center"><?= $this->Form->submit('追加', array('name' => 'kakunin')); ?></div></td>
</tr>
</table>
<br>
<?= $this->Form->end() ?>
