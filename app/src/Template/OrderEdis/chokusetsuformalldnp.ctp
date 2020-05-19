<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\User $user
 */

?>
<?php
 use App\myClass\EDImenus\htmlEDImenu;//myClassフォルダに配置したクラスを使用
 $htmlEDImenu = new htmlEDImenu();
 $htmlEDIs = $htmlEDImenu->EDImenus();

 $arrmikan = array('0'=>'分納（未了）','1'=>'完納（完了）');

 ?>
 <hr size="5" style="margin: 0.5rem">
 <table style="margin-bottom:0px" width="750" border="0" align="center" cellpadding="0" cellspacing="0" bordercolor="#CCCCCC">
 <?php
    echo $htmlEDIs;
 ?>
 </table>
 <hr size="5" style="margin: 0.5rem">
    <?= $this->Flash->render() ?>
    <?= $this->Form->create($orderEdis, ['url' => ['action' => 'chokusetsuconfirmdnp']]) ?>
    <fieldset>
      <table style="margin-bottom:0px" width="1000" border="0" align="center" cellpadding="0" cellspacing="0" bordercolor="#CCCCCC">
        <tr style="background-color: #E6FFFF">
          <td style="padding: 0.1rem 0.1rem; text-align: center"><a href="qr/index.php"><?php echo $this->Html->image('Labelimg/touroku_tyokusetsu.gif',array('width'=>'85','height'=>'36','url'=>array('controller'=>'OrderEdis','action'=>'chokusetsuformpro')));?></td>
        </tr>
      </table>
<br><br><br>
<table align="left" border="2" bordercolor="#E6FFFF" cellpadding="0" cellspacing="0" style="border-bottom: solid;border-width: 1px">
  <tr>
    <td width="270" bgcolor="#FFFFCC" style="font-size: 12pt;"><strong style="font-size: 11pt; color:blue">注文日付</strong></td>
    <td bgcolor="#FFFFCC" style="font-size: 12pt;"><strong style="font-size: 11pt; color:blue">注文No</strong></td>
	</tr>
  <tr>
    <td bgcolor="#FFFFCC"><?= $this->Form->input("date_order", array('type' => 'date', 'monthNames' => false, 'label'=>false)); ?></td>
    <td bgcolor="#FFFFCC"><?= $this->Form->control('num_order', array('type'=>'text', 'label'=>false)) ?></td>
	</tr>
</table>
<br><br><br><br><br><br><br>
<table align="left" border="2" bordercolor="#E6FFFF" cellpadding="0" cellspacing="0" style="border-bottom: solid;border-width: 1px">
  <tr>
    <td width="180" bgcolor="#FFFFCC" style="font-size: 12pt;"><strong style="font-size: 11pt; color:blue">品番</strong></td>
    <td width="180" bgcolor="#FFFFCC" style="font-size: 12pt;"><strong style="font-size: 11pt; color:blue">品名</strong></td>
    <td  width="70" bgcolor="#FFFFCC" style="font-size: 12pt;"><strong style="font-size: 11pt; color:blue">数量</strong></td>
    <td  width="270" bgcolor="#FFFFCC" style="font-size: 12pt;"><strong style="font-size: 11pt; color:blue">納期</strong></td>
    <td width="120" bgcolor="#FFFFCC" style="font-size: 12pt;"><strong style="font-size: 11pt; color:blue">完納未納</strong></td>
	</tr>
  <tr>
    <td bgcolor="#FFFFCC"><?= __($product_code) ?></td>
    <td bgcolor="#FFFFCC"><?= __($product_name) ?></td>
    <td bgcolor="#FFFFCC"><?= $this->Form->control('amount', array('type'=>'text', 'label'=>false)) ?></td>
    <td bgcolor="#FFFFCC"><?= $this->Form->input("date_deliver", array('type' => 'date', 'monthNames' => false, 'label'=>false)); ?></td>
    <td bgcolor="#FFFFCC"><?= $this->Form->input('kannou', ["type"=>"select", "options"=>$arrmikan, 'label'=>false]); ?></td>
	</tr>
</table>
<br><br><br><br><br><br><br>
<table align="left" border="2" bordercolor="#E6FFFF" cellpadding="0" cellspacing="0" style="border-bottom: solid;border-width: 1px">
  <tr>
    <td width="350" bgcolor="#FFFFCC" style="font-size: 12pt;"><strong style="font-size: 11pt; color:blue">注文品名</strong></td>
    <td  width="350" bgcolor="#FFFFCC" style="font-size: 12pt;"><strong style="font-size: 11pt; color:blue">内容コード</strong></td>
    <td bgcolor="#FFFFCC" style="font-size: 12pt;"><strong style="font-size: 11pt; color:blue">納入場所</strong></td>
	</tr>
  <tr>
    <td bgcolor="#FFFFCC"><?= $this->Form->control('pro_order', array('type'=>'text', 'label'=>false)) ?></td>
    <td bgcolor="#FFFFCC"><?= $this->Form->control('line_code', array('type'=>'text', 'label'=>false)) ?></td>
    <td bgcolor="#FFFFCC"><?= $this->Form->input('place_deliver', ["type"=>"select", "empty"=>"選択してください", "options"=>$arrPlaceDeliver, 'label'=>false]); ?></td>
	</tr>
</table>
<br><br>

<?= $this->Form->control('product_code', array('type'=>'hidden', 'value'=>$product_code, 'label'=>false)) ?>
<?= $this->Form->control('product_name', array('type'=>'hidden', 'value'=>$product_name, 'label'=>false)) ?>

    </fieldset>
    <table align="center" border="2" bordercolor="#E6FFFF" cellpadding="0" cellspacing="0">
    <tr>
      <td style="border-style: none;"><div align="center"><?= $this->Form->submit('登録確認', array('name' => 'kakunin')); ?></div></td>
  </tr>
  </table>
<br><br><br>
    <?= $this->Form->end() ?>
