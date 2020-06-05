<?php
 use App\myClass\Zensumenus\htmlzensumenu;//myClassフォルダに配置したクラスを使用
 $htmlzensumenu = new htmlzensumenu();
 $htmlzensus = $htmlzensumenu->zensumenus();
 $htmlzensusubs = $htmlzensumenu->zensussubmenus();
 $htmlzensustartends = $htmlzensumenu->zensustartend();
 ?>
 <hr size="5" style="margin: 0.5rem">
 <table style="margin-bottom:0px" width="750" border="0" align="center" cellpadding="0" cellspacing="0" bordercolor="#CCCCCC">
 <?php
    echo $htmlzensus;
 ?>
 </table>
 <hr size="5" style="margin: 0.5rem">
 <table style="margin-bottom:0px" width="750" border="0" align="center" cellpadding="0" cellspacing="0" bordercolor="#CCCCCC">
 <?php
    echo $htmlzensustartends;
 ?>
 </table>
 <br><br>
 <table width="200" align="left" border="2" bordercolor="#E6FFFF" cellpadding="0" cellspacing="0" style="border-bottom: solid;border-width: 1px">
   <tr>
     <td bgcolor="#FFFFCC" style="font-size: 12pt;"><strong style="font-size: 11pt; color:blue">担当者</strong></td>
 	</tr>
  <tr>
    <td bgcolor="#FFFFCC" style="font-size: 12pt;"><strong style="font-size: 10pt"><?= __($Staff) ?></strong></td>
 </tr>
 </table>
 <br><br><br>
    <?= $this->Flash->render() ?>
    <?= $this->Form->create($ResultZensuHeads, ['url' => ['action' => 'zensufinishpre']]) ?>
    <br><br><br><br>

  <table align="left" border="2" bordercolor="#E6FFFF" cellpadding="0" cellspacing="0">
    <tr style="border-bottom: solid;border-width: 1px">
      <td bgcolor="#FFFFCC"><strong style="font-size: 13pt; color:blue">品番</strong></td>
      <td bgcolor="#FFFFCC"><strong style="font-size: 13pt; color:blue">品名</strong></td>
      <td bgcolor="#FFFFCC"><strong style="font-size: 13pt; color:blue">ロットNo.</strong></td>
      <td bgcolor="#FFFFCC"><strong style="font-size: 13pt; color:blue"></strong></td>
    </tr>
  <?php for ($i=0;$i<$cnt;$i++): ?>
    <tr style="border-bottom: solid;border-width: 1px">
      <td width="220"  bgcolor="#FFFFCC" style="font-size: 12pt;"><?= h(${"product_code".$i}) ?></td>
      <td width="250"  bgcolor="#FFFFCC" style="font-size: 12pt;"><?= h(${"product_name".$i}) ?></td>
      <td width="220"  bgcolor="#FFFFCC" style="font-size: 12pt;"><?= h(${"lot_num".$i}) ?></td>
      <td width="100"  bgcolor="#FFFFCC" style="font-size: 10pt;"><?= $this->Form->submit('登録', array('name' => $i)); ?></td>
    </tr>

  <?= $this->Form->control('id'.$i, array('type'=>'hidden', 'value'=>${"id".$i}, 'label'=>false)) ?>
  <?= $this->Form->control('product_code'.$i, array('type'=>'hidden', 'value'=>${"product_code".$i}, 'label'=>false)) ?>
  <?= $this->Form->control('product_name'.$i, array('type'=>'hidden', 'value'=>${"product_name".$i}, 'label'=>false)) ?>
  <?= $this->Form->control('lot_num'.$i, array('type'=>'hidden', 'value'=>${"lot_num".$i}, 'label'=>false)) ?>
  <?= $this->Form->control('datetime_finish'.$i, array('type'=>'hidden', 'value'=>date('Y-m-d h:m:s'), 'label'=>false)) ?>
  <?php endfor;?>
</table>
<?= $this->Form->control('cnt', array('type'=>'hidden', 'value'=>$cnt, 'label'=>false)) ?>
<?= $this->Form->control('Staff', array('type'=>'hidden', 'value'=>$Staff, 'label'=>false)) ?>
<?= $this->Form->control('staff_id', array('type'=>'hidden', 'value'=>$Staffid, 'label'=>false)) ?>


<br><br>
<br><br>
<br><br>
<br><br>
<br><br>

<?php
echo "<pre>";
print_r($Data);
echo "</pre>";
?>

    <?= $this->Form->end() ?>
