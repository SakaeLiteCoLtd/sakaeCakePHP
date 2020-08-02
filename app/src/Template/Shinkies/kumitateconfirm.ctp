<?php
$this->layout = 'defaultshinki';
?>
<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\Deliver $product
 */
 use App\myClass\Shinkimenus\htmlShinkimenu;//myClassフォルダに配置したクラスを使用

 $htmlShinkimenu = new htmlShinkimenu();
 $htmlShinkis = $htmlShinkimenu->Shinkimenus();
?>
        <?php
          $username = $this->request->Session()->read('Auth.User.username');

          header('Expires:-1');
          header('Cache-Control:');
          header('Pragma:');
          echo $this->Form->create($assembleProducts, ['url' => ['action' => 'kumitatedo']]);

?>
<hr size="5" style="margin: 0.5rem">
<table style="margin-bottom:0px" width="750" border="0" align="center" cellpadding="0" cellspacing="0" bordercolor="#CCCCCC">
<?php
   echo $htmlShinkis;
?>
</table>
 <hr size="5" style="margin: 0.5rem">
 <table style="margin-bottom:0px" width="750" border="0" align="center" cellpadding="0" cellspacing="0" bordercolor="#CCCCCC">
 <tr style="background-color: #E6FFFF">
   <td style="padding: 0.1rem 0.1rem;"><a href="qr/index.php"><?php echo $this->Html->image('Labelimg/subTourokuAssem.gif',array('width'=>'85','height'=>'36','url'=>array('controller'=>'shinkies','action'=>'kumitateproductform')));?></td>
   <td style="padding: 0.1rem 0.1rem;"><a href="qr/index.php"><?php echo $this->Html->image('Labelimg/subYobidashiAssem.gif',array('width'=>'85','height'=>'36','url'=>array('controller'=>'shinkies','action'=>'kumitateyobidashi')));?></td>
 </tr>
 </table>
 <hr size="5" style="margin: 0.5rem">
 <br>
 <legend align="center"><strong style="font-size: 13pt; color:blue"><?= __("組立品登録") ?></strong></legend>
<br>

<table align="left" border="2" bordercolor="#E6FFFF" cellpadding="0" cellspacing="0">
  <tr style="border-bottom: solid;border-width: 1px">
    <td bgcolor="#FFFFCC"><strong style="font-size: 13pt; color:blue">品番</strong></td>
    <td bgcolor="#FFFFCC"><strong style="font-size: 13pt; color:blue">品名</strong></td>
  </tr>
  <tr style="border-bottom: solid;border-width: 1px">
    <td width="263"  bgcolor="#FFFFCC" style="font-size: 12pt;"><?= h($product_code) ?></td>
    <td width="263"  bgcolor="#FFFFCC" style="font-size: 12pt;"><?= h($product_name) ?></td>
  </tr>
</table>
<br><br><br>
<br><br><br>

<table align="left" border="2" bordercolor="#E6FFFF" cellpadding="0" cellspacing="0">
<tr style="border-bottom: solid;border-width: 1px">
  <td width='50'  bgcolor="#FFFFCC"><strong style="font-size: 13pt; color:blue"></strong></td>
  <td width='200'  bgcolor="#FFFFCC"><strong style="font-size: 13pt; color:blue">品番</strong></td>
  <td width='200'  bgcolor="#FFFFCC"><strong style="font-size: 13pt; color:blue">員数</strong></td>
</tr>

<?php for($i=0; $i<=$tuika; $i++): ?>
<tr style="border-bottom: solid;border-width: 1px">
  <td bgcolor="#FFFFCC"><?= h($i+1) ?></td>
  <td bgcolor="#FFFFCC"><?= h($data['product'.$i]) ?></td>
  <td bgcolor="#FFFFCC"><?= h($data['inzu'.$i]) ?></td>
</tr>
<?= $this->Form->control('num', array('type'=>'hidden', 'value'=>$i, 'label'=>false)) ?>
<?php endfor;?>

</table>
<br>
<table align="left" border="2" bordercolor="#E6FFFF" cellpadding="0" cellspacing="0">
<tr bgcolor="#E6FFFF" >
<td align="left" rowspan="2" width="50" bgcolor="#E6FFFF" style="border: none"><div align="right"><?= $this->Form->submit(__('登録'), array('name' => 'kakunin')); ?></div></td>
<td width="300" colspan="40" nowrap="nowrap" bgcolor="#E6FFFF" style="border: none"><div align="center"><strong style="font-size: 15pt; color:blue"></strong></div></td>
<td width="300" colspan="50" nowrap="nowrap" bgcolor="#E6FFFF" style="border: none"><div align="center"><strong style="font-size: 15pt; color:blue"></strong></div></td>
</tr>
</table>

<?= $this->Form->control('product_code', array('type'=>'hidden', 'value'=>$product_code, 'label'=>false)) ?>
<?= $this->Form->control('product_name', array('type'=>'hidden', 'value'=>$product_name, 'label'=>false)) ?>
<?php for($i=0; $i<=$tuika; $i++): ?>
<tr style="border-bottom: solid;border-width: 1px">
  <?= $this->Form->control('product'.$i, array('type'=>'hidden', 'value'=>$data['product'.$i], 'label'=>false)) ?>
  <?= $this->Form->control('inzu'.$i, array('type'=>'hidden', 'value'=>$data['inzu'.$i], 'label'=>false)) ?>
</tr>
<?= $this->Form->control('num', array('type'=>'hidden', 'value'=>$i, 'label'=>false)) ?>
<?php endfor;?>



  <?= $this->Form->end() ?>
