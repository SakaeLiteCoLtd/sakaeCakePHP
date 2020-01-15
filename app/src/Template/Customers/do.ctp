<?php
/**
 * AuthHelper: Authの変数にアクセスできる
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\Customer $customer
 */
 use App\myClass\Shinkimenus\htmlShinkimenu;//myClassフォルダに配置したクラスを使用

 $htmlShinkimenu = new htmlShinkimenu();
 $htmlShinkis = $htmlShinkimenu->Shinkimenus();
?>
<?= $this->Form->create($customer, ['url' => ['action' => 'index']]) ?>

<?php
            $username = $this->request->Session()->read('Auth.User.username');
            $session = $this->request->getSession();
            $customer_code = $session->read('customerdata.customer_code');
            $name = $session->read('customerdata.name');
            $zip = $session->read('customerdata.zip');
            $address = $session->read('customerdata.address');
            $tel = $session->read('customerdata.tel');
            $fax = $session->read('customerdata.fax');
            $status = $session->read('customerdata.status');
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

<legend align="center"><font color="red"><?= __($mes) ?></font></legend>
<table align="center" border="2" bordercolor="#E6FFFF" cellpadding="0" cellspacing="0" style="border-bottom: solid;border-width: 1px">
        <tbody border="2" bordercolor="#E6FFFF" bgcolor="#FFFFCC">
          <td><div align="center"><strong style="font-size: 12pt; color:blue">顧客コード</strong></div></td>
          <td style="border-left-style: none;"><div align="center"><strong style="font-size: 12pt; color:blue">社名</strong></div></td>
        <tbody border="2" bordercolor="#E6FFFF" bgcolor="#FFFFCC">
          <td><?= h($customer_code) ?></td>
          <td style="border-left-style: none;"><?= h($name) ?></td>
        <tbody border="2" bordercolor="#E6FFFF" bgcolor="#FFFFCC">
          <td colspan="2"><div align="center"><strong style="font-size: 12pt; color:blue">住所</strong></div></td>
        <tbody border="2" bordercolor="#E6FFFF" bgcolor="#FFFFCC">
          <td colspan="2"><?= h($address) ?></td>
        <tbody border="2" bordercolor="#E6FFFF" bgcolor="#FFFFCC">
          <td><div align="center"><strong style="font-size: 12pt; color:blue">電話番号</strong></div></td>
          <td style="border-left-style: none;"><div align="center"><strong style="font-size: 12pt; color:blue">FAX</strong></div></td>
        <tbody border="2" bordercolor="#E6FFFF" bgcolor="#FFFFCC">
          <td><?= h($tel) ?></td>
          <td style="border-left-style: none;"><?= h($fax) ?></td>
        <tbody border="2" bordercolor="#E6FFFF" bgcolor="#FFFFCC">
          <td><div align="center"><strong style="font-size: 12pt; color:blue">ZIP</strong></div></td>
          <td style="border-left-style: none;"><div align="center"><strong style="font-size: 12pt; color:blue">Status</strong></div></td>
        <tbody border="2" bordercolor="#E6FFFF" bgcolor="#FFFFCC">
          <td><?= h($zip) ?></td>
          <td style="border-left-style: none;"><?= h($status) ?></td>
          <tbody border="2" bordercolor="#E6FFFF" bgcolor="#FFFFCC">
            <td><div align="center"><strong style="font-size: 12pt; color:blue">登録日時</strong></div></td>
            <td style="border-left-style: none;"><div align="center"><strong style="font-size: 12pt; color:blue">登録者</strong></div></td>
          <tbody border="2" bordercolor="#E6FFFF" bgcolor="#FFFFCC">
            <td><?= h($customer->created_at) ?></td>
  		      <td style="border-left-style: none;"><?= h($CreatedStaff) ?></td>
    </table>
<br>
<table align="center" border="2" bordercolor="#E6FFFF" cellpadding="0" cellspacing="0">
<tr>
  <td style="border-style: none;"><div align="center"><?= $this->Form->submit(__('トップ'), array('name' => 'top')); ?></div></td>
</tr>
</table>
<br>
