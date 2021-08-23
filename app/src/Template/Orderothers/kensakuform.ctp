<?php
 use App\myClass\EDImenus\htmlEDImenu;//myClassフォルダに配置したクラスを使用
 $htmlEDImenu = new htmlEDImenu();
 $htmlEDIs = $htmlEDImenu->EDImenus();
 ?>
 <hr size="5" style="margin: 0.5rem">
 <table style="margin-bottom:0px" width="750" border="0" align="center" cellpadding="0" cellspacing="0" bordercolor="#CCCCCC">
 <?php
    echo $htmlEDIs;
 ?>
 </table>
 <hr size="5" style="margin: 0.5rem">
 <table style="margin-bottom:0px" width="750" border="0" align="center" cellpadding="0" cellspacing="0" bordercolor="#CCCCCC">
  <td style="padding: 0.1rem 0.1rem; text-align: center"><a href="qr/index.php"><?php echo $this->Html->image('Labelimg/subYobidashi.gif',array('width'=>'85','height'=>'36','url'=>array('action'=>'addpreadd')));?></td>
 </table>
 <hr size="5" style="margin: 0.5rem">

        <?= $this->Form->create($OrderSpecials, ['url' => ['action' => 'kensakuichiran']]) ?>

<table align="center" border="2" bordercolor="#E6FFFF" cellpadding="0" cellspacing="0">
  <tbody border="2" bordercolor="#E6FFFF" bgcolor="#FFFFCC" style="border-bottom: solid;border-width: 1px">
    <tr style="border-bottom: 0px;border-width: 0px">
      <td width="250" height="35" colspan="20" nowrap="nowrap"><div align="center"><strong style="font-size: 15pt; color:blue">会社名</strong></div></td>
      <td width="500" colspan="40" nowrap="nowrap"><div align="center"><strong style="font-size: 15pt; color:blue">納期絞り込み</strong></div></td>
    </tr>

<?php
      $dateYMD = date('Y-m-d');
      $dateYMD1 = strtotime($dateYMD);
      $dayye = date('Y-m-d', strtotime('-1 day', $dateYMD1));

      echo "<tr style='border-bottom: 0px;border-width: 0px'>\n";
  ?>
      <td rowspan='2'  height='6' colspan='20'>
        <?= $this->Form->input('cs_id', ["type"=>"select", "empty"=>"", "options"=>$arrCustomers, 'label'=>false, 'empty'=>true]); ?>
      </td>
<?php
      echo "<td width='50' colspan='3' style='border-bottom: 0px'><div align='center'><strong style='font-size: 15pt; color:blue'>\n";
      echo "開始";
      echo "</strong></div></td>\n";

  ?>
  <td width="350" colspan="37" style="border-bottom: 0px;border-width: 1px"><div align="center"><?= $this->Form->input("date_sta", array('type' => 'date', 'value' => $dayye, 'monthNames' => false, 'label'=>false)); ?></div></td>
  <?php

      echo "</tr>\n";
      echo "<tr style='border-bottom: 0px;border-width: 0px'>\n";
      echo "<td colspan='3'><div align='center'><strong style='font-size: 15pt; color:blue'>\n";
      echo "終了";
      echo "</strong></div></td>\n";

?>
<td colspan="37" style="border-bottom: solid;border-width: 1px"><div align="center"><?= $this->Form->input("date_fin", array('type' => 'date', 'value' => $dateYMD, 'monthNames' => false, 'label'=>false)); ?></div></td>
<?php

      echo "</tr>\n";

 ?>
<br>
  <tr bgcolor="#E6FFFF" >
    <td width="100" colspan="30" nowrap="nowrap" bgcolor="#E6FFFF" style="border: none"><div align="center"><strong style="font-size: 15pt; color:blue"></strong></div></td>
    <td align="right" rowspan="2"  colspan="20" width="250" bgcolor="#E6FFFF" style="border: none"><div align="right"><?= $this->Form->submit(__('呼出'), array('name' => 'kensaku')); ?></div></td>
  </tr>
</table>
</fieldset>

<?=$this->Form->end() ?>
