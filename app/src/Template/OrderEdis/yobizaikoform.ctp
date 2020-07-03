<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\Deliver $product
 */
 use App\myClass\Shinkimenus\htmlShinkimenu;//myClassフォルダに配置したクラスを使用
?>
<?php
    $htmlShinkimenu = new htmlShinkimenu();
    $htmlShinkis = $htmlShinkimenu->Shinkimenus();
    $htmldenpyomenus = $htmlShinkimenu->denpyomenus();
?>

<?php
  $username = $this->request->Session()->read('Auth.User.username');

  header('Expires:-1');
  header('Cache-Control:');
  header('Pragma:');
  echo $this->Form->create($OrderToSuppliers, ['url' => ['action' => 'yobizaikoformtuika']]);
?>

<hr size="5" style="margin: 0.5rem">
<table style="margin-bottom:0px" width="750" border="0" align="center" cellpadding="0" cellspacing="0" bordercolor="#CCCCCC">
  <?php
       echo $htmldenpyomenus;
  ?>
</table>
 <hr size="5" style="margin: 0.5rem">
 <table style="margin-bottom:0px" width="750" border="0" align="center" cellpadding="0" cellspacing="0" bordercolor="#CCCCCC">
 <tr style="background-color: #E6FFFF">
   <td style="padding: 0.1rem 0.1rem;"><a href="qr/index.php"><?php echo $this->Html->image('Labelimg/hattyusumi.gif',array('width'=>'85','height'=>'36','url'=>array('controller'=>'orderEdis','action'=>'denpyouhenkoukensaku')));?></td>
   <td style="padding: 0.1rem 0.1rem;"><a href="qr/index.php"><?php echo $this->Html->image('Labelimg/yobizaiko.gif',array('width'=>'85','height'=>'36','url'=>array('controller'=>'orderEdis','action'=>'yobizaikopreadd')));?></td>
 </tr>
 </table>
 <hr size="5" style="margin: 0.5rem">
 <br>
 <legend align="center"><strong style="font-size: 13pt; color:blue"><?= __("予備在庫発注") ?></strong></legend>
<br>
<table width="200" align="left" border="2" bordercolor="#E6FFFF" cellpadding="0" cellspacing="0" style="border-bottom: solid;border-width: 1px">
  <tr>
    <td bgcolor="#FFFFCC" style="font-size: 12pt;"><strong style="font-size: 11pt; color:blue">担当者</strong></td>
 </tr>
 <tr>
   <td bgcolor="#FFFFCC" style="font-size: 12pt;"><strong style="font-size: 10pt"><?= __($Staff) ?></strong></td>
</tr>
</table>
<br><br><br>
<br><br><br>
<table align="left" border="2" bordercolor="#E6FFFF" cellpadding="0" cellspacing="0">
  <tr style="border-bottom: solid;border-width: 1px">
    <td bgcolor="#FFFFCC"><strong style="font-size: 13pt; color:blue">品番</strong></td>
    <td bgcolor="#FFFFCC"><strong style="font-size: 13pt; color:blue">品名</strong></td>
  </tr>
  <tr style="border-bottom: solid;border-width: 1px">
    <td width="350"  bgcolor="#FFFFCC" style="font-size: 12pt;"><?= h($product_code) ?></td>
    <td width="350"  bgcolor="#FFFFCC" style="font-size: 12pt;"><?= h($product_name) ?></td>
  </tr>
</table>
<br><br><br>
<br><br><br>
<table align="left" border="2" bordercolor="#E6FFFF" cellpadding="0" cellspacing="0">
  <tr style="border-bottom: solid;border-width: 1px">
    <td bgcolor="#FFFFCC"><strong style="font-size: 13pt; color:blue">発注先</strong></td>
    <td bgcolor="#FFFFCC"><strong style="font-size: 13pt; color:blue">発注日</strong></td>
  </tr>
  <tr style="border-bottom: solid;border-width: 1px">
    <td width="400"  bgcolor="#FFFFCC" style="font-size: 12pt;"><?= h($Supplier) ?></td>
    <td width="300"  bgcolor="#FFFFCC" style="font-size: 12pt;"><?= h(date('Y-m-d')) ?></td>
  </tr>
</table>
<br><br><br>
<br><br><br>


<table align="left" border="2" bordercolor="#E6FFFF" cellpadding="0" cellspacing="0">
<tr bgcolor="#E6FFFF" >
  <td align="left" rowspan="2" width="50" bgcolor="#E6FFFF" style="border: none"><div align="right"><?= $this->Form->submit(__('行追加'), array('name' => 'tuika')); ?></div></td>
  <td align="left" rowspan="2" width="50" bgcolor="#E6FFFF" style="border: none"><div align="right"><?= $this->Form->submit(__('行削除'), array('name' => 'sakujo')); ?></div></td>
  <td align="left" rowspan="2" width="50" bgcolor="#E6FFFF" style="border: none"><div align="right"><?= $this->Form->submit(__('不良内容登録確認'), array('name' => 'kakunin')); ?></div></td>
</tr>
</table>
<br><br>
<table align="left" border="2" bordercolor="#E6FFFF" cellpadding="0" cellspacing="0">
  <tr style="border-bottom: solid;border-width: 1px">
    <td width='100'  bgcolor="#FFFFCC"><strong style="font-size: 13pt; color:blue">No.</strong></td>
    <td width='200'  bgcolor="#FFFFCC"><strong style="font-size: 13pt; color:blue">数量</strong></td>
    <td width='400'  bgcolor="#FFFFCC"><strong style="font-size: 13pt; color:blue">納期</strong></td>
  </tr>

  <?php for($i=0; $i<1; $i++): ?>
  <tr style="border-bottom: solid;border-width: 1px">
    <td bgcolor="#FFFFCC"><?= h($i+1) ?></td>
    <td bgcolor="#FFFFCC"><?= $this->Form->input('amount'.$i, ["type"=>"text", 'label'=>false]); ?></td>
    <td bgcolor="#FFFFCC"><?= $this->Form->input('date_deliver'.$i, array('type' => 'date', 'monthNames' => false, 'label'=>false)); ?></td>
  </tr>
  <?= $this->Form->control('num', array('type'=>'hidden', 'value'=>$i, 'label'=>false)) ?>
  <?php endfor;?>
</table>

<?= $this->Form->control('product_code', array('type'=>'hidden', 'value'=>$product_code, 'label'=>false)) ?>
<?= $this->Form->control('product_name', array('type'=>'hidden', 'value'=>$product_name, 'label'=>false)) ?>
<?= $this->Form->control('Supplier', array('type'=>'hidden', 'value'=>$Supplier, 'label'=>false)) ?>
<?= $this->Form->control('Staff', array('type'=>'hidden', 'value'=>$Staff, 'label'=>false)) ?>
<?= $this->Form->control('staff_id', array('type'=>'hidden', 'value'=>$staff_id, 'label'=>false)) ?>

<br><br><br><br>
<br><br><br><br>
<br><br><br>
