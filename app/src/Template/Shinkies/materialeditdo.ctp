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
<table style="margin-bottom:0px" width="500" border="0" align="center" cellpadding="0" cellspacing="0" bordercolor="#CCCCCC">
  <tr style="background-color: #E6FFFF">
    <td style="padding: 0.1rem 0.1rem;"><a href="qr/index.php"><?php echo $this->Html->image('Labelimg/genryouedit.gif',array('width'=>'105','url'=>array('action'=>'materialeditkensaku')));?></td>
  </tr>
</table>
<hr size="5" style="margin: 0.5rem">

    <?= $this->Form->create($priceMaterials, ['url' => ['action' => 'materialsform']]) ?>
    <fieldset>

      <br>
      <div align="center"><font color="black" size="3"><?= __($mess) ?></font></div>
      <br>

      <table align="center" border="2" bordercolor="#E6FFFF" cellpadding="0" cellspacing="0" style="border-bottom: solid;border-width: 1px">
        <tr>
          <td width="280" bgcolor="#FFFFCC" style="font-size: 8pt;padding: 0.2rem"><strong style="font-size: 11pt; color:blue">グレード</strong></td>
          <td width="282" bgcolor="#FFFFCC" style="font-size: 8pt;padding: 0.2rem"><strong style="font-size: 11pt; color:blue">色番号</strong></td>
      	</tr>
        <tr>
          <td bgcolor="#FFFFCC" style="padding: 0.2rem"><?= h($grade) ?></td>
          <td bgcolor="#FFFFCC" style="padding: 0.2rem"><?= h($color) ?></td>
      	</tr>
      </table>
      <br>
      <table align="center" border="2" bordercolor="#E6FFFF" cellpadding="0" cellspacing="0" style="border-bottom: solid;border-width: 1px">
        <tr>
          <td width="280" colspan="2" bgcolor="#FFFFCC" style="font-size: 12pt;padding: 0.2rem"><strong style="font-size: 11pt; color:blue">単価（円/kg）</strong></td>
          <td width="280" bgcolor="#FFFFCC" style="font-size: 12pt;padding: 0.2rem"><strong style="font-size: 11pt; color:blue">原料サプライヤー</strong></td>
      	</tr>
        <tr>
          <td width="220" bgcolor="#FFFFCC" style="border-right-style: none;padding: 0.2rem"><?= h($price) ?></td>
          <td width="62" bgcolor="#FFFFCC" style="border-left-style: none;padding: 0.2rem"><strong style="font-size: 11pt; color:blue">円/kg</strong></td>
          <td width="280"  bgcolor="#FFFFCC" style="padding: 0.2rem"><?= h($sup_name) ?></td>
      	</tr>
      </table>

    </fieldset>
    <table align="center" border="2" bordercolor="#E6FFFF" cellpadding="0" cellspacing="0">
    <tr>
      <td style="border-style: none;"><div align="center"><?= $this->Form->submit(__('TOP'), array('name' => 'kakunin')); ?></div></td>
    </tr>
  </table>
<br>
