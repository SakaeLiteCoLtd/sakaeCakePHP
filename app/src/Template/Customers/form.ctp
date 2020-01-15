<?php
/**
 * AuthHelper: Authの変数にアクセスできる
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\Customer $customer
 */
use App\myClass\Shinkimenus\htmlShinkimenu;//myClassフォルダに配置したクラスを使用
?>
        <?php
            $username = $this->request->Session()->read('Auth.User.username');

            $htmlShinkimenu = new htmlShinkimenu();
            $htmlShinkis = $htmlShinkimenu->Shinkimenus();
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

    <?= $this->Form->create($customer, ['url' => ['action' => 'confirm']]) ?>
    <fieldset>
      <table align="center" border="2" bordercolor="#E6FFFF" cellpadding="0" cellspacing="0" style="border-bottom: solid;border-width: 1px">
              <tbody border="2" bordercolor="#E6FFFF" bgcolor="#FFFFCC">
                <td><div align="center"><strong style="font-size: 12pt; color:blue">顧客コード</strong></div></td>
                <td style="border-left-style: none;"><div align="center"><strong style="font-size: 12pt; color:blue">社名</strong></div></td>
              <tbody border="2" bordercolor="#E6FFFF" bgcolor="#FFFFCC">
                <td><?= $this->Form->input("customer_code", array('type' => 'value', 'label'=>false)); ?></td>
            		<td style="border-left-style: none;"><?= $this->Form->input("name", array('type' => 'value', 'label'=>false)); ?></td>
              <tbody border="2" bordercolor="#E6FFFF" bgcolor="#FFFFCC">
                <td colspan="2"><div align="center"><strong style="font-size: 12pt; color:blue">住所</strong></div></td>
              <tbody border="2" bordercolor="#E6FFFF" bgcolor="#FFFFCC">
                <td colspan="2"><?= $this->Form->input("address", array('type' => 'value', 'label'=>false, 'size' => '50')); ?></td>
              <tbody border="2" bordercolor="#E6FFFF" bgcolor="#FFFFCC">
                <td><div align="center"><strong style="font-size: 12pt; color:blue">電話番号</strong></div></td>
                <td style="border-left-style: none;"><div align="center"><strong style="font-size: 12pt; color:blue">FAX</strong></div></td>
              <tbody border="2" bordercolor="#E6FFFF" bgcolor="#FFFFCC">
                <td><?= $this->Form->input("tel", array('type' => 'value', 'label'=>false)); ?></td>
      		      <td style="border-left-style: none;"><?= $this->Form->input("fax", array('type' => 'value', 'label'=>false)); ?></td>
              <tbody border="2" bordercolor="#E6FFFF" bgcolor="#FFFFCC">
                <td><div align="center"><strong style="font-size: 12pt; color:blue">ZIP</strong></div></td>
                <td style="border-left-style: none;"><div align="center"><strong style="font-size: 12pt; color:blue">Status</strong></div></td>
              <tbody border="2" bordercolor="#E6FFFF" bgcolor="#FFFFCC">
                <td><?= $this->Form->input("zip", array('type' => 'value', 'label'=>false)); ?></td>
                <td style="border-left-style: none;"><?= $this->Form->input("status", array('type' => 'value', 'label'=>false)); ?></td>
      </table>

        <?php
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
