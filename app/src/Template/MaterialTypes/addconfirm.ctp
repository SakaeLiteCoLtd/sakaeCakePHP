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
    <td style="padding: 0.1rem 0.1rem;"><a href="qr/index.php"><?php echo $this->Html->image('Labelimg/chokusoushinki.gif',array('width'=>'105','url'=>array('action'=>'addform')));?></td>
  </tr>
</table>
<hr size="5" style="margin: 0.5rem">

    <?= $this->Form->create($materialTypes, ['url' => ['action' => 'adddo']]) ?>
    <fieldset>

      <div align="center"><font color="black" size="3"><?= __("下のように登録します。よろしければ登録ボタンを押してください。") ?></font></div>
      <br>

<table align="center" border="2" bordercolor="#E6FFFF" cellpadding="0" cellspacing="0" style="border-bottom: solid;border-width: 1px">
  <tr>
    <td width="200" bgcolor="#FFFFCC" style="font-size: 8pt;padding: 0.2rem"><strong style="font-size: 11pt; color:blue">原料種類</strong></td>
	</tr>
  <tr>
    <td bgcolor="#FFFFCC"><?= h($name) ?></td>
	</tr>
</table>

    </fieldset>
    <table align="center" border="2" bordercolor="#E6FFFF" cellpadding="0" cellspacing="0">
      <tr bgcolor="#E6FFFF" >
        <td style="border-style: none;"><div align="center"><?= $this->Form->submit('戻る', ['onclick' => 'history.back()', 'type' => 'button']); ?></div></td>
        <td align="center" rowspan="2" width="30" bgcolor="#E6FFFF" style="border: none"><div align="center"><?= $this->Form->submit(__('登録'), array('name' => 'confirm', 'value'=>"1")); ?></div></td>
      </tr>
  </table>
<br>

<?= $this->Form->control('name', array('type'=>'hidden', 'value'=>$name, 'label'=>false)) ?>
