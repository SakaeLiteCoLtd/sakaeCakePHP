<?php
/**
 * AuthHelper: Authの変数にアクセスできる
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\Deliver $priceMaterial
 */
 use Cake\ORM\TableRegistry;//独立したテーブルを扱う
$this->KensahyouHeads = TableRegistry::get('kensahyouHeads');//kensahyouHeadsテーブルを使う
$this->Products = TableRegistry::get('products');//productsテーブルを使う
?>
        <?php
          $username = $this->request->Session()->read('Auth.User.username');

          header('Expires:-1');
          header('Cache-Control:');
          header('Pragma:');

          echo $this->Form->create($KouteiKensahyouHeads, ['url' => ['action' => 'typeimtaioupreadd']]);
        ?>

        <?php
         use App\myClass\Syukkakensa\htmlSyukkakensamenu;//myClassフォルダに配置したクラスを使用
         $htmlSyukkakensamenu = new htmlSyukkakensamenu();
         $htmlKouteismenus = $htmlSyukkakensamenu->Kouteismenu();
         ?>
         <hr size="5" style="margin: 0.5rem">
         <table style="margin-bottom:0px" width="750" border="0" align="center" cellpadding="0" cellspacing="0" bordercolor="#CCCCCC">
         <?php
            echo $htmlKouteismenus;
         ?>
         </table>
         <hr size="5" style="margin: 0.5rem">

<?php if($check == 1): ?>
  <fieldset>
    <div align="center"><strong><font color="red">＊運用中</font></strong></div>
    <br>
    <table width="600" border="1" align="center" bordercolor="#000000" bgcolor="#FFDEAD">
        <tbody border="2" bordercolor="#E6FFFF" bgcolor="#FFFFCC">
        <tr>
          <td colspan="6" nowrap="nowrap" style="border-bottom: solid;border-width: 1px"><div align="center"><strong><font color="blue">部品番号</font></strong></div></td>
          <td colspan="6" nowrap="nowrap" style="border-bottom: solid;border-width: 1px"><?= h($product_code) ?></td>
          <td colspan="6" nowrap="nowrap" style="border-bottom: solid;border-width: 1px"><div align="center"><strong><font color="blue">部品名</font></strong></div></td>
          <td colspan="6" nowrap="nowrap" style="border-bottom: solid;border-width: 1px"><?= h($Productname) ?></td>
        </tr>
    </table>
    <br>
    <table width="600" border="1" align="center" bordercolor="#000000" bgcolor="#FFDEAD">
        <tbody border="2" bordercolor="#E6FFFF" bgcolor="#FFFFCC">
        <tr>
          <td colspan="6" nowrap="nowrap" style="border-bottom: solid;border-width: 1px"><div align="center"><strong><font color="blue">工程検査運用中バージョン</font></strong></div></td>
          <td colspan="6" nowrap="nowrap" style="border-bottom: solid;border-width: 1px"><?= h($versionnow) ?></td>
        </tr>
    </table>
    <br>
    <table width="600" border="1" align="center" bordercolor="#000000" bgcolor="#FFDEAD">
        <tbody border="2" bordercolor="#E6FFFF" bgcolor="#FFFFCC">
        <tr>
          <td colspan="6" nowrap="nowrap" style="border-bottom: solid;border-width: 1px"><div align="center"><strong><font color="blue">使用中IMタイプ</font></strong></div></td>
          <td colspan="6" nowrap="nowrap" style="border-bottom: solid;border-width: 1px"><?= h($typenow) ?></td>
          <td colspan="6" nowrap="nowrap" style="border-bottom: solid;border-width: 1px"><div align="center"><strong><font color="blue">新規IMタイプ</font></strong></div></td>
          <td colspan="6" nowrap="nowrap" style="border-bottom: solid;border-width: 1px"><?= $this->Form->input("type_im", ["type"=>"select","empty"=>"選択してください", "options"=>$arrType, 'label'=>false, 'required'=>true]) ?></td>
        </tr>
    </table>
<br>
<table align="center" border="2" bordercolor="#E6FFFF" cellpadding="0" cellspacing="0">
<tr>
  <td style="border-style: none;"><div align="center"><?= $this->Form->submit(__('更新'), array('name' => 'kakunin')); ?></div></td>
</tr>
</table>

<?php
echo $this->Form->hidden('id' ,['value'=>$id]);
echo $this->Form->hidden('version' ,['value'=>$newversion]);
?>

</fieldset>
<?php else: ?>
<br><br>
<div align="center"><strong><font color="red">＊その品番は検査表が登録されていません。</font></strong></div>
<br><br>
  <?php endif; ?>
