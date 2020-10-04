<?php
/**
 * AuthHelper: Authの変数にアクセスできる
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\Staff $staff
 */
use Cake\ORM\TableRegistry;//独立したテーブルを扱う
$this->KensahyouHeads = TableRegistry::get('kensahyouHeads');//productsテーブルを使う
$this->Products = TableRegistry::get('products');//productsテーブルを使う
?>

<?php
          $username = $this->request->Session()->read('Auth.User.username');
          echo $this->Form->create($kensahyouSokuteidata, ['url' => ['action' => 'index']]);

//          $session = $this->request->getSession();
//          $sessiondata = $session->read();//postデータ取得し、$dataと名前を付ける
//          $data = $sessiondata['sokuteidata'];
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
 <br>
 <legend align="center"><font color="red"><?= __($mes) ?></font></legend>
<br>

    <table width="1200" border="1" align="center" bordercolor="#000000" bgcolor="#FFFFFF" style="background-color: #FFFFFF">
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
                  echo '<td colspan="2"><div align="center">';
        //          echo $data["{$q}"]["result_size_{$r}"] ;
                  echo ${"result_size_".$q."_".$r} ;
                  echo '</div></td>';
              }
              echo "<td colspan='2'>\n";
              echo "</td>\n";
              echo "<td colspan='2'>\n";
              echo $_SESSION['sokuteidata']["{$q}"]["situation_dist1"];
              echo "</td>\n";
              echo "<td colspan='2'>\n";
              echo $_SESSION['sokuteidata']["{$q}"]["situation_dist2"];
              echo "</td>\n";
                echo "<td colspan='2'>\n";
                echo $_SESSION['sokuteidata']["{$q}"]["result_weight"];
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
<table align="center" border="2" bordercolor="#E6FFFF" cellpadding="0" cellspacing="0">
<tr>
  <td style="border-style: none;"><div align="center"><?= $this->Form->submit(__('トップ'), array('name' => 'top')); ?></div></td>
</tr>
</table>
<br>
