<?php
 use App\myClass\Labelmenus\htmlLabelmenu;//myClassフォルダに配置したクラスを使用
 $htmlLabelmenu = new htmlLabelmenu();
 $htmlLabels = $htmlLabelmenu->Labelmenus();
 ?>
 <hr size="5" style="margin: 0.5rem">
 <table style="margin-bottom:0px" width="750" border="0" align="center" cellpadding="0" cellspacing="0" bordercolor="#CCCCCC">
 <?php
    echo $htmlLabels;
 ?>
 </table>
 <hr size="5" style="margin: 0.5rem">
<br>
<?php
 $htmlLabelLotsubmenu = new htmlLabelmenu();
 $htmlLabelhasulotmenus = $htmlLabelLotsubmenu->Labelhasulotmenus();
?>
 <table style="margin-bottom:0px" width="750" border="0" align="center" cellpadding="0" cellspacing="0" bordercolor="#CCCCCC">
 <?php
    echo $htmlLabelhasulotmenus;
 ?>
 </table>
    <?= $this->Flash->render() ?>
    <?= $this->Form->create($MotoLots, ['url' => ['action' => 'hasulotlogin']]) ?>
    <br>
     <div align="center"><font color="red" size="2"><?= __($mess) ?></font></div>
     <br>
    <legend align="center"><strong style="font-size: 11pt; color:blue"><?= __("端数登録　社員ID登録") ?></strong></legend>
    <fieldset>
<table align="center" border="2" bordercolor="#E6FFFF" cellpadding="0" cellspacing="0" style="border-bottom: solid;border-width: 1px">
  <tr>
    <td bgcolor="#FFFFCC" style="font-size: 12pt;"><strong style="font-size: 11pt; color:blue">社員ID</strong></td>
		<td bgcolor="#FFFFCC"><?= $this->Form->control('username', array('type'=>'text', 'label'=>false ,'autofocus'=>true)) ?></td>
	</tr>
</table>
    </fieldset>

    <table align="center" border="2" bordercolor="#E6FFFF" cellpadding="0" cellspacing="0">
    <tr>
    <td style="border-style: none;"><div align="center"><?= $this->Form->submit('登録', array('name' => 'login')); ?></div></td>
  </tr>
  </table>
<br>
    <?= $this->Form->end() ?>
