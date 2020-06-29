<?php
/**
 * AuthHelper: Authの変数にアクセスできる
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\Customer $customer
 */
use App\myClass\Shinkimenus\htmlShinkimenu;//myClassフォルダに配置したクラスを使用
use Cake\ORM\TableRegistry;//独立したテーブルを扱う
?>
        <?php
            $username = $this->request->Session()->read('Auth.User.username');

            $htmlShinkimenu = new htmlShinkimenu();
            $htmlShinkis = $htmlShinkimenu->Shinkimenus();
            $htmlcustomers = $htmlShinkimenu->customermenus();

            $this->Customers = TableRegistry::get('customers');
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

        <legend align="center"><strong style="font-size: 14pt; color:blue"><?= __("納入先呼出") ?></strong></legend>
        <br>

<?=$this->Form->create($PlaceDeliver, ['url' => ['action' => 'kensakuview']]) ?>

<table align="center" border="2" bordercolor="#E6FFFF" cellpadding="0" cellspacing="0">
  <tbody border="2" bordercolor="#E6FFFF" bgcolor="#FFFFCC" style="border-bottom: solid;border-width: 1px">
        <thead>
            <tr border="2" bordercolor="#E6FFFF" bgcolor="#FFFFCC">
              <td width="150" height="30" colspan="20" nowrap="nowrap"><div align="center"><strong style="font-size: 10pt; color:blue">顧客コード</strong></div></td>
              <td width="100" height="30" colspan="20" nowrap="nowrap"><div align="center"><strong style="font-size: 10pt; color:blue">顧客</strong></div></td>
              <td width="200" height="30" colspan="20" nowrap="nowrap"><div align="center"><strong style="font-size: 10pt; color:blue">納入先ID</strong></div></td>
              <td width="200" height="30" colspan="20" nowrap="nowrap"><div align="center"><strong style="font-size: 10pt; color:blue">ハンディ表示</strong></div></td>
            </tr>
        </thead>
        <tbody border="2" bordercolor="#E6FFFF" bgcolor="#FFFFCC">
          <?php foreach ($PlaceDelivers as $PlaceDelivers): ?>

            <?php
            $CustomersData = $this->Customers->find()->where(['customer_code' => $PlaceDelivers->cs_code])->toArray();
            if(isset($CustomersData[0])){
              $Customername = $CustomersData[0]->name;
            }else{
              $Customername = "";
            }

            ?>

          <tr style="border-bottom: solid;border-width: 1px">
            <td colspan="20" nowrap="nowrap"><?= h($PlaceDelivers->cs_code) ?></td>
            <td colspan="20" nowrap="nowrap"><?= h($Customername) ?></td>
            <td colspan="20" nowrap="nowrap"><?= h($PlaceDelivers->id_from_order) ?></td>
            <td colspan="20" nowrap="nowrap"><?= h($PlaceDelivers->name) ?></td>
          </tr>
          <?php endforeach; ?>
        </tbody>
    </table>
<br><br>
