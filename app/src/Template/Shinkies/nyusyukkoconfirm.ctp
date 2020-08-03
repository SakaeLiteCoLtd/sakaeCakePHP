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
  <td style="padding: 0.1rem 0.1rem;"><a href="qr/index.php"><?php echo $this->Html->image('Labelimg/label_touroku.gif',array('width'=>'85','height'=>'36','url'=>array('action'=>'nyusyukkoform')));?></td>
  <td style="padding: 0.1rem 0.1rem;"><a href="qr/index.php"><?php echo $this->Html->image('Labelimg/subYobidashi.gif',array('width'=>'85','height'=>'36','url'=>array('action'=>'nyusyukkoyobidashi')));?></td>
</tr>
</table>
<hr size="5" style="margin: 0.5rem">

<?php
if($this->request->getData('flag') == 1){
  $flag = "有";
}else{
  $flag = "無";
}
?>

    <?= $this->Form->create($outsourceHandys, ['url' => ['action' => 'nyusyukkodo']]) ?>
    <fieldset>
      <table align="center" border="2" bordercolor="#E6FFFF" cellpadding="0" cellspacing="0" style="border-bottom: solid;border-width: 1px">
              <tbody border="2" bordercolor="#E6FFFF" bgcolor="#FFFFCC">
                <td><div align="center"><strong style="font-size: 12pt; color:blue">会社名</strong></div></td>
                <td style="border-left-style: none;"><div align="center"><strong style="font-size: 12pt; color:blue">ハンディ表示名</strong></div></td>
              <tbody border="2" bordercolor="#E6FFFF" bgcolor="#FFFFCC">
                <td><?= h($this->request->getData('sup_name')) ?></td>
            		<td style="border-left-style: none;"><?= h($this->request->getData('handy_name')) ?></td>
              <tbody border="2" bordercolor="#E6FFFF" bgcolor="#FFFFCC">
                <td colspan="2"><div align="center"><strong style="font-size: 12pt; color:blue">住所</strong></div></td>
              <tbody border="2" bordercolor="#E6FFFF" bgcolor="#FFFFCC">
                <td colspan="2"><?= h($this->request->getData('address')) ?></td>
      </table>
      <br>
      <table align="center" border="2" bordercolor="#E6FFFF" cellpadding="0" cellspacing="0" style="border-bottom: solid;border-width: 1px">
        <tr>
        <td width="100" bgcolor="#FFFFCC" style="font-size: 12pt;padding: 0.2rem"><strong style="font-size: 11pt; color:blue">仕入伝票発行</strong></td>
      </tr>
      <tr>
        <td width="100"  bgcolor="#FFFFCC" style="padding: 0.2rem"><?= h($flag)?></td>
      </tr>
      </table>

      <br>
    <table align="center" border="2" bordercolor="#E6FFFF" cellpadding="0" cellspacing="0">
    <tr>
      <td style="border-style: none;"><div align="center"><?= $this->Form->submit(__('登録'), array('name' => 'kakunin')); ?></div></td>
    </tr>
  </table>

  <?= $this->Form->control('sup_name', array('type'=>'hidden', 'value'=>$this->request->getData('sup_name'), 'label'=>false)) ?>
  <?= $this->Form->control('handy_name', array('type'=>'hidden', 'value'=>$this->request->getData('handy_name'), 'label'=>false)) ?>
  <?= $this->Form->control('address', array('type'=>'hidden', 'value'=>$this->request->getData('address'), 'label'=>false)) ?>
  <?= $this->Form->control('flag', array('type'=>'hidden', 'value'=>$this->request->getData('flag'), 'label'=>false)) ?>

<br>
