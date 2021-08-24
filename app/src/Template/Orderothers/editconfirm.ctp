<?php
 use App\myClass\EDImenus\htmlEDImenu;//myClassフォルダに配置したクラスを使用
 $htmlEDImenu = new htmlEDImenu();
 $htmlEDIs = $htmlEDImenu->EDImenus();
 ?>
 <hr size="5" style="margin: 0.5rem">
 <table style="margin-bottom:0px" width="750" border="0" align="center" cellpadding="0" cellspacing="0" bordercolor="#CCCCCC">
 <?php
    echo $htmlEDIs;
 ?>
 </table>
 <hr size="5" style="margin: 0.5rem">
 <?= $this->Flash->render() ?>
 <?= $this->Form->create($OrderSpecials, ['url' => ['action' => 'editpreadd']]) ?>
 <fieldset>
   <table style="margin-bottom:0px" border="0" align="center" cellpadding="0" cellspacing="0" bordercolor="#CCCCCC">
     <tr style="background-color: #E6FFFF">
       <td style="padding: 0.1rem 0.1rem; text-align: center"><a href="qr/index.php"><?php echo $this->Html->image('Labelimg/subYobidashi.gif',array('width'=>'85','height'=>'36','url'=>array('action'=>'kensakuform')));?></td>
     </tr>
   </table>
   <br>
   <div align="center"><font color="red" size="3"><?= __($mes) ?></font></div>
   <br>
<table width="1000" align="center" border="2" bordercolor="#E6FFFF" cellpadding="0" cellspacing="0" style="border-bottom: solid;border-width: 1px">
  <tr>
    <td width="250" bgcolor="#FFFFCC" style="font-size: 12pt;"><strong style="font-size: 11pt; color:blue">注文日付</strong></td>
    <td width="230" bgcolor="#FFFFCC" style="font-size: 12pt;"><strong style="font-size: 11pt; color:blue">注文NO(無ければ任意の英数字)</strong></td>
    <td bgcolor="#FFFFCC" style="font-size: 12pt;"><strong style="font-size: 11pt; color:blue">発注元顧客</strong></td>
    <td width="60" bgcolor="#FFFFCC" style="font-size: 12pt;"><strong style="font-size: 11pt; color:blue">状況</strong></td>
	</tr>
  <tr>
    <td bgcolor="#FFFFCC"><?= h($date_order) ?></td>
    <td bgcolor="#FFFFCC"><?= h($num_order) ?></td>
    <td bgcolor="#FFFFCC"><?= h($cs_name) ?></td>
    <td bgcolor="#FFFFCC"><?= h($kannou_name) ?></td>
	</tr>
</table>
<br><br>
<table width="1000" align="center" border="2" bordercolor="#E6FFFF" cellpadding="0" cellspacing="0" style="border-bottom: solid;border-width: 1px">
  <tr>
    <td width="250" bgcolor="#FFFFCC" style="font-size: 12pt;"><strong style="font-size: 10pt; color:blue">品番、または顧客発注名(半角英数のみ)</strong></td>
    <td width="100" bgcolor="#FFFFCC" style="font-size: 12pt;"><strong style="font-size: 11pt; color:blue">受注項目</strong></td>
    <td width="100" bgcolor="#FFFFCC" style="font-size: 12pt;"><strong style="font-size: 11pt; color:blue">価格(円)</strong></td>
    <td  width="100" bgcolor="#FFFFCC" style="font-size: 12pt;"><strong style="font-size: 11pt; color:blue">数量</strong></td>
    <td  width="270" bgcolor="#FFFFCC" style="font-size: 12pt;"><strong style="font-size: 11pt; color:blue">納期</strong></td>
	</tr>
  <tr>
    <td bgcolor="#FFFFCC"><?= h($order_name) ?></td>
    <td bgcolor="#FFFFCC"><?= h($element_name) ?></td>
    <td bgcolor="#FFFFCC"><?= h($price) ?></td>
    <td bgcolor="#FFFFCC"><?= h($amount) ?></td>
    <td bgcolor="#FFFFCC"><?= h($date_deliver) ?></td>
	</tr>
</table>

<?= $this->Form->control('Id', array('type'=>'hidden', 'value'=>$Id, 'label'=>false)) ?>
<?= $this->Form->control('date_order', array('type'=>'hidden', 'value'=>$date_order, 'label'=>false)) ?>
<?= $this->Form->control('num_order', array('type'=>'hidden', 'value'=>$num_order, 'label'=>false)) ?>
<?= $this->Form->control('cs_id', array('type'=>'hidden', 'value'=>$cs_id, 'label'=>false)) ?>
<?= $this->Form->control('order_name', array('type'=>'hidden', 'value'=>$order_name, 'label'=>false)) ?>
<?= $this->Form->control('element_id', array('type'=>'hidden', 'value'=>$element_id, 'label'=>false)) ?>
<?= $this->Form->control('price', array('type'=>'hidden', 'value'=>$price, 'label'=>false)) ?>
<?= $this->Form->control('amount', array('type'=>'hidden', 'value'=>$amount, 'label'=>false)) ?>
<?= $this->Form->control('date_deliver', array('type'=>'hidden', 'value'=>$date_deliver, 'label'=>false)) ?>
<?= $this->Form->control('cs_name', array('type'=>'hidden', 'value'=>$cs_name, 'label'=>false)) ?>
<?= $this->Form->control('element_name', array('type'=>'hidden', 'value'=>$element_name, 'label'=>false)) ?>

</fieldset>
<table align="center" border="2" bordercolor="#E6FFFF" cellpadding="0" cellspacing="0">
  <tr>
    <td style="border-style: none;"><div align="center"><?= $this->Form->submit('戻る', ['onclick' => 'history.back()', 'type' => 'button']); ?></div></td>
    <td style="border-style: none;"><div align="center"><?= $this->Form->submit('決定', array('name' => 'noukikakunin')); ?></div></td>
  </tr>
</table>
<br><br><br>

<?= $this->Form->end() ?>
