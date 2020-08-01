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

        <legend align="center"><strong style="font-size: 14pt; color:blue"><?= __("顧客登録") ?></strong></legend>

    <?= $this->Form->create($customer, ['url' => ['action' => 'do']]) ?>

    <?php
        $username = $this->request->Session()->read('Auth.User.username');

        $session = $this->request->getSession();

        $data = $session->read();

        $session->write('customerdata.customer_code', $_POST['customer_code']);
        $session->write('customerdata.name', $_POST['name']);
        $session->write('customerdata.address', $_POST['address']);
        $session->write('customerdata.tel', $_POST['tel']);
        $session->write('customerdata.fax', $_POST['fax']);
        $session->write('customerdata.status', 0);
        $session->write('customerdata.delete_flag', 0);
        $session->write('customerdata.created_staff', $data['login']['staff_id']);

        $data = $session->read();
        /*
        echo "<pre>";
        print_r($data);
        echo "</pre>";
*/
    ?>

    <fieldset>
      <table align="center" border="2" bordercolor="#E6FFFF" cellpadding="0" cellspacing="0" style="border-bottom: solid;border-width: 1px">
              <tbody border="2" bordercolor="#E6FFFF" bgcolor="#FFFFCC">
                <td><div align="center"><strong style="font-size: 12pt; color:blue">顧客コード</strong></div></td>
                <td style="border-left-style: none;"><div align="center"><strong style="font-size: 12pt; color:blue">顧客名</strong></div></td>
              <tbody border="2" bordercolor="#E6FFFF" bgcolor="#FFFFCC">
                <td bgcolor="#FFFFCC" style="padding: 0.2rem"><?= h($this->request->getData('customer_code')) ?></td>
                <td bgcolor="#FFFFCC" style="border-left-style: none;padding: 0.2rem"><?= h($this->request->getData('name')) ?></td>
              <tbody border="2" bordercolor="#E6FFFF" bgcolor="#FFFFCC">
                <td colspan="2" style="padding: 0.2rem"><div align="center"><strong style="font-size: 12pt; color:blue">住所</strong></div></td>
              <tbody border="2" bordercolor="#E6FFFF" bgcolor="#FFFFCC">
                <td colspan="2" bgcolor="#FFFFCC" style="padding: 0.2rem"><?= h($this->request->getData('address')) ?></td>
              <tbody border="2" bordercolor="#E6FFFF" bgcolor="#FFFFCC">
                <td><div align="center"><strong style="font-size: 12pt; color:blue">電話番号</strong></div></td>
                <td style="border-left-style: none;"><div align="center"><strong style="font-size: 12pt; color:blue">FAX</strong></div></td>
              <tbody border="2" bordercolor="#E6FFFF" bgcolor="#FFFFCC">
                <td bgcolor="#FFFFCC" style="padding: 0.2rem"><?= h($this->request->getData('tel')) ?></td>
                <td bgcolor="#FFFFCC" style="border-left-style: none;padding: 0.2rem"><?= h($this->request->getData('fax')) ?></td>
              <tbody border="2" bordercolor="#E6FFFF" bgcolor="#FFFFCC">
                <td><div align="center"><strong style="font-size: 12pt; color:blue">納入先ID</strong></div></td>
                <td style="border-left-style: none;"><div align="center"><strong style="font-size: 12pt; color:blue">ハンディ表示名</strong></div></td>
              <tbody border="2" bordercolor="#E6FFFF" bgcolor="#FFFFCC">
                <td bgcolor="#FFFFCC" style="padding: 0.2rem"><?= h($this->request->getData('place_deliver_code')) ?></td>
                <td bgcolor="#FFFFCC" style="border-left-style: none;padding: 0.2rem"><?= h($this->request->getData('name_handy')) ?></td>
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
      <td style="border-style: none;"><div align="center"><?= $this->Form->submit(__('登録'), array('name' => 'kakunin')); ?></div></td>
    </tr>
  </table>
<br>
