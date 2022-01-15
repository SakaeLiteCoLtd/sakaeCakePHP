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

<?= $this->Form->create($kensahyouHead, ['url' => ['action' => 'editpreadd']]) ?>
        <?php
            $username = $this->request->Session()->read('Auth.User.username');
            header('Expires:-1');
            header('Cache-Control:');
            header('Pragma:');

            echo $this->Form->hidden('product_code' ,['value'=>$data['product_code'] ]) ;
            echo $this->Form->hidden('version' ,['value'=>$data['version'] ]) ;
            echo $this->Form->hidden('type_im' ,['value'=>$data['type_im'] ]) ;
            echo $this->Form->hidden('maisu' ,['value'=>$data['maisu'] ]) ;

            $Array = Array();

            for($k=1; $k<=$data['maisu']; $k++){
              for($i=1; $i<=8; $i++){
                echo $this->Form->hidden("upper_$k$i" ,['value'=>$data["upper_$k$i"] ]) ;
                echo $this->Form->hidden("lower_$k$i" ,['value'=>$data["lower_$k$i"] ]) ;
                echo $this->Form->hidden("size_$k$i" ,['value'=>$data["size_$k$i"] ]) ;
              }
              echo $this->Form->hidden("size_$k"."9" ,['value'=>$data["size_$k"."9"] ]) ;
            }

            echo $this->Form->hidden("bik" ,['value'=>$data["bik"] ]) ;
            echo $this->Form->hidden('status' ,['value'=>$data['status'] ]) ;
            echo $this->Form->hidden('delete_flag' ,['value'=>$data['delete_flag'] ]) ;
            echo $this->Form->hidden('updated_staff' ,['value'=>null ]) ;

        ?>
        <br>
        <legend align="center"><font color="red"><?= __($mes) ?></font></legend>
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
      <td colspan="9"><?= h($data['version']) ?></td>
      <td colspan="5" nowrap="nowrap"><div align="center"><strong>IMタイプ</strong></div></td>
      <td colspan="9"><?= h($type_im_hyouji) ?></td>
    </tr>

    <?php for($j=1; $j<=$data['maisu']; $j++): ?>

    <tr style="border-bottom: solid;border-width: 1px">
      <td colspan="5" nowrap="nowrap"><div align="center"><strong>枚数</strong></div></td>
      <td colspan="9"><?= h($j." / ".$data['maisu']) ?></td>
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
        echo $data['upper_'.$j.$k];
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
        echo $data['lower_'.$j.$k];
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
        echo $data['size_'.$j.$l];
        echo '</div></td>';
        }
    ?>

    <?php if($j == 1): ?>
    <td colspan="2"><div align="center"><?= h($data['text_10']) ?></div></td>
    <td colspan="2"><div align="center"><?= h($data['text_11']) ?></div></td>
  <?php else: ?>
    <td colspan="2"></td>
    <td colspan="2"></td>
  <?php endif; ?>

    </tr>

  <?php endfor;?>

    <td height="120" colspan="28" style="vertical-align: top; border-bottom: solid;border-width: 1px;text-align: left">
      <strong style="text-align: left">備考：</strong><br>
          <div cols="120" rows="10"><?= h($data['bik']) ?></div>
      </td>
    </tr>
   <tr>
</table>

<br>
<br>
<table align="center" border="2" bordercolor="#E6FFFF" cellpadding="0" cellspacing="0">
<tr>
  <td style="border-style: none;"><div align="center"><?= $this->Form->submit('戻る', ['onclick' => 'history.back()', 'type' => 'button']); ?></div></td>
  <td style="border-style: none;"><div align="center"><?= $this->Form->submit('決定', array('name' => 'kakunin')); ?></div></td>
</tr>
</table>
<br>
<?= $this->Form->end() ?>
