<?php
$this->layout = 'defaultshinki';
?>
<?php
use App\myClass\Shinkimenus\htmlShinkimenu;//myClassフォルダに配置したクラスを使用
use Cake\ORM\TableRegistry;//独立したテーブルを扱う

$this->ProductSuppliers = TableRegistry::get('ProductSuppliers');

$htmlShinkimenu = new htmlShinkimenu();
$htmlShinkis = $htmlShinkimenu->Shinkimenus();
$htmlgaityumenus = $htmlShinkimenu->gaityumenus();
$htmlgaityuproductsmenus = $htmlShinkimenu->gaityuproductsmenus();
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
  <td style="padding: 0.1rem 0.1rem;"><a href="qr/index.php"><?php echo $this->Html->image('Labelimg/sub_index_gaityuproduct.gif',array('width'=>'85','height'=>'36','url'=>array('controller'=>'shinkies','action'=>'menugaityuproducts')));?></td>
</tr>
</table>
<hr size="5" style="margin: 0.5rem">
<table align="center" border="2" bordercolor="#E6FFFF" cellpadding="0" cellspacing="0">
  <tbody border="2" bordercolor="#E6FFFF" bgcolor="#FFFFCC" style="border-bottom: solid;border-width: 1px">
        <thead>
            <tr border="2" bordercolor="#E6FFFF" bgcolor="#FFFFCC">
              <td width="200" height="30" colspan="20" nowrap="nowrap"><div align="center"><strong style="font-size: 10pt; color:blue">品番</strong></div></td>
              <td width="100" height="30" colspan="20" nowrap="nowrap"><div align="center"><strong style="font-size: 10pt; color:blue">出荷先</strong></div></td>
              <td width="150" height="30" colspan="20" nowrap="nowrap"><div align="center"><strong style="font-size: 10pt; color:blue">単価（円/kg）</strong></div></td>
            </tr>
        </thead>
        <tbody border="2" bordercolor="#E6FFFF" bgcolor="#FFFFCC">
          <?php foreach ($ProductGaityus as $ProductGaityus): ?>
            <?php
            $ProductSuppliers = $this->ProductSuppliers->find()->where(['id' => $ProductGaityus->id_supplier])->toArray();
            if(isset($ProductSuppliers[0])){
              $ProductSuppliername = $ProductSuppliers[0]->name;
            }else{
              $ProductSuppliername = "";
            }
            ?>
          <tr style="border-bottom: solid;border-width: 1px">
            <td colspan="20" nowrap="nowrap"><?= h($ProductGaityus->product_code) ?></td>
            <td colspan="20" nowrap="nowrap"><?= h($ProductSuppliername) ?></td>
            <td colspan="20" nowrap="nowrap"><?= h($ProductGaityus->price_shiire) ?></td>
          </tr>
          <?php endforeach; ?>
        </tbody>
    </table>
<br><br>
