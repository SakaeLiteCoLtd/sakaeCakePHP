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
  echo $this->Form->create($kensahyouHead, ['url' => ['action' => 'editform']]);
  $options2 = [
    '0' => '新バージョン登録',
    '1' => '登録内容修正　　'
  ];
  $attributes = array('value' => 0);
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
      <td colspan="9"><?= $this->Form->input("maisu", ["type"=>"select", "options"=>$arrmaisu, 'label'=>false, 'required'=>true]) ?></td>
      <td colspan="14" nowrap="nowrap">&nbsp;<input type="hidden" name="version" value="0"/></td>
    </tr>
</table>

<?php
echo $this->Form->hidden('id' ,['value'=>$kensahyouHead->id]);
echo $this->Form->hidden('product_code' ,['value'=>$product_code]);
echo $this->Form->hidden('status' ,['value'=>0]);
echo $this->Form->hidden('delete_flag' ,['value'=>0]);
echo $this->Form->hidden('updated_staff');
?>
    </fieldset>
    <center><?= $this->Form->submit(__('次へ'), array('name' => 'kakunin')) ?></center>
<br><br><br><br>
    <?= $this->Form->end() ?>
