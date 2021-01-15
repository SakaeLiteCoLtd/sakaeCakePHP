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

<table style="margin-bottom:0px" width="750" border="0" align="center" cellpadding="0" cellspacing="0" bordercolor="#CCCCCC">
   <tr style="background-color: #E6FFFF">
     <td bgcolor="#E6FFFF"><strong style="font-size: 11pt; color:red"><?= h($mes) ?></strong></td>
   </tr>
 </table>
 <br>

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
    <td  width="340" bgcolor="#FFFFCC" style="font-size: 12pt;"><strong style="font-size: 11pt; color:blue">備考</strong></td>
	</tr>
  <tr>
    <td  width="200" bgcolor="#FFFFCC"><?= h($ContRejection) ?></td>
    <td width="80"  bgcolor="#FFFFCC" style="text-align:right;border-right-style: none"><?= h($amount) ?></td>
    <td width="80"  bgcolor="#FFFFCC" style="text-align:left;border-left-style: none"><strong style="font-size: 8pt; color:blue">ヶ以上</strong></td>
    <td width="200"  bgcolor="#FFFFCC"><?= h($check) ?></td>
    <td bgcolor="#FFFFCC"><?= h($bik) ?></td>
	</tr>
</table>

<?= $this->Form->control('product', array('type'=>'hidden', 'value'=>$product_code, 'label'=>false)) ?>
<?= $this->Form->control('staff', array('type'=>'hidden', 'value'=>$staff_moto, 'label'=>false)) ?>
<?= $this->Form->control('Kensakuday', array('type'=>'hidden', 'value'=>$Kensakuday_num, 'label'=>false)) ?>
<?= $this->Form->control('datesta', array('type'=>'hidden', 'value'=>$datesta, 'label'=>false)) ?>
<?= $this->Form->control('datefin', array('type'=>'hidden', 'value'=>$datefin, 'label'=>false)) ?>
<?= $this->Form->control('ContRejection', array('type'=>'hidden', 'value'=>$cont, 'label'=>false)) ?>
<?= $this->Form->control('amount', array('type'=>'hidden', 'value'=>$amount, 'label'=>false)) ?>
<?= $this->Form->control('check', array('type'=>'hidden', 'value'=>$check, 'label'=>false)) ?>
<?= $this->Form->control('bik', array('type'=>'hidden', 'value'=>$bik, 'label'=>false)) ?>

<?= $this->Form->control('check', array('type'=>'hidden', 'value'=>$checknum, 'label'=>false)) ?>

<br><br><br>
<table align="left" border="2" bordercolor="#E6FFFF" cellpadding="0" cellspacing="0">
<tr>
  <td style="border-style: none;"><div align="left"><?= $this->Form->submit(__('品番順'), array('name' => 'product_sort')); ?></div></td>
  <td style="border-style: none;"><div align="left"><?= $this->Form->submit(__('不良項目順'), array('name' => 'furyou_sort')); ?></div></td>
  <td style="border-style: none;"><div align="left"><?= $this->Form->submit(__('検査時間順'), array('name' => 'kensajikan_sort')); ?></div></td>
</tr>
</table>

<table align="center" border="2" bordercolor="#E6FFFF" cellpadding="0" cellspacing="0">
  <tbody border="2" bordercolor="#E6FFFF" bgcolor="#FFFFCC" style="border-bottom: solid;border-width: 1px">
        <thead>
            <tr border="2" bordercolor="#E6FFFF" bgcolor="#FFFFCC">
              <td width="100" height="30" colspan="20" nowrap="nowrap"><div align="center"><strong style="font-size: 12pt; color:blue">品番</strong></div></td>
              <td width="100" height="30" colspan="20" nowrap="nowrap"><div align="center"><strong style="font-size: 12pt; color:blue">ロットNO.</strong></div></td>
              <td width="100" height="30" colspan="20" nowrap="nowrap"><div align="center"><strong style="font-size: 12pt; color:blue">検査開始</strong></div></td>
              <td width="100" height="30" colspan="20" nowrap="nowrap"><div align="center"><strong style="font-size: 12pt; color:blue">検査終了</strong></div></td>
              <td width="100" height="30" colspan="20" nowrap="nowrap"><div align="center"><strong style="font-size: 12pt; color:blue">所要時間</strong></div></td>
              <td width="100" height="30" colspan="20" nowrap="nowrap"><div align="center"><strong style="font-size: 12pt; color:blue">次検査所要時間</strong></div></td>
              <td width="100" height="30" colspan="20" nowrap="nowrap"><div align="center"><strong style="font-size: 12pt; color:blue">不良内容</strong></div></td>
              <td width="100" height="30" colspan="20" nowrap="nowrap"><div align="center"><strong style="font-size: 12pt; color:blue">数量</strong></div></td>
              <td width="100" height="30" colspan="20" nowrap="nowrap"><div align="center"><strong style="font-size: 12pt; color:blue">備考</strong></div></td>
              <td width="100" height="30" colspan="20" nowrap="nowrap"><div align="center"><strong style="font-size: 12pt; color:blue">検査員</strong></div></td>
            </tr>
        </thead>

        <?php
           if(isset($arrichiran[0])){
             $num = count($arrichiran);
           }else{
             $num = 0;
           }
        ?>

        <tbody border="2" bordercolor="#E6FFFF" bgcolor="#FFFFCC">
            <?php for($i=0; $i<$num; $i++): ?>
            <tr style="border-bottom: solid;border-width: 1px">
                <td colspan="20" nowrap="nowrap"><?= h($arrichiran[$i]['product_code']) ?></td>
                <td colspan="20" nowrap="nowrap"><?= h($arrichiran[$i]['lot_num']) ?></td>
                <td colspan="20" nowrap="nowrap"><?= h($arrichiran[$i]['date_sta']) ?></td>
                <td colspan="20" nowrap="nowrap"><?= h($arrichiran[$i]['date_fin']) ?></td>
                <td colspan="20" nowrap="nowrap"><?= h($arrichiran[$i]['diff']) ?></td>
                <td colspan="20" nowrap="nowrap">0</td>
                <td colspan="20" nowrap="nowrap"><?= h($arrichiran[$i]['cont_rejection']) ?></td>
                <td colspan="20" nowrap="nowrap"><?= h($arrichiran[$i]['amount']) ?></td>
                <td colspan="20" nowrap="nowrap"><?= h($arrichiran[$i]['bik']) ?></td>
                <td colspan="20" nowrap="nowrap"><?= h($arrichiran[$i]['staff']) ?></td>
            </tr>
        <?php endfor;?>
        </tbody>
      </table>


    </fieldset>
    <table align="center" border="2" bordercolor="#E6FFFF" cellpadding="0" cellspacing="0">
    <tr>
      <td style="border-style: none;"><div align="center"><?= $this->Form->submit('csv出力', array('name' => 'csv')); ?></div></td>
  </tr>
  </table>

<br>
<br><br>
    <?= $this->Form->end() ?>
