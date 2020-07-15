<?php
$this->layout = 'defaultaccount';
?>

<?php
use App\myClass\Shinkimenus\htmlShinkimenu;//myClassフォルダに配置したクラスを使用
?>
<?php
  header('Expires:-1');
  header('Cache-Control:');
  header('Pragma:');
?>
<?php
    $htmlShinkimenu = new htmlShinkimenu();
    $htmlaccountmenus = $htmlShinkimenu->accountmenus();
    $htmlpricemenus = $htmlShinkimenu->pricemenus();
?>
<hr size="5" style="margin: 0.5rem">
<table style="margin-bottom:0px" width="750" border="0" align="center" cellpadding="0" cellspacing="0" bordercolor="#CCCCCC">
  <?php
       echo $htmlaccountmenus;
  ?>
</table>
<hr size="5" style="margin: 0.5rem">
<table style="margin-bottom:0px" width="750" border="0" align="center" cellpadding="0" cellspacing="0" bordercolor="#CCCCCC">
  <?php
       echo $htmlpricemenus;
  ?>
</table>
<hr size="5" style="margin: 0.5rem">
<br>
<table style="margin-bottom:0px" width="750" border="0" align="center" cellpadding="0" cellspacing="0" bordercolor="#CCCCCC">
   <tr style="background-color: #E6FFFF">
     <td style="padding: 0.1rem 0.1rem; text-align: center"><?php echo $this->Html->image('Labelimg/accountMaterialPriceOrder.gif');?></td>
   </tr>
 </table>
<br><br>

  <?= $this->Form->create($user, ['url' => ['action' => 'pricematerialsyusei']]) ?>

  <table align="center" border="2" bordercolor="#E6FFFF" cellpadding="0" cellspacing="0">
    <tbody border="2" bordercolor="#E6FFFF" bgcolor="#FFFFCC" style="border-bottom: solid;border-width: 1px">
          <thead>
              <tr border="2" bordercolor="#E6FFFF" bgcolor="#FFFFCC">
                <td width="200" height="30" colspan="20" nowrap="nowrap"><div align="center"><strong style="font-size: 13pt; color:blue">オーダーID</strong></div></td>
                <td width="200" height="30" colspan="20" nowrap="nowrap"><div align="center"><strong style="font-size: 13pt; color:blue">グレード</strong></div></td>
                <td width="200" height="30" colspan="20" nowrap="nowrap"><div align="center"><strong style="font-size: 13pt; color:blue">色番号</strong></div></td>
                <td width="200" height="30" colspan="20" nowrap="nowrap"><div align="center"><strong style="font-size: 13pt; color:blue">数量</strong></div></td>
                <td width="200" height="30" colspan="20" nowrap="nowrap"><div align="center"><strong style="font-size: 13pt; color:blue">受入日</strong></div></td>
                <td width="200" height="30" colspan="20" nowrap="nowrap"><div align="center"><strong style="font-size: 13pt; color:blue">単価</strong></div></td>
                <td width="60" height="30" colspan="20" nowrap="nowrap"><div align="center"><strong style="font-size: 9pt; color:blue"></strong></div></td>
              </tr>
          </thead>
          <tbody border="2" bordercolor="#E6FFFF" bgcolor="#FFFFCC">
            <?php for($i=0; $i<count($OrderMaterials); $i++): ?>
            <tr style="border-bottom: solid;border-width: 1px">

              <?php


              ?>

              <td colspan="20" nowrap="nowrap"><font><?= h($OrderMaterials[$i]->id_order) ?></font></td>
              <td colspan="20" nowrap="nowrap"><font><?= h($OrderMaterials[$i]->grade) ?></font></td>
              <td colspan="20" nowrap="nowrap"><font><?= h($OrderMaterials[$i]->color) ?></font></td>
              <td colspan="20" nowrap="nowrap"><font><?= h($OrderMaterials[$i]->amount) ?></font></td>
              <td colspan="20" nowrap="nowrap"><font><?= h($OrderMaterials[$i]->date_order) ?></font></td>
              <td colspan="20" nowrap="nowrap"><font><?= h($OrderMaterials[$i]->price) ?></font></td>
              <?php
              echo "<td colspan='20' nowrap='nowrap'><div align='center'>";
              echo $this->Form->submit("編集" , ['action'=>'hensyu', 'name' => $OrderMaterials[$i]->id]) ;
              echo "</div></td>";
              ?>
            </tr>
          <?php endfor;?>
          </tbody>
      </table>
  <br><br>
