<?php
$this->layout = 'defaultshinki';
?>
<?php
 use App\myClass\Shinkimenus\htmlShinkimenu;//myClassフォルダに配置したクラスを使用

 $htmlShinkimenu = new htmlShinkimenu();
 $htmlShinkis = $htmlShinkimenu->Shinkimenus();
?>
<?php
  $username = $this->request->Session()->read('Auth.User.username');

  header('Expires:-1');
  header('Cache-Control:');
  header('Pragma:');
  echo $this->Form->create($user, ['url' => ['action' => 'editdo']]);
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
    <td style="padding: 0.1rem 0.1rem;"><?php echo $this->Html->image('Labelimg/chokusouhensyuu.gif',array('width'=>'105'));?></td>
  </tr>
</table>
<hr size="5" style="margin: 0.5rem">
<br>
<legend align="center"><font color="black"><?= __("検査外注製品更新") ?></legend>
  <br>
  <legend align="center"><font color="red"><?= __($mess) ?></legend>
  <br>
<table align="center" border="2" bordercolor="#E6FFFF" cellpadding="0" cellspacing="0">
  <tbody border="2" bordercolor="#E6FFFF" bgcolor="#FFFFCC" style="border-bottom: solid;border-width: 1px">
    <tr style="border-bottom: 0px;border-width: 0px">
      <td width="200"><div align="center"><strong style="font-size: 13pt; color:blue">品番</strong></div></td>
      <td width="200"><div align="center"><strong style="font-size: 13pt; color:blue">品名</strong></div></td>
      <td width="200"><div align="center"><strong style="font-size: 13pt; color:blue">仕入先</strong></div></td>
    </tr>
    <tr style="border-bottom: 0px;border-width: 0px">
      <td bgcolor="#FFFFCC"><?= h($product_code) ?></td>
      <td bgcolor="#FFFFCC"><?= h($product_name) ?></td>
      <td bgcolor="#FFFFCC"><?= h($outsource_handy_name) ?></td>
    </tr>
  </table>

  <?= $this->Form->control('NonKadouSeikeisId', array('type'=>'hidden', 'value'=>$NonKadouSeikeisId, 'label'=>false)) ?>
  <?= $this->Form->control('product_code', array('type'=>'hidden', 'value'=>$product_code, 'label'=>false)) ?>
  <?= $this->Form->control('product_name', array('type'=>'hidden', 'value'=>$product_name, 'label'=>false)) ?>
  <?= $this->Form->control('outsource_handy_id', array('type'=>'hidden', 'value'=>$outsource_handy_id, 'label'=>false)) ?>
  <?= $this->Form->control('check', array('type'=>'hidden', 'value'=>$check, 'label'=>false)) ?>
  <br>
  <table align="center" border="2" bordercolor="#E6FFFF" cellpadding="0" cellspacing="0">
    <tr bgcolor="#E6FFFF" >
      <td style="border-style: none;"><div align="center"><?= $this->Form->submit('戻る', ['onclick' => 'history.back()', 'type' => 'button']); ?></div></td>
      <td align="center" rowspan="2" width="30" bgcolor="#E6FFFF" style="border: none"><div align="center"><?= $this->Form->submit(__('決定'), array('name' => 'confirm', 'value'=>"1")); ?></div></td>
    </tr>
  </table>

  <br><br><br>
