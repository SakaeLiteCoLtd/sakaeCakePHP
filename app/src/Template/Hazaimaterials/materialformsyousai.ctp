<?php
 use App\myClass\Genryoumenu\htmlGenryoumenu;//myClassフォルダに配置したクラスを使用
 $htmlGenryoumenu = new htmlGenryoumenu();
 $htmlGenryou = $htmlGenryoumenu->Genryoumenus();

 if(!isset($_SESSION)){
   session_start();
   header('Expires:-1');
   header('Cache-Control:');
   header('Pragma:');
 }

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
     <td style="padding: 0.1rem 0.1rem;"><a href="qr/index.php"><?php echo $this->Html->image('Labelimg/hazaigenryou.gif',array('width'=>'105','url'=>array('action'=>'materialmenu')));?></td>
 </tr>
</table>
<hr size="5" style="margin: 0.5rem">
<br><br>
<?= $this->Form->create($stockEndMaterials, ['url' => ['action' => 'materialconfirm']]) ?>

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
    <td width="282" bgcolor="#FFFFCC" style="font-size: 8pt;padding: 0.2rem"><strong style="font-size: 11pt; color:blue">グレード</strong></td>
	</tr>
  <tr>
    <td bgcolor="#FFFFCC" style="padding: 0.2rem">
      <?= h($grade) ?>
    </td>
	</tr>
</table>
<br>
<table align="center" border="2" bordercolor="#E6FFFF" cellpadding="0" cellspacing="0" style="border-bottom: solid;border-width: 1px">
  <tr>
    <td width="282" bgcolor="#FFFFCC" style="font-size: 8pt;padding: 0.2rem"><strong style="font-size: 11pt; color:blue">色</strong></td>
	</tr>
  <tr>
    <td bgcolor="#FFFFCC" style="padding: 0.2rem">
      <?= h($color) ?>
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
      <?= $this->Form->input("status_material", ["type"=>"select", "options"=>$arrStatusMaterial, 'label'=>false, 'required'=>true]) ?>
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
      <?= $this->Form->control('amount', array('type'=>'text', 'label'=>false, 'pattern'=>'^[0-9.]+$', 'title'=>'半角数字で入力して下さい。', 'required'=>true)) ?>
    </td>
	</tr>
</table>
<br>

<table align="center" border="2" bordercolor="#E6FFFF" cellpadding="0" cellspacing="0">
  <tr>
    <td style="border-style: none;"><div align="center"><?= $this->Form->submit('次へ', array('name' => 'next')); ?></div></td>
  </tr>
</table>
<br><br><br><br><br><br><br>
<?= $this->Form->control('username', array('type'=>'hidden', 'value'=>$username, 'label'=>false)) ?>
<?= $this->Form->control('staff_name', array('type'=>'hidden', 'value'=>$staff_name, 'label'=>false)) ?>
<?= $this->Form->control('grade', array('type'=>'hidden', 'value'=>$grade, 'label'=>false)) ?>
<?= $this->Form->control('color', array('type'=>'hidden', 'value'=>$color, 'label'=>false)) ?>
<?= $this->Form->control('price_material_id', array('type'=>'hidden', 'value'=>$price_material_id, 'label'=>false)) ?>
