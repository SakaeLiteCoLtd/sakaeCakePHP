<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\Customer $customer
 */
use App\myClass\Shinkimenus\htmlShinkimenu;//myClassフォルダに配置したクラスを使用
?>
<?= $this->Form->create($customer, ['url' => ['action' => 'deliverpreadd']]) ?>
        <?php
        $username = $this->request->Session()->read('Auth.User.username');

        $htmlShinkimenu = new htmlShinkimenu();
        $htmlShinkis = $htmlShinkimenu->Shinkimenus();
        $htmlcustomers = $htmlShinkimenu->customermenus();

        $username = $this->request->Session()->read('Auth.User.username');

        $htmlShinkimenu = new htmlShinkimenu();
        $htmlShinkis = $htmlShinkimenu->Shinkimenus();

        $session = $this->request->getSession();
//        $session->write('placedata.customer', $_POST['customer']);
        $session->write('placedata.id_from_order', $_POST['id_from_order']);
        $session->write('placedata.name', $_POST['name']);
        $session->write('placedata.cs_code', $cs_code);
        $session->write('placedata.delete_flag', $_POST['delete_flag']);
        $session->write('placedata.created_staff', $_POST['created_staff']);
        $session->write('placedata.created_at', date('Y-m-d H:i:s'));
        $session->write('placedata.updated_staff', null);
/*
        $data = $session->read();
        echo "<pre>";
        print_r($data);
        echo "</pre>";
*/
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

        <legend align="center"><strong style="font-size: 14pt; color:blue"><?= __("納入先登録") ?></strong></legend>
        <br>

<table align="center" border="2" bordercolor="#E6FFFF" cellpadding="0" cellspacing="0" style="border-bottom: solid;border-width: 1px">
        <tbody border="2" bordercolor="#E6FFFF" bgcolor="#FFFFCC">
          <td colspan="2"><div align="center"><strong style="font-size: 12pt; color:blue">顧客コード</strong></div></td>
        <tbody border="2" bordercolor="#E6FFFF" bgcolor="#FFFFCC">
          <td colspan="2" bgcolor="#FFFFCC"><?= h($Customer) ?></td>
        <tbody border="2" bordercolor="#E6FFFF" bgcolor="#FFFFCC">
          <td><div align="center"><strong style="font-size: 12pt; color:blue">納入先ID</strong></div></td>
          <td style="border-left-style: none;"><div align="center"><strong style="font-size: 12pt; color:blue">ハンディ表示名</strong></div></td>
        <tbody border="2" bordercolor="#E6FFFF" bgcolor="#FFFFCC">
          <td><?= h($this->request->getData('id_from_order')) ?></td>
          <td style="border-left-style: none;"><?= h($this->request->getData('name')) ?></td>
</table>

<br>
<table align="center" border="2" bordercolor="#E6FFFF" cellpadding="0" cellspacing="0">
<tr>
  <td style="border-style: none;"><div align="center"><?= $this->Form->submit('戻る', ['onclick' => 'history.back()', 'type' => 'button']); ?></div></td>
  <td style="border-style: none;"><div align="center"><?= $this->Form->submit('追加', array('name' => 'kakunin')); ?></div></td>
</tr>
</table>
<br>
<?= $this->Form->end() ?>
