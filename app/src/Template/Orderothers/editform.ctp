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
    <?= $this->Form->create($OrderSpecials, ['url' => ['action' => 'editconfirm']]) ?>
    <fieldset>
      <table style="margin-bottom:0px" border="0" align="center" cellpadding="0" cellspacing="0" bordercolor="#CCCCCC">
        <tr style="background-color: #E6FFFF">
          <td style="padding: 0.1rem 0.1rem; text-align: center"><a href="qr/index.php"><?php echo $this->Html->image('Labelimg/subYobidashi.gif',array('width'=>'85','height'=>'36','url'=>array('action'=>'kensakuform')));?></td>
        </tr>
      </table>
<br><br>
<table width="1000" align="center" border="2" bordercolor="#E6FFFF" cellpadding="0" cellspacing="0" style="border-bottom: solid;border-width: 1px">
  <tr>
    <td width="250" bgcolor="#FFFFCC" style="font-size: 12pt;"><strong style="font-size: 11pt; color:blue">注文日付</strong></td>
    <td width="230" bgcolor="#FFFFCC" style="font-size: 12pt;"><strong style="font-size: 11pt; color:blue">注文NO(無ければ任意の英数字)</strong></td>
    <td bgcolor="#FFFFCC" style="font-size: 12pt;"><strong style="font-size: 11pt; color:blue">発注元顧客</strong></td>
    <td width="60" bgcolor="#FFFFCC" style="font-size: 12pt;"><strong style="font-size: 11pt; color:blue">状況</strong></td>
	</tr>
  <tr>
    <td bgcolor="#FFFFCC"><?= $this->Form->input("date_order", array('type' => 'date', 'monthNames' => false, 'value'=>$date_order, 'label'=>false)); ?></td>
    <td bgcolor="#FFFFCC"><?= $this->Form->control('num_order', array('type'=>'text', 'label'=>false, 'value'=>$num_order, 'required'=>true)) ?></td>
    <td bgcolor="#FFFFCC"><?= $this->Form->input('cs_id', ["type"=>"select", "empty"=>"選択してください", "options"=>$arrCustomers, 'value'=>$cs_id, 'label'=>false, 'required'=>true]); ?></td>
    <td bgcolor="#FFFFCC"><?= $this->Form->input('kannou', ["type"=>"select", "options"=>$arrkannou, 'value'=>$kannou, 'label'=>false, 'required'=>true]); ?></td>
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
    <td bgcolor="#FFFFCC"><?= $this->Form->control('order_name', array('type'=>'text', 'label'=>false, 'value'=>$order_name, 'required'=>true)) ?></td>
    <td bgcolor="#FFFFCC"><?= $this->Form->input('element_id', ["type"=>"select", "options"=>$arrElements, 'value'=>$element_id, 'label'=>false, 'required'=>true]); ?></td>
    <td bgcolor="#FFFFCC"><?= $this->Form->control('price', array('type'=>'text', 'value'=>$price, 'label'=>false)) ?></td>
    <td bgcolor="#FFFFCC"><?= $this->Form->control('amount', array('type'=>'text', 'value'=>$amount, 'label'=>false, 'required'=>true)) ?></td>
    <td bgcolor="#FFFFCC"><?= $this->Form->input("date_deliver", array('type' => 'date', 'monthNames' => false, 'value'=>$date_deliver, 'label'=>false)); ?></td>
	</tr>
</table>
<br>
<table align="center">
<tbody>
  <tr>
    <td><?= $this->Form->control('check', array('type'=>'checkbox', 'label'=>false)) ?></td>
    <td><div><strong style="font-size: 11pt; color:blue">データを削除する場合はチェックを入れてください。</strong></div></td>
  </tr>
</tbody>
</table>
<br>
    <table align="center" border="2" bordercolor="#E6FFFF" cellpadding="0" cellspacing="0">
    <tr>
      <td style="border-style: none;"><div align="center"><?= $this->Form->submit('変更確認', array('name' => 'kakunin')); ?></div></td>
  </tr>
  </table>
</fieldset>

<?= $this->Form->control('Id', array('type'=>'hidden', 'value'=>$Id, 'label'=>false)) ?>

<br><br><br>
    <?= $this->Form->end() ?>
