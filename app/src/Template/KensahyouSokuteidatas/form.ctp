<?php
/**
 * AuthHelper: Authの変数にアクセスできる
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\Deliver $priceMaterial
 */
 use Cake\ORM\TableRegistry;//独立したテーブルを扱う
$this->KensahyouHeads = TableRegistry::get('kensahyouHeads');//kensahyouHeadsテーブルを使う
$this->Products = TableRegistry::get('products');//productsテーブルを使う
?>
        <?php
          $username = $this->request->Session()->read('Auth.User.username');

          header('Expires:-1');
          header('Cache-Control:');
          header('Pragma:');
          
          echo $this->Form->hidden('product_code' ,['value'=>$product_code ]) ;
          echo $this->Form->create($kensahyouSokuteidata, ['url' => ['action' => 'confirm']]);
        ?>

    <fieldset>
<div align="center"><strong><font color="red">＊入力してください</font></strong></div>
<br>
    <table width="900" border="1" align="center" bordercolor="#000000" style="background-color: #FFFFFF">
        <tr style="border-bottom: solid;border-width: 1px">
          <td colspan="4" nowrap="nowrap"><div align="center"><strong>部品番号</strong></div></td>
          <td colspan="8" nowrap="nowrap"><?= h($product_code) ?></td>
          <td colspan="4" nowrap="nowrap"><div align="center"><strong>部品名</strong></div></td>
          <td colspan="8" nowrap="nowrap"><?= h($Productname) ?></td>
        </tr>
        <tr style="border-bottom: solid;border-width: 1px">
          <td colspan="4" nowrap="nowrap"><div align="center"><strong>新規バージョン</strong></div></td>
          <td colspan="8"><?= h($KensahyouHeadver) ?></td>
          <td colspan="12" nowrap="nowrap">&nbsp;</td>
        </tr>
        <tr style="border-bottom: solid;border-width: 1px">
          <td colspan="4" nowrap="nowrap"><div align="center"><strong>製造年月日</strong></div></td>
          <td colspan="8"><?= $this->Form->input("manu_date", array('type' => 'date', 'label'=>false)); ?></td>
          <td colspan="4" nowrap="nowrap"><div align="center"><strong>検査年月日</strong></div></td>
          <td colspan="8"><?= $this->Form->input("inspec_date", array('type' => 'date', 'label'=>false)); ?></td>
        </tr>
<?php
     echo $htmlKensahyouHeader; 
?>
        <?php
            $lowerArraygyou = Array();
            for($j=1; $j<=8; $j++){
                echo "<tr style='border-bottom: solid;border-width: 1px'><td nowrap='nowrap' colspan='4'><div align='center'><strong>\n";
                echo $j;
                echo "</strong></div></td>\n";
                    $resultArray = Array();
                    for($i=1; $i<=9; $i++){
                        echo "<td colspan='2'><div align='center'>\n";
                        echo "<input type='text' name=result_size_".$j."_".$i." value='' size='6'/>\n";
                        echo "</div></td>\n";
                    }
                echo "<td colspan='2'>\n";
                echo "<input type='text' name=result_weight_".$j." value='' size='6'/>\n";
                echo "</td>\n";
            }
        ?>
        </tr>
          <td height="120" colspan="24" style="border-bottom: solid;border-width: 1px">
	      <strong>備考：</strong><br>
              <textarea name="bik"  cols="120" rows="10"></textarea>
          </td>
        </tr>
       <tr>
</table>
<br>
<strong>　　*備考の欄内にはソリ・フレ値・外観の検査基準を外観の規格欄内の値と関連付けてください。</strong>
        <?php
            echo $this->Form->hidden('kensahyou_heads_id' ,['value'=>$KensahyouHeadid]);
            echo $this->Form->hidden('product_code' ,['value'=>$product_code]) ;
            echo $this->Form->hidden('delete_flag' ,['value'=>0]);
            echo $this->Form->hidden('created_staff', ['value'=>$staff_id]);
            echo $this->Form->hidden('updated_staff');
        ?>
    </fieldset>
    <center><?= $this->Form->button(__('confirm'), array('name' => 'kakunin')) ?></center>
    <?= $this->Form->end() ?>

