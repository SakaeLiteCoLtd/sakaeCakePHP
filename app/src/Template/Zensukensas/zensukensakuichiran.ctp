<?php
use App\myClass\Zensumenus\htmlzensumenu;//myClassフォルダに配置したクラスを使用
$htmlzensumenu = new htmlzensumenu();
$htmlzensus = $htmlzensumenu->zensumenus();
$htmlzensusubs = $htmlzensumenu->zensussubmenus();
 ?>
 <hr size="5" style="margin: 0.5rem">
 <table style="margin-bottom:0px" width="750" border="0" align="center" cellpadding="0" cellspacing="0" bordercolor="#CCCCCC">
 <?php
    echo $htmlzensus;
 ?>
 </table>
 <hr size="5" style="margin: 0.5rem">
    <?= $this->Flash->render() ?>
    <?= $this->Form->create($ResultZensuHeads, ['url' => ['action' => 'zensukensakuichiran']]) ?>
    <fieldset>
<br><br>
<table width="900"  align="center" border="2" bordercolor="#E6FFFF" cellpadding="0" cellspacing="0" style="border-bottom: solid;border-width: 1px">
  <tr>
    <td width="150" bgcolor="#FFFFCC" style="font-size: 12pt;"><strong style="font-size: 11pt; color:blue">検査員</strong></td>
    <td width="150" bgcolor="#FFFFCC" style="font-size: 12pt;"><strong style="font-size: 11pt; color:blue">品番</strong></td>
    <td width="150" colspan="2" bgcolor="#FFFFCC" style="text-align:right;font-size: 12pt;border-right-style: none"><strong style="font-size: 11pt; color:blue">検索日時の種類</strong></td>
    <td bgcolor="#FFFFCC" style="text-align:left;border-left-style: none"><?= h($Kensakuday) ?></td>
	</tr>
  <tr>
    <td bgcolor="#FFFFCC"><?= h($Staff) ?></td>
    <td bgcolor="#FFFFCC"><?= h($product_code) ?></td>
    <td  colspan="2" bgcolor="#FFFFCC" style="text-align:right;border-right-style: none"><?= h($datesta) ?><strong style="font-size: 9pt">　　～</strong></td>
    <td bgcolor="#FFFFCC" style="text-align:left;border-left-style: none"><?= h($datefin) ?></td>
	</tr>
</table>
<br><br>
<table align="center" border="2" bordercolor="#E6FFFF" cellpadding="0" cellspacing="0" style="border-bottom: solid;border-width: 1px">
  <tr>
    <td width="150" bgcolor="#FFFFCC" style="font-size: 12pt;"><strong style="font-size: 11pt; color:blue">内容</strong></td>
    <td width="150" colspan="2" bgcolor="#FFFFCC" style="font-size: 12pt;"><strong style="font-size: 11pt; color:blue">総数</strong></td>
    <td  width="200" bgcolor="#FFFFCC" style="font-size: 12pt;"><strong style="font-size: 11pt; color:blue">数量ゼロ</strong></td>
    <td  width="400" bgcolor="#FFFFCC" style="font-size: 12pt;"><strong style="font-size: 11pt; color:blue">備考</strong></td>
	</tr>
  <tr>
    <td  width="200" bgcolor="#FFFFCC"><?= h($ContRejection) ?></td>
    <td width="80"  bgcolor="#FFFFCC" style="text-align:right;border-right-style: none"><?= h($amount) ?></td>
    <td width="80"  bgcolor="#FFFFCC" style="text-align:left;border-left-style: none"><strong style="font-size: 8pt; color:blue">ヶ以上</strong></td>
    <td width="200"  bgcolor="#FFFFCC"><?= h($check) ?></td>
    <td bgcolor="#FFFFCC"><?= h($bik) ?></td>
	</tr>
</table>

    </fieldset>
    <table align="center" border="2" bordercolor="#E6FFFF" cellpadding="0" cellspacing="0">
    <tr>
      <td style="border-style: none;"><div align="center"><?= $this->Form->submit('csv出力', array('name' => 'csv')); ?></div></td>
  </tr>
  </table>
<br><br><br>
    <?= $this->Form->end() ?>
