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
//          echo $this->Form->hidden('lot_num', ['value'=>$lot_num]);
          echo $this->Form->create($kensahyouSokuteidata, ['url' => ['action' => 'confirm']]);
        ?>

    <fieldset>
<div align="center"><strong><font color="red">＊入力してください</font></strong></div>
<br>
    <table width="1200" border="1" align="center" bordercolor="#000000" style="background-color: #FFFFFF">
        <tr style="border-bottom: solid;border-width: 1px">
          <td colspan="5" nowrap="nowrap"><div align="center"><strong>部品番号</strong></div></td>
          <td colspan="9" nowrap="nowrap"><?= h($product_code) ?></td>
          <td colspan="5" nowrap="nowrap"><div align="center"><strong>部品名</strong></div></td>
          <td colspan="9" nowrap="nowrap"><?= h($Productname) ?></td>
        </tr>
        <tr style="border-bottom: solid;border-width: 1px">
          <td colspan="5" nowrap="nowrap"><div align="center"><strong>新規バージョン</strong></div></td>
          <td colspan="9"><?= h($KensahyouHeadver) ?></td>
          <td colspan="5" nowrap="nowrap"><div align="center"><strong>ロット番号</strong></div></td>
          <td colspan="9"><?= h($lot_num) ?></td>
        </tr>
        <tr style="border-bottom: solid;border-width: 1px">
          <td colspan="5" nowrap="nowrap"><div align="center"><strong>製造年月日</strong></div></td>
          <td colspan="9"><?= $this->Form->input("manu_date", array('type' => 'date', 'monthNames' => false, 'label'=>false)); ?></td>
          <?php
            $ImSokuteidataHead = $this->ImSokuteidataHeads->find()->where(['lot_num' => $lot_num])->toArray();
            if(isset($ImSokuteidataHead[0])){
              $inspec_date = $ImSokuteidataHead[0]->inspec_date;
              $ImSokuteidataHead_id = $ImSokuteidataHead[0]->id;
            }
          ?>
          <td colspan="5" nowrap="nowrap"><div align="center"><strong>検査年月日</strong></div></td>
          <?php if(isset($ImSokuteidataHead[0])): ?>
            <td colspan="9"><?= h($inspec_date) ?></td>
        <?php else : ?>
          <td colspan="9"><?= $this->Form->input("inspec_date", array('type' => 'date', 'monthNames' => false, 'label'=>false)); ?></td>
        <?php endif; ?>

        </tr>

  <?php
  if(isset($ImSokuteidataHead[0])){
    $ImKikaku = $this->ImKikakus->find()->where(['im_sokuteidata_head_id' => $ImSokuteidataHead_id])->toArray();
    $ImKikaku_id = $ImKikaku[0]->size;
  }
  $KensahyouHead = $this->KensahyouHeads->find()->where(['id' => $KensahyouHeadid])->toArray();
    $l = 0;
    for($m=1; $m<=10; $m++){
      if(isset($KensahyouHead[0]["size_".$m])){
        $l = $l + 1;
        ${"Kensahyou_size_".$m} = $KensahyouHead[0]["size_".$m];
        $ImKikaku = $this->ImKikakus->find()->where(['size' => ${"Kensahyou_size_".$m}])->toArray();
        if(isset($ImKikaku[0])){
        ${"ImKikaku_size_num_".$m} = $ImKikaku[0]->size_num;
//        echo "<pre>";
//        echo $ImKikaku[0];
//        echo "</pre>";
      } else {
        ${"ImKikaku_size_num_".$m} = 0;
     }
    	 } else {
         $KensahyouHead_num = $l;
         break;
      }
    }
/*
     for($q=1; $q<=$KensahyouHead_num; $q++){
       $ImSokuteidataResult = $this->ImSokuteidataResults->find()->where(['im_sokuteidata_head_id' => $ImSokuteidataHead_id , 'size_num' => ${"ImKikaku_size_num_".$q}])->toArray();
       foreach ((array)$ImSokuteidataResult as $key => $value) {//serialで並び替え
            $sort[$key] = $value['serial'];
        }
        if(isset($ImSokuteidataResult[0])){
         array_multisort($sort, SORT_ASC, $ImSokuteidataResult);
         $cnt = count($ImSokuteidataResult);
         for($r=1; $r<=$cnt; $r++){
           $r1 = $r-1;
           ${"ImSokuteidata_result_".$q."_".$r} = $ImSokuteidataResult[$r1]->result;
           ${"ImSokuteidata_result_".$q."_".$r} = round(${"ImSokuteidata_result_".$q."_".$r},2);
          }
        }
      }
*/
  ?>

<?php
     echo $htmlKensahyouHeader;
?>

        <tr style='background-color: #FFFFFF;border-bottom: solid;border-width: 1px'>
          <td width='24' colspan='4'><div align='center'><strong>検査種類</strong></div></td>
          <?php
            for($i=1; $i<=8; $i++){
              echo "<td colspan='2'><div align='center'>\n";
      //        if(isset(${"ImSokuteidata_result_".$i."_1"})){//もしも
                echo "<div align='center'><strong>\n";
                echo ${"kind_kensa".$i};
                echo "</strong></div>\n";
      //        } else {
      //            echo "<div align='center'><strong>ノギス</strong></div>\n";
      //        }
                  echo "</div></td>\n";
              }
              echo "</td>\n";
              echo "<td colspan='2'>\n";
              echo "</td>\n";
              echo "<td colspan='2'>\n";
              echo "</td>\n";
          ?>
          <td colspan='2'>&nbsp;</td>
          <td colspan='2'>&nbsp;</td>
        </tr>

        <?php
            $lowerArraygyou = Array();
            for($j=1; $j<=8; $j++){
                echo "<tr style='border-bottom: solid;border-width: 1px'><td nowrap='nowrap' colspan='4'><div align='center'><strong>\n";
                echo $j;
                echo "</strong></div></td>\n";
                    $resultArray = Array();
                    for($i=1; $i<=9; $i++){
                        echo "<td colspan='2'><div align='center'>\n";
                      if(isset(${"ImSokuteidata_result_".$i."_".$j})){//もしも
                        echo "<input type='text' name=result_size_".$j."_".$i." value=${"ImSokuteidata_result_".$i."_".$j} size='6'/>\n";
                      } else {
                        echo "<input type='text' name=result_size_".$j."_".$i." value='' size='6'/>\n";
                      }
                        echo "</div></td>\n";
                    }
                    echo "<td colspan='2'><div align='center'><select name=situation_dist1_".$j.">\n";
                    foreach ($arrhantei as $value){
                    echo "<option value=$value>$value</option>";
                    }
                    echo "</select></div></td>\n";
                    echo "<td colspan='2'><div align='center'><select name=situation_dist2_".$j.">\n";
                    foreach ($arrhantei as $value){
                    echo "<option value=$value>$value</option>";
                    }
                    echo "</select></div></td>\n";
                    echo "<td colspan='2'>\n";
                    echo "<input type='text' name=result_weight_".$j." value='' size='6'/>\n";
                    echo "</td>\n";
            }
        ?>

        </tr>
          <td height="120" colspan="28" style="border-bottom: solid;border-width: 1px">
            <strong>備考：</strong><br>
                  <?= h($KensahyouHeadbik) ?>
              </td>
        </tr>
       <tr>
</table>
<br>
<strong>　　*備考の欄内にはソリ・フレ値・外観の検査基準を外観の規格欄内の値と関連付けてください。</strong>

        <?php
        if(isset($ImSokuteidataHead[0])){
        echo $this->Form->hidden('inspec_date' ,['value'=>$inspec_date]);
        echo $this->Form->hidden('kensahyou_heads_id' ,['value'=>$KensahyouHeadid]);
        echo $this->Form->hidden('product_code' ,['value'=>$product_code]) ;
        echo $this->Form->hidden('delete_flag' ,['value'=>0]);
        echo $this->Form->hidden('created_staff', ['value'=>$staff_id]);
        echo $this->Form->hidden('updated_staff');
      }else{
        echo $this->Form->hidden('kensahyou_heads_id' ,['value'=>$KensahyouHeadid]);
        echo $this->Form->hidden('product_code' ,['value'=>$product_code]) ;
        echo $this->Form->hidden('delete_flag' ,['value'=>0]);
        echo $this->Form->hidden('created_staff', ['value'=>$staff_id]);
        echo $this->Form->hidden('updated_staff');
      }
        ?>
    </fieldset>
    <table align="center" border="2" bordercolor="#E6FFFF" cellpadding="0" cellspacing="0">
    <tr>
      <td style="border-style: none;"><div align="center"><?= $this->Form->submit(__('確認'), array('name' => 'kakunin')); ?></div></td>
    </tr>
  </table>
<br>
    <fieldset>
      <?= $this->Form->control('lot_num', array('type'=>'hidden', 'value'=>$lot_num, 'label'=>false)) ?>
      <?= $this->Form->control('kind_kensa_1', array('type'=>'hidden', 'value'=>$kind_kensa1, 'label'=>false)) ?>
      <?= $this->Form->control('kind_kensa_2', array('type'=>'hidden', 'value'=>$kind_kensa2, 'label'=>false)) ?>
      <?= $this->Form->control('kind_kensa_3', array('type'=>'hidden', 'value'=>$kind_kensa3, 'label'=>false)) ?>
      <?= $this->Form->control('kind_kensa_4', array('type'=>'hidden', 'value'=>$kind_kensa4, 'label'=>false)) ?>
      <?= $this->Form->control('kind_kensa_5', array('type'=>'hidden', 'value'=>$kind_kensa5, 'label'=>false)) ?>
      <?= $this->Form->control('kind_kensa_6', array('type'=>'hidden', 'value'=>$kind_kensa6, 'label'=>false)) ?>
      <?= $this->Form->control('kind_kensa_7', array('type'=>'hidden', 'value'=>$kind_kensa7, 'label'=>false)) ?>
      <?= $this->Form->control('kind_kensa_8', array('type'=>'hidden', 'value'=>$kind_kensa8, 'label'=>false)) ?>
      <?= $this->Form->control('kadouseikeiId', array('type'=>'hidden', 'value'=>$kadouseikeiId, 'label'=>false)) ?>
    </fieldset>

    <?= $this->Form->end() ?>
