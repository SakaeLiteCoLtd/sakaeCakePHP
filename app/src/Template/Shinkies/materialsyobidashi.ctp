<?php
$this->layout = 'defaultshinki';
?>
<?php
use Cake\ORM\TableRegistry;//独立したテーブルを扱う
$this->Suppliers = TableRegistry::get('suppliers');
?>
<?php
use App\myClass\Shinkimenus\htmlShinkimenu;//myClassフォルダに配置したクラスを使用

$htmlShinkimenu = new htmlShinkimenu();
$htmlShinkis = $htmlShinkimenu->Shinkimenus();
?>

<hr size="5" style="margin: 0.5rem">
<table style="margin-bottom:0px" width="750" border="0" align="center" cellpadding="0" cellspacing="0" bordercolor="#CCCCCC">
<?php
   echo $htmlShinkis;
?>
</table>
<hr size="5" style="margin: 0.5rem">

<table style="margin-bottom:0px" width="750" border="0" align="center" cellpadding="0" cellspacing="0" bordercolor="#CCCCCC">
<tr style="background-color: #E6FFFF">
  <td style="padding: 0.1rem 0.1rem;"><a href="qr/index.php"><?php echo $this->Html->image('Labelimg/subTourokuMaterial.gif',array('width'=>'85','height'=>'36','url'=>array('action'=>'materialsform')));?></td>
  <td style="padding: 0.1rem 0.1rem;"><a href="qr/index.php"><?php echo $this->Html->image('Labelimg/subYobidashiMaterial.gif',array('width'=>'85','height'=>'36','url'=>array('action'=>'materialsyobidashi')));?></td>
  <td style="padding: 0.1rem 0.1rem;"><a href="qr/index.php"><?php echo $this->Html->image('Labelimg/subTourokuShiire.gif',array('width'=>'85','height'=>'36','url'=>array('action'=>'supplierform')));?></td>
</tr>
</table>
<hr size="5" style="margin: 0.5rem">
<br><br>

  <?= $this->Form->create($priceMaterials, ['url' => ['action' => 'yusyouzaisyusei']]) ?>

  <table align="center" border="2" bordercolor="#E6FFFF" cellpadding="0" cellspacing="0">
    <tbody border="2" bordercolor="#E6FFFF" bgcolor="#FFFFCC" style="border-bottom: solid;border-width: 1px">
          <thead>
              <tr border="2" bordercolor="#E6FFFF" bgcolor="#FFFFCC">
                <td width="200" height="30" colspan="20" nowrap="nowrap"><div align="center"><strong style="font-size: 13pt; color:blue">グレード</strong></div></td>
                <td width="200" height="30" colspan="20" nowrap="nowrap"><div align="center"><strong style="font-size: 13pt; color:blue">色</strong></div></td>
                <td width="250" height="30" colspan="20" nowrap="nowrap"><div align="center"><strong style="font-size: 13pt; color:blue">会社名</strong></div></td>
              </tr>
          </thead>
          <tbody border="2" bordercolor="#E6FFFF" bgcolor="#FFFFCC">
            <?php for($i=0; $i<count($PriceMaterials); $i++): ?>
            <tr style="border-bottom: solid;border-width: 1px">

              <?php
              $sup_id = $PriceMaterials[$i]->sup_id;
              $Suppliers = $this->Suppliers->find()->where(['id' => $sup_id])->toArray();
              if(isset($Suppliers[0])){
                $Suppliername = $Suppliers[0]->name;
              }else{
                $Suppliername = "";
              }
              ?>

              <td colspan="20" nowrap="nowrap"><font><?= h($PriceMaterials[$i]->grade) ?></font></td>
              <td colspan="20" nowrap="nowrap"><font><?= h($PriceMaterials[$i]->color) ?></font></td>
              <td colspan="20" nowrap="nowrap"><font><?= h($Suppliername) ?></font></td>
            </tr>
          <?php endfor;?>
          </tbody>
      </table>
  <br><br>
