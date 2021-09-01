<?php
 use App\myClass\Genryoumenu\htmlGenryoumenu;//myClassフォルダに配置したクラスを使用
 $htmlGenryoumenu = new htmlGenryoumenu();
 $htmlGenryou = $htmlGenryoumenu->Genryoumenus();

 echo $this->Form->create($stockEndMaterials, ['url' => ['action' => 'kensakuichiran']]);

 ?>
 <hr size="5" style="margin: 0.5rem">
 <table style="margin-bottom:0px" width="750" border="0" align="center" cellpadding="0" cellspacing="0" bordercolor="#CCCCCC">
 <?php
    echo $htmlGenryou;
 ?>
 </table>
 <hr size="5" style="margin: 0.5rem">
<table style="margin-bottom:0px" width="1000" border="0" align="center" cellpadding="0" cellspacing="0" bordercolor="#CCCCCC">
  <tr style="background-color: #E6FFFF">
    <td style="padding: 0.1rem 0.1rem;"><a href="qr/index.php"><?php echo $this->Html->image('Labelimg/hazaisiyousuuryou.gif',array('width'=>'105','url'=>array('controller'=>'Hazaishiyous', 'action'=>'menu')));?></td>
  </tr>
</table>
<hr size="5" style="margin: 0.5rem">
 <table style="margin-bottom:0px" width="750" border="0" align="center" cellpadding="0" cellspacing="0" bordercolor="#CCCCCC">
  <tr style="background-color: #E6FFFF">
    <td style="padding: 0.1rem 0.1rem;"><a href="qr/index.php"><?php echo $this->Html->image('Labelimg/hazaisiyoukensakugreen.gif',array('width'=>'105','url'=>array('action'=>'kensakuform')));?></td>
  </tr>
</table>
<hr size="5" style="margin: 0.5rem">
<br>
<table style="margin-bottom:0px" width="750" border="0" align="center" cellpadding="0" cellspacing="0" bordercolor="#CCCCCC">
   <tr style="background-color: #E6FFFF">
     <td bgcolor="#E6FFFF"><strong style="font-size: 11pt; color:red"><?= h($mes) ?></strong></td>
   </tr>
 </table>
 <br>
<table align="center" border="2" bordercolor="#E6FFFF" cellpadding="0" cellspacing="0">
  <tbody border="2" bordercolor="#E6FFFF" bgcolor="#FFFFCC" style="border-bottom: solid;border-width: 1px">
          <tr border="2" bordercolor="#E6FFFF" bgcolor="#FFFFCC">
            <td height="20" colspan="20" nowrap="nowrap"><div align="center"><strong style="font-size: 10pt; color:blue">端材</strong></div></td>
            <td colspan="20" nowrap="nowrap"><div align="center"><strong style="font-size: 10pt; color:blue">使用期間</strong></div></td>
          </tr>
          <tr style="border-bottom: solid;border-width: 1px">
            <td colspan="20" nowrap="nowrap"><?= h($materialgrade_color) ?></td>
            <td colspan="20" nowrap="nowrap"><?= h($datesta." ～ ".$datefin) ?></td>
          </tr>
        </tbody>
      </table>
<br><br>
<table align="center" border="2" bordercolor="#E6FFFF" cellpadding="0" cellspacing="0">
  <tbody border="2" bordercolor="#E6FFFF" bgcolor="#FFFFCC" style="border-bottom: solid;border-width: 1px">
          <tr border="2" bordercolor="#E6FFFF" bgcolor="#FFFFCC">
            <td height="20" colspan="20" nowrap="nowrap"><div align="center"><strong style="font-size: 10pt; color:blue">端材</strong></div></td>
            <td colspan="20" nowrap="nowrap"><div align="center"><strong style="font-size: 10pt; color:blue">ロットNo.</strong></div></td>
            <td colspan="20" nowrap="nowrap"><div align="center"><strong style="font-size: 10pt; color:blue">端材ステータス</strong></div></td>
            <td colspan="20" nowrap="nowrap"><div align="center"><strong style="font-size: 10pt; color:blue">数量(kg)</strong></div></td>
            <td colspan="20" nowrap="nowrap"><div align="center"><strong style="font-size: 10pt; color:blue">TAB取込日時</strong></div></td>
            <td colspan="20" nowrap="nowrap"><div align="center"><strong style="font-size: 10pt; color:blue">使用日時</strong></div></td>
            <td colspan="20" nowrap="nowrap"><div align="center"><strong style="font-size: 10pt; color:blue">使用スタッフ</strong></div></td>
          </tr>

            <?php for($i=0; $i<count($arrShiyouhazais); $i++): ?>
              <tr style="border-bottom: solid;border-width: 1px">
                <td colspan="20" nowrap="nowrap"><?= h($arrShiyouhazais[$i]["grade_color"]) ?></td>
                <td colspan="20" nowrap="nowrap"><?= h($arrShiyouhazais[$i]["lot_num"]) ?></td>
                <td colspan="20" nowrap="nowrap"><?= h($arrShiyouhazais[$i]["status_material"]) ?></td>
                <td colspan="20" nowrap="nowrap"><?= h($arrShiyouhazais[$i]["amount"]) ?></td>
                <td colspan="20" nowrap="nowrap"><?= h($arrShiyouhazais[$i]["import_tab_at"]) ?></td>
                <td colspan="20" nowrap="nowrap"><?= h($arrShiyouhazais[$i]["shiped_at"]) ?></td>
                <td colspan="20" nowrap="nowrap"><?= h($arrShiyouhazais[$i]["shiped_staff"]) ?></td>
              </tr>
            <?php endfor;?>

          </tbody>
        </table>
    <br>
    <table align="center" border="2" bordercolor="#E6FFFF" cellpadding="0" cellspacing="0">
    <tr>
      <td style="border-style: none;"><div align="center"><?= $this->Form->submit('csv出力', array('name' => 'csv')); ?></div></td>
    </tr>
    </table>
<br><br>
<?= $this->Form->control('materialgrade_color', array('type'=>'hidden', 'value'=>$materialgrade_color, 'label'=>false)) ?>
<?= $this->Form->control('datesta', array('type'=>'hidden', 'value'=>$datesta, 'label'=>false)) ?>
<?= $this->Form->control('datefin', array('type'=>'hidden', 'value'=>$datefin, 'label'=>false)) ?>
