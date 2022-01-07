<?php
/**
 * AuthHelper: Authの変数にアクセスできる
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\Deliver $priceMaterial
 */
 use Cake\ORM\TableRegistry;//独立したテーブルを扱う
$this->KensahyouHeads = TableRegistry::get('kensahyouHeads');//productsテーブルを使う
$this->Products = TableRegistry::get('products');//productsテーブルを使う
?>
        <?php
          $username = $this->request->Session()->read('Auth.User.username');

          header('Expires:-1');
          header('Cache-Control:');
          header('Pragma:');

          $arrtext10 = [
            '' => '',
            '外観1' => '外観1'
          ];
          $arrtext11 = [
            '' => '',
            '外観2' => '外観2'
          ];

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

    <?= $this->Form->create($kensahyouHead, ['url' => ['action' => 'form']]) ?>
    <fieldset>
<div align="center"><strong><font color="red">＊登録してください</font></strong></div>
<br>
    <table width="1200" border="1" align="center" bordercolor="#000000" bgcolor="#FFFFFF" style="background-color: #FFFFFF">
        <tr style="border-bottom: solid;border-width: 1px">
          <td colspan="5" nowrap="nowrap"><div align="center"><strong>部品番号</strong></div></td>
          <td colspan="9" nowrap="nowrap"><?= h($Productcode) ?></td>
          <td colspan="5" nowrap="nowrap"><div align="center"><strong>部品名</strong></div></td>
          <td colspan="9" nowrap="nowrap"><?= h($Productname) ?></td>
        </tr>
        <tr style="border-bottom: solid;border-width: 1px">
          <td colspan="5" nowrap="nowrap"><div align="center"><strong>新規バージョン</strong></div></td>
          <td colspan="9"><?= h("0") ?></td>
          <td colspan="5" nowrap="nowrap"><div align="center"><strong>IMタイプ</strong></div></td>
          <td colspan="9" nowrap="nowrap"><?= h($type_im_hyouji) ?></td>
        </tr>
        <tr style="border-bottom: solid;border-width: 1px">
          <td colspan="5" nowrap="nowrap"><div align="center"><strong>枚数</strong></div></td>
          <td colspan="9" nowrap="nowrap"><?= h($num." / ".$maisu) ?></td>
          <td colspan="14" nowrap="nowrap">&nbsp;<input type="hidden" name="version" value="0"/></td>
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
          <td width="60" nowrap="nowrap" colspan="2"><div align="center"><font size="-3"><strong>ソリ・フレ<?= h("(".$num.")") ?></strong></font></div></td>
          <td width='60' nowrap='nowrap' colspan='2'><div align='center'><font size='-1'><strong>外観１</strong></font></div></td>
          <td width='60' nowrap='nowrap' colspan='2'><div align='center'><font size='-1'><strong>外観２</strong></font></div></td>
          <td width="51" nowrap="nowrap" colspan="2"><div align="center"><font size="-1"><strong>単重</strong></font></div></td>
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
            echo '<td colspan="2"><div align="center">';
            echo '<input name=" upper_'. $num . $i . '" type="text"  value="" size="6"/>';
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
            echo '<td colspan="2"><div align="center">';
            echo '<input name=" lower_'. $num . $i . '" type="text"  value="" size="6"/>';
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
            echo '<td colspan="2"><div align="center">';
            echo '<input name=" size_'. $num . $i . '" type="text"  value="" size="6"/>';
            echo '</div></td>';
            }
            ?>

        <?php if($num == 1): ?>

        <td colspan="2"><div align="center"><?= $this->Form->input('text_10', ["type"=>"select", "options"=>$arrtext10, 'label'=>false]); ?></div></td>
        <td colspan="2"><div align="center"><?= $this->Form->input('text_11', ["type"=>"select", "options"=>$arrtext11, 'label'=>false]); ?></div></td>

      <?php else: ?>
        <td colspan="2"></td>
        <td colspan="2"></td>
      <?php endif; ?>

        </tr>

        <td height="120" colspan="28" style="vertical-align: top; border-bottom: solid;border-width: 1px;text-align: left">
          <strong style="text-align: left">備考：</strong><br>
              <textarea name="bik"  cols="120" rows="10"><?php echo $bik ;?></textarea>
          </td>
        </tr>
       <tr>
</table>
<table>
<td style="text-align: left">
  <strong>　*備考の欄内にはソリ・フレ値・外観の検査基準を外観の規格欄内の値と関連付けてください。</strong>
</td>
</table>
<br>
<table align="center" border="2" bordercolor="#E6FFFF" cellpadding="0" cellspacing="0">
<tr>
  <td style="border-style: none;"><div align="center"><?= $this->Form->submit('戻る', ['onclick' => 'history.back()', 'type' => 'button']); ?></div></td>
  <td style="border-style: none;"><div align="center"><?= $this->Form->submit('次へ', array('name' => 'kakunin')); ?></div></td>
</tr>
</table>
<br>

    <?php if($num > 1): ?>
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
    <td width='60' nowrap='nowrap' colspan='2'><div align='center'><font size='-1'><strong>外観１</strong></font></div></td>
    <td width='60' nowrap='nowrap' colspan='2'><div align='center'><font size='-1'><strong>外観２</strong></font></div></td>
    <td width="51" nowrap="nowrap" colspan="2"><div align="center"><font size="-1"><strong>単重</strong></font></div></td>

  </tr>
  <tr style="border-bottom: solid;border-width: 1px">
    <td width="33" rowspan="3" nowrap="nowrap" colspan="2"><div align="center"><strong>規格</strong></div></td>
    <td width="45" nowrap="nowrap" colspan="2"><div align="center"><strong>上限</strong></div></td>

  <?php
      $upperArray = Array();
      for($i=1; $i<=8; $i++){
      echo '<td colspan="2"><div align="center">';
      echo ${"upper_1".$i};
      echo '</div></td>';

      echo $this->Form->hidden('upper_1'.$i ,['value'=>${"upper_1".$i}]);

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
      echo '<td colspan="2"><div align="center">';
      echo ${"lower_1".$i};
      echo '</div></td>';

      echo $this->Form->hidden('lower_1'.$i ,['value'=>${"lower_1".$i}]);

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
      echo '<td colspan="2"><div align="center">';
      echo ${"size_1".$i};
      echo '</div></td>';

      echo $this->Form->hidden('size_1'.$i ,['value'=>${"size_1".$i}]);

      }

      echo $this->Form->hidden('text_10' ,['value'=>$text_10]);
      echo $this->Form->hidden('text_11' ,['value'=>$text_11]);

      ?>

      <td colspan="2"><div align="center"><?= h($text_10) ?></div></td>
      <td colspan="2"><div align="center"><?= h($text_11) ?></div></td>

    <?php else: ?>
    <?php endif; ?>

  <?php if($num == 3): ?>
    <table width="1200" border="1" align="center" bordercolor="#000000" bgcolor="#FFFFFF" style="background-color: #FFFFFF">
      <tr style="border-bottom: solid;border-width: 1px">
        <td colspan="5" nowrap="nowrap"><div align="center"><strong>枚数</strong></div></td>
        <td colspan="9" nowrap="nowrap"><?= h("2 / ".$maisu) ?></td>
        <td colspan="14" nowrap="nowrap">&nbsp;<input type="hidden" name="version" value="0"/></td>
      </tr>
      <tr style="border-bottom: solid;border-width: 1px">

    <td colspan="4">&nbsp;</td>
    <td width="24" colspan="2"><div align="center"><strong>I</strong></div></td>
    <td width="38" colspan="2"><div align="center"><strong>J</strong></div></td>
    <td width="38" colspan="2"><div align="center"><strong>K</strong></div></td>
    <td width="38" colspan="2"><div align="center"><strong>L</strong></div></td>
    <td width="38" colspan="2"><div align="center"><strong>M</strong></div></td>
    <td width="38" colspan="2"><div align="center"><strong>N</strong></div></td>
    <td width="38" colspan="2"><div align="center"><strong>O</strong></div></td>
    <td width="38" colspan="2"><div align="center"><strong>P</strong></div></td>
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
      echo '<td colspan="2"><div align="center">';
      echo ${"upper_2".$i};
      echo '</div></td>';

      echo $this->Form->hidden('upper_2'.$i ,['value'=>${"upper_2".$i}]);

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
      echo '<td colspan="2"><div align="center">';
      echo ${"lower_2".$i};
      echo '</div></td>';

      echo $this->Form->hidden('lower_2'.$i ,['value'=>${"lower_2".$i}]);

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
      echo '<td colspan="2"><div align="center">';
      echo ${"size_2".$i};
      echo '</div></td>';

      echo $this->Form->hidden('size_2'.$i ,['value'=>${"size_2".$i}]);

      }

      ?>

  <td colspan="2"></td>
  <td colspan="2"></td>

  <?php else: ?>
  <?php endif; ?>

          <?php
              echo $this->Form->hidden('version' ,['value'=>0]);
              echo $this->Form->hidden('product_code' ,['value'=>$product_code]);
              echo $this->Form->hidden('type_im' ,['value'=>$type_im]);
              echo $this->Form->hidden('maisu' ,['value'=>$maisu]);
              echo $this->Form->hidden('num' ,['value'=>$num]);
              echo $this->Form->hidden('status' ,['value'=>0]);
              echo $this->Form->hidden('delete_flag' ,['value'=>0]);
              echo $this->Form->hidden('updated_staff');
          ?>

      </fieldset>
      <br>

    <?= $this->Form->end() ?>
    <br>
