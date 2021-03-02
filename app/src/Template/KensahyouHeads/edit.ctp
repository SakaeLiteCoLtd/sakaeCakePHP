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

	<?php
  echo $this->Form->create($kensahyouHead, ['url' => ['action' => 'editconfirm']]);
  $options2 = [
    '0' => '新バージョン登録',
    '1' => '登録内容修正　　'
  ];
  $attributes = array('value' => 0)
	?>

    <fieldset>

      <a align="center"><?= $this->Form->radio("kousinn_flag", $options2, $attributes); ?></a>
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
      <td colspan="9"><?= h($newversion) ?></td>
      <td colspan="5" nowrap="nowrap"><div align="center"><strong>IMタイプ</strong></div></td>
      <td colspan="9"><?= $this->Form->input("type_im", ["type"=>"select","empty"=>"選択してください", "options"=>$arrType, 'label'=>false, 'required'=>true]) ?></td>
    </tr>
    <tr style="border-bottom: solid;border-width: 1px">
      <td colspan="5" nowrap="nowrap"><div align="center"><strong>枚数</strong></div></td>
      <td colspan="9"><?= $this->Form->input("maisu", array('type' => 'value', 'label'=>false)); ?></td>
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
      <td width="60" nowrap="nowrap" colspan="2"><div align="center"><font size="-3"><strong>ソリ・フレ</strong></font></div></td>
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
        echo '<input name=" upper_' . $i . '" type="text"  value="" size="6"/>';
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
        echo '<input name=" lower_' . $i . '" type="text"  value="" size="6"/>';
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
        echo '<input name=" size_' . $i . '" type="text"  value="" size="6"/>';
        echo '</div></td>';
        }
        echo '<td colspan="2"><div align="center">';
        echo '<input name="text_10" type="text"  value="" size="6"/>';
        echo '</div></td>';
        echo '<td colspan="2"><div align="center">';
        echo '<input name="text_11" type="text"  value="" size="6"/>';
        echo '</div></td>';

    ?>

    </tr>

    <td height="120" colspan="28" style="vertical-align: top; border-bottom: solid;border-width: 1px;text-align: left">
      <strong style="text-align: left">備考：</strong><br>
          <textarea name="bik"  cols="120" rows="10"></textarea>
      </td>
    </tr>
   <tr>
</table>
<table>
<td style="text-align: left">
<strong>　*備考の欄内にはソリ・フレ値・外観の検査基準を外観の規格欄内の値と関連付けてください。</strong>
</td>
</table>

<?php
echo $this->Form->hidden('id' ,['value'=>$kensahyouHead->id]);
echo $this->Form->hidden('version' ,['value'=>$kensahyouHead->version+1]);
echo $this->Form->hidden('product_code' ,['value'=>$product_code]);
echo $this->Form->hidden('status' ,['value'=>0]);
echo $this->Form->hidden('delete_flag' ,['value'=>0]);
echo $this->Form->hidden('updated_staff');
?>
    </fieldset>
    <center><?= $this->Form->submit(__('確認'), array('name' => 'kakunin')) ?></center>
<br>
    <?= $this->Form->end() ?>
