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
              $_SESSION['sokuteidata'] = array();
              $dotcheck = 0;
              $result_weight_total = 0;
              $result_weight_count = 0;
              $nyuuryokucount = 0;
              $mess = "";
              $nyuuryokucountcheck = 0;

              for($n=1; $n<=8; $n++){
                $nyuuryokucount = 0;
                $gyou_check = 0;
                $size_count = 0;
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

                        for($m=1; $m<=9; $m++){

                          $dot1 = substr($_POST["result_size_{$n}_{$m}"], 0, 1);
                          $dot2 = substr($_POST["result_size_{$n}_{$m}"], -1, 1);

                          if($dot1 == "." || $dot2 == "."){
                            $dotcheck = $dotcheck + 1;
                          }
                        }

                        for($m=1; $m<=8; $m++){

                          if(strlen($_POST["result_size_{$n}_{$m}"]) > 0){
                            $gyou_check = 1;
                            $size_count = $size_count + 1;
                            $nyuuryokucount = $nyuuryokucount + 1;
                          }

                        }

                        if($gyou_check == 1 && $size_count != $count_size){
                          $mess = $mess.$n."行目の測定データの個数が合いません。入力忘れ、余分な入力がないか確認してください。<br>";
                        }

                        if(strlen($_POST["result_size_{$n}_9"]) > 0){
                          $nyuuryokucount = $nyuuryokucount + 1;
                        }

                        if($gyou_check == 1 && $count_sori == 1 && strlen($_POST["result_size_{$n}_9"]) < 1){
                          $mess = $mess.$n."行目のソリ・フレがありません。入力漏れがないか確認してください。<br>";
                        }

                        if($_POST["situation_dist1_{$n}"] == "OK" || $_POST["situation_dist1_{$n}"] == "out"){
                          $nyuuryokucount = $nyuuryokucount + 1;
                        }

                        if($gyou_check == 1 && $count_text_10 == 1 && $_POST["situation_dist1_{$n}"] == ""){
                          $mess = $mess.$n."行目の外観１が選択されていません。漏れがないか確認してください。<br>";
                        }

                        if($_POST["situation_dist2_{$n}"] == "OK" || $_POST["situation_dist2_{$n}"] == "out"){
                          $nyuuryokucount = $nyuuryokucount + 1;
                        }

                        if($gyou_check == 1 && $count_text_11 == 1 && $_POST["situation_dist2_{$n}"] == ""){
                          $mess = $mess.$n."行目の外観２が選択されていません。漏れがないか確認してください。<br>";
                        }

                        if(strlen($_POST["result_weight_{$n}"]) > 0){

                          $dot1 = substr($_POST["result_weight_{$n}"], 0, 1);
                          $dot2 = substr($_POST["result_weight_{$n}"], -1, 1);

                          if($dot1 == "." || $dot2 == "."){
                            $dotcheck = $dotcheck + 1;
                          }else{
                            $result_weight_total = $result_weight_total + $_POST["result_weight_{$n}"];
                            $result_weight_count = $result_weight_count + 1;
                            $nyuuryokucount = $nyuuryokucount + 1;
                          }

                        }

                        if($gyou_check == 1 && strlen($_POST["result_weight_{$n}"]) < 1){
                          $mess = $mess.$n."行目の単重がありません。入力漏れがないか確認してください。<br>";
                        }
/*
                        echo "<pre>";
                        print_r($nyuuryokucount);
                        echo "</pre>";
*/
                        if($nyuuryokucount > 0 && $nyuuryokucount != $count_total){
                          $nyuuryokucountcheck = $nyuuryokucountcheck + 1;
                        }

              }

              if($result_weight_count == 0){
                $result_weight_ave = 0;
                $result_weight_20 = 0;
              }else{
                $result_weight_ave = round($result_weight_total / $result_weight_count, 1);
                $result_weight_20 = round($result_weight_ave * 0.2, 1);
              }

?>

<?php
 use App\myClass\Syukkakensa\htmlSyukkakensamenu;//myClassフォルダに配置したクラスを使用
 $htmlSyukkakensamenu = new htmlSyukkakensamenu();
 $htmlSyukkakensamenus = $htmlSyukkakensamenu->Syukkakensamenu();
 ?>
 <hr size="5" style="margin: 0.5rem">
 <table style="margin-bottom:0px" width="750" border="0" align="center" cellpadding="0" cellspacing="0" bordercolor="#CCCCCC">
 <?php
    echo $htmlSyukkakensamenus;
 ?>
 </table>
 <hr size="5" style="margin: 0.5rem">

 <?php if ($dotcheck < 1 && $nyuuryokucountcheck < 1): ?>

   <br>
   <legend align="left"><font color="red"><?= __($mess) ?></font></legend>
  <br>
<div align="center"><strong><font color="red">＊下記のように登録します</font></strong></div>
<br>

    <table width="1400" border="1" align="center" bordercolor="#000000" bgcolor="#FFFFFF" style="background-color: #FFFFFF">
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

                //データが平均プラスマイナス平均×0.2以内のときはOKそうでなければ赤文字
                if($this->request->getData("result_weight_{$q}") <= $result_weight_ave + $result_weight_20 && $this->request->getData("result_weight_{$q}") >= $result_weight_ave - $result_weight_20){
                  echo "<td colspan='2'><div align='center'>\n";
                  echo $this->request->getData("result_weight_{$q}");
                  echo "</td>\n";
                } else {
                echo '<td colspan="2"><div align="center"><font color="red">';
                echo $this->request->getData("result_weight_{$q}");
                echo '</div></td>';
                }


        //        echo "<td colspan='2'><div align='center'>\n";
        //        echo $this->request->getData("result_weight_{$q}");
        //        echo "</td>\n";


                echo "<td colspan='2'><div align='center'>\n";
                echo ${"hikaku_".$q};
                echo "</td>\n";
            }
        ?>
        </tr>
        <td height="120" colspan="28" style="vertical-align: top; border-bottom: solid;border-width: 1px;text-align: left">
          <strong style="text-align: left">備考：</strong><br>
                  <?= h($KensahyouHeadbik) ?>
              </td>
        </tr>
       <tr>
</table>

<br>
<br>
<table align="center" border="2" bordercolor="#E6FFFF" cellpadding="0" cellspacing="0">
<tr>
  <td style="border-style: none;"><div align="center"><?= $this->Form->submit('戻る', ['onclick' => 'history.back()', 'type' => 'button']); ?></div></td>
  <td style="border-style: none;"><div align="center"><?= $this->Form->submit('追加', array('name' => 'kakunin')); ?></div></td>
</tr>
</table>
<br>
<?= $this->Form->end() ?>

<?php else : ?>
  <?php
    if($dotcheck > 0){
      $mess = $mess."「 . 」で始まっているデータまたは「 . 」で終わっているデータがあります。　";
    }
  ?>

  <br>
  <legend align="center"><font color="red"><?= __($mess) ?></font></legend>
 <br>
  <table align="center" border="2" bordercolor="#E6FFFF" cellpadding="0" cellspacing="0">
  <tr>
    <td style="border-style: none;"><div align="center"><?= $this->Form->submit('戻る', ['onclick' => 'history.back()', 'type' => 'button']); ?></div></td>
  </tr>
  </table>
  <br>
  <?= $this->Form->end() ?>

<?php endif; ?>
