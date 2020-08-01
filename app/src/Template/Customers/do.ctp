<?php
$this->layout = 'defaultshinki';
?>
<?php
/**
 * AuthHelper: Authの変数にアクセスできる
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\Customer $customer
 */
 use App\myClass\Shinkimenus\htmlShinkimenu;//myClassフォルダに配置したクラスを使用

 $htmlShinkimenu = new htmlShinkimenu();
 $htmlShinkis = $htmlShinkimenu->Shinkimenus();
 $htmlcustomers = $htmlShinkimenu->customermenus();
?>
<?= $this->Form->create($customer, ['url' => ['action' => 'form']]) ?>

<?php
            $session = $this->request->getSession();
            $customer_code = $session->read('customerdata.customer_code');
            $name = $session->read('customerdata.name');
            $address = $session->read('customerdata.address');
            $tel = $session->read('customerdata.tel');
            $fax = $session->read('customerdata.fax');
?>
<hr size="5" style="margin: 0.5rem">
<table style="margin-bottom:0px" width="750" border="0" align="center" cellpadding="0" cellspacing="0" bordercolor="#CCCCCC">
  <?php
       echo $htmlShinkis;
  ?>
</table>
<hr size="5" style="margin: 0.5rem">
<table style="margin-bottom:0px" width="750" border="0" align="center" cellpadding="0" cellspacing="0" bordercolor="#CCCCCC">
  <?php
       echo $htmlcustomers;
  ?>
</table>
<hr size="5" style="margin: 0.5rem">
<br>

<legend align="center"><strong style="font-size: 14pt; color:blue"><?= __("顧客登録") ?></strong></legend>
<br>

<legend align="center"><font color="red"><?= __($mes) ?></font></legend>
<table align="center" border="2" bordercolor="#E6FFFF" cellpadding="0" cellspacing="0" style="border-bottom: solid;border-width: 1px">
        <tbody border="2" bordercolor="#E6FFFF" bgcolor="#FFFFCC">
          <td><div align="center"><strong style="font-size: 12pt; color:blue">顧客コード</strong></div></td>
          <td style="border-left-style: none;"><div align="center"><strong style="font-size: 12pt; color:blue">顧客名</strong></div></td>
        <tbody border="2" bordercolor="#E6FFFF" bgcolor="#FFFFCC">
          <td bgcolor="#FFFFCC" style="padding: 0.2rem"><?= h($customer_code) ?></td>
          <td bgcolor="#FFFFCC" style="border-left-style: none;padding: 0.2rem"><?= h($name) ?></td>
        <tbody border="2" bordercolor="#E6FFFF" bgcolor="#FFFFCC">
          <td colspan="2" style="padding: 0.2rem"><div align="center"><strong style="font-size: 12pt; color:blue">住所</strong></div></td>
        <tbody border="2" bordercolor="#E6FFFF" bgcolor="#FFFFCC">
          <td colspan="2" bgcolor="#FFFFCC" style="padding: 0.2rem"><?= h($address) ?></td>
        <tbody border="2" bordercolor="#E6FFFF" bgcolor="#FFFFCC">
          <td><div align="center"><strong style="font-size: 12pt; color:blue">電話番号</strong></div></td>
          <td style="border-left-style: none;"><div align="center"><strong style="font-size: 12pt; color:blue">FAX</strong></div></td>
        <tbody border="2" bordercolor="#E6FFFF" bgcolor="#FFFFCC">
          <td bgcolor="#FFFFCC" style="padding: 0.2rem"><?= h($tel) ?></td>
          <td bgcolor="#FFFFCC" style="border-left-style: none;padding: 0.2rem"><?= h($fax) ?></td>
</table>
<br>
<br>
