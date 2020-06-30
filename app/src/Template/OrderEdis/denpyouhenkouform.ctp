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

              header('Expires:-1');
              header('Cache-Control:');
              header('Pragma:');

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
$i = 0;
?>

<?= $this->Form->create($OrderToSuppliers, ['url' => ['action' => 'denpyouhenkouconfirm']]) ?>

  <table align="center" border="2" bordercolor="#E6FFFF" cellpadding="0" cellspacing="0">
    <tbody border="2" bordercolor="#E6FFFF" bgcolor="#FFFFCC" style="border-bottom: solid;border-width: 1px">
          <thead>
              <tr border="2" bordercolor="#E6FFFF" bgcolor="#FFFFCC">
                <td width="150" height="30" colspan="20" nowrap="nowrap"><div align="center"><strong style="font-size: 12pt; color:blue">伝票NO</strong></div></td>
                <td width="150" height="30" colspan="20" nowrap="nowrap"><div align="center"><strong style="font-size: 12pt; color:blue">品番</strong></div></td>
                <td width="200" height="30" colspan="20" nowrap="nowrap"><div align="center"><strong style="font-size: 12pt; color:blue">品名</strong></div></td>
                <td width="80" height="30" colspan="20" nowrap="nowrap"><div align="center"><strong style="font-size: 12pt; color:blue">数量</strong></div></td>
                <td width="200" height="30" colspan="20" nowrap="nowrap"><div align="center"><strong style="font-size: 12pt; color:blue">納期</strong></div></td>
                <td width="50" height="30" colspan="20" nowrap="nowrap"><div align="center"><strong style="font-size: 12pt; color:blue">発注先</strong></div></td>
              </tr>
          </thead>
          <tbody border="2" bordercolor="#E6FFFF" bgcolor="#FFFFCC">
            <?php for($i=0; $i<$count; $i++): ?>
              <tr style="border-bottom: solid;border-width: 1px">
                <?= $this->Form->control('id'.$i, array('type'=>'hidden', 'value'=>$arrOrderToSupplier[$i]["id"], 'label'=>false)) ?>
                <td width="150" colspan="20" nowrap="nowrap"><?= h($arrOrderToSupplier[$i]["id_order"]) ?></td>
                <td width="150" colspan="20" nowrap="nowrap"><?= h($arrOrderToSupplier[$i]["product_code"]) ?></td>
                <td width="200" colspan="20" nowrap="nowrap"><?= h($arrOrderToSupplier[$i]["product_name"]) ?></td>
                <?php
                    $amount = $arrOrderToSupplier[$i]["amount"];
                ?>
                 <?php
                       echo "<td width='80' colspan='20'><div align='center'>\n";
                       echo "<input type='text' value=$amount name=amount.$i size='6'/>\n";
                       echo "</div></td>\n";
                  ?>
                 <?php
                       $date_deliver = $arrOrderToSupplier[$i]["date_deliver"]->format('Y-m-d');
                       echo "<td width='200' colspan='20'><div align='center'>\n";
                       echo "<input type='date' value=$date_deliver name=date_deliver.$i empty=Please select size='6'/>\n";
                       echo "</div></td>\n";
                  ?>
                <td width="150" colspan="20" nowrap="nowrap"><?= h($arrOrderToSupplier[$i]["Supplier"]) ?></td>
              </tr>
            <?php endfor;?>
          </tbody>
      </table>
      <?= $this->Form->control('num', array('type'=>'hidden', 'value'=>$count, 'label'=>false)) ?>

  <br>
  <table align="left" border="2" bordercolor="#E6FFFF" cellpadding="0" cellspacing="0">
  <tr>
  <td style="border-style: none;"><div align="center"><?= $this->Form->submit('変更内容確認', array('name' => 'henkou')); ?></div></td>
  </tr>
  </table>
<br><br><br><br><br><br>

  <?=$this->Form->end() ?>
</form>
