<?php
$this->layout = 'defaultaccount';
?>

<?php
use App\myClass\Shinkimenus\htmlShinkimenu;//myClassフォルダに配置したクラスを使用
use Cake\ORM\TableRegistry;//独立したテーブルを扱う
$this->ProductSuppliers = TableRegistry::get('productSuppliers');
$this->AccountKaikakeElements = TableRegistry::get('accountKaikakeElements');
?>
<?php
  header('Expires:-1');
  header('Cache-Control:');
  header('Pragma:');
?>
<?php
    $htmlShinkimenu = new htmlShinkimenu();
    $htmlaccountmenus = $htmlShinkimenu->accountmenus();
    $htmlkaikakemenus = $htmlShinkimenu->kaikakemenus();
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
       echo $htmlkaikakemenus;
  ?>
</table>
<hr size="5" style="margin: 0.5rem">
<br>
<table style="margin-bottom:0px" width="750" border="0" align="center" cellpadding="0" cellspacing="0" bordercolor="#CCCCCC">
   <tr style="background-color: #E6FFFF">
     <td style="padding: 0.1rem 0.1rem; text-align: center"><?php echo $this->Html->image('Labelimg/accountProductKaikakeKensaku.gif');?></td>
   </tr>
 </table>
<br><br>

  <?= $this->Form->create($user, ['url' => ['action' => 'productkaikakesyusei']]) ?>

  <table align="center" border="2" bordercolor="#E6FFFF" cellpadding="0" cellspacing="0">
    <tbody border="2" bordercolor="#E6FFFF" bgcolor="#FFFFCC" style="border-bottom: solid;border-width: 1px">
          <thead>
              <tr border="2" bordercolor="#E6FFFF" bgcolor="#FFFFCC">
                <td width="200" height="30" colspan="20" nowrap="nowrap"><div align="center"><strong style="font-size: 13pt; color:blue">会社名</strong></div></td>
                <td width="200" height="30" colspan="20" nowrap="nowrap"><div align="center"><strong style="font-size: 13pt; color:blue">項目</strong></div></td>
                <td width="200" height="30" colspan="20" nowrap="nowrap"><div align="center"><strong style="font-size: 13pt; color:blue">受入日</strong></div></td>
                <td width="200" height="30" colspan="20" nowrap="nowrap"><div align="center"><strong style="font-size: 13pt; color:blue">受入金額</strong></div></td>
                <td width="60" height="30" colspan="20" nowrap="nowrap"><div align="center"><strong style="font-size: 9pt; color:blue"></strong></div></td>
              </tr>
          </thead>
          <tbody border="2" bordercolor="#E6FFFF" bgcolor="#FFFFCC">
            <?php for($i=0; $i<count($AccountProductKaikakes); $i++): ?>
            <tr style="border-bottom: solid;border-width: 1px">

              <?php

              $ProductSupplierData = $this->ProductSuppliers->find()->where(['id' => $AccountProductKaikakes[$i]->sup_id])->toArray();
              if(isset($ProductSupplierData[0])){
                $ProductSupplier = $ProductSupplierData[0]->name;
              }else{
                $ProductSupplier = "ProductSuppliersテーブルに登録されていません。";
              }

              $AccountKaikakeElementData = $this->AccountKaikakeElements->find()->where(['id' => $AccountProductKaikakes[$i]->kaikake_element_id])->toArray();
              $AccountKaikakeElement = $AccountKaikakeElementData[0]->element;

              ?>

              <td colspan="20" nowrap="nowrap"><font><?= h($ProductSupplier) ?></font></td>
              <td colspan="20" nowrap="nowrap"><font><?= h($AccountKaikakeElement) ?></font></td>
              <td colspan="20" nowrap="nowrap"><font><?= h($AccountProductKaikakes[$i]->date) ?></font></td>
              <td colspan="20" nowrap="nowrap"><font><?= h($AccountProductKaikakes[$i]->kingaku) ?></font></td>
              <?php
              echo "<td colspan='20' nowrap='nowrap'><div align='center'>";
              echo $this->Form->submit("編集" , ['action'=>'hensyu', 'name' => $AccountProductKaikakes[$i]->id]) ;
              echo "</div></td>";
              ?>
            </tr>
          <?php endfor;?>
          </tbody>
      </table>
  <br><br>
