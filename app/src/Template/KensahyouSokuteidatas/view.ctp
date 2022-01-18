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
          echo $this->Form->create($KensahyouSokuteidatas, ['url' => ['action' => 'index']]);
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

        <?php for($j=1; $j<=$maisu; $j++): ?>

          <?php if($j > 1): ?>
            <tr style="border-bottom: solid;border-width: 1px">
              <td colspan="28" nowrap="nowrap"><div align="center"></div></td>
            </tr>
          <?php else: ?>
          <?php endif; ?>

        <tr style="border-bottom: solid;border-width: 1px">
          <td colspan="5" nowrap="nowrap"><div align="center"><strong>枚数</strong></div></td>
          <td colspan="9"><?= h($j." / ".$maisu) ?></td>
          <td colspan="14" nowrap="nowrap">&nbsp;<input type="hidden" name="version" value="0"/></td>
        </tr>
        <tr style="border-bottom: solid;border-width: 1px">

        <?php if($j == 1): ?>

          <td colspan="4">&nbsp;</td>
          <td width="24" colspan="2"><div align="center"><strong>A</strong></div></td>
          <td width="38" colspan="2"><div align="center"><strong>B</strong></div></td>
          <td width="38" colspan="2"><div align="center"><strong>C</strong></div></td>
          <td width="38" colspan="2"><div align="center"><strong>D</strong></div></td>
          <td width="38" colspan="2"><div align="center"><strong>E</strong></div></td>
          <td width="38" colspan="2"><div align="center"><strong>F</strong></div></td>
          <td width="38" colspan="2"><div align="center"><strong>G</strong></div></td>
          <td width="38" colspan="2"><div align="center"><strong>H</strong></div></td>
          <td width="60" nowrap="nowrap" colspan="2"><div align="center"><font size="-3"><strong>ソリ・フレ<?= h("(".$j.")") ?></strong></font></div></td>
          <td width='60' nowrap='nowrap' colspan='2'><div align='center'><font size='-1'><strong>外観１</strong></font></div></td>
          <td width='60' nowrap='nowrap' colspan='2'><div align='center'><font size='-1'><strong>外観２</strong></font></div></td>
          <td width="51" nowrap="nowrap" colspan="2"><div align="center"><font size="-1"><strong>単重</strong></font></div></td>

          <?php elseif($j == 2): ?>

            <td colspan="4">&nbsp;</td>
            <td width="24" colspan="2"><div align="center"><strong>I</strong></div></td>
            <td width="38" colspan="2"><div align="center"><strong>J</strong></div></td>
            <td width="38" colspan="2"><div align="center"><strong>K</strong></div></td>
            <td width="38" colspan="2"><div align="center"><strong>L</strong></div></td>
            <td width="38" colspan="2"><div align="center"><strong>M</strong></div></td>
            <td width="38" colspan="2"><div align="center"><strong>N</strong></div></td>
            <td width="38" colspan="2"><div align="center"><strong>O</strong></div></td>
            <td width="38" colspan="2"><div align="center"><strong>P</strong></div></td>
            <td width="60" nowrap="nowrap" colspan="2"><div align="center"><font size="-3"><strong>ソリ・フレ<?= h("(".$j.")") ?></strong></font></div></td>
            <td width='60' nowrap='nowrap' colspan='2'><div align='center'><font size='-1'><strong></strong></font></div></td>
            <td width='60' nowrap='nowrap' colspan='2'><div align='center'><font size='-1'><strong></strong></font></div></td>
            <td width="51" nowrap="nowrap" colspan="2"><div align="center"><font size="-1"><strong></strong></font></div></td>

          <?php else: ?>

            <td colspan="4">&nbsp;</td>
            <td width="24" colspan="2"><div align="center"><strong>Q</strong></div></td>
            <td width="38" colspan="2"><div align="center"><strong>R</strong></div></td>
            <td width="38" colspan="2"><div align="center"><strong>S</strong></div></td>
            <td width="38" colspan="2"><div align="center"><strong>T</strong></div></td>
            <td width="38" colspan="2"><div align="center"><strong>U</strong></div></td>
            <td width="38" colspan="2"><div align="center"><strong>V</strong></div></td>
            <td width="38" colspan="2"><div align="center"><strong>W</strong></div></td>
            <td width="38" colspan="2"><div align="center"><strong>X</strong></div></td>
            <td width="60" nowrap="nowrap" colspan="2"><div align="center"><font size="-3"><strong>ソリ・フレ<?= h("(".$j.")") ?></strong></font></div></td>
            <td width='60' nowrap='nowrap' colspan='2'><div align='center'><font size='-1'><strong></strong></font></div></td>
            <td width='60' nowrap='nowrap' colspan='2'><div align='center'><font size='-1'><strong></strong></font></div></td>
            <td width="51" nowrap="nowrap" colspan="2"><div align="center"><font size="-1"><strong></strong></font></div></td>

          <?php endif; ?>

        </tr>
        <tr style="border-bottom: solid;border-width: 1px">
          <td width="33" rowspan="3" nowrap="nowrap" colspan="2"><div align="center"><strong>規格</strong></div></td>
          <td width="45" nowrap="nowrap" colspan="2"><div align="center"><strong>上限</strong></div></td>

        <?php
            $Array = Array();
            for($k=1; $k<=8; $k++){
              $num_size = ($j - 1)*9 + $k;

            echo '<td colspan="2"><div align="center">';
            echo ${"upper_".$num_size};
            echo '</div></td>';
            }
            echo "<td colspan='2'>\n";
            echo "</td>\n";
            echo "<td colspan='2'>\n";
            echo "</td>\n";

        ?>

          <td colspan="2"><div align="center"></div></td>
          <td rowspan="3" colspan="2">&nbsp;</td>
        </tr>
        <tr style="border-bottom: solid;border-width: 1px">
          <td nowrap="nowrap" colspan="2"><div align="center"><strong>下限</strong></div></td>

        <?php
            $Array = Array();
            for($k=1; $k<=8; $k++){
              $num_size = ($j - 1)*9 + $k;
            echo '<td colspan="2"><div align="center">';
            echo ${"lower_".$num_size};
            echo '</div></td>';
            }
            echo "<td colspan='2'>\n";
            echo "</td>\n";
            echo "<td colspan='2'>\n";
            echo "</td>\n";

        ?>

          <td colspan="2"><div align="center"></div></td>
        </tr>
        <tr style="border-bottom: solid;border-width: 1px">
          <td nowrap="nowrap" colspan="2"><div align="center"><strong>寸法</strong></div></td>

        <?php
            $Array = Array();
            for($l=1; $l<=9; $l++){
              $num_size = ($j - 1)*9 + $l;

            echo '<td colspan="2"><div align="center">';
            echo ${"size_".$num_size};
            echo '</div></td>';
            }
        ?>

        <?php if($j == 1): ?>
        <td colspan="2"><div align="center"><?= h($text_10) ?></div></td>
        <td colspan="2"><div align="center"><?= h($text_11) ?></div></td>
       <?php else: ?>
        <td colspan="2"></td>
        <td colspan="2"></td>
       <?php endif; ?>

       </tr>

       <?php
       echo "<tr style='border-bottom: solid;border-width: 1px'><td nowrap='nowrap' colspan='4'><div align='center'><strong>\n";
       echo "検査種類";
       echo "</strong></div></td>\n";
       $kensaArray = Array();
       for($i=1; $i<=9; $i++){
         $num_size = ($j - 1)*9 + $i;

         echo "<td colspan='2'><div align='center' style='font-size: 9pt'>\n";
         echo ${"ImKikakuid_".$num_size};
         echo "</div></td>\n";
       }
       echo "<td colspan='2'>\n";
       echo "</td>\n";
       echo "<td colspan='2'>\n";
       echo "</td>\n";
       echo "<td colspan='2'>\n";
       echo "</td>\n";

       ?>

       <?php if($j == 1): ?>

         <?php
             $lowerArraygyou = Array();
             for($q=1; $q<=8; $q++){
               echo '<tr style="border-bottom: solid;border-width: 1px"><td nowrap="nowrap" colspan="4"><div align="center"><strong>';
               echo $q;
               echo '</strong></div></td>';

               $lowerArray = Array();
               for($r=1; $r<=8; $r++){
                   if((float)${"result_size_".$q."_".$r} <= (float)${"size_".$r}+(float)${"upper_".$r} && (float)${"result_size_".$q."_".$r} >= (float)${"size_".$r}+(float)${"lower_".$r}){
                   echo '<td colspan="2"><div align="center">';
                   echo ${"result_size_".$q."_".$r};
                   echo '</div></td>';
                   } else {
                   echo '<td colspan="2"><div align="center"><font color="red">';
                   echo ${"result_size_".$q."_".$r};
                   echo '</div></td>';
                   }
               }
                 echo "<td colspan='2'><div align='center'>\n";
                 echo ${"result_size_".$q."_9"};
                 echo "</td>\n";

                 if(${"situation_dist1_".$q} == "OK"){
                   echo "<td colspan='2'><div align='center'>\n";
                   echo ${"situation_dist1_".$q};
                   echo "</td>\n";
                 } else {
                 echo '<td colspan="2"><div align="center"><font color="red">';
                 echo ${"situation_dist1_".$q};
                 echo '</div></td>';
                 }

                 if(${"situation_dist2_".$q} == "OK"){
                   echo "<td colspan='2'><div align='center'>\n";
                   echo ${"situation_dist2_".$q};
                   echo "</td>\n";
                 } else {
                 echo '<td colspan="2"><div align="center"><font color="red">';
                 echo ${"situation_dist2_".$q};
                 echo '</div></td>';
                 }

                 echo '<td colspan="2"><div align="center">';
                 echo ${"result_weight_".$q};
                 echo '</div></td>';

             }
         ?>

       <?php elseif($j == 2): ?>

           <?php
               $lowerArraygyou = Array();
               for($q=1; $q<=8; $q++){
                 echo '<tr style="border-bottom: solid;border-width: 1px"><td nowrap="nowrap" colspan="4"><div align="center"><strong>';
                 echo $q;
                 echo '</strong></div></td>';

                 $lowerArray = Array();
                 for($r=10; $r<=17; $r++){
                     if((float)${"result_size_".$q."_".$r} <= (float)${"size_".$r}+(float)${"upper_".$r}
                      && (float)${"result_size_".$q."_".$r} >= (float)${"size_".$r}+(float)${"lower_".$r}){
                     echo '<td colspan="2"><div align="center">';
                     echo ${"result_size_".$q."_".$r};
                     echo '</div></td>';
                     } else {
                     echo '<td colspan="2"><div align="center"><font color="red">';
                     echo ${"result_size_".$q."_".$r};
                     echo '</div></td>';
                     }
                 }
                   echo "<td colspan='2'><div align='center'>\n";
                   echo ${"result_size_".$q."_18"};
                   echo "</td>\n";

                   echo '<td colspan="2"><div align="center">';
                   echo '</div></td>';
                   echo '<td colspan="2"><div align="center">';
                   echo '</div></td>';
                   echo '<td colspan="2"><div align="center">';
                   echo '</div></td>';

               }
           ?>

         <?php elseif($j == 3): ?>

             <?php
                 $lowerArraygyou = Array();
                 for($q=1; $q<=8; $q++){
                   echo '<tr style="border-bottom: solid;border-width: 1px"><td nowrap="nowrap" colspan="4"><div align="center"><strong>';
                   echo $q;
                   echo '</strong></div></td>';

                   $lowerArray = Array();
                   for($r=19; $r<=26; $r++){
                       if((float)${"result_size_".$q."_".$r} <= (float)${"size_".$r}+(float)${"upper_".$r} && (float)${"result_size_".$q."_".$r} >= (float)${"size_".$r}+(float)${"lower_".$r}){
                       echo '<td colspan="2"><div align="center">';
                       echo ${"result_size_".$q."_".$r};
                       echo '</div></td>';
                       } else {
                       echo '<td colspan="2"><div align="center"><font color="red">';
                       echo ${"result_size_".$q."_".$r};
                       echo '</div></td>';
                       }
                   }
                     echo "<td colspan='2'><div align='center'>\n";
                     echo ${"result_size_".$q."_27"};
                     echo "</td>\n";

                     echo '<td colspan="2"><div align="center">';
                     echo '</div></td>';
                     echo '<td colspan="2"><div align="center">';
                     echo '</div></td>';
                     echo '<td colspan="2"><div align="center">';
                     echo '</div></td>';

                 }
             ?>

           <?php else: ?>

       <?php endif; ?>

        </tr>

       <?php endfor;?>

       </tr>
       <td height="120" colspan="28" style="vertical-align: top; border-bottom: solid;border-width: 1px;text-align: left">
         <strong style="text-align: left">備考：</strong><br>
             <?= h($KensahyouHeadbik) ?>
         </td>
       </tr>
       <tr>
       </table>
<br>

</fieldset>
