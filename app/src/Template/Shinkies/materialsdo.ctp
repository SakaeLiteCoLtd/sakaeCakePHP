<?php
$this->layout = 'defaultshinki';
?>
<?php
use App\myClass\Shinkimenus\htmlShinkimenu;//myClassフォルダに配置したクラスを使用

$htmlShinkimenu = new htmlShinkimenu();
$htmlShinkis = $htmlShinkimenu->Shinkimenus();
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
  <td style="padding: 0.1rem 0.1rem;"><a href="qr/index.php"><?php echo $this->Html->image('Labelimg/subTourokuMaterial.gif',array('width'=>'85','height'=>'36','url'=>array('action'=>'materialsform')));?></td>
  <td style="padding: 0.1rem 0.1rem;"><a href="qr/index.php"><?php echo $this->Html->image('Labelimg/subYobidashiMaterial.gif',array('width'=>'85','height'=>'36','url'=>array('action'=>'materialsyobidashi')));?></td>
  <td style="padding: 0.1rem 0.1rem;"><a href="qr/index.php"><?php echo $this->Html->image('Labelimg/subTourokuShiire.gif',array('width'=>'85','height'=>'36','url'=>array('action'=>'supplierform')));?></td>
</tr>
</table>

<hr size="5" style="margin: 0.5rem">

    <?= $this->Form->create($priceMaterials, ['url' => ['action' => 'menu']]) ?>

    <br>
      <legend align="center"><font color="red"><?= __($mes) ?></font></legend>
      <fieldset>

<table align="center" border="2" bordercolor="#E6FFFF" cellpadding="0" cellspacing="0" style="border-bottom: solid;border-width: 1px">
  <tr>
    <td width="280" bgcolor="#FFFFCC" style="font-size: 8pt;padding: 0.2rem"><strong style="font-size: 11pt; color:blue">グレード</strong></td>
    <td width="282" bgcolor="#FFFFCC" style="font-size: 8pt;padding: 0.2rem"><strong style="font-size: 11pt; color:blue">色番号</strong></td>
	</tr>
  <tr>
    <td bgcolor="#FFFFCC" style="padding: 0.2rem"><?= h($this->request->getData('grade')) ?></td>
    <td bgcolor="#FFFFCC" style="padding: 0.2rem"><?= h($this->request->getData('color')) ?></td>
	</tr>
</table>
<table align="center" border="2" bordercolor="#E6FFFF" cellpadding="0" cellspacing="0" style="border-bottom: solid;border-width: 1px">
  <tr>
    <td width="280" bgcolor="#FFFFCC" style="font-size: 8pt;padding: 0.2rem"><strong style="font-size: 11pt; color:blue">ロット下限</strong></td>
    <td width="282" bgcolor="#FFFFCC" style="font-size: 8pt;padding: 0.2rem"><strong style="font-size: 11pt; color:blue">ロット上限</strong></td>
	</tr>
  <tr>
    <td bgcolor="#FFFFCC" style="padding: 0.2rem"><?= h($this->request->getData('lot_low')) ?></td>
    <td bgcolor="#FFFFCC" style="padding: 0.2rem"><?= h($this->request->getData('lot_upper')) ?></td>
	</tr>
</table>
<table align="center" border="2" bordercolor="#E6FFFF" cellpadding="0" cellspacing="0" style="border-bottom: solid;border-width: 1px">
  <tr>
    <td width="280" colspan="2" bgcolor="#FFFFCC" style="font-size: 12pt;padding: 0.2rem"><strong style="font-size: 11pt; color:blue">単価（円/kg）</strong></td>
    <td width="280" bgcolor="#FFFFCC" style="font-size: 12pt;padding: 0.2rem"><strong style="font-size: 11pt; color:blue">原料サプライヤー</strong></td>
	</tr>
  <tr>
    <td width="140" bgcolor="#FFFFCC" style="text-align: right;border-right-style: none;padding: 0.2rem"><?= h($this->request->getData('price')) ?></td>
    <td width="140" bgcolor="#FFFFCC" style="text-align: left;border-left-style: none;padding: 0.2rem"><strong style="font-size: 11pt; color:blue">円/kg</strong></td>
    <td bgcolor="#FFFFCC" style="padding: 0.2rem"><?= h($this->request->getData('Suppliername')) ?></td>
	</tr>
</table>
<table align="center" border="2" bordercolor="#E6FFFF" cellpadding="0" cellspacing="0" style="border-bottom: solid;border-width: 1px">
  <tr>
    <td width="280" bgcolor="#FFFFCC" style="font-size: 12pt;padding: 0.2rem"><strong style="font-size: 11pt; color:blue">種類</strong></td>
	</tr>
  <tr>
    <td bgcolor="#FFFFCC" style="padding: 0.2rem"><?= h($this->request->getData('hyouji_status_buying')) ?></td>
	</tr>
</table>

    </fieldset>

    <table align="center" border="2" bordercolor="#E6FFFF" cellpadding="0" cellspacing="0">
    <tr>
      <td style="border-style: none;"><div align="center"><?= $this->Form->submit(__('メニュー'), array('name' => 'kakunin')); ?></div></td>
    </tr>
  </table>

  <?= $this->Form->control('grade', array('type'=>'hidden', 'value'=>$this->request->getData('grade'), 'label'=>false)) ?>
  <?= $this->Form->control('color', array('type'=>'hidden', 'value'=>$this->request->getData('color'), 'label'=>false)) ?>
  <?= $this->Form->control('lot_low', array('type'=>'hidden', 'value'=>$this->request->getData('lot_low'), 'label'=>false)) ?>
  <?= $this->Form->control('lot_upper', array('type'=>'hidden', 'value'=>$this->request->getData('lot_upper'), 'label'=>false)) ?>
  <?= $this->Form->control('price', array('type'=>'hidden', 'value'=>$this->request->getData('price'), 'label'=>false)) ?>
  <?= $this->Form->control('sup_id', array('type'=>'hidden', 'value'=>$this->request->getData('sup_id'), 'label'=>false)) ?>

<br>
