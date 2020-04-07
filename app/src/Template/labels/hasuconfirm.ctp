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
   echo $this->Form->create($orderEdis, ['url' => ['action' => 'hasudo']]);
   $i = 1 ;
   $p = 0 ;
?>
<?php
header('Expires:-1');
header('Cache-Control:');
header('Pragma:');

$data = $this->request->getData();
?>

<br><br><br>
<table align="center" border="2" bordercolor="#E6FFFF" cellpadding="0" cellspacing="0">
  <tbody border="2" bordercolor="#E6FFFF" bgcolor="#FFFFCC" style="border-bottom: solid;border-width: 1px">
        <thead>
          <tr border="2" bordercolor="#E6FFFF" bgcolor="#FFFFCC">
            <td width="310" height="30" colspan="20" nowrap="nowrap"><div align="center"><strong style="font-size: 12pt; color:blue">品番</strong></div></td>
            <td width="320" height="30" colspan="20" nowrap="nowrap"><div align="center"><strong style="font-size: 12pt; color:blue">品名</strong></div></td>
            <td width="150" height="30" colspan="20" nowrap="nowrap"><div align="center"><strong style="font-size: 12pt; color:blue">端数</strong></div></td>
          </tr>
        </thead>
        <tbody border="2" bordercolor="#E6FFFF" bgcolor="#FFFFCC">
          <?php for ($i=0;$i<$i_num+1;$i++): ?>
            <?php foreach (${"orderEdis".$i} as ${"orderEdis".$i}): ?>
            <tr style="border-bottom: solid;border-width: 1px">
              <td colspan="20" nowrap="nowrap"><?= h(${"orderEdis".$i}->product_code) ?></td>
                <?php
                  $product_code = ${"orderEdis".$i}->product_code;
              		$Product = $this->Products->find()->where(['product_code' => $product_code])->toArray();
              		$product_name = $Product[0]->product_name;

                  $amount = ${"orderEdis".$i}->amount;
                  $Konpou = $this->Konpous->find()->where(['product_code' => $product_code])->toArray();
                  if(isset($Konpou[0])){
                    $irisu = $Konpou[0]->irisu;
                    $hasu = $amount % $irisu;
                  }else{
                    $hasu = "konpousテーブルに登録されていません！責任者に報告してください";
                  }
                ?>
                <td colspan="20" nowrap="nowrap"><?= h($product_name) ?></td>
                <td colspan="20" nowrap="nowrap"><?= h($hasu) ?></td>

            <?php
             $i_count = $i;
             echo $this->Form->hidden('i_count' ,['value'=>$i_count]);
             echo $this->Form->hidden("orderEdis_".$i ,['value'=>${"orderEdis".$i}->id]);

            if($hasu == 0){
              $p = $p;
            }else{
              $_SESSION['labelhasu'][$p] = array(
                'product_code' => ${"orderEdis".$i}->product_code,
                'amount' => $amount,
                'hasu' => $hasu
              );
              $p = $p + 1;
            }

            ?>

            </tr>
            <?php endforeach; ?>
          <?php endfor;?>

        </tbody>
    </table>
<br>
<table align="left" border="2" bordercolor="#E6FFFF" cellpadding="0" cellspacing="0">
<tr>
  <td style="border-style: none;"><div align="center"><?= $this->Form->submit('csv発行', array('name' => 'hakkou')); ?></div></td>
</tr>
</table>

<?=$this->Form->end() ?>

</form>
