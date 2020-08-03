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

    <?= $this->Form->create($outsourceHandys, ['url' => ['action' => 'nyusyukkoconfirm']]) ?>
    <fieldset>
      <table align="center" border="2" bordercolor="#E6FFFF" cellpadding="0" cellspacing="0" style="border-bottom: solid;border-width: 1px">
              <tbody border="2" bordercolor="#E6FFFF" bgcolor="#FFFFCC">
                <td><div align="center"><strong style="font-size: 12pt; color:blue">会社名</strong></div></td>
                <td style="border-left-style: none;"><div align="center"><strong style="font-size: 12pt; color:blue">ハンディ表示名</strong></div></td>
              <tbody border="2" bordercolor="#E6FFFF" bgcolor="#FFFFCC">
                <td><?= $this->Form->input("sup_name", array('type' => 'value', 'label'=>false)); ?></td>
            		<td style="border-left-style: none;"><?= $this->Form->input("handy_name", array('type' => 'value', 'label'=>false)); ?></td>
              <tbody border="2" bordercolor="#E6FFFF" bgcolor="#FFFFCC">
                <td colspan="2"><div align="center"><strong style="font-size: 12pt; color:blue">住所</strong></div></td>
              <tbody border="2" bordercolor="#E6FFFF" bgcolor="#FFFFCC">
                <td colspan="2"><?= $this->Form->input("address", array('type' => 'value', 'label'=>false, 'size' => '50')); ?></td>
      </table>
      <br>
      <table align="center" border="2" bordercolor="#E6FFFF" cellpadding="0" cellspacing="0" style="border-bottom: solid;border-width: 1px">
        <tr>
        <td width="100" bgcolor="#FFFFCC" style="font-size: 12pt;padding: 0.2rem"><strong style="font-size: 11pt; color:blue">仕入伝票発行</strong></td>
      </tr>
      <tr>
        <td width="100"  bgcolor="#FFFFCC" style="padding: 0.2rem"><?= $this->Form->input("flag", ["type"=>"select","options"=>$arrDenpyou, 'label'=>false]) ?></td>
      </tr>
      </table>


      <br>
    <table align="center" border="2" bordercolor="#E6FFFF" cellpadding="0" cellspacing="0">
    <tr>
      <td style="border-style: none;"><div align="center"><?= $this->Form->submit(__('確認'), array('name' => 'kakunin')); ?></div></td>
    </tr>
  </table>
<br>
