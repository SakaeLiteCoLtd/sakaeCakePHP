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
     <td style="padding: 0.1rem 0.1rem;"><a href="qr/index.php"><?php echo $this->Html->image('Labelimg/hazaisiyou.gif',array('width'=>'105','url'=>array('action'=>'shippedpreadd')));?></td>
 </tr>
</table>
<hr size="5" style="margin: 0.5rem">
<?= $this->Form->create($stockEndMaterials, ['url' => ['action' => 'shippeddo']]) ?>
<br>
<legend align="center"><font color="black"><?= __("以下の端材原料を使用登録します。") ?></font></legend>
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
<br>
<table align="center" border="2" bordercolor="#E6FFFF" cellpadding="0" cellspacing="0" style="border-bottom: solid;border-width: 1px">
  <tr>
    <td width="282" bgcolor="#FFFFCC" style="font-size: 8pt;padding: 0.2rem"><strong style="font-size: 11pt; color:blue">端材</strong></td>
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
    <td width="282" bgcolor="#FFFFCC" style="font-size: 8pt;padding: 0.2rem"><strong style="font-size: 11pt; color:blue">ロットNo.</strong></td>
	</tr>
  <tr>
    <td bgcolor="#FFFFCC" style="padding: 0.2rem">
      <?= h($lot_num) ?>
    </td>
	</tr>
</table>
<br>

<table align="center" border="2" bordercolor="#E6FFFF" cellpadding="0" cellspacing="0">
  <tr>
    <td style="border-style: none;"><div align="center"><?= $this->Form->submit('戻る', ['onclick' => 'history.back()', 'type' => 'button']); ?></div></td>
    <td style="border-style: none;"><div align="center"><?= $this->Form->submit('登録', array('name' => 'next')); ?></div></td>
  </tr>
</table>
<br><br><br><br><br><br><br>
<?= $this->Form->control('username', array('type'=>'hidden', 'value'=>$username, 'label'=>false)) ?>
<?= $this->Form->control('staff_name', array('type'=>'hidden', 'value'=>$staff_name, 'label'=>false)) ?>
<?= $this->Form->control('materialgrade_color', array('type'=>'hidden', 'value'=>$materialgrade_color, 'label'=>false)) ?>
<?= $this->Form->control('lot_num', array('type'=>'hidden', 'value'=>$lot_num, 'label'=>false)) ?>
<?= $this->Form->control('StockEndMaterialsId', array('type'=>'hidden', 'value'=>$StockEndMaterialsId, 'label'=>false)) ?>
