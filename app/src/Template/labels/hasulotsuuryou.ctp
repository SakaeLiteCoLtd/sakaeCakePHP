 <?php
 $username = $this->request->Session()->read('Auth.User.username');
 header('Expires:-1');
 header('Cache-Control:');
 header('Pragma:');
 ?>
 <?php
  use App\myClass\Labelmenus\htmlLabelmenu;//myClassフォルダに配置したクラスを使用
  $htmlLabelmenu = new htmlLabelmenu();
  $htmlLabels = $htmlLabelmenu->Labelmenus();
  ?>
  <hr size="5" style="margin: 0.5rem">
  <table style="margin-bottom:0px" width="750" border="0" align="center" cellpadding="0" cellspacing="0" bordercolor="#CCCCCC">
  <?php
     echo $htmlLabels;
  ?>
  </table>
  <hr size="5" style="margin: 0.5rem">
 <br><br>
 <table width="200" align="left" border="2" bordercolor="#E6FFFF" cellpadding="0" cellspacing="0" style="border-bottom: solid;border-width: 1px">
   <tr>
     <td bgcolor="#FFFFCC" style="font-size: 12pt;"><strong style="font-size: 11pt; color:blue">担当者</strong></td>
 	</tr>
  <tr>
    <td bgcolor="#FFFFCC" style="font-size: 12pt;"><strong style="font-size: 10pt"><?= __($Staff) ?></strong></td>
 </tr>
 </table>
 <br><br><br>
    <?= $this->Flash->render() ?>
    <?= $this->Form->create($MotoLots, ['url' => ['action' => 'hasulotconfirm']]) ?>
    <br><br><br><br>

    <?php if($check_product != 1)://問題なしの時 ?>

  <table align="left" border="2" bordercolor="#E6FFFF" cellpadding="0" cellspacing="0">
    <tr style="border-bottom: solid;border-width: 1px">
      <td bgcolor="#FFFFCC"><strong style="font-size: 13pt; color:blue">品番</strong></td>
      <td bgcolor="#FFFFCC"><strong style="font-size: 13pt; color:blue">ロットNo.</strong></td>
      <td bgcolor="#FFFFCC"><strong style="font-size: 13pt; color:blue">数量</strong></td>
    </tr>
    <tr style="border-bottom: solid;border-width: 1px">
      <td width="263"  bgcolor="#FFFFCC" style="font-size: 12pt;"><?= h($product_code1) ?></td>
      <td width="263"  bgcolor="#FFFFCC" style="font-size: 12pt;"><?= h($lot_num) ?></td>
      <td width="263"  bgcolor="#FFFFCC" style="font-size: 12pt;"><?= h($amount) ?></td>
    </tr>
</table>
<br><br><br>
<br><br><br>
<br>

<table align="left" border="2" bordercolor="#E6FFFF" cellpadding="0" cellspacing="0">
  <tr style="border-bottom: solid;border-width: 1px">
    <td width='250'  bgcolor="#FFFFCC"><strong style="font-size: 13pt; color:blue">元ロットNo.</strong></td>
    <td width='250'  bgcolor="#FFFFCC"><strong style="font-size: 13pt; color:blue">元ロット数量</strong></td>
  </tr>

  <?php for($i=0; $i<=$tuika; $i++): ?>
  <tr style="border-bottom: solid;border-width: 1px">
    <td width="250"  bgcolor="#FFFFCC" style="font-size: 12pt;"><?= h(${"lot_moto".$i}) ?></td>
    <td width="250" bgcolor="#FFFFCC"><?= $this->Form->control('amount_moto'.$i, array('type'=>'text', 'label'=>false, 'maxlength' => 100)) ?></td>
  </tr>
  <?= $this->Form->control('lot_moto'.$i, array('type'=>'hidden', 'value'=>${"lot_moto".$i}, 'label'=>false)) ?>
  <?= $this->Form->control('num', array('type'=>'hidden', 'value'=>$i, 'label'=>false)) ?>

  <?php endfor;?>

</table>
<br><br><br><br><br><br><br>
<table align="left" border="2" bordercolor="#E6FFFF" cellpadding="0" cellspacing="0">
<tr bgcolor="#E6FFFF" >
  <td align="left" rowspan="2" width="50" bgcolor="#E6FFFF" style="border: none"><div align="left"><?= $this->Form->submit(__('登録確認'), array('name' => 'kakunin')); ?></div></td>
  <td width="400" colspan="40" nowrap="nowrap" bgcolor="#E6FFFF" style="border: none"><div align="center"><strong style="font-size: 15pt; color:blue"></strong></div></td>
  <td width="300" colspan="50" nowrap="nowrap" bgcolor="#E6FFFF" style="border: none"><div align="center"><strong style="font-size: 15pt; color:blue"></strong></div></td>
</tr>
</table>

<br>
<?= $this->Form->control('product_code', array('type'=>'hidden', 'value'=>$product_code1, 'label'=>false)) ?>
<?= $this->Form->control('lot_num', array('type'=>'hidden', 'value'=>$lot_num, 'label'=>false)) ?>
<?= $this->Form->control('amount', array('type'=>'hidden', 'value'=>$amount, 'label'=>false)) ?>
<?= $this->Form->control('Staff', array('type'=>'hidden', 'value'=>$Staff, 'label'=>false)) ?>
<?= $this->Form->control('staff_id', array('type'=>'hidden', 'value'=>$staff_id, 'label'=>false)) ?>

<br><br><br>
    <?= $this->Form->end() ?>
  <?php else: //合計数量が違う時 ?>
    <br><br>
    <legend align="center"><font color="red"><?= __('＊そのロットは、製品が違います。') ?></font></legend>
    <br><br><br><br><br>
  <?php endif; ?>
