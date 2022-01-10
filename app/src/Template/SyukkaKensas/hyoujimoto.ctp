<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\Staff $staff
 */
 use Cake\ORM\TableRegistry;//独立したテーブルを扱う
$this->KensahyouHeads = TableRegistry::get('kensahyouHeads');//productsテーブルを使う
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

  <fieldset>
<div align="center"><strong><font color="red">＊IM対応登録内容表示</font></strong></div>
<br>
      <table width="1200" border="1" align="center" bordercolor="#000000" style="background-color: #FFFFFF">
          <tr style="border-bottom: solid;border-width: 1px">
            <td colspan="28" nowrap="nowrap"><div align="center"><strong>検査表</strong></div></td>
          </tr>
          <tr style="border-bottom: solid;border-width: 1px">
            <td colspan="5" nowrap="nowrap"><div align="center"><strong>部品番号</strong></div></td>
            <td colspan="9" nowrap="nowrap"><?= h($product_code) ?></td>
            <td colspan="5" nowrap="nowrap"><div align="center"><strong>部品名</strong></div></td>
            <td colspan="9" nowrap="nowrap"><?= h($Productname) ?></td>
          </tr>
  <?php
       echo $htmlKensahyouHeader;
  ?>
          <?php
          echo "<tr style='border-bottom: solid;border-width: 1px'><td nowrap='nowrap' colspan='4'><div align='center'><strong>\n";

          echo "ＩＭ検査";
          echo "</strong></div></td>\n";
              $resultArray = Array();
              for($i=1; $i<=9; $i++){
                echo "<td colspan='2'><div align='center'>\n";
                echo ${"kind_kensa".$i};
                echo "</div></td>\n";
              }
              echo "<td colspan='2'>\n";
              echo "</td>\n";
              echo "<td colspan='2'>\n";
              echo "</td>\n";
              echo "<td colspan='2'>\n";
              echo "</td>\n";
          echo "<tr style='border-bottom: solid;border-width: 1px'><td nowrap='nowrap' colspan='4'><div align='center'><strong>\n";

              echo "検査Ｎｏ";
              echo "</strong></div></td>\n";
                  $resultArray = Array();
                  for($i=1; $i<=9; $i++){
                      echo "<td colspan='2'><div align='center'>\n";
                      echo ${"size_num_".$i};
                      echo "</div></td>\n";
                  }
              echo "<td colspan='2'>\n";
              echo "</td>\n";
              echo "<td colspan='2'>\n";
              echo "</td>\n";
              echo "<td colspan='2'>\n";
              echo "</td>\n";
          ?>
    </table>
    <br>
    <table align="center" border="2" bordercolor="#E6FFFF" cellpadding="0" cellspacing="0">
    <tr bgcolor="#E6FFFF">
      <td style="border-style: none;"><div><?= $this->Form->submit('戻る', ['onclick' => 'history.back()', 'type' => 'button']); ?></div></td>
    </tr>
    </table>
      </fieldset>
      <?= $this->Form->end() ?>
<br>
    <?= $this->Form->end() ?>
