<?php
 use App\myClass\Genryoumenu\htmlGenryoumenu;//myClassフォルダに配置したクラスを使用
 $htmlGenryoumenu = new htmlGenryoumenu();
 $htmlGenryou = $htmlGenryoumenu->Genryoumenus();
 ?>

 <hr size="5" style="margin: 0.5rem">
 <table style="margin-bottom:0px" width="750" border="0" align="center" cellpadding="0" cellspacing="0" bordercolor="#CCCCCC">
 <?php
    echo $htmlGenryou;
 ?>
 </table>
<hr size="5" style="margin: 0.5rem">
<table style="margin-bottom:0px" width="1000" border="0" align="center" cellpadding="0" cellspacing="0" bordercolor="#CCCCCC">
 <tr style="background-color: #E6FFFF">
     <td style="padding: 0.1rem 0.1rem;"><a href="qr/index.php"><?php echo $this->Html->image('Labelimg/hazaigenryou.gif',array('width'=>'105','url'=>array('action'=>'materialpreadd')));?></td>
 </tr>
</table>
<hr size="5" style="margin: 0.5rem">
<br><br>
<?= $this->Form->create($stockEndMaterials, ['url' => ['action' => 'materialdo']]) ?>

<br>
<div align="center"><font color="black" size="3"><?= __("下のように登録します。よろしければ登録ボタンを押してください。") ?></font></div>
<br>
<div align="center"><font color="red" size="3"><?= __($mess) ?></font></div>
<br>

<table align="center" border="2" bordercolor="#E6FFFF" cellpadding="0" cellspacing="0" style="border-bottom: solid;border-width: 1px">
  <tr>
    <td width="282" bgcolor="#FFFFCC" style="font-size: 8pt;padding: 0.2rem"><strong style="font-size: 11pt; color:blue">登録社員</strong></td>
	</tr>
  <tr>
    <td bgcolor="#FFFFCC" style="padding: 0.2rem">
      <?= h($staff_name) ?>
    </td>
	</tr>
</table>

<?php if ($check_product == 1): ?>

<br>
<table align="center" border="2" bordercolor="#E6FFFF" cellpadding="0" cellspacing="0" style="border-bottom: solid;border-width: 1px">
  <tr>
    <td width="282" bgcolor="#FFFFCC" style="font-size: 8pt;padding: 0.2rem"><strong style="font-size: 11pt; color:blue">品番</strong></td>
	</tr>
  <tr>
    <td bgcolor="#FFFFCC" style="padding: 0.2rem">
      <?= h($product_code) ?>
    </td>
	</tr>
</table>

<?php else : ?>
<?php endif; ?>

<br>
<table align="center" border="2" bordercolor="#E6FFFF" cellpadding="0" cellspacing="0" style="border-bottom: solid;border-width: 1px">
  <tr>
    <td width="282" bgcolor="#FFFFCC" style="font-size: 8pt;padding: 0.2rem"><strong style="font-size: 11pt; color:blue">原料グレード_色</strong></td>
	</tr>
  <tr>
    <td bgcolor="#FFFFCC" style="padding: 0.2rem">
      <?= h($materialgrade_color) ?>
    </td>
	</tr>
</table>
<br>
<table align="center" border="2" bordercolor="#E6FFFF" cellpadding="0" cellspacing="0" style="border-bottom: solid;border-width: 1px">
  <tr>
    <td width="282" bgcolor="#FFFFCC" style="font-size: 8pt;padding: 0.2rem"><strong style="font-size: 11pt; color:blue">端材ステイタス</strong></td>
	</tr>
  <tr>
    <td bgcolor="#FFFFCC" style="padding: 0.2rem">
      <?= h($hyouji_status_material) ?>
    </td>
	</tr>
</table>
<br>
<table align="center" border="2" bordercolor="#E6FFFF" cellpadding="0" cellspacing="0" style="border-bottom: solid;border-width: 1px">
  <tr>
    <td width="282" bgcolor="#FFFFCC" style="font-size: 8pt;padding: 0.2rem"><strong style="font-size: 11pt; color:blue">数量（kg）</strong></td>
	</tr>
  <tr>
    <td bgcolor="#FFFFCC" style="padding: 0.2rem">
      <?= h($amount) ?>
    </td>
	</tr>
</table>
<br>

<table align="center" border="2" bordercolor="#E6FFFF" cellpadding="0" cellspacing="0">
  <tr>
    <td style="border-style: none;"><div align="center"><?= $this->Form->submit('戻る', ['onclick' => 'history.back()', 'type' => 'button']); ?></div></td>
    <td style="border-style: none;"><div align="center"><?= $this->Form->submit('登録', array('name' => 'hakkou')); ?></div></td>
  </tr>
</table>
<br><br><br><br><br><br><br>
<?= $this->Form->control('username', array('type'=>'hidden', 'value'=>$username, 'label'=>false)) ?>
<?= $this->Form->control('staff_name', array('type'=>'hidden', 'value'=>$staff_name, 'label'=>false)) ?>
<?= $this->Form->control('materialgrade_color', array('type'=>'hidden', 'value'=>$materialgrade_color, 'label'=>false)) ?>
<?= $this->Form->control('product_code', array('type'=>'hidden', 'value'=>$product_code, 'label'=>false)) ?>
<?= $this->Form->control('price_material_id', array('type'=>'hidden', 'value'=>$price_material_id, 'label'=>false)) ?>
<?= $this->Form->control('hyouji_status_material', array('type'=>'hidden', 'value'=>$hyouji_status_material, 'label'=>false)) ?>
<?= $this->Form->control('status_material', array('type'=>'hidden', 'value'=>$status_material, 'label'=>false)) ?>
<?= $this->Form->control('amount', array('type'=>'hidden', 'value'=>$amount, 'label'=>false)) ?>
<?= $this->Form->control('check_product', array('type'=>'hidden', 'value'=>$check_product, 'label'=>false)) ?>
