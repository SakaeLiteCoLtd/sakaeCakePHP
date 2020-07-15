<?php
$this->layout = 'defaultaccount';
?>

<?php
use App\myClass\Shinkimenus\htmlShinkimenu;//myClassフォルダに配置したクラスを使用
use Cake\ORM\TableRegistry;//独立したテーブルを扱う
$this->Products = TableRegistry::get('products');
$this->Customers = TableRegistry::get('customers');
$this->AccountYusyouzaiMasters = TableRegistry::get('accountYusyouzaiMasters');
?>
<?php
  header('Expires:-1');
  header('Cache-Control:');
  header('Pragma:');
?>
<?php
    $htmlShinkimenu = new htmlShinkimenu();
    $htmlaccountmenus = $htmlShinkimenu->accountmenus();
    $htmlyusyouzaimenus = $htmlShinkimenu->yusyouzaimenus();
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
       echo $htmlyusyouzaimenus;
  ?>
</table>
<hr size="5" style="margin: 0.5rem">
<br>
<table style="margin-bottom:0px" width="750" border="0" align="center" cellpadding="0" cellspacing="0" bordercolor="#CCCCCC">
   <tr style="background-color: #E6FFFF">
     <td style="padding: 0.1rem 0.1rem; text-align: center"><?php echo $this->Html->image('Labelimg/accountYusyouzaiUkeireKensaku.gif');?></td>
   </tr>
 </table>
<br><br>

  <?= $this->Form->create($user, ['url' => ['action' => 'ukeiresyusei']]) ?>

  <table align="center" border="2" bordercolor="#E6FFFF" cellpadding="0" cellspacing="0">
    <tbody border="2" bordercolor="#E6FFFF" bgcolor="#FFFFCC" style="border-bottom: solid;border-width: 1px">
          <thead>
              <tr border="2" bordercolor="#E6FFFF" bgcolor="#FFFFCC">
                <td width="200" height="30" colspan="20" nowrap="nowrap"><div align="center"><strong style="font-size: 13pt; color:blue">会社名</strong></div></td>
                <td width="150" height="30" colspan="20" nowrap="nowrap"><div align="center"><strong style="font-size: 13pt; color:blue">品番</strong></div></td>
                <td width="150" height="30" colspan="20" nowrap="nowrap"><div align="center"><strong style="font-size: 13pt; color:blue">品名</strong></div></td>
                <td width="150" height="30" colspan="20" nowrap="nowrap"><div align="center"><strong style="font-size: 13pt; color:blue">単価</strong></div></td>
                <td width="200" height="30" colspan="20" nowrap="nowrap"><div align="center"><strong style="font-size: 13pt; color:blue">受入日付</strong></div></td>
                <td width="150" height="30" colspan="20" nowrap="nowrap"><div align="center"><strong style="font-size: 13pt; color:blue">数量</strong></div></td>
                <td width="60" height="30" colspan="20" nowrap="nowrap"><div align="center"><strong style="font-size: 9pt; color:blue"></strong></div></td>
              </tr>
          </thead>
          <tbody border="2" bordercolor="#E6FFFF" bgcolor="#FFFFCC">
            <?php for($i=0; $i<count($AccountYusyouzaiUkeires); $i++): ?>
            <tr style="border-bottom: solid;border-width: 1px">

              <?php
              $product_code = $AccountYusyouzaiUkeires[$i]->product_code;
              $Product = $this->Products->find()->where(['product_code' => $product_code])->toArray();
              $product_name = $Product[0]->product_name;

              $AccountYusyouzaiMasters = $this->AccountYusyouzaiMasters->find()->where(['product_code' => $product_code])->toArray();
              $customer_code = $AccountYusyouzaiMasters[0]->customer_code;
              $CustomersData = $this->Customers->find()->where(['customer_code' => $customer_code])->toArray();
              if(isset($CustomersData[0])){
                $customer = $CustomersData[0]->name;
              }else{
                $customer = "";
              }
              ?>

              <td colspan="20" nowrap="nowrap"><font><?= h($customer) ?></font></td>
              <td colspan="20" nowrap="nowrap"><font><?= h($AccountYusyouzaiUkeires[$i]->product_code) ?></font></td>
              <td colspan="20" nowrap="nowrap"><font><?= h($product_name) ?></font></td>
              <td colspan="20" nowrap="nowrap"><font><?= h($AccountYusyouzaiUkeires[$i]->tanka) ?></font></td>
              <td colspan="20" nowrap="nowrap"><font><?= h($AccountYusyouzaiUkeires[$i]->date_ukeire) ?></font></td>
              <td colspan="20" nowrap="nowrap"><font><?= h($AccountYusyouzaiUkeires[$i]->amount) ?></font></td>
              <?php
              echo "<td colspan='20' nowrap='nowrap'><div align='center'>";
              echo $this->Form->submit("編集" , ['action'=>'hensyu', 'name' => $AccountYusyouzaiUkeires[$i]->id]) ;
              echo "</div></td>";
              ?>
            </tr>
          <?php endfor;?>
          </tbody>
      </table>
  <br><br>
