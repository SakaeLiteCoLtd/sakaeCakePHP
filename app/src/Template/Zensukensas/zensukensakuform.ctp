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

<table width="1000"  align="center" border="2" bordercolor="#E6FFFF" cellpadding="0" cellspacing="0" style="border-bottom: solid;border-width: 1px">
  <tr>
    <td width="200" bgcolor="#FFFFCC" style="font-size: 12pt;"><strong style="font-size: 11pt; color:blue">検査員</strong></td>
    <td width="200" bgcolor="#FFFFCC" style="font-size: 12pt;"><strong style="font-size: 11pt; color:blue">品番</strong></td>
    <td colspan="2" bgcolor="#FFFFCC" style="text-align:right;font-size: 12pt;border-right-style: none"><strong style="font-size: 11pt; color:blue">検索日時の種類</strong></td>
    <td bgcolor="#FFFFCC" style="border-right-style: none;border-left-style: none"><?= $this->Form->input('Kensakuday', ["type"=>"select", "options"=>$arrKensakuday, 'label'=>false, 'width'=>200]); ?></td>
    <td bgcolor="#FFFFCC"  width="100" style="border-left-style: none"></td>
	</tr>
  <tr>
    <td bgcolor="#FFFFCC"><?= $this->Form->input('staff', ["type"=>"select", "options"=>$arrStaff, 'label'=>false]); ?></td>
    <td bgcolor="#FFFFCC"><?= $this->Form->input('product', array('type'=>'text', 'label'=>false)) ?></td>
    <td  colspan="2" bgcolor="#FFFFCC" style="border-right-style: none"><?= $this->Form->input('datesta', array('type'=>'datetime', 'monthNames' => false, 'value' => $dateTo, 'label'=>false)) ?></td>
    <td  colspan="2" bgcolor="#FFFFCC" style="border-left-style: none"><?= $this->Form->input('datefin', array('type'=>'datetime', 'monthNames' => false, 'value' => $dateTomo, 'label'=>false)) ?></td>
	</tr>
</table>
<br><br>
<table align="center" border="2" bordercolor="#E6FFFF" cellpadding="0" cellspacing="0" style="border-bottom: solid;border-width: 1px">
  <tr>
    <td width="200" bgcolor="#FFFFCC" style="font-size: 12pt;"><strong style="font-size: 11pt; color:blue">内容</strong></td>
    <td width="200" colspan="2" bgcolor="#FFFFCC" style="font-size: 12pt;"><strong style="font-size: 11pt; color:blue">総数</strong></td>
    <td  width="200" colspan="4" bgcolor="#FFFFCC" style="font-size: 12pt;"><strong style="font-size: 11pt; color:blue">数量ゼロ</strong></td>
    <td  width="200" bgcolor="#FFFFCC" style="font-size: 12pt;"><strong style="font-size: 11pt; color:blue">備考</strong></td>
	</tr>
  <tr>
    <td  width="200" bgcolor="#FFFFCC"><?= $this->Form->input('ContRejection', ["type"=>"select", "options"=>$arrContRejection, 'label'=>false]); ?></td>
    <td width="170"  bgcolor="#FFFFCC" style="border-right-style: none"><?= $this->Form->control('amount', array('type'=>'text', 'label'=>false)) ?></td>
    <td width="80"  bgcolor="#FFFFCC" style="border-left-style: none;text-align:left"><strong style="font-size: 8pt; color:blue">ヶ以上</strong></td>
    <td width="30"  bgcolor="#FFFFCC" style="border-right-style: none"></td>
    <td width="30"  bgcolor="#FFFFCC" style="border-left-style: none;border-right-style: none"><?= $this->Form->control('check', array('type'=>'checkbox', 'label'=>false)) ?></td>
    <td width="200"  bgcolor="#FFFFCC" style="border-left-style: none;border-right-style: none"><strong style="font-size: 11pt">不良登録ゼロを除く</strong></td>
    <td width="30"  bgcolor="#FFFFCC" style="border-left-style: none"></td>
    <td width="240" bgcolor="#FFFFCC"><?= $this->Form->input("bik", array('type' => 'text', 'label'=>false)); ?></td>
	</tr>
</table>

    </fieldset>
    <table align="center" border="2" bordercolor="#E6FFFF" cellpadding="0" cellspacing="0">
    <tr>
      <td style="border-style: none;"><div align="center"><?= $this->Form->submit('呼出', array('name' => 'yobidasi')); ?></div></td>
  </tr>
  </table>
<br><br><br>
    <?= $this->Form->end() ?>
