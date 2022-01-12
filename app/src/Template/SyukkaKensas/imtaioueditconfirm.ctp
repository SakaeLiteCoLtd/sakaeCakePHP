<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\Staff $staff
 */
 use Cake\ORM\TableRegistry;//独立したテーブルを扱う
$this->KensahyouHeads = TableRegistry::get('kensahyouHeads');//kensahyouHeadsテーブルを使う
$this->Products = TableRegistry::get('products');//productsテーブルを使う
$this->ImKikakuTaious = TableRegistry::get('imKikakuTaious');
?>

<?= $this->Form->create($entity, ['url' => ['action' => 'imtaioueditpreadd']]) ?>

<?php
      $username = $this->request->Session()->read('Auth.User.username');
      $session = $this->request->getSession();
/*
      $ImKikakuTaious = $this->ImKikakuTaious->find()->where(['product_code' => $_POST['product_code'], 'status' => '0'])->toArray();
      $version = $ImKikakuTaious[0]->version + 1;

      for($n=1; $n<=9; $n++){

        $kind_kensa_arr = explode("_",$_POST["kind_kensa_{$n}"]);//切り離し
        if(isset($kind_kensa_arr[1])){
          $kind_kensa = $kind_kensa_arr[1];
        }else{
          $kind_kensa = $_POST["kind_kensa_{$n}"];
        }

        $resultArray = Array();
        $_SESSION['kikakudata'][$n] = array(
          'product_code' => $_POST['product_code'],
          'kensahyuo_num' => $n,
          'version' => $version,
    //      "kind_kensa" => $_POST["kind_kensa_{$n}"],
          "kind_kensa" => $kind_kensa,
          "size_num" => $_POST["size_num_{$n}"],
          "created_staff" => "",
          "created_at" => ""
        );
      }

      $_SESSION['kousinn_flag'] = array(
        'kousinn_flag' => 9999
      );
*/
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
<div align="center"><strong><font color="red">＊下記のように更新します</font></strong></div>
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
  //   echo $htmlKensahyouHeader;
?>

<?php for($j=1; $j<=$maisu; $j++): ?>

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
      echo '<td colspan="2"><div align="center">';
      echo ${"upper_".$j.$k};
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
      echo '<td colspan="2"><div align="center">';
      echo ${"lower_".$j.$k};
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
      echo '<td colspan="2"><div align="center">';
      echo ${"size_".$j.$l};
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

    echo "ＩＭ検査";
    echo "</strong></div></td>\n";
        $resultArray = Array();
        for($i=1; $i<=9; $i++){
          $num = ($j - 1)*9 + $i;

            echo "<td colspan='2'><div align='center'>\n";
            echo $this->request->getData("kind_kensa_{$num}") ;
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
          $num = ($j - 1)*9 + $i;

            echo "<td colspan='2'><div align='center'>\n";
            echo $this->request->getData("size_num_{$num}") ;
            echo "</div></td>\n";
        }
    echo "<td colspan='2'>\n";
    echo "</td>\n";
    echo "<td colspan='2'>\n";
    echo "</td>\n";
    echo "<td colspan='2'>\n";
    echo "</td>\n";
?>

<?php endfor;?>

</table>

<br>
<br>
<?php
echo $this->Form->hidden('product_code' ,['value'=>$product_code]);
echo $this->Form->hidden('newversion' ,['value'=>$newversion]);
echo $this->Form->hidden('maisu' ,['value'=>$maisu]);
?>

</fieldset>
<table align="center" border="2" bordercolor="#E6FFFF" cellpadding="0" cellspacing="0">
<tr>
  <td style="border-style: none;"><div align="center"><?= $this->Form->submit('戻る', ['onclick' => 'history.back()', 'type' => 'button']); ?></div></td>
  <td style="border-style: none;"><div align="center"><?= $this->Form->submit('決定', array('name' => 'kakunin')); ?></div></td>
</tr>
</table>

        <?= $this->Form->end() ?>
