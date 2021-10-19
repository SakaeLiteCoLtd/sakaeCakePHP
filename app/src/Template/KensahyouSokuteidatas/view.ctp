<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\Staff[]|\Cake\Collection\CollectionInterface $staffs
 */
use Cake\ORM\TableRegistry;//独立したテーブルを扱う
$this->Products = TableRegistry::get('products');//productsテーブルを使う
$this->KensahyouSokuteidatas = TableRegistry::get('kensahyouSokuteidatas');//kensahyouHeadsテーブルを使う
?>
<?php
          $username = $this->request->Session()->read('Auth.User.username');

          header('Expires:-1');
          header('Cache-Control:');
          header('Pragma:');
          echo $this->Form->create($kensahyouSokuteidatas, ['url' => ['action' => 'index']]);
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

<fieldset>
<div align="center"><strong><font color="red">＊詳細表示</font></strong></div>
<br>
    <table width="1200" border="1" align="center" bordercolor="#000000" style="background-color: #FFFFFF" >
        <tr style="background-color: #FFFFFF;border-bottom: solid;border-width: 1px">
          <td colspan="5" nowrap="nowrap"><div align="center"><strong>部品番号</strong></div></td>
          <td colspan="9" nowrap="nowrap"><?= h($product_code) ?></td>
          <td colspan="5" nowrap="nowrap"><div align="center"><strong>部品名</strong></div></td>
          <td colspan="9" nowrap="nowrap"><?= h($Productname) ?></td>
        </tr>
        <tr style="background-color: #FFFFFF;border-bottom: solid;border-width: 1px">
          <td colspan="5" nowrap="nowrap"><div align="center"><strong>バージョン</strong></div></td>
          <td colspan="9"><?= h($KensahyouHeadver-1) ?></td>
          <td colspan="5" nowrap="nowrap"><div align="center"><strong>ロット番号</strong></div></td>
          <td colspan="9"><?= h($lot_num) ?></td>
        </tr>
        <tr style="background-color: #FFFFFF;border-bottom: solid;border-width: 1px">
          <td colspan="5" nowrap="nowrap"><div align="center"><strong>製造年月日</strong></div></td>
          <td colspan="9"><?= h($KensahyouHead_manu_date); ?></td>
          <td colspan="5" nowrap="nowrap"><div align="center"><strong>検査年月日</strong></div></td>
          <td colspan="9"><?= h($KensahyouHead_inspec_date); ?></td>
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
            ?>

            <?php foreach ($kensahyouSokuteidatas as $KensahyouSokuteidata): ?>
                <tr style='background-color: #FFFFFF;border-bottom: solid;border-width: 1px'><td nowrap="nowrap" colspan="4"><div align="center"><strong><?= h($KensahyouSokuteidata->cavi_num) ?></strong></div></td>
                <?php
                      for($r=1; $r<=9; $r++){
                          echo '<td colspan="2" style="background-color: #FFFFFF;border-bottom: solid;border-width: 1px"><div align="center">';
                          echo $KensahyouSokuteidata->{"result_size_{$r}"} ;
                          echo '</div></td>';
                      }
                ?>
                <td colspan='2'><div align="center"><?= h($KensahyouSokuteidata->situation_dist1) ?></div></td>
                <td colspan='2'><div align="center"><?= h($KensahyouSokuteidata->situation_dist2) ?></div></td>
                <td colspan='2'><div align="center"><?= h($KensahyouSokuteidata->result_weight) ?></div></td>
            <?php endforeach; ?>
        </tr>
        <td height="120" colspan="28" style="vertical-align: top; border-bottom: solid;border-width: 1px;text-align: left">
          <strong style="text-align: left">備考：</strong><br>
              <div cols="120" rows="10"><?= h($KensahyouHeadbik) ?></div>
          </td>
        </tr>
    </table>
<br>

</fieldset>
