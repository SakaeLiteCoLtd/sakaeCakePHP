<?php
 use App\myClass\Genryoumenu\htmlGenryoumenu;//myClassフォルダに配置したクラスを使用
 $htmlGenryoumenu = new htmlGenryoumenu();
 $htmlGenryou = $htmlGenryoumenu->Genryoumenus();
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
      <td style="padding: 0.1rem 0.1rem;"><a href="qr/index.php"><?php echo $this->Html->image('Labelimg/hazaicsv.gif',array('width'=>'105','url'=>array('action'=>'csvlogin')));?></td>
  </tr>
</table>
<hr size="5" style="margin: 0.5rem">
<br>
<?=$this->Form->create($stockEndMaterials, ['url' => ['action' => 'menu']]) ?>
<br>
<legend align="center"><font color="red" size="3"><?= __($mes) ?></font></legend>
<br>
<table align="center" border="2" bordercolor="#E6FFFF" cellpadding="0" cellspacing="0">
  <tbody border="2" bordercolor="#E6FFFF" bgcolor="#FFFFCC" style="border-bottom: solid;border-width: 1px">
        <thead>
            <tr border="2" bordercolor="#E6FFFF" bgcolor="#FFFFCC">
              <td width="150" height="30" colspan="20" nowrap="nowrap"><div align="center"><strong style="font-size: 12pt; color:blue">グレード</strong></div></td>
              <td width="150" height="30" colspan="20" nowrap="nowrap"><div align="center"><strong style="font-size: 12pt; color:blue">色番</strong></div></td>
              <td width="150" height="30" colspan="20" nowrap="nowrap"><div align="center"><strong style="font-size: 12pt; color:blue">端材ステイタス</strong></div></td>
              <td width="150" height="30" colspan="20" nowrap="nowrap"><div align="center"><strong style="font-size: 12pt; color:blue">数量</strong></div></td>
              <td width="150" height="30" colspan="20" nowrap="nowrap"><div align="center"><strong style="font-size: 12pt; color:blue">登録日</strong></div></td>
              <td width="150" height="30" colspan="20" nowrap="nowrap"><div align="center"><strong style="font-size: 12pt; color:blue">登録者</strong></div></td>
            </tr>
        </thead>
        <tbody border="2" bordercolor="#E6FFFF" bgcolor="#FFFFCC">
          <?php for($i=0; $i<count($csvStockEndMaterials); $i++): ?>
            <tr style="border-bottom: solid;border-width: 1px">
              <td colspan="20" nowrap="nowrap"><?= h($csvStockEndMaterials[$i]["grade"]) ?></td>
              <td colspan="20" nowrap="nowrap"><?= h($csvStockEndMaterials[$i]["color"]) ?></td>
              <td colspan="20" nowrap="nowrap"><?= h($csvStockEndMaterials[$i]["status_material"]) ?></td>
              <td colspan="20" nowrap="nowrap"><?= h($csvStockEndMaterials[$i]["amount"]) ?></td>
              <td colspan="20" nowrap="nowrap"><?= h($csvStockEndMaterials[$i]["created_at"]) ?></td>
              <td colspan="20" nowrap="nowrap"><?= h($csvStockEndMaterials[$i]["staff_name"]) ?></td>
            </tr>
           <?php endfor;?>
        </tbody>
    </table>

<br>
<table align="center" border="2" bordercolor="#E6FFFF" cellpadding="0" cellspacing="0">
  <tr>
    <td style="border-style: none;"><div align="center"><?= $this->Form->submit('TOP', array('name' => 'top')); ?></div></td>
  </tr>
</table>
<br><br><br><br><br><br><br>

<?=$this->Form->end() ?>
</form>
