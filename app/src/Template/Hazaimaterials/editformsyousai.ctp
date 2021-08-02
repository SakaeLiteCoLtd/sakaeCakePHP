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
   <td style="padding: 0.1rem 0.1rem;"><a href="qr/index.php"><?php echo $this->Html->image('Labelimg/hazaisyuusei.gif',array('width'=>'105','url'=>array('action'=>'editpreadd')));?></td>
 </tr>
</table>
<hr size="5" style="margin: 0.5rem">
<?= $this->Form->create($stockEndMaterials, ['url' => ['action' => 'editconfirm']]) ?>
<br>
<div align="center"><font color="red" size="3"><?= __($mess) ?></font></div>
<legend align="center"><font color="black"><?= __("修正してください。") ?></font></legend>
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
    <td width="200" bgcolor="#FFFFCC" style="font-size: 8pt;padding: 0.2rem"><strong style="font-size: 11pt; color:blue">端材</strong></td>
    <td width="180" bgcolor="#FFFFCC" style="font-size: 8pt;padding: 0.2rem"><strong style="font-size: 11pt; color:blue">品番</strong></td>
    <td width="150" bgcolor="#FFFFCC" style="font-size: 8pt;padding: 0.2rem"><strong style="font-size: 11pt; color:blue">ロットNo.</strong></td>
    <td width="100" bgcolor="#FFFFCC" style="font-size: 8pt;padding: 0.2rem"><strong style="font-size: 11pt; color:blue">数量（kg）</strong></td>
    <td width="100" bgcolor="#FFFFCC" style="font-size: 8pt;padding: 0.2rem"><strong style="font-size: 11pt; color:blue">使用状況</strong></td>
	</tr>
  <tr>
    <td bgcolor="#FFFFCC" style="padding: 0.2rem">
      <?= h($materialgrade_color) ?>
    </td>
    <td bgcolor="#FFFFCC" style="padding: 0.2rem">
      <?= h($StockEndMaterialData["product_code"]) ?>
    </td>
    <td bgcolor="#FFFFCC" style="padding: 0.2rem">
      <?= h($StockEndMaterialData["lot_num"]) ?>
    </td>
    <td bgcolor="#FFFFCC" style="padding: 0.2rem">
      <?= $this->Form->control('amount', array('type'=>'text', 'value'=>$StockEndMaterialData["amount"], 'label'=>false, 'pattern'=>'^[0-9.]+$', 'title'=>'半角数字で入力して下さい。', 'required'=>true)) ?>
    </td>
    <td bgcolor="#FFFFCC" style="padding: 0.2rem">

      <?php if ($shippedflag == 0): ?>

        <select name="shippedflag">
          <option value="0" selected>未使用</option>
          <option value="1">使用済</option>
        </select>

    <?php else : ?>

      <select name="shippedflag">
        <option value="0">未使用</option>
        <option value="1" selected>使用済</option>
      </select>

    <?php endif; ?>

    </td>
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
    <td style="border-style: none;"><div align="center"><?= $this->Form->submit('確認', array('name' => 'next')); ?></div></td>
  </tr>
</table>
<br><br><br><br><br><br><br>
<?= $this->Form->control('username', array('type'=>'hidden', 'value'=>$username, 'label'=>false)) ?>
<?= $this->Form->control('staff_name', array('type'=>'hidden', 'value'=>$staff_name, 'label'=>false)) ?>
<?= $this->Form->control('materialgrade_color', array('type'=>'hidden', 'value'=>$materialgrade_color, 'label'=>false)) ?>
<?= $this->Form->control('product_code', array('type'=>'hidden', 'value'=>$StockEndMaterialData["product_code"], 'label'=>false)) ?>
<?= $this->Form->control('lot_num', array('type'=>'hidden', 'value'=>$StockEndMaterialData["lot_num"], 'label'=>false)) ?>
<?= $this->Form->control('StockEndMaterialsId', array('type'=>'hidden', 'value'=>$StockEndMaterialsId, 'label'=>false)) ?>
