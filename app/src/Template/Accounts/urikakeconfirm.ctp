<?php
$this->layout = 'defaultaccount';
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

  <?= $this->Form->create($user, ['url' => ['action' => 'urikakedo']]) ?>

  <table align="center" border="2" bordercolor="#E6FFFF" cellpadding="0" cellspacing="0">
    <tbody border="2" bordercolor="#E6FFFF" bgcolor="#FFFFCC" style="border-bottom: solid;border-width: 1px">
      <tr style="border-bottom: 0px;border-width: 0px">
        <td width="300" nowrap="nowrap"><div align="center"><strong style="font-size: 13pt; color:blue">会社名</strong></div></td>
        <td width="200" nowrap="nowrap"><div align="center"><strong style="font-size: 13pt; color:blue">項目</strong></div></td>
        <td width="200" nowrap="nowrap"><div align="center"><strong style="font-size: 13pt; color:blue">日付</strong></div></td>
        <td width="200" nowrap="nowrap"><div align="center"><strong style="font-size: 13pt; color:blue">金額</strong></div></td>
      </tr>
      <tr style="border-bottom: 0px;border-width: 0px">
        <td width="280" bgcolor="#FFFFCC" style="padding: 0.2rem"><?= h($customer) ?></td>
        <td width="280" bgcolor="#FFFFCC" style="padding: 0.2rem"><?= h($AccountUrikakeElement) ?></td>
        <td style="border-bottom: solid;border-width: 1px"><div align="center"><?= h($dateYMD) ?></div></td>
        <td bgcolor="#FFFFCC" style="padding: 0.2rem"><?= h($price) ?></td>
      </tr>

      <?php if($zaiko_check == 1): ?>

      <table align="center" border="2" bordercolor="#E6FFFF" cellpadding="0" cellspacing="0" style="border-bottom: solid;border-width: 1px">
        <br><br>
        <tr>
          <td width="280" bgcolor="#FFFFCC" nowrap="nowrap"><div align="center"><strong style="font-size: 13pt; color:blue">製品番号、または原料グレード</strong></div></td>
          <td width="300" bgcolor="#FFFFCC" colspan="2" nowrap="nowrap"><div align="center"><strong style="font-size: 13pt; color:blue">数量（ヶ、kg）</strong></div></td>
      	</tr>
        <tr>
          <td width="280" bgcolor="#FFFFCC" style="padding: 0.2rem"><?= $this->Form->control('productGrade', array('type'=>'text', 'label'=>false, 'autofocus'=>true)) ?></td>
          <td  width="220" bgcolor="#FFFFCC" style="border-right-style: none;padding: 0.2rem"><?= $this->Form->control('suryouKg', array('type'=>'text', 'label'=>false)) ?></td>
          <td width="82" bgcolor="#FFFFCC" style="border-left-style: none;padding: 0.2rem"><strong style="font-size: 11pt; color:blue">（ヶ、kg）</strong></td>
      	</tr>
      </table>

      <?= $this->Form->control('zaiko_check', array('type'=>'hidden', 'value'=>$zaiko_check, 'label'=>false)) ?>

      <?php else:?>

        <?= $this->Form->control('zaiko_check', array('type'=>'hidden', 'value'=>$zaiko_check, 'label'=>false)) ?>

      <?php endif; ?>

  <table align="left" border="2" bordercolor="#E6FFFF" cellpadding="0" cellspacing="0">
    <br>
  <tr bgcolor="#E6FFFF" >
    <td align="left" rowspan="2" width="30" bgcolor="#E6FFFF" style="border: none"><div align="center"><?= $this->Form->submit(__('登録'), array('name' => 'do')); ?></div></td>
  </tr>
  </table>

  <?= $this->Form->control('customer', array('type'=>'hidden', 'value'=>$this->request->getData('customer'), 'label'=>false)) ?>
	<?= $this->Form->control('urikakeelement', array('type'=>'hidden', 'value'=>$this->request->getData('urikakeelement'), 'label'=>false)) ?>
  <?= $this->Form->control('date', array('type'=>'hidden', 'value'=>$dateYMD, 'label'=>false)) ?>
	<?= $this->Form->control('price', array('type'=>'hidden', 'value'=>$this->request->getData('price'), 'label'=>false)) ?>


  <br><br>
