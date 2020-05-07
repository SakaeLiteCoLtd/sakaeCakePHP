<?php
 use App\myClass\Labelmenus\htmlLabelmenu;//myClassフォルダに配置したクラスを使用
 $htmlLabelmenu = new htmlLabelmenu();
 $htmlLabels = $htmlLabelmenu->Labelmenus();
 ?>
 <hr size="5" style="margin: 0.5rem">
 <table style="margin-bottom:0px" width="750" border="0" align="center" cellpadding="0" cellspacing="0" bordercolor="#CCCCCC">
 <?php
    echo $htmlLabels;
 ?>
 </table>
 <hr size="5" style="margin: 0.5rem">
 <?php
   $username = $this->request->Session()->read('Auth.User.username');
   use Cake\ORM\TableRegistry;//独立したテーブルを扱う
   $this->Products = TableRegistry::get('products');//productsテーブルを使う
   $this->Konpous = TableRegistry::get('konpous');//productsテーブルを使う
   echo $this->Form->create($orderEdis, ['url' => ['action' => 'hasuconfirm']]);
   $i = 0 ;
?>
<?php
header('Expires:-1');
header('Cache-Control:');
header('Pragma:');

  $data = $this->request->getData();
  $Data=$this->request->query();

?>

<br><br><br><br>

<table align="center" border="2" bordercolor="#E6FFFF" cellpadding="0" cellspacing="0">
  <tbody border="2" bordercolor="#E6FFFF" bgcolor="#FFFFCC">
    <tr>
      <td width="350" colspan="20" nowrap="nowrap"><div align="center"><strong style="font-size: 15pt; color:blue">納入日指定</strong></div></td>
      <td rowspan="2" width="150"  style="border-bottom: solid;border-width: 1px"><div align="center"><?= $this->Form->submit(__('呼出'), array('name' => 'yobidasi')); ?></div></td>
    </tr>
      <td width="250" colspan="20" style="border-bottom: solid;border-width: 1px"><div align="center"><?= $this->Form->input("data_yobidashi", array('type' => 'date', 'value' => $data_yobidashi, 'monthNames' => false, 'label'=>false)); ?></div></td>
</table>
<br><br>


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
                <td width="250" height="30" colspan="20" nowrap="nowrap"><div align="center"><strong style="font-size: 12pt; color:blue">品番</strong></div></td>
                <td width="300" height="30" colspan="20" nowrap="nowrap"><div align="center"><strong style="font-size: 12pt; color:blue">品名</strong></div></td>
                <td width="150" height="30" colspan="20" nowrap="nowrap"><div align="center"><strong style="font-size: 12pt; color:blue">端数</strong></div></td>
              </tr>
          </thead>
          <tbody border="2" bordercolor="#E6FFFF" bgcolor="#FFFFCC">
              <?php foreach ($arrProcode as $arrProcode): ?>
              <tr style="border-bottom: solid;border-width: 1px">
                <?php
                echo "<td colspan='10' nowrap='nowrap'>\n";
                echo "<input type='checkbox' name=check".$i."  size='6'/>\n";
                echo "<input type='hidden' name=product_code".$i." value=${"product_code".$i} size='6'/>\n";//チェックされたもののidをキープする
                echo "<input type='hidden' name=hasu".$i." value=${"hasu".$i} size='6'/>\n";
                echo "<input type='hidden' name=".$i." value=$i size='6'/>\n";//チェックされたもののidをキープする
                echo "</td>\n";
                ?>
                <td width="250" colspan="20" nowrap="nowrap"><?= h(${"product_code".$i}) ?></td>
                  <?php
            //      $product_code = $orderEdis->product_code;
                		$Product = $this->Products->find()->where(['product_code' => ${"product_code".$i}])->toArray();
                		$product_name = $Product[0]->product_name;
/*
                    $amount = $orderEdis->amount;
                    $Konpou = $this->Konpous->find()->where(['product_code' => $product_code])->toArray();
                    if(isset($Konpou[0])){
                      $irisu = $Konpou[0]->irisu;
                      $hasu = $amount % $irisu;
                    }else{
                      $hasu = "konpousテーブルに登録されていません！責任者に報告してください";
                    }
  */
                  ?>
                <td width="300" colspan="20" nowrap="nowrap"><?= h($product_name) ?></td>
                <td width="200" colspan="20" nowrap="nowrap"><?= h(${"hasu".$i}) ?></td>
              </tr>
              <?php
              $i = $i + 1 ;
              $this->set('i',$i);
               ?>
              <?php endforeach; ?>

             <?php
             echo "<input type='hidden' name='nummax' value=$i size='6'/>\n";
              ?>

          </tbody>
      </table>
  <br>
  <table align="left" border="2" bordercolor="#E6FFFF" cellpadding="0" cellspacing="0">
  <tr>
  <td style="border-style: none;"><div align="center"><?= $this->Form->submit('csv発行準備', array('name' => 'hakkou')); ?></div></td>
  </tr>
  </table>
  <?=$this->Form->end() ?>
</form>
