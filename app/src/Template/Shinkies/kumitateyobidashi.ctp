<?php
$this->layout = 'defaultshinki';
?>
<?php
use Cake\ORM\TableRegistry;//独立したテーブルを扱う
$this->Products = TableRegistry::get('products');
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
  <td style="padding: 0.1rem 0.1rem;"><a href="qr/index.php"><?php echo $this->Html->image('Labelimg/subTourokuAssem.gif',array('width'=>'85','height'=>'36','url'=>array('controller'=>'shinkies','action'=>'kumitateproductform')));?></td>
  <td style="padding: 0.1rem 0.1rem;"><a href="qr/index.php"><?php echo $this->Html->image('Labelimg/subYobidashiAssem.gif',array('width'=>'85','height'=>'36','url'=>array('controller'=>'shinkies','action'=>'kumitateyobidashi')));?></td>
</tr>
</table>
<hr size="5" style="margin: 0.5rem">
<br><br>

  <?= $this->Form->create($assembleProducts, ['url' => ['action' => 'menu']]) ?>

  <table align="center" border="2" bordercolor="#E6FFFF" cellpadding="0" cellspacing="0">
    <tbody border="2" bordercolor="#E6FFFF" bgcolor="#FFFFCC" style="border-bottom: solid;border-width: 1px">
          <thead>
              <tr border="2" bordercolor="#E6FFFF" bgcolor="#FFFFCC">
                <td width="200" height="30" colspan="20" nowrap="nowrap"><div align="center"><strong style="font-size: 13pt; color:blue">品番</strong></div></td>
                <td width="200" height="30" colspan="20" nowrap="nowrap"><div align="center"><strong style="font-size: 13pt; color:blue">品名</strong></div></td>
                <td width="200" height="30" colspan="20" nowrap="nowrap"><div align="center"><strong style="font-size: 13pt; color:blue">組み立て品番</strong></div></td>
                <td width="200" height="30" colspan="20" nowrap="nowrap"><div align="center"><strong style="font-size: 13pt; color:blue">組み立て品名</strong></div></td>
              </tr>
          </thead>
          <tbody border="2" bordercolor="#E6FFFF" bgcolor="#FFFFCC">
            <?php for($i=0; $i<count($AssembleProducts); $i++): ?>

              <?php
              $Product = $this->Products->find()->where(['product_code' => $AssembleProducts[$i]->product_code])->toArray();
              if(isset($Product[0])){
                $product_name = $Product[0]->product_name;
              }else{
                $product_name = "";
              }
              $Product_cld = $this->Products->find()->where(['product_code' => $AssembleProducts[$i]->child_pid])->toArray();
              if(isset($Product_cld[0])){
                $product_name_cld = $Product_cld[0]->product_name;
              }else{
                $product_name_cld = "";
              }
              ?>

            <tr style="border-bottom: solid;border-width: 1px">
              <td colspan="20" nowrap="nowrap"><font><?= h($AssembleProducts[$i]->product_code) ?></font></td>
              <td colspan="20" nowrap="nowrap"><font><?= h($product_name) ?></font></td>
              <td colspan="20" nowrap="nowrap"><font><?= h($AssembleProducts[$i]->product_code) ?></font></td>
              <td colspan="20" nowrap="nowrap"><font><?= h($product_name_cld) ?></font></td>
            </tr>
          <?php endfor;?>
          </tbody>
      </table>
  <br><br>
