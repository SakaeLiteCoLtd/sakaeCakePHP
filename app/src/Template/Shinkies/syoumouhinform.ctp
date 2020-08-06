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
  <td style="padding: 0.1rem 0.1rem;"><a href="qr/index.php"><?php echo $this->Html->image('Labelimg/label_touroku.gif',array('width'=>'85','height'=>'36','url'=>array('action'=>'syoumouhinform')));?></td>
  <td style="padding: 0.1rem 0.1rem;"><a href="qr/index.php"><?php echo $this->Html->image('Labelimg/subYobidashi.gif',array('width'=>'85','height'=>'36','url'=>array('action'=>'syoumouhinyobidashi')));?></td>
</tr>
</table>
<hr size="5" style="margin: 0.5rem">

    <?= $this->Form->create($syoumouSuppliers, ['url' => ['action' => 'syoumouhinconfirm']]) ?>
    <fieldset>
      <table align="center" border="2" bordercolor="#E6FFFF" cellpadding="0" cellspacing="0" style="border-bottom: solid;border-width: 1px">
        <tr>
        <td width="500" bgcolor="#FFFFCC" style="font-size: 12pt;padding: 0.2rem"><strong style="font-size: 11pt; color:blue">業者名</strong></td>
      </tr>
      <tr>
        <td  width="500" bgcolor="#FFFFCC"><?= $this->Form->control('name', array('type'=>'text', 'label'=>false, 'autofocus'=>true)) ?></td>
      </tr>
      </table>
      <table align="center" border="2" bordercolor="#E6FFFF" cellpadding="0" cellspacing="0" style="border-bottom: solid;border-width: 1px">
        <tr>
        <td width="500" bgcolor="#FFFFCC" style="font-size: 12pt;padding: 0.2rem"><strong style="font-size: 11pt; color:blue">ふりがな（ひらがなで入力してください）</strong></td>
      </tr>
      <tr>
        <td  width="500" bgcolor="#FFFFCC"><?= $this->Form->control('furigana', array('type'=>'text', 'label'=>false)) ?></td>
      </tr>
      </table>
      <br>
      <table align="center" border="2" bordercolor="#E6FFFF" cellpadding="0" cellspacing="0" style="border-bottom: solid;border-width: 1px">
        <tr>
        <td width="200" bgcolor="#FFFFCC" style="font-size: 12pt;padding: 0.2rem"><strong style="font-size: 11pt; color:blue">税込・税別</strong></td>
      </tr>
      <tr>
        <td width="200"  bgcolor="#FFFFCC" style="padding: 0.2rem"><?= $this->Form->input("tax_include", ["type"=>"select","options"=>$arrTax, 'label'=>false]) ?></td>
      </tr>
      </table>

      <br>
    <table align="center" border="2" bordercolor="#E6FFFF" cellpadding="0" cellspacing="0">
    <tr>
      <td style="border-style: none;"><div align="center"><?= $this->Form->submit(__('確認'), array('name' => 'kakunin')); ?></div></td>
    </tr>
  </table>
<br>
