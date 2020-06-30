<?php
/**
 * AuthHelper: Authの変数にアクセスできる
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\Customer $customer
 */
use App\myClass\Shinkimenus\htmlShinkimenu;//myClassフォルダに配置したクラスを使用
?>
<?php
  use Cake\ORM\TableRegistry;//独立したテーブルを扱う
  $this->Products = TableRegistry::get('products');
  $this->ProductSuppliers = TableRegistry::get('productSuppliers');
?>
        <?php
            $username = $this->request->Session()->read('Auth.User.username');

            $htmlShinkimenu = new htmlShinkimenu();
            $htmlShinkis = $htmlShinkimenu->Shinkimenus();
            $htmldenpyomenus = $htmlShinkimenu->denpyomenus();
        ?>
        <hr size="5" style="margin: 0.5rem">
        <table style="margin-bottom:0px" width="750" border="0" align="center" cellpadding="0" cellspacing="0" bordercolor="#CCCCCC">
          <?php
               echo $htmldenpyomenus;
          ?>
        </table>
        <hr size="5" style="margin: 0.5rem">
        <table style="margin-bottom:0px" width="750" border="0" align="center" cellpadding="0" cellspacing="0" bordercolor="#CCCCCC">
          <td style="padding: 0.1rem 0.1rem;"><a href="qr/index.php"><?php echo $this->Html->image('Labelimg/hattyusumi.gif',array('width'=>'85','height'=>'36','url'=>array('controller'=>'orderEdis','action'=>'denpyouhenkoukensaku')));?></td>
          <td style="padding: 0.1rem 0.1rem;"><a href="qr/index.php"><?php echo $this->Html->image('Labelimg/yobizaiko.gif',array('width'=>'85','height'=>'36','url'=>array('controller'=>'orderEdis','action'=>'yobizaikopreadd')));?></td>
        </table>
        <hr size="5" style="margin: 0.5rem">
        <br>
<?php
header('Expires:-1');
header('Cache-Control:');
header('Pragma:');

$i = 0;
?>

<?= $this->Form->create($OrderToSuppliers, ['url' => ['action' => 'denpyouhenkouform']]) ?>

  <table align="right" border="2" bordercolor="#E6FFFF" cellpadding="0" cellspacing="0">
  <tr>
  <td style="border-style: none;"><div align="center"><?= $this->Form->submit('全て選択', array('name' => 'subete')); ?></div></td>
  </tr>
  </table>
  <table align="center" border="2" bordercolor="#E6FFFF" cellpadding="0" cellspacing="0">
    <tbody border="2" bordercolor="#E6FFFF" bgcolor="#FFFFCC" style="border-bottom: solid;border-width: 1px">
          <thead>
              <tr border="2" bordercolor="#E6FFFF" bgcolor="#FFFFCC">
                <td width="30" height="30" colspan="10" nowrap="nowrap"><div align="center"><strong style="font-size: 12pt; color:blue"></strong></div></td>
                <td width="150" height="30" colspan="20" nowrap="nowrap"><div align="center"><strong style="font-size: 12pt; color:blue">伝票NO</strong></div></td>
                <td width="150" height="30" colspan="20" nowrap="nowrap"><div align="center"><strong style="font-size: 12pt; color:blue">品番</strong></div></td>
                <td width="200" height="30" colspan="20" nowrap="nowrap"><div align="center"><strong style="font-size: 12pt; color:blue">品名</strong></div></td>
                <td width="50" height="30" colspan="20" nowrap="nowrap"><div align="center"><strong style="font-size: 12pt; color:blue">数量</strong></div></td>
                <td width="200" height="30" colspan="20" nowrap="nowrap"><div align="center"><strong style="font-size: 12pt; color:blue">納期</strong></div></td>
                <td width="50" height="30" colspan="20" nowrap="nowrap"><div align="center"><strong style="font-size: 12pt; color:blue">発注先</strong></div></td>
              </tr>
          </thead>
          <tbody border="2" bordercolor="#E6FFFF" bgcolor="#FFFFCC">
              <?php foreach ($OrderToSuppliers as $OrderToSuppliers): ?>
                <?php
                $i = $i + 1 ;
                $this->set('i',$i);
                 ?>
              <tr style="border-bottom: solid;border-width: 1px">
                <?php
                echo "<td colspan='10' nowrap='nowrap'>\n";
                echo "<input type='checkbox' name=check".$i."  size='6'/>\n";
                echo "<input type='hidden' name=".$i." value=$OrderToSuppliers->id size='6'/>\n";//チェックされたもののidをキープする
                echo "</td>\n";
                ?>
                <td width="150" colspan="20" nowrap="nowrap"><?= h($OrderToSuppliers->id_order) ?></td>
                <td width="150" colspan="20" nowrap="nowrap"><?= h($OrderToSuppliers->product_code) ?></td>
                  <?php
                    $product_code = $OrderToSuppliers->product_code;
                		$Product = $this->Products->find()->where(['product_code' => $product_code])->toArray();
                		$product_name = $Product[0]->product_name;

                    $ProductSuppliers = $this->ProductSuppliers->find()->where(['id' => $OrderToSuppliers->id_supplier])->toArray();
                		$Supplier = $ProductSuppliers[0]->name;
                  ?>
                <td width="200" colspan="20" nowrap="nowrap"><?= h($product_name) ?></td>
                <td width="100" colspan="20" nowrap="nowrap"><?= h($OrderToSuppliers->amount) ?></td>
              <?php
                    $date_deliver = $OrderToSuppliers->date_deliver->format('Y-m-d');
                    echo "<td width='200' colspan='20'><div align='center'>\n";
                    echo "<input type='date' value=$date_deliver name=date_deliver empty=Please select size='6'/>\n";
                    echo "</div></td>\n";
               ?>
                <td width="150" colspan="20" nowrap="nowrap"><?= h($Supplier) ?></td>
              </tr>
              <?php endforeach; ?>

             <?php
              echo "<input type='hidden' name='nummax' value=$i size='6'/>\n";
              ?>

          </tbody>
      </table>
  <br>
  <table align="left" border="2" bordercolor="#E6FFFF" cellpadding="0" cellspacing="0">
  <tr>
  <td style="border-style: none;"><div align="center"><?= $this->Form->submit('数量・日付変更', array('name' => 'henkou')); ?></div></td>
  </tr>
  </table>
  <?=$this->Form->end() ?>
</form>
