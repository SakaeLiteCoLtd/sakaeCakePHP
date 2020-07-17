<?php
$this->layout = 'defaultaccount';
?>
<?php
  header('Expires:-1');
  header('Cache-Control:');
  header('Pragma:');
?>

<?php
use App\myClass\Shinkimenus\htmlShinkimenu;//myClassフォルダに配置したクラスを使用
?>
<?php
    $htmlShinkimenu = new htmlShinkimenu();
    $htmlaccountmenus = $htmlShinkimenu->accountmenus();
    $htmlurikakemenus = $htmlShinkimenu->urikakemenus();
?>
<hr size="5" style="margin: 0.5rem">
<table style="margin-bottom:0px" width="750" border="0" align="center" cellpadding="0" cellspacing="0" bordercolor="#CCCCCC">
  <?php
       echo $htmlaccountmenus;
  ?>
</table>
<hr size="5" style="margin: 0.5rem">
<table style="margin-bottom:0px" width="750" border="0" align="center" cellpadding="0" cellspacing="0" bordercolor="#CCCCCC">
  <?php
       echo $htmlurikakemenus;
  ?>
</table>
<hr size="5" style="margin: 0.5rem">
<br>
<table style="margin-bottom:0px" width="750" border="0" align="center" cellpadding="0" cellspacing="0" bordercolor="#CCCCCC">
   <tr style="background-color: #E6FFFF">
     <td style="padding: 0.1rem 0.1rem; text-align: center"><?php echo $this->Html->image('Labelimg/account_urikake_touroku.gif');?></td>
   </tr>
 </table>
<br><br>
<?php if ($roleCheck == 1): ?>
  <br><br>
  <legend align="center"><font color="red"><?= __("※データを登録する権限がありません。") ?></font></legend>
  <br><br>
  <br><br>
<?php else : ?>

  <?= $this->Form->create($user, ['url' => ['action' => 'urikakesyuseiconfirm']]) ?>

  <table align="center" border="2" bordercolor="#E6FFFF" cellpadding="0" cellspacing="0">
    <tbody border="2" bordercolor="#E6FFFF" bgcolor="#FFFFCC" style="border-bottom: solid;border-width: 1px">
      <tr style="border-bottom: 0px;border-width: 0px">
        <td width="300" nowrap="nowrap"><div align="center"><strong style="font-size: 13pt; color:blue">会社名</strong></div></td>
        <td width="200" nowrap="nowrap"><div align="center"><strong style="font-size: 13pt; color:blue">項目</strong></div></td>
        <td width="300" nowrap="nowrap"><div align="center"><strong style="font-size: 13pt; color:blue">日付</strong></div></td>
        <td width="200" nowrap="nowrap"><div align="center"><strong style="font-size: 13pt; color:blue">金額</strong></div></td>
        <td width="70" nowrap="nowrap"><div align="center"><strong style="font-size: 13pt; color:blue">削除</strong></div></td>
      </tr>
      <tr style="border-bottom: 0px;border-width: 0px">
        <td width="280" bgcolor="#FFFFCC" style="padding: 0.2rem"><?= $this->Form->input("customer", ["type"=>"select","empty"=>"選択してください", "options"=>$arrCustomer, 'value' => $customer_code, 'label'=>false]) ?></td>
        <td width="280" bgcolor="#FFFFCC" style="padding: 0.2rem"><?= $this->Form->input("urikakeelement", ["type"=>"select","empty"=>"選択してください", "options"=>$arrAccountUrikakeElement, 'value' => $urikake_element_id, 'label'=>false]) ?></td>
        <td style="border-bottom: solid;border-width: 1px"><div align="center"><?= $this->Form->input("date", array('type' => 'date', 'value' => $date, 'monthNames' => false, 'label'=>false)); ?></div></td>
        <td bgcolor="#FFFFCC" style="padding: 0.2rem"><?= $this->Form->control('price', array('type'=>'text', 'value' => $kingaku, 'label'=>false)) ?></td>
        <td bgcolor="#FFFFCC" style="padding: 0.2rem"><?= $this->Form->control('check', array('type'=>'checkbox', 'label'=>false)) ?></td>
      </tr>

  <table align="left" border="2" bordercolor="#E6FFFF" cellpadding="0" cellspacing="0">
    <br>
  <tr bgcolor="#E6FFFF" >
    <td align="left" rowspan="2" width="30" bgcolor="#E6FFFF" style="border: none"><div align="center"><?= $this->Form->submit(__('確認'), array('name' => 'confirm')); ?></div></td>
  </tr>
  </table>
  <br><br>

  <?= $this->Form->control('UrikakeId', array('type'=>'hidden', 'value'=>$UrikakeId, 'label'=>false)) ?>

<?php endif; ?>
