<?php
 use App\myClass\Syukkakensa\htmlSyukkakensamenu;//myClassフォルダに配置したクラスを使用
 $htmlSyukkakensamenu = new htmlSyukkakensamenu();
 $htmlSyukkakensamenus = $htmlSyukkakensamenu->Syukkakensamenu();
 ?>
 <hr size="5" style="margin: 0.5rem">
 <table style="margin-bottom:0px" width="750" border="0" align="center" cellpadding="0" cellspacing="0" bordercolor="#CCCCCC">
 <?php
    echo $htmlSyukkakensamenus;
 ?>
 </table>
 <hr size="5" style="margin: 0.5rem">

<?= $this->Form->create($product, ['url' => ['action' => 'ichiran']]) ?>
<fieldset>

<?php
$date = date('Y-m-d');
$dateto = strtotime($date);
$dateto = date('Y-m-d', strtotime('+1 day', $dateto));
?>

<br>
 <div align="center"><font color="red" size="2"><?= __($mess) ?></font></div>
 <br>

<table align="center" border="2" bordercolor="#E6FFFF" cellpadding="0" cellspacing="0" style="border-bottom: solid;border-width: 1px">
  <tr>
    <td width="280" bgcolor="#FFFFCC" style="font-size: 8pt;padding: 0.2rem"><strong style="font-size: 11pt; color:blue">納期</strong></td>
    <td width="282" bgcolor="#FFFFCC" style="font-size: 8pt;padding: 0.2rem"><strong style="font-size: 11pt; color:blue">顧客</strong></td>
	</tr>
  <tr>
    <td width="280"  bgcolor="#FFFFCC" style="padding: 0.2rem"><div align="center"><?= $this->Form->input("date_deliver", array('type' => 'date', 'value' => $dateto, 'monthNames' => false, 'label'=>false)); ?></div></td>
    <td width="280"  bgcolor="#FFFFCC" style="padding: 0.2rem"><?= $this->Form->input("field", ["type"=>"select", "options"=>$field, 'label'=>false, 'required'=>true]) ?></td>
	</tr>
</table>

    </fieldset>
    <table align="center" border="2" bordercolor="#E6FFFF" cellpadding="0" cellspacing="0">
    <tr>
      <td style="border-style: none;"><div align="center"><?= $this->Form->submit(__('呼出'), array('name' => 'yobidashi')); ?></div></td>
    </tr>
  </table>
<br>
