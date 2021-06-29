<?php
$this->layout = 'defaultshinki';
?>
<?php
use App\myClass\Shinkimenus\htmlShinkimenu;//myClassフォルダに配置したクラスを使用
use Cake\ORM\TableRegistry;//独立したテーブルを扱う
$this->Products = TableRegistry::get('products');//productsテーブルを使う
$this->OutsourceHandys = TableRegistry::get('outsourceHandys');//productsテーブルを使う

$htmlShinkimenu = new htmlShinkimenu();
$htmlShinkis = $htmlShinkimenu->Shinkimenus();
$htmlchokusoumenus = $htmlShinkimenu->chokusoumenus();
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
    <td style="padding: 0.1rem 0.1rem;"><a href="qr/index.php"><?php echo $this->Html->image('Labelimg/chokusoushinki.gif',array('width'=>'105','url'=>array('action'=>'addform')));?></td>
    <td style="padding: 0.1rem 0.1rem;"><a href="qr/index.php"><?php echo $this->Html->image('Labelimg/chokusouhensyuu.gif',array('width'=>'105','url'=>array('action'=>'editformpre')));?></td>
  </tr>
</table>
<hr size="5" style="margin: 0.5rem">
<br>
<legend align="center"><font color="black"><?= __("検査外注製品一覧") ?></legend>
<br>
<table align="center" border="2" bordercolor="#E6FFFF" cellpadding="0" cellspacing="0">
  <tbody border="2" bordercolor="#E6FFFF" bgcolor="#FFFFCC" style="border-bottom: solid;border-width: 1px">
        <thead>
            <tr border="2" bordercolor="#E6FFFF" bgcolor="#FFFFCC">
              <td width="250" colspan="20" nowrap="nowrap"><div align="center"><strong style="font-size: 12pt; color:blue">品番</strong></div></td>
              <td width="250" colspan="20" nowrap="nowrap"><div align="center"><strong style="font-size: 12pt; color:blue">品名</strong></div></td>
              <td width="200" colspan="20" nowrap="nowrap"><div align="center"><strong style="font-size: 12pt; color:blue">仕入先</strong></div></td>
            </tr>
        </thead>
        <tbody border="2" bordercolor="#E6FFFF" bgcolor="#FFFFCC">
          <?php for($i=0; $i<count($arrNonKadouSeikeis); $i++): ?>
            <tr style="border-bottom: solid;border-width: 1px">
                <td width="150" colspan="20" nowrap="nowrap"><?= h($arrNonKadouSeikeis[$i]["product_code"]) ?></td>
                <?php
                  $product_code = $arrNonKadouSeikeis[$i]["product_code"];
                  $Product = $this->Products->find()->where(['product_code' => $product_code])->toArray();
              		$product_name = $Product[0]->product_name;

                  $OutsourceHandys = $this->OutsourceHandys->find()->where(['id' => $arrNonKadouSeikeis[$i]["outsource_handy_id"]])->toArray();
              		$outsource_handy_name = $OutsourceHandys[0]->name;
                ?>
                <td width="150" colspan="20" nowrap="nowrap"><?= h($product_name) ?></td>
                <td width="200" colspan="20" nowrap="nowrap"><?= h($outsource_handy_name) ?></td>
            </tr>
          <?php endfor;?>
        </tbody>
    </table>
<br><br>
