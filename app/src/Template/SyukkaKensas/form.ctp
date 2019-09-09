<?php
/**
 * AuthHelper: Authの変数にアクセスできる
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\Deliver $priceMaterial
 */
 use Cake\ORM\TableRegistry;//独立したテーブルを扱う
$this->KensahyouHeads = TableRegistry::get('kensahyouHeads');//kensahyouHeadsテーブルを使う
$this->Products = TableRegistry::get('products');//productsテーブルを使う
$this->ImSokuteidataHeads = TableRegistry::get('imSokuteidataHeads');//productsテーブルを使う
$this->ImKikakus = TableRegistry::get('imKikakus');//productsテーブルを使う
$this->ImSokuteidataResults = TableRegistry::get('imSokuteidataResults');//productsテーブルを使う
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
          <td colspan="4" nowrap="nowrap"><div align="center"><strong>ロット番号</strong></div></td>
          <td colspan="8"><?= h($lot_num) ?></td>
        </tr>
        <tr style="border-bottom: solid;border-width: 1px">
          <td colspan="4" nowrap="nowrap"><div align="center"><strong>製造年月日</strong></div></td>
          <td colspan="8"><?= $this->Form->input("manu_date", array('type' => 'date', 'label'=>false)); ?></td>
          <?php
            $ImSokuteidataHead = $this->ImSokuteidataHeads->find()->where(['lot_num' => $lot_num])->toArray();
            $inspec_date = $ImSokuteidataHead[0]->inspec_date;
            $ImSokuteidataHead_id = $ImSokuteidataHead[0]->id;

          ?>
          <td colspan="4" nowrap="nowrap"><div align="center"><strong>検査年月日</strong></div></td>
          <td colspan="8"><?= h($inspec_date) ?></td>
        </tr>

  <?php
  $ImKikaku = $this->ImKikakus->find()->where(['im_sokuteidata_head_id' => $ImSokuteidataHead_id])->toArray();
  $ImKikaku_id = $ImKikaku[0]->size;

  $KensahyouHead = $this->KensahyouHeads->find()->where(['id' => $KensahyouHeadid])->toArray();

  $k = 0;
  $l = 0;
    for($j=0; $j<=10; $j++){
      if(isset($ImKikaku[$j])){
        $k = $k + 1;
        ${"im_size_".$k} = $ImKikaku[$j]['size'];
//        echo "<pre>";
//        echo ${"im_size_".$k};
//        echo "</pre>";
    	} else {
//        echo "<pre>";
//        echo $k;
//        echo "</pre>";
        $ImKikaku_num = $k;
        break;
      }
    }
    for($m=1; $m<=10; $m++){
      if(isset($KensahyouHead[0]["size_".$m])){
        $l = $l + 1;
        ${"Kensahyou_size_".$m} = $KensahyouHead[0]["size_".$m];
//        echo "<pre>";
//        echo ${"Kensahyou_size_".$m};
//        echo "</pre>";
    	} else {
//        echo "<pre>";
//        echo $l;
//        echo "</pre>";
        $KensahyouHead_num = $l;
        break;
      }
    }

    for($p=1; $p<=$ImKikaku_num; $p++){
      echo "<pre>";
      echo ${"im_size_".$p};
      echo "</pre>";
    }
    for($q=1; $q<=$KensahyouHead_num; $q++){
      echo "<pre>";
      echo ${"Kensahyou_size_".$q};
      echo "</pre>";
    }
  ?>

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
                      if($i == 1){//もしも${"Kensahyou_size_".$m}=${"im_size_".$k}…size_num=$kのresultをserial=0001~0004まで表示
                        echo "<input type='text' name=result_size_".$j."_".$i." value=$i size='6'/>\n";
                      } else {
                        echo "<input type='text' name=result_size_".$j."_".$i." value='' size='6'/>\n";
                      }
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
