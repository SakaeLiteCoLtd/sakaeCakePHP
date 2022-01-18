<?php
/**
 * AuthHelper: Authの変数にアクセスできる
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\Deliver $priceMaterial
 */
 use Cake\ORM\TableRegistry;//独立したテーブルを扱う
$this->KensahyouHeads = TableRegistry::get('kensahyouHeads');//kensahyouHeadsテーブルを使う
$this->Products = TableRegistry::get('products');//productsテーブルを使う
$this->ImSokuteidataHeads = TableRegistry::get('imSokuteidataHeads');//ImKikakuTaiousテーブルを使う
?>
        <?php
          $username = $this->request->Session()->read('Auth.User.username');

          header('Expires:-1');
          header('Cache-Control:');
          header('Pragma:');

          echo $this->Form->hidden('product_code' ,['value'=>$product_code ]) ;
          echo $this->Form->create($kensahyouSokuteidata, ['url' => ['action' => 'form']]);

          $ImSokuteidataHead = $this->ImSokuteidataHeads->find()->where(['lot_num' => $lot_num])->toArray();

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
          <td colspan="5" nowrap="nowrap"><div align="center"><strong>バージョン</strong></div></td>
          <td colspan="9"><?= h($KensahyouHeadver-1) ?></td>
          <td colspan="5" nowrap="nowrap"><div align="center"><strong>ロット番号</strong></div></td>

          <?php if($num == 1): ?>
          <td colspan="9"><?= $this->Form->input("lot_num_new", array('type' => 'text', 'pattern' => '^[0-9A-Za-z.-]+$', 'title' => "半角英数字で入力して下さい。", 'label'=>false, 'value'=>$this->request->getData('lot_num'), 'required'=>true)); ?></td>
        <?php else : ?>
          <td colspan="9"><?= h($lot_num_new) ?></td>
          <?php
          echo $this->Form->hidden('lot_num_new' ,['value'=>$lot_num_new]);
          ?>
      <?php endif; ?>

        </tr>
        <tr style="border-bottom: solid;border-width: 1px">
          <td colspan="5" nowrap="nowrap"><div align="center"><strong>製造年月日</strong></div></td>
          <td colspan="9"><?= $this->Form->input("manu_date", array('type' => 'date', 'monthNames' => false, 'label'=>false)); ?></td>

      <?php if(isset($ImSokuteidataHead[0])): ?>
          <?php
            $inspec_date = $ImSokuteidataHead[0]->inspec_date;
            $ImSokuteidataHead_id = $ImSokuteidataHead[0]->id;
            echo $this->Form->hidden('inspec_date' ,['value'=>$inspec_date]);
          ?>
          <td colspan="5" nowrap="nowrap"><div align="center"><strong>検査年月日</strong></div></td>
          <td colspan="9"><?= $this->Form->input("inspec_date", array('type' => 'date', 'monthNames' => false, 'label'=>false)); ?></td>
     <?php else : ?>
       <td colspan="5" nowrap="nowrap"><div align="center"><strong>検査年月日</strong></div></td>
       <td colspan="9"><?= $this->Form->input("inspec_date", array('type' => 'date', 'monthNames' => false, 'label'=>false)); ?></td>
     <?php endif; ?>

        </tr>
<?php
  //   echo $htmlKensahyouHeader;
?>

<?php
  $red_check = 0;
?>

<?php if($num > 1): ?>

  <?php
    $first = 1;
  ?>

  <table width="1200" border="1" align="center" bordercolor="#000000" bgcolor="#FFFFFF" style="background-color: #FFFFFF">
    <tr style="border-bottom: solid;border-width: 1px">
      <td colspan="5" nowrap="nowrap"><div align="center"><strong>枚数</strong></div></td>
      <td colspan="9" nowrap="nowrap"><?= h("1 / ".$maisu) ?></td>
      <td colspan="14" nowrap="nowrap">&nbsp;<input type="hidden" name="version" value="0"/></td>
    </tr>
    <tr style="border-bottom: solid;border-width: 1px">

<td colspan="4">&nbsp;</td>
<td width="24" colspan="2"><div align="center"><strong>A</strong></div></td>
<td width="38" colspan="2"><div align="center"><strong>B</strong></div></td>
<td width="38" colspan="2"><div align="center"><strong>C</strong></div></td>
<td width="38" colspan="2"><div align="center"><strong>D</strong></div></td>
<td width="38" colspan="2"><div align="center"><strong>E</strong></div></td>
<td width="38" colspan="2"><div align="center"><strong>F</strong></div></td>
<td width="38" colspan="2"><div align="center"><strong>G</strong></div></td>
<td width="38" colspan="2"><div align="center"><strong>H</strong></div></td>
<td width="60" nowrap="nowrap" colspan="2"><div align="center"><font size="-3"><strong>ソリ・フレ(1)</strong></font></div></td>
<td style="width:120px" colspan='2'><div align='center'><font size='-1'><strong>外観１</strong></font></div></td>
<td style="width:120px" colspan='2'><div align='center'><font size='-1'><strong>外観２</strong></font></div></td>
<td style="width:120px" nowrap="nowrap" colspan="2"><div align="center"><font size="-1"><strong>単重</strong></font></div></td>

</tr>
<tr style="border-bottom: solid;border-width: 1px">
<td width="33" rowspan="3" nowrap="nowrap" colspan="2"><div align="center"><strong>規格</strong></div></td>
<td width="45" nowrap="nowrap" colspan="2"><div align="center"><strong>上限</strong></div></td>

<?php
  $upperArray = Array();
  for($i=1; $i<=8; $i++){
    $num_size = ($first - 1)*9 + $i;
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
  $lowerArray = Array();
  for($i=1; $i<=8; $i++){
    $num_size = ($first - 1)*9 + $i;
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
  $sizeArray = Array();
  for($i=1; $i<=9; $i++){
    $num_size = ($first - 1)*9 + $i;
  echo '<td colspan="2"><div align="center">';
  echo ${"size_".$num_size};
  echo '</div></td>';
  }
  ?>

  <td colspan="2"><div align="center"><?= h($text_10) ?></div></td>
  <td colspan="2"><div align="center"><?= h($text_11) ?></div></td>

  <?php
  echo "<tr style='border-bottom: solid;border-width: 1px'><td nowrap='nowrap' colspan='4'><div align='center'><strong>\n";
  echo "検査種類";
  echo "</strong></div></td>\n";
  $kensaArray = Array();
  for($i=1; $i<=9; $i++){

    echo "<td colspan='2'><div align='center'>\n";
    echo ${"ImKikakuid_".$i};
    echo "</div></td>\n";

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
            if(${"result_size_".$q."_".$r} <= ${"size_".$r}+${"upper_".$r} && ${"result_size_".$q."_".$r} >= ${"size_".$r}+${"lower_".$r}){
            echo '<td colspan="2"><div align="center">';
            echo ${"result_size_".$q."_".$r};
            echo '</div></td>';
            } else {
              if(strlen(${"result_size_".$q."_".$r}) > 0){
                $red_check = $red_check + 1;
              }
            echo '<td colspan="2"><div align="center"><font color="red">';
            echo ${"result_size_".$q."_".$r};
            echo '</div></td>';
            }

            echo $this->Form->hidden("result_size_".$q."_".$r ,['value'=>${"result_size_".$q."_".$r} ]) ;

        }
          echo "<td colspan='2'><div align='center'>\n";
          echo ${"result_size_".$q."_9"};
          echo "</td>\n";
          echo $this->Form->hidden("result_size_".$q."_9" ,['value'=>${"result_size_".$q."_9"} ]) ;

          if(${"situation_dist1_".$q} == "OK"){
            echo "<td colspan='2'><div align='center'>\n";
            echo ${"situation_dist1_".$q};
            echo "</td>\n";
          } else {
          echo '<td colspan="2"><div align="center"><font color="red">';
          echo ${"situation_dist1_".$q};
          echo '</div></td>';
          }
          echo $this->Form->hidden("situation_dist1_".$q,['value'=>${"situation_dist1_".$q} ]) ;

          if(${"situation_dist2_".$q} == "OK"){
            echo "<td colspan='2'><div align='center'>\n";
            echo ${"situation_dist2_".$q};
            echo "</td>\n";
          } else {
          echo '<td colspan="2"><div align="center"><font color="red">';
          echo ${"situation_dist2_".$q};
          echo '</div></td>';
          }
          echo $this->Form->hidden("situation_dist2_".$q,['value'=>${"situation_dist2_".$q} ]) ;

          echo '<td colspan="2"><div align="center">';
          echo ${"result_weight_".$q};
          echo '</div></td>';
          echo $this->Form->hidden("result_weight_".$q,['value'=>${"result_weight_".$q} ]) ;

      }
  ?>
  </tr>
  <td height="120" colspan="28" style="vertical-align: top; border-bottom: solid;border-width: 1px;text-align: left">
    <strong style="text-align: left">備考：</strong><br>
            <?= h($KensahyouHeadbik) ?>
        </td>
  </tr>
 <tr>

<?php else: ?>
<?php endif; ?>

<?php if($num == 3): ?>

  <?php
    $second = 2;
  ?>

  <table width="1200" border="1" align="center" bordercolor="#000000" bgcolor="#FFFFFF" style="background-color: #FFFFFF">
    <tr style="border-bottom: solid;border-width: 1px">
      <td colspan="5" nowrap="nowrap"><div align="center"><strong>枚数</strong></div></td>
      <td colspan="9" nowrap="nowrap"><?= h("2 / ".$maisu) ?></td>
      <td colspan="14" nowrap="nowrap">&nbsp;<input type="hidden" name="version" value="0"/></td>
    </tr>
    <tr style="border-bottom: solid;border-width: 1px">

<td colspan="4">&nbsp;</td>
<td width="24" colspan="2"><div align="center"><strong>A</strong></div></td>
<td width="38" colspan="2"><div align="center"><strong>B</strong></div></td>
<td width="38" colspan="2"><div align="center"><strong>C</strong></div></td>
<td width="38" colspan="2"><div align="center"><strong>D</strong></div></td>
<td width="38" colspan="2"><div align="center"><strong>E</strong></div></td>
<td width="38" colspan="2"><div align="center"><strong>F</strong></div></td>
<td width="38" colspan="2"><div align="center"><strong>G</strong></div></td>
<td width="38" colspan="2"><div align="center"><strong>H</strong></div></td>
<td width="60" nowrap="nowrap" colspan="2"><div align="center"><font size="-3"><strong>ソリ・フレ(2)</strong></font></div></td>
<td width='60' nowrap='nowrap' colspan='2'><div align='center'><font size='-1'><strong></strong></font></div></td>
<td width='60' nowrap='nowrap' colspan='2'><div align='center'><font size='-1'><strong></strong></font></div></td>
<td width="51" nowrap="nowrap" colspan="2"><div align="center"><font size="-1"><strong></strong></font></div></td>

</tr>
<tr style="border-bottom: solid;border-width: 1px">
<td width="33" rowspan="3" nowrap="nowrap" colspan="2"><div align="center"><strong>規格</strong></div></td>
<td width="45" nowrap="nowrap" colspan="2"><div align="center"><strong>上限</strong></div></td>

<?php
  $upperArray = Array();
  for($i=1; $i<=8; $i++){
    $num_size = ($second - 1)*9 + $i;
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
  $lowerArray = Array();
  for($i=1; $i<=8; $i++){
    $num_size = ($second - 1)*9 + $i;
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
  $sizeArray = Array();
  for($i=1; $i<=9; $i++){
    $num_size = ($second - 1)*9 + $i;
  echo '<td colspan="2"><div align="center">';
  echo ${"size_".$num_size};
  echo '</div></td>';
  }
  ?>

  <td colspan="2"><div align="center"></div></td>
  <td colspan="2"><div align="center"></div></td>

  <?php
  echo "<tr style='border-bottom: solid;border-width: 1px'><td nowrap='nowrap' colspan='4'><div align='center'><strong>\n";
  echo "検査種類";
  echo "</strong></div></td>\n";
  $kensaArray = Array();
  for($i=1; $i<=9; $i++){
    $num_size = ($second - 1)*9 + $i;

    echo "<td colspan='2'><div align='center'>\n";
    echo ${"ImKikakuid_".$num_size};
    echo "</div></td>\n";

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
          $num_size = ($second - 1)*9 + $r;

            if((int)${"result_size_".$q."_".$num_size} <= (int)${"size_".$num_size}+(int)${"upper_".$num_size}
             && (int)${"result_size_".$q."_".$num_size} >= (int)${"size_".$num_size}+(int)${"lower_".$num_size}){
            echo '<td colspan="2"><div align="center">';
            echo ${"result_size_".$q."_".$num_size};
            echo '</div></td>';
            } else {
              if(strlen(${"result_size_".$q."_".$r}) > 0){
                $red_check = $red_check + 1;
              }
            echo '<td colspan="2"><div align="center"><font color="red">';
            echo ${"result_size_".$q."_".$num_size};
            echo '</div></td>';
            }

            echo $this->Form->hidden("result_size_".$q."_".$num_size ,['value'=>${"result_size_".$q."_".$num_size} ]) ;

        }
          echo "<td colspan='2'><div align='center'>\n";
          echo ${"result_size_".$q."_18"};
          echo "</td>\n";
          echo $this->Form->hidden("result_size_".$q."_18" ,['value'=>${"result_size_".$q."_18"} ]) ;

          echo "<td colspan='2'><div align='center'>\n";
          echo "</td>\n";
          echo "<td colspan='2'><div align='center'>\n";
          echo "</td>\n";
          echo "<td colspan='2'><div align='center'>\n";
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

<?php else: ?>
<?php endif; ?>

<tr style="border-bottom: solid;border-width: 1px">
  <td colspan="5" nowrap="nowrap"><div align="center"><strong>枚数</strong></div></td>
  <td colspan="9" nowrap="nowrap"><?= h($num." / ".$maisu) ?></td>
  <td colspan="14" nowrap="nowrap"><div align="center"><?= $this->Form->submit(__('シグネス反映'), array('name' => 'signess')); ?></div></td>
</tr>
<tr style="border-bottom: solid;border-width: 1px">

<?php if($num == 1): ?>
<td colspan="4">&nbsp;</td>
<td width="24" colspan="2"><div align="center"><strong>A</strong></div></td>
<td width="38" colspan="2"><div align="center"><strong>B</strong></div></td>
<td width="38" colspan="2"><div align="center"><strong>C</strong></div></td>
<td width="38" colspan="2"><div align="center"><strong>D</strong></div></td>
<td width="38" colspan="2"><div align="center"><strong>E</strong></div></td>
<td width="38" colspan="2"><div align="center"><strong>F</strong></div></td>
<td width="38" colspan="2"><div align="center"><strong>G</strong></div></td>
<td width="38" colspan="2"><div align="center"><strong>H</strong></div></td>
<td width="60" colspan="2"><div align="center"><font size="-3"><strong>ソリ・フレ<?= h("(".$num.")") ?></strong></font></div></td>
<td style="width:120px" colspan='2'><div align='center'><font size='-1'><strong>外観１</strong></font></div></td>
<td style="width:120px" colspan='2'><div align='center'><font size='-1'><strong>外観２</strong></font></div></td>
<td width="51" colspan="2"><div align="center"><font size="-1"><strong>単重</strong></font></div></td>
<?php elseif($num == 2): ?>
<td colspan="4">&nbsp;</td>
<td width="24" colspan="2"><div align="center"><strong>I</strong></div></td>
<td width="38" colspan="2"><div align="center"><strong>J</strong></div></td>
<td width="38" colspan="2"><div align="center"><strong>K</strong></div></td>
<td width="38" colspan="2"><div align="center"><strong>L</strong></div></td>
<td width="38" colspan="2"><div align="center"><strong>M</strong></div></td>
<td width="38" colspan="2"><div align="center"><strong>N</strong></div></td>
<td width="38" colspan="2"><div align="center"><strong>O</strong></div></td>
<td width="38" colspan="2"><div align="center"><strong>P</strong></div></td>
<td width="60" nowrap="nowrap" colspan="2"><div align="center"><font size="-3"><strong>ソリ・フレ<?= h("(".$num.")") ?></strong></font></div></td>
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
<td width="60" nowrap="nowrap" colspan="2"><div align="center"><font size="-3"><strong>ソリ・フレ<?= h("(".$num.")") ?></strong></font></div></td>
<td width='60' nowrap='nowrap' colspan='2'><div align='center'><font size='-1'><strong></strong></font></div></td>
<td width='60' nowrap='nowrap' colspan='2'><div align='center'><font size='-1'><strong></strong></font></div></td>
<td width="51" nowrap="nowrap" colspan="2"><div align="center"><font size="-1"><strong></strong></font></div></td>
<?php endif; ?>

</tr>
<tr style="border-bottom: solid;border-width: 1px">
<td width="33" rowspan="3" nowrap="nowrap" colspan="2"><div align="center"><strong>規格</strong></div></td>
<td width="45" nowrap="nowrap" colspan="2"><div align="center"><strong>上限</strong></div></td>

<?php
  $upperArray = Array();
  for($i=1; $i<=8; $i++){
    $num_size = ($num - 1)*9 + $i;

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
  $lowerArray = Array();
  for($i=1; $i<=8; $i++){
    $num_size = ($num - 1)*9 + $i;
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
  $sizeArray = Array();
  for($i=1; $i<=9; $i++){
    $num_size = ($num - 1)*9 + $i;
  echo '<td colspan="2"><div align="center">';
  echo ${"size_".$num_size};
  echo '</div></td>';
  }
  ?>

  <?php if($num == 1): ?>
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
          $num_size = ($num - 1)*9 + $i;

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
            $lowerArraygyou = Array();
            for($j=1; $j<=8; $j++){
                echo "<tr style='border-bottom: solid;border-width: 1px'><td nowrap='nowrap' colspan='4'><div align='center'><strong>\n";
                echo $j;
                echo "</strong></div></td>\n";
                $resultArray = Array();
                for($i=1; $i<=9; $i++){
                  $num_size = ($num - 1)*9 + $i;

                    echo "<td colspan='2'><div align='center'>\n";
                  if(isset(${"ImSokuteidata_result_".$num_size."_".$j})){//もしも
                    echo "<input type='text' pattern='^[0-9.]+$' title='半角数字で入力して下さい。' name=result_size_".$j."_".$num_size." value=${"ImSokuteidata_result_".$num_size."_".$j} size='6'/>\n";
                  } elseif(isset(${"result_size_".$j."_".$num_size}) && strlen(${"result_size_".$j."_".$num_size}) > 0) {
                    echo "<input type='text' pattern='^[0-9.]+$' title='半角数字で入力して下さい。' name=result_size_".$j."_".$num_size." value=${"result_size_".$j."_".$num_size}>\n";
                  } else {
                    echo "<input type='text' pattern='^[0-9.]+$' title='半角数字で入力して下さい。' name=result_size_".$j."_".$num_size." value=''>\n";
                  }
                    echo "</div></td>\n";
                }

                if($num == 1){

                  if($text_10 == "外観1"){

                    if(isset(${"situation_dist1_".$j}) && strlen(${"situation_dist1_".$j}) > 0){

                      ?>
                      <td colspan='2'><div align='center'>
                        <?= $this->Form->control('situation_dist1_'.$j, ['options' => $arrhantei, 'value'=>${"situation_dist1_".$j}, 'label'=>false]) ?>
                      </div></td>
                      <?php

                    }else{

                      echo "<td colspan='2'><div align='center'><select name=situation_dist1_".$j.">\n";
                      foreach ($arrhantei as $value){
                      echo "<option value=$value>$value</option>";
                      }
                      echo "</select></div></td>\n";

                    }

                  }else{
                    echo "<td colspan='2'><div align='center'><hidden>\n";
                    echo "</div></td>\n";
                    echo $this->Form->hidden('situation_dist1_'.$j,['value'=>""]);
                  }

                  if($text_11 == "外観2"){

                    if(isset(${"situation_dist2_".$j}) && strlen(${"situation_dist2_".$j}) > 0){

                      ?>
                      <td colspan='2'><div align='center'>
                        <?= $this->Form->control('situation_dist2_'.$j, ['options' => $arrhantei, 'value'=>${"situation_dist2_".$j}, 'label'=>false]) ?>
                      </div></td>
                      <?php

                    }else{

                      echo "<td colspan='2'><div align='center'><select name=situation_dist2_".$j.">\n";
                      foreach ($arrhantei as $value){
                      echo "<option value=$value>$value</option>";
                      }
                      echo "</select></div></td>\n";

                    }

                  }else{
                    echo "<td colspan='2'><div align='center'><hidden>\n";
                    echo "</div></td>\n";
                    echo $this->Form->hidden('situation_dist2_'.$j ,['value'=>""]);
                  }

                      echo "<td colspan='2'>\n";
                      if(isset(${"result_weight_".$j}) && strlen(${"result_weight_".$j}) > 0){//もしも
                        echo "<input type='text' pattern='^[0-9.]+$' title='半角数字で入力して下さい。' name=result_weight_".$j." value='${"result_weight_".$j}'>\n";
                      } else {
                        echo "<input type='text' pattern='^[0-9.]+$' title='半角数字で入力して下さい。' name=result_weight_".$j." value='' size='6'/>\n";
                      }
                      echo "</td>\n";

                }else{
                  echo "<td colspan='2'>\n";
                  echo "</td>\n";
                  echo "<td colspan='2'>\n";
                  echo "</td>\n";
                  echo "<td colspan='2'>\n";
                  echo "</td>\n";
                }

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
<table>
<td style="text-align: left">
  <strong>　*備考の欄内にはソリ・フレ値・外観の検査基準を外観の規格欄内の値と関連付けてください。</strong>
</td>
</table>
        <?php
        echo $this->Form->hidden('kensahyou_heads_id' ,['value'=>$KensahyouHeadid]);
        echo $this->Form->hidden('lot_num' ,['value'=>$lot_num]);
        echo $this->Form->hidden('product_code1' ,['value'=>$product_code]);
        echo $this->Form->hidden('product_name1' ,['value'=>$Productname]);
        echo $this->Form->hidden('product_code' ,['value'=>$product_code]);
        echo $this->Form->hidden('num' ,['value'=>$num]);
        echo $this->Form->hidden('maisu' ,['value'=>$maisu]);
        echo $this->Form->hidden('delete_flag' ,['value'=>0]);
        echo $this->Form->hidden('created_staff', ['value'=>$staff_id]);
        echo $this->Form->hidden('updated_staff');
        echo $this->Form->hidden('kadouseikeiId' ,['value'=>$kadouseikeiId]);
        ?>
    </fieldset>

    <br>
    <?php if($red_check > 0): ?>
      <legend align="center"><font color="red"><?= __("赤文字部分が規格から外れています。入力ミスの場合は「戻る」ボタンで修正してください。入力ミスでない場合はそのまま続けてください。") ?></font></legend>
    <?php else: ?>
    <?php endif; ?>
    <legend align="center"><font color="red"><?= __($mess) ?></font></legend>
   <br>
    <table align="center" border="2" bordercolor="#E6FFFF" cellpadding="0" cellspacing="0">
    <tr>
      <td style="border-style: none;"><div align="center"><?= $this->Form->submit('戻る', ['onclick' => 'history.back()', 'type' => 'button']); ?></div></td>
      <td style="border-style: none;"><div align="center"><?= $this->Form->submit(__('次へ'), array('name' => 'next')); ?></div></td>
    </tr>
  </table>
  <br>
  <br>
