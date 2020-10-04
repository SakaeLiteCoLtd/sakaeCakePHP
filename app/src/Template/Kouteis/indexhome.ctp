<?php
 use App\myClass\Syukkakensa\htmlSyukkakensamenu;//myClassフォルダに配置したクラスを使用
 $htmlSyukkakensamenu = new htmlSyukkakensamenu();
 $htmlKouteismenus = $htmlSyukkakensamenu->Kouteismenu();
 ?>
 <hr size="5" style="margin: 0.5rem">
 <table style="margin-bottom:0px" width="750" border="0" align="center" cellpadding="0" cellspacing="0" bordercolor="#CCCCCC">
 <?php
    echo $htmlKouteismenus;
 ?>
 </table>
 <hr size="5" style="margin: 0.5rem">

<?= $this->Form->create($KouteiKensahyouHeads, ['url' => ['action' => 'torikomi']]) ?>
<fieldset>

<table width="600" border="1" align="center" bordercolor="#000000" bgcolor="#FFDEAD">
    <tbody border="2" bordercolor="#E6FFFF" bgcolor="#FFFFCC">
    <tr>
      <td width="450" nowrap="nowrap" style="border-bottom: solid;border-width: 1px"><div align="center"><strong><font color="blue" size="4">ＩＭデータ取り込み</font></strong></div></td>
      <td nowrap="nowrap" style="border-bottom: solid;border-width: 1px"><?= $this->Form->submit(__('ＩＭデータ取り込み'), array('name' => 'top')) ?></td>
    </tr>
</table>
<br>
<br>

</fieldset>
