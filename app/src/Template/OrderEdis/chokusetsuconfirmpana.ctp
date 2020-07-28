<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\User $user
 */
 header('Expires:-1');
 header('Cache-Control:');
 header('Pragma:');

?>
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
    <?= $this->Form->create($orderEdis, ['url' => ['action' => 'chokusetsupanapreadd']]) ?>
    <fieldset>
      <table style="margin-bottom:0px" width="850" border="0" align="center" cellpadding="0" cellspacing="0" bordercolor="#CCCCCC">
        <tr style="background-color: #E6FFFF">
          <td style="padding: 0.1rem 0.1rem; text-align: center"><a href="qr/index.php"><?php echo $this->Html->image('Labelimg/touroku_tyokusetsu.gif',array('width'=>'85','height'=>'36','url'=>array('controller'=>'OrderEdis','action'=>'chokusetsuformpro')));?></td>
        </tr>
      </table>
<br><br>
<table align="center" border="2" bordercolor="#E6FFFF" cellpadding="0" cellspacing="0" style="border-bottom: solid;border-width: 1px">
  <tr>
    <td width="200" bgcolor="#FFFFCC" style="font-size: 12pt;"><strong style="font-size: 11pt; color:blue">注文日付</strong></td>
    <td  width="200" bgcolor="#FFFFCC" style="font-size: 12pt;"><strong style="font-size: 11pt; color:blue">注文No</strong></td>
    <td  width="200" bgcolor="#FFFFCC" style="font-size: 12pt;"><strong style="font-size: 11pt; color:blue">発注元顧客</strong></td>
    <td  width="200" bgcolor="#FFFFCC" style="font-size: 12pt;"><strong style="font-size: 11pt; color:blue">納入ライン</strong></td>
	</tr>
  <tr>
    <td bgcolor="#FFFFCC"><?= __($date_order) ?></td>
    <td bgcolor="#FFFFCC"><?= __($num_order) ?></td>
    <td bgcolor="#FFFFCC"><?= __($place_deliver_name) ?></td>
    <td bgcolor="#FFFFCC"><?= __($line_code) ?></td>
	</tr>
</table>
<br><br>
<table align="center" border="2" bordercolor="#E6FFFF" cellpadding="0" cellspacing="0" style="border-bottom: solid;border-width: 1px">
  <tr>
    <td width="200" bgcolor="#FFFFCC" style="font-size: 12pt;"><strong style="font-size: 11pt; color:blue">品番</strong></td>
    <td width="200" bgcolor="#FFFFCC" style="font-size: 12pt;"><strong style="font-size: 11pt; color:blue">品名</strong></td>
    <td  width="200"  bgcolor="#FFFFCC" style="font-size: 12pt;"><strong style="font-size: 11pt; color:blue">数量</strong></td>
    <td   width="200"  bgcolor="#FFFFCC" style="font-size: 12pt;"><strong style="font-size: 11pt; color:blue">納期</strong></td>
	</tr>
  <tr>
    <td bgcolor="#FFFFCC"><?= __($product_code) ?></td>
    <td bgcolor="#FFFFCC"><?= __($product_name) ?></td>
    <td bgcolor="#FFFFCC"><?= __($amount) ?></td>
    <td bgcolor="#FFFFCC"><?= __($date_deliver) ?></td>
	</tr>
</table>
<br><br>

<?php if($price_check == 1): ?>

<table align="center" border="2" bordercolor="#E6FFFF" cellpadding="0" cellspacing="0" style="border-bottom: solid;border-width: 1px">
  <tr>
    <td bgcolor="#FFFFCC" style="font-size: 12pt;"><strong style="font-size: 11pt; color:blue">単価</strong></td>
	</tr>
  <tr>
		<td bgcolor="#FFFFCC"><?= $this->Form->control('price', array('type'=>'text', 'label'=>false)) ?></td>
	</tr>
</table>

<?php else: //csv押したとき ?>

  <?= $this->Form->control('price', array('type'=>'hidden', 'value'=>$price, 'label'=>false)) ?>

<?php endif; ?>

<?= $this->Form->control('date_order', array('type'=>'hidden', 'value'=>$date_order, 'label'=>false)) ?>
<?= $this->Form->control('num_order', array('type'=>'hidden', 'value'=>$num_order, 'label'=>false)) ?>
<?= $this->Form->control('place_deliver_code', array('type'=>'hidden', 'value'=>$place_deliver_code, 'label'=>false)) ?>
<?= $this->Form->control('line_code', array('type'=>'hidden', 'value'=>$line_code, 'label'=>false)) ?>
<?= $this->Form->control('place_line', array('type'=>'hidden', 'value'=>$line_code, 'label'=>false)) ?>
<?= $this->Form->control('product_code', array('type'=>'hidden', 'value'=>$product_code, 'label'=>false)) ?>
<?= $this->Form->control('product_name', array('type'=>'hidden', 'value'=>$product_name, 'label'=>false)) ?>
<?= $this->Form->control('amount', array('type'=>'hidden', 'value'=>$amount, 'label'=>false)) ?>
<?= $this->Form->control('date_deliver', array('type'=>'hidden', 'value'=>$date_deliver, 'label'=>false)) ?>
<?= $this->Form->control('first_date_deliver', array('type'=>'hidden', 'value'=>$date_deliver, 'label'=>false)) ?>
<?= $this->Form->control('customer_code', array('type'=>'hidden', 'value'=>$customer_code, 'label'=>false)) ?>
    </fieldset>
    <table align="center" border="2" bordercolor="#E6FFFF" cellpadding="0" cellspacing="0">

      <?php if($line_code_check == 1): ?>
        <legend align="center"><font color="red"><?= __("環境依存文字「㈱」は使用できません。納入ラインを入力し直してください。") ?></font></legend>
        <tr>
          <td style="border-style: none;"><div align="center"><?= $this->Form->submit('戻る', ['onclick' => 'history.back()', 'type' => 'button']); ?></div></td>
      </tr>
      <?php else: //csv押したとき ?>
        <tr>
          <td style="border-style: none;"><div align="center"><?= $this->Form->submit('登録', array('name' => 'kakunin')); ?></div></td>
      </tr>
      <?php endif; ?>


  </table>
<br><br><br>
    <?= $this->Form->end() ?>
