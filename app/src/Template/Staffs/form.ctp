<?php
/**
 * AuthHelper: Authの変数にアクセスできる
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\Staff $staff
 */
 use App\myClass\Shinkimenus\htmlShinkimenu;//myClassフォルダに配置したクラスを使用

 $htmlShinkimenu = new htmlShinkimenu();
 $htmlShinkis = $htmlShinkimenu->Shinkimenus();
 ?>
        <?php
            $username = $this->request->Session()->read('Auth.User.username');
            $options = [
	            '0' => '男',
	            '1' => '女'
                    ];
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

    <?= $this->Form->create($staff, ['url' => ['action' => 'confirm']]) ?>
    <fieldset>
<table bgcolor="#FFFFCC" align="center" border="2" bordercolor="#E6FFFF" cellpadding="0" cellspacing="0">
	<tr bgcolor="#FFFFCC">
            <th bgcolor="#FFFFCC" scope="row"><?= __('スタッフＩＤ') ?></th>
		<td bgcolor="#FFFFCC"><?= $this->Form->input("staff_code", array('type' => 'value', 'label'=>false)) ?></td>
	</tr>
	<tr bgcolor="#FFFFCC">
            <th bgcolor="#FFFFCC" scope="row"><?= __('姓') ?></th>
		<td bgcolor="#FFFFCC"><?= $this->Form->input("f_name", array('type' => 'value', 'label'=>false)); ?></td>
	</tr>
	<tr bgcolor="#FFFFCC">
            <th scope="row"><?= __('名') ?></th>
		<td><?= $this->Form->input("l_name", array('type' => 'value', 'label'=>false)); ?></td>
	</tr>
	<tr bgcolor="#FFFFCC">
            <th scope="row" bgcolor="#FFFFCC"><?= __('性別') ?></th>
		<td bgcolor="#FFFFCC"><?= $this->Form->radio("sex", $options); ?></td>
	</tr>
	<tr bgcolor="#FFFFCC">
            <th scope="row"><?= __('誕生日') ?></th>
		<td><?= $this->Form->input("birth", array('type' => 'date', 'monthNames' => false, 'minYear' => date('Y') - 70, 'label'=>false)); ?></td>
	</tr>
	<tr bgcolor="#FFFFCC">
            <th scope="row" bgcolor="#FFFFCC"><?= __('メール') ?></th>
		<td bgcolor="#FFFFCC"><?= $this->Form->input("mail", array('type' => 'value', 'label'=>false)); ?></td>
	</tr>
	<tr bgcolor="#FFFFCC">
            <th scope="row"><?= __('電話番号') ?></th>
		<td><?= $this->Form->input("tel", array('type' => 'value', 'label'=>false)); ?></td>
	</tr>
	<tr bgcolor="#FFFFCC">
            <th scope="row" bgcolor="#FFFFCC"><?= __('住所') ?></th>
		<td bgcolor="#FFFFCC"><?= $this->Form->input("address", array('type' => 'value', 'label'=>false)); ?></td>
	</tr>
	<tr bgcolor="#FFFFCC">
            <th scope="row"><?= __('入社日') ?></th>
		<td style="border-bottom: solid;border-width: 1px"><?= $this->Form->input("date_start", array('type' => 'date', 'monthNames' => false, 'label'=>false)); ?></td>
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
    <table align="center" border="2" bordercolor="#E6FFFF" cellpadding="0" cellspacing="0">
    <tr>
      <td style="border-style: none;"><div align="center"><?= $this->Form->submit(__('確認'), array('name' => 'kakunin')); ?></div></td>
    </tr>
  </table>
<br>
