<?php
$this->layout = 'defaultaccount';
?>
<?php
use App\myClass\Shinkimenus\htmlShinkimenu;//myClassフォルダに配置したクラスを使用
?>
<?php
  header('Expires:-1');
  header('Cache-Control:');
  header('Pragma:');
?>
<?php
    $htmlShinkimenu = new htmlShinkimenu();
    $htmlaccountmenus = $htmlShinkimenu->accountmenus();
    $htmlsoukomenus = $htmlShinkimenu->soukomenus();
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
       echo $htmlsoukomenus;
  ?>
</table>
<hr size="5" style="margin: 0.5rem">
<br>
<table style="margin-bottom:0px" width="750" border="0" align="center" cellpadding="0" cellspacing="0" bordercolor="#CCCCCC">
   <tr style="background-color: #E6FFFF">
     <td style="padding: 0.1rem 0.1rem; text-align: center"><?php echo $this->Html->image('Labelimg/subSubKensaku.gif');?></td>
   </tr>
 </table>
<br><br>

<?php if ($roleCheck == 1): ?>
  <br><br>
  <legend align="center"><font color="red"><?= __("※データを登録する権限がありません。") ?></font></legend>
  <br><br>
  <br><br>
<?php else : ?>

  <?= $this->Form->create($user, ['url' => ['action' => 'soukosyuseiconfirm']]) ?>

  <table align="center" border="2" bordercolor="#E6FFFF" cellpadding="0" cellspacing="0">
    <tbody border="2" bordercolor="#E6FFFF" bgcolor="#FFFFCC" style="border-bottom: solid;border-width: 1px">
      <tr style="border-bottom: 0px;border-width: 0px">
        <td width="200" nowrap="nowrap"><div align="center"><strong style="font-size: 13pt; color:blue">項目</strong></div></td>
        <td width="300" nowrap="nowrap"><div align="center"><strong style="font-size: 13pt; color:blue">日付</strong></div></td>
        <td width="300" nowrap="nowrap"><div align="center"><strong style="font-size: 13pt; color:blue">会社名</strong></div></td>
        <td width="200" nowrap="nowrap"><div align="center"><strong style="font-size: 13pt; color:blue">品番</strong></div></td>
        <td width="200" nowrap="nowrap"><div align="center"><strong style="font-size: 13pt; color:blue">数量</strong></div></td>
      </tr>
      <tr style="border-bottom: 0px;border-width: 0px">
        <td width="280" bgcolor="#FFFFCC" style="padding: 0.2rem"><?= $this->Form->input("type", ["type"=>"select","empty"=>"選択してください", "options"=>$arrType, 'value' => $type, 'label'=>false]) ?></td>
        <td style="border-bottom: solid;border-width: 1px"><div align="center"><?= $this->Form->input("date", array('type' => 'date', 'value' => $date_work, 'monthNames' => false, 'label'=>false)); ?></div></td>
        <td width="280" bgcolor="#FFFFCC" style="padding: 0.2rem"><?= $this->Form->input("sup_id", ["type"=>"select","empty"=>"選択してください", "options"=>$arrOutsourceHandy, 'value' => $sup_id, 'label'=>false]) ?></td>
        <td bgcolor="#FFFFCC" style="padding: 0.2rem"><?= $this->Form->control('product_code', array('type'=>'text', 'value' => $product_code, 'label'=>false)) ?></td>
        <td bgcolor="#FFFFCC" style="padding: 0.2rem"><?= $this->Form->control('amount', array('type'=>'text', 'value' => $amount, 'label'=>false)) ?></td>
      </tr>

  <table align="left" border="2" bordercolor="#E6FFFF" cellpadding="0" cellspacing="0">
    <br>
  <tr bgcolor="#E6FFFF" >
    <td align="left" rowspan="2" width="30" bgcolor="#E6FFFF" style="border: none"><div align="center"><?= $this->Form->submit(__('確認'), array('name' => 'confirm')); ?></div></td>
  </tr>
  </table>
  <br><br>

  <?= $this->Form->control('Id', array('type'=>'hidden', 'value'=>$Id, 'label'=>false)) ?>

<?php endif; ?>
