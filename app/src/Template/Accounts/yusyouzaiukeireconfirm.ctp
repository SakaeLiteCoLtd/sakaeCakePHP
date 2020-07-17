<?php
$this->layout = 'defaultaccount';
?>

<?php
use App\myClass\Shinkimenus\htmlShinkimenu;//myClassフォルダに配置したクラスを使用
?>
<?php
    $htmlShinkimenu = new htmlShinkimenu();
    $htmlaccountmenus = $htmlShinkimenu->accountmenus();
    $htmlyusyouzaimenus = $htmlShinkimenu->yusyouzaimenus();
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
       echo $htmlyusyouzaimenus;
  ?>
</table>
<hr size="5" style="margin: 0.5rem">
<br>
<table style="margin-bottom:0px" width="750" border="0" align="center" cellpadding="0" cellspacing="0" bordercolor="#CCCCCC">
   <tr style="background-color: #E6FFFF">
     <td style="padding: 0.1rem 0.1rem; text-align: center"><?php echo $this->Html->image('Labelimg/accountYusyouzaiUkeire.gif');?></td>
   </tr>
 </table>
<br><br>

  <?= $this->Form->create($user, ['url' => ['action' => 'yusyouzaiukeiredo']]) ?>

  <table align="center" border="2" bordercolor="#E6FFFF" cellpadding="0" cellspacing="0">
    <tbody border="2" bordercolor="#E6FFFF" bgcolor="#FFFFCC" style="border-bottom: solid;border-width: 1px">
      <tr style="border-bottom: 0px;border-width: 0px">
        <td width="150" nowrap="nowrap"><div align="center"><strong style="font-size: 13pt; color:blue">品番</strong></div></td>
        <td width="150" nowrap="nowrap"><div align="center"><strong style="font-size: 13pt; color:blue">品名</strong></div></td>
        <td width="150" nowrap="nowrap"><div align="center"><strong style="font-size: 13pt; color:blue">単価（円）</strong></div></td>
        <td width="300" nowrap="nowrap"><div align="center"><strong style="font-size: 13pt; color:blue">日付</strong></div></td>
        <td width="150" nowrap="nowrap"><div align="center"><strong style="font-size: 13pt; color:blue">数量</strong></div></td>
      </tr>
      <tr style="border-bottom: 0px;border-width: 0px">
        <td bgcolor="#FFFFCC" style="padding: 0.2rem"><?= h($product_code) ?></td>
        <td bgcolor="#FFFFCC" style="padding: 0.2rem"><?= h($product_name) ?></td>
        <td bgcolor="#FFFFCC" style="padding: 0.2rem"><?= h($tanka) ?></td>
        <td bgcolor="#FFFFCC" style="padding: 0.2rem"><?= h($dateYMD) ?></td>
        <td bgcolor="#FFFFCC" style="padding: 0.2rem"><?= h($amount) ?></td>
      </tr>

  <table align="left" border="2" bordercolor="#E6FFFF" cellpadding="0" cellspacing="0">
    <br>
  <tr bgcolor="#E6FFFF" >
    <td align="left" rowspan="2" width="30" bgcolor="#E6FFFF" style="border: none"><div align="center"><?= $this->Form->submit(__('登録'), array('name' => 'confirm')); ?></div></td>
  </tr>
  </table>
  <br><br>

  <?= $this->Form->control('product_code', array('type'=>'hidden', 'value'=>$product_code, 'label'=>false)) ?>
  <?= $this->Form->control('product_name', array('type'=>'hidden', 'value'=>$product_name, 'label'=>false)) ?>
  <?= $this->Form->control('tanka', array('type'=>'hidden', 'value'=>$tanka, 'label'=>false)) ?>
  <?= $this->Form->control('date', array('type'=>'hidden', 'value'=>$dateYMD, 'label'=>false)) ?>
  <?= $this->Form->control('amount', array('type'=>'hidden', 'value'=>$amount, 'label'=>false)) ?>

    </fieldset>
