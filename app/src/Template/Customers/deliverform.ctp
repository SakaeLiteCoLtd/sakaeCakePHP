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
            $htmlcustomers = $htmlShinkimenu->customermenus();
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

    <?= $this->Form->create($customer, ['url' => ['action' => 'deliverconfirm']]) ?>
    <fieldset>
      <table align="center" border="2" bordercolor="#E6FFFF" cellpadding="0" cellspacing="0" style="border-bottom: solid;border-width: 1px">
              <tbody border="2" bordercolor="#E6FFFF" bgcolor="#FFFFCC">
                <td colspan="2"><div align="center"><strong style="font-size: 12pt; color:blue">顧客コード</strong></div></td>
              <tbody border="2" bordercolor="#E6FFFF" bgcolor="#FFFFCC">
                <td colspan="2" bgcolor="#FFFFCC"><?= $this->Form->input("customer", ["type"=>"select","empty"=>"選択してください", "options"=>$arrCustomer, 'label'=>false]) ?></td>
              <tbody border="2" bordercolor="#E6FFFF" bgcolor="#FFFFCC">
                <td><div align="center"><strong style="font-size: 12pt; color:blue">納入先ID</strong></div></td>
                <td style="border-left-style: none;"><div align="center"><strong style="font-size: 12pt; color:blue">ハンディ表示名</strong></div></td>
              <tbody border="2" bordercolor="#E6FFFF" bgcolor="#FFFFCC">
                <td><?= $this->Form->input("id_from_order", array('type' => 'value', 'label'=>false)); ?></td>
                <td style="border-left-style: none;"><?= $this->Form->input("name", array('type' => 'value', 'label'=>false)); ?></td>
      </table>

        <?php
            echo $this->Form->hidden('delete_flag');
            echo $this->Form->hidden('created_staff', ['empty' => true]);
            echo $this->Form->hidden('updated_staff');
        ?>
    </fieldset>

    <legend align="center"><font color="red"><?= __("※住所、電話番号、FAXは空のままでも登録できます。") ?></font></legend>
    <br>

    <table align="center" border="2" bordercolor="#E6FFFF" cellpadding="0" cellspacing="0">
    <tr>
      <td style="border-style: none;"><div align="center"><?= $this->Form->submit(__('確認'), array('name' => 'kakunin')); ?></div></td>
    </tr>
  </table>
<br>
