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
     <td style="padding: 0.1rem 0.1rem; text-align: center"><?php echo $this->Html->image('Labelimg/accountYusyouzaiMasterKensaku.gif');?></td>
   </tr>
 </table>
<br><br>

  <?= $this->Form->create($user, ['url' => ['action' => 'yusyouzaisyusei']]) ?>

  <table align="center" border="2" bordercolor="#E6FFFF" cellpadding="0" cellspacing="0">
    <tbody border="2" bordercolor="#E6FFFF" bgcolor="#FFFFCC" style="border-bottom: solid;border-width: 1px">
          <thead>
              <tr border="2" bordercolor="#E6FFFF" bgcolor="#FFFFCC">
                <td width="200" height="30" colspan="20" nowrap="nowrap"><div align="center"><strong style="font-size: 13pt; color:blue">会社名</strong></div></td>
                <td width="150" height="30" colspan="20" nowrap="nowrap"><div align="center"><strong style="font-size: 13pt; color:blue">品番</strong></div></td>
                <td width="150" height="30" colspan="20" nowrap="nowrap"><div align="center"><strong style="font-size: 13pt; color:blue">品名</strong></div></td>
                <td width="150" height="30" colspan="20" nowrap="nowrap"><div align="center"><strong style="font-size: 13pt; color:blue">単価</strong></div></td>
                <td width="150" height="30" colspan="20" nowrap="nowrap"><div align="center"><strong style="font-size: 13pt; color:blue">数量</strong></div></td>
                <td width="60" height="30" colspan="20" nowrap="nowrap"><div align="center"><strong style="font-size: 9pt; color:blue"></strong></div></td>
              </tr>
          </thead>
          <tbody border="2" bordercolor="#E6FFFF" bgcolor="#FFFFCC">
            <?php for($i=0; $i<count($AccountYusyouzaiMasters); $i++): ?>
            <tr style="border-bottom: solid;border-width: 1px">

              <?php
              $customer_code = $AccountYusyouzaiMasters[$i]->customer_code;
              $CustomersData = $this->Customers->find()->where(['customer_code' => $customer_code])->toArray();
              if(isset($CustomersData[0])){
                $customer = $CustomersData[0]->name;
              }else{
                $customer = "";
              }
/*
              $product_code = $AccountYusyouzaiMasters[$i]->product_code;
              $Product = $this->Products->find()->where(['product_code' => $product_code])->toArray();
              if(isset($Product[0])){
                $product_name = $Product[0]->product_name;
              }else{
                $product_name = "";
              }
*/
              if($AccountYusyouzaiMasters[$i]->flag_product_material == 1){
                $Type = "原料";
              }else{
                $Type = "製品";
              }
              ?>

              <td colspan="20" nowrap="nowrap"><font><?= h($customer) ?></font></td>
              <td colspan="20" nowrap="nowrap"><font><?= h($AccountYusyouzaiMasters[$i]->product_code) ?></font></td>
              <td colspan="20" nowrap="nowrap"><font><?= h($AccountYusyouzaiMasters[$i]->product_name) ?></font></td>
              <td colspan="20" nowrap="nowrap"><font><?= h($AccountYusyouzaiMasters[$i]->price) ?></font></td>
              <td colspan="20" nowrap="nowrap"><font><?= h($Type) ?></font></td>
              <?php
              echo "<td colspan='20' nowrap='nowrap'><div align='center'>";
              echo $this->Form->submit("編集" , ['action'=>'hensyu', 'name' => $AccountYusyouzaiMasters[$i]->id]) ;
              echo "</div></td>";
              ?>
            </tr>
          <?php endfor;?>
          </tbody>
      </table>
  <br><br>
