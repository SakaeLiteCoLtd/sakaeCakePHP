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

<?= $this->Form->create($kensahyouSokuteidata, ['url' => ['action' => 'preadd']]) ?>

<?php
    $data = $this->request->getData();
/*
    echo "<pre>";
    print_r($data['inspec_date']);
    echo "</pre>";
*/
    $manu_dateY = $data['manu_date']['year'];//manu_dateのyearに$manu_dateYと名前を付ける
    $manu_dateM = $data['manu_date']['month'];//manu_dateのmonthに$manu_dateMと名前を付ける
    $manu_dateD = $data['manu_date']['day'];//manu_dateのdayに$manu_dateDと名前を付ける
    $manu_dateYMD = array($manu_dateY,$manu_dateM,$manu_dateD);//$manu_dateY,$manu_dateM,$manu_dateDの配列に$manu_dateYMD
    $manu_date = implode("-",$manu_dateYMD);//$manu_dateY,$manu_dateM,$manu_dateDを「-」でつなぐ
    $this->set('manu_date',$manu_date);//セット

    if(isset($data['inspec_date']['year'])){
      $inspec_dateY = $data['inspec_date']['year'];//manu_dateのyearに$manu_dateYと名前を付ける
      $inspec_dateM = $data['inspec_date']['month'];//manu_dateのmonthに$manu_dateMと名前を付ける
      $inspec_dateD = $data['inspec_date']['day'];//manu_dateのdayに$manu_dateDと名前を付ける
      $inspec_dateYMD = array($inspec_dateY,$inspec_dateM,$inspec_dateD);//$manu_dateY,$manu_dateM,$manu_dateDの配列に$manu_dateYMD
      $inspec_date = implode("-",$inspec_dateYMD);//$manu_dateY,$manu_dateM,$manu_dateDを「-」でつなぐ
      $this->set('inspec_date',$inspec_dateD);//セット
    }else{
      $inspec_dateY = substr($data['inspec_date'],0,4);//inspec_dateのyearに$inspec_dateYと名前を付けるsubstr($data['inspec_date'],0,4)
      $inspec_dateM = substr($data['inspec_date'],5,2);//inspec_dateのmonthに$inspec_dateMと名前を付ける
      $inspec_dateD = substr($data['inspec_date'],8,2);//inspec_dateのdayに$inspec_dateDと名前を付ける
      $inspec_dateYMD = array($inspec_dateY,$inspec_dateM,$inspec_dateD);//$inspec_dateY,$inspec_dateM,$inspec_dateDの配列に$manu_dateYMD
      $inspec_date = implode("-",$inspec_dateYMD);//$inspec_dateY,$inspec_dateM,$inspec_dateDを「-」でつなぐ
      $this->set('inspec_date',$inspec_date);//セット
    }

    $session = $this->request->getSession();
    $username = $this->request->Session()->read('Auth.User.username');

    for($n=1; $n<=8; $n++){
            $resultArray = Array();
              $result_weight = $_POST["result_weight_{$n}"];
              $_SESSION['sokuteidata'][$n] = array(
                'kensahyou_heads_id' => $_POST['kensahyou_heads_id'],
                'product_code' => $_POST['product_code'],
                'lot_num' => $lot_num,
                'manu_date' => $manu_date,
                'inspec_date' => $inspec_date,
                'cavi_num' => $n,
                'delete_flag' => $_POST['delete_flag'],
      //          'created_staff' => $_POST['created_staff'],
                'updated_staff' => $_POST['updated_staff'],

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
    echo "<pre>";
    print_r($_SESSION['sokuteidata']);
    echo "</pre>";
*/
    $_SESSION['kadouseikeiId'] = $_POST['kadouseikeiId'];
/*
    echo "<pre>";
    print_r($_SESSION['kadouseikeiId']);
    echo "</pre>";
*/
?>

<br>
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
          <td colspan="9"><?= h($this->request->getData('lot_num')) ?></td>
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

<tr style='background-color: #FFFFFF;border-bottom: solid;border-width: 1px'>
  <td width='24' colspan='4'><div align='center'><strong>検査種類</strong></div></td>
  <?php
  $session = $this->request->getSession();
  $sessiondata = $session->read();//postデータ取得し、$dataと名前を付ける

    for($i=1; $i<=8; $i++){
      echo "<td colspan='2'><div align='center'>\n";
      if($sessiondata['sokuteidata'][1]["result_size_".$i] != ""){//もしも
        echo "<div align='center'><strong>\n";
        echo $this->request->getData("kind_kensa_{$i}");
        echo "</strong></div>\n";
//                  echo "<input type='text' value='test' size='6'/>\n";
        } else {
          echo "<div align='center'><strong>ノギス</strong></div>\n";
        }
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
