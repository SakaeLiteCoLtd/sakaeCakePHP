<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\Staff $staff
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

              echo $this->Form->create($kensahyouSokuteidata, ['url' => ['action' => 'preadd']]);
              $session = $this->request->getSession();


              for($n=1; $n<=8; $n++){
                      $resultArray = Array();
                        $result_weight = $_POST["result_weight_{$n}"];
                        $_SESSION['sokuteidata'][$n] = array(
                          'kensahyou_heads_id' => $KensahyouHeadid,
                          'product_code' => $product_code,
                          'lot_num' => $lot_num,
                          'manu_date' => $manu_date,
                          'inspec_date' => $inspec_date,
                          'cavi_num' => $n,
                          'delete_flag' => $delete_flag,
                          'updated_staff' => $updated_staff,

                          "result_size_1" => $_POST["result_size_{$n}_1"],
                          "result_size_2" => $_POST["result_size_{$n}_2"],
                          "result_size_3" => $_POST["result_size_{$n}_3"],
                          "result_size_4" => $_POST["result_size_{$n}_4"],
                          "result_size_5" => $_POST["result_size_{$n}_5"],
                          "result_size_6" => $_POST["result_size_{$n}_6"],
                          "result_size_7" => $_POST["result_size_{$n}_7"],
                          "result_size_8" => $_POST["result_size_{$n}_8"],
                          "result_size_9" => $_POST["result_size_{$n}_9"],

                          'result_weight' => $_POST["result_weight_{$n}"],
                          'situation_dist1' => $_POST["situation_dist1_{$n}"],
                          'situation_dist2' => $_POST["situation_dist2_{$n}"],
                        );
              }
/*
              for($n=1; $n<=8; $n++){
                      $resultArray = Array();
                      for($k=1; $k<=9; $k++){
                          echo "<input type='hidden' name=sokuteidata[$n][kensahyou_heads_id] value='$KensahyouHeadid' />\n";
                          echo "<input type='hidden' name=sokuteidata[$n][product_code] value='$product_code' />\n";
                          echo "<input type='hidden' name=sokuteidata[$n][lot_num] value='$lot_num' />\n";
                          echo "<input type='hidden' name=sokuteidata[$n][manu_date] value='$manu_date' size='6'/>\n";
                          echo "<input type='hidden' name=sokuteidata[$n][inspec_date] value='$inspec_date' size='6'/>\n";
                          echo "<input type='hidden' name=sokuteidata[$n][cavi_num] value='{$n}' size='6'/>\n";
                          echo "<input type='hidden' name=sokuteidata[$n][delete_flag] value='$delete_flag' size='6'/>\n";
                    //      echo "<input type='hidden' name=sokuteidata[$n][created_staff] value='$created_staff' size='6'/>\n";
                          echo "<input type='hidden' name=sokuteidata[$n][updated_staff] value='$updated_staff' size='6'/>\n";

                          $result_size = $_POST["result_size_{$n}_{$k}"];

                          echo "<input type='hidden' name=sokuteidata[$n][result_size_$k] value='$result_size' size='6'/>\n";

                          $result_weight = $_POST["result_weight_{$n}"];

                          echo "<input type='hidden' name=sokuteidata[$n][result_weight] value='$result_weight' size='6'/>\n";
                      }
              }
*/
?>

              <p align="center"><?php echo $this->Html->image('ShinkiTourokuMenu/touroku.gif',array('width'=>'157','height'=>'50'));?></p>

<hr size="5">
<div align="center"><strong><font color="red">＊下記のように登録します</font></strong></div>
<br>

    <table width="1200" border="1" align="center" bordercolor="#000000" bgcolor="#FFFFFF" style="background-color: #FFFFFF">
        <tr style="border-bottom: solid;border-width: 1px">
          <td colspan="5" nowrap="nowrap"><div align="center"><strong>部品番号</strong></div></td>
          <td colspan="9" nowrap="nowrap"><?= h($this->request->getData('product_code')) ?></td>
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
          <td colspan="9"><?= h($manu_date) ?></td>
          <td colspan="5" nowrap="nowrap"><div align="center"><strong>検査年月日</strong></div></td>
          <td colspan="9"><?= h($inspec_date) ?></td>
        </tr>

<?php
     echo $htmlKensahyouHeader;
?>

        <?php
        echo "<tr style='border-bottom: solid;border-width: 1px'><td nowrap='nowrap' colspan='4'><div align='center'><strong>\n";
        echo "検査種類";
        echo "</strong></div></td>\n";
        $kensaArray = Array();
        for($i=1; $i<=9; $i++){

          echo "<td colspan='2'><div align='center'>\n";
          echo ${"ImKikakuid_".$i};
          echo "</div></td>\n";

//        echo "<td colspan='2'><div align='center'>\n";
//        echo "ノギス";
//        echo "</strong></div></td>\n";
        }
        echo "<td colspan='2'>\n";
        echo "</td>\n";
        echo "<td colspan='2'>\n";
        echo "</td>\n";
        echo "<td colspan='2'>\n";
        echo "</td>\n";

            $lowerArraygyou = Array();
            for($q=1; $q<=8; $q++){
              echo '<tr style="border-bottom: solid;border-width: 1px"><td nowrap="nowrap" colspan="4"><div align="center"><strong>';
              echo $q;
              echo '</strong></div></td>';

              $lowerArray = Array();
              for($r=1; $r<=8; $r++){
                	if($this->request->getData("result_size_{$q}_{$r}") <= ${"size_".$r}+${"upper_".$r} && $this->request->getData("result_size_{$q}_{$r}") >= ${"size_".$r}+${"lower_".$r}){
                  echo '<td colspan="2"><div align="center">';
                  echo $this->request->getData("result_size_{$q}_{$r}") ;
                  echo '</div></td>';
                  } else {
                  echo '<td colspan="2"><div align="center"><font color="red">';
                  echo $this->request->getData("result_size_{$q}_{$r}") ;
                  echo '</div></td>';
                	}
              }
                echo "<td colspan='2'><div align='center'>\n";
                echo $this->request->getData("result_size_{$q}_9");
                echo "</td>\n";
                echo "<td colspan='2'>\n";
                echo $this->request->getData("situation_dist1_{$q}");
                echo "</td>\n";
                echo "<td colspan='2'>\n";
                echo $this->request->getData("situation_dist2_{$q}");
                echo "</td>\n";
                echo "<td colspan='2'><div align='center'>\n";
                echo $this->request->getData("result_weight_{$q}");
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
<br>

        <p align="center"><?= $this->Form->button('back', ['onclick' => 'history.back()', 'type' => 'button']) ?>
        <?= $this->Form->button(__('OK'), array('name' => 'touroku')) ?></p>

        <?= $this->Form->end() ?>
