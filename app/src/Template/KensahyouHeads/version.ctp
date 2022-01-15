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

<?php if($KensaProduct == empty($arr)): ?>

    <?php foreach ($kensahyouHeads as $kensahyouHead): ?>

    <fieldset>
          <?php
          	$KensaProduct = $this->KensahyouHeads->find()->where(['product_code' => $product_code ,'delete_flag' => '0'])->order(["version"=>"desc"])->toArray();
          	$KensaProductV = $KensaProduct[0]->version;
           	$this->set('KensaProductV',$KensaProductV);

            $newversion = $KensaProductV + 1;
          ?>
    <table width="600" border="1" align="center" bordercolor="#000000" bgcolor="#FFDEAD">
        <tbody border="2" bordercolor="#E6FFFF" bgcolor="#FFFFCC">
        <tr>
          <td colspan="6" nowrap="nowrap" style="border-bottom: solid;border-width: 1px"><div align="center"><strong><font color="blue">部品番号</font></strong></div></td>
          <td colspan="6" nowrap="nowrap" style="border-bottom: solid;border-width: 1px"><?= h($Productcode) ?></td>
          <td colspan="6" nowrap="nowrap" style="border-bottom: solid;border-width: 1px"><div align="center"><strong><font color="blue">部品名</font></strong></div></td>
          <td colspan="6" nowrap="nowrap" style="border-bottom: solid;border-width: 1px"><?= h($Productname) ?></td>
        </tr>
    </table>
    <table width="600" border="1" align="center" bordercolor="#000000" bgcolor="#FFDEAD">
        <tbody border="2" bordercolor="#E6FFFF" bgcolor="#FFFFCC">
        <tr>
          <td colspan="9" nowrap="nowrap" style="border-bottom: solid;border-width: 1px"><div align="center"><strong><font color="blue">出荷検査運用中バージョン</font></strong></div></td>
          <td colspan="3" nowrap="nowrap" style="border-bottom: solid;border-width: 1px"><?= h($KensaProductV) ?></td>
        </tr>
    </table>
    <table width="600" border="1" align="center" bordercolor="#000000" bgcolor="#FFDEAD">
        <tbody border="2" bordercolor="#E6FFFF" bgcolor="#FFFFCC">
        <tr>
          <td colspan="9" nowrap="nowrap" style="border-bottom: solid;border-width: 1px"><div align="center"><strong><font color="blue">新規登録バージョン</font></strong></div></td>
          <td colspan="3" nowrap="nowrap" style="border-bottom: solid;border-width: 1px"><?= h($newversion) ?></td>
        </tr>
    </table>
<br>
    <table align="center">
        <tr>
          <td class="actions">
              <a><?= $this->Html->link(__('編集'), ['action' => 'edit', $kensahyouHead->id]) ?></a>
          </td>
        </tr>
    </table>

    <?php endforeach; ?>
<?=$this->Form->end() ?>

<?php else: ?>
    <?= $this->Form->create($kensahyouHead, ['url' => ['action' => 'form']]) ?>
    <fieldset>
<div align="center"><strong><font color="red">＊枚数を選択してください</font></strong></div>
<br>
    <table width="800" border="1" align="center" bordercolor="#000000" bgcolor="#FFFFFF" style="background-color: #FFFFFF">
        <tr height="60" style="border-bottom: solid;border-width: 1px">
          <td colspan="5" nowrap="nowrap"><div align="center"><strong>部品番号</strong></div></td>
          <td colspan="9" nowrap="nowrap"><?= h($Productcode) ?></td>
          <td colspan="5" nowrap="nowrap"><div align="center"><strong>部品名</strong></div></td>
          <td colspan="9" nowrap="nowrap"><?= h($Productname) ?></td>
        </tr>
        <tr height="60" style="border-bottom: solid;border-width: 1px">
          <td colspan="5" nowrap="nowrap"><div align="center"><strong>IMタイプ</strong></div></td>
          <td colspan="9"><?= $this->Form->input("type_im", ["type"=>"select","empty"=>"選択してください", "options"=>$arrType, 'label'=>false, 'required'=>true]) ?></td>
          <td colspan="5" nowrap="nowrap"><div align="center"><strong>枚数</strong></div></td>
          <td colspan="9"><?= $this->Form->input("maisu", ["type"=>"select", "options"=>$arrmaisu, 'label'=>false, 'required'=>true]) ?></td>
        </tr>
</table>

        <?php
            echo $this->Form->hidden('version' ,['value'=>0]);
            echo $this->Form->hidden('product_code' ,['value'=>$product_code]);
            echo $this->Form->hidden('status' ,['value'=>0]);
            echo $this->Form->hidden('delete_flag' ,['value'=>0]);
            echo $this->Form->hidden('updated_staff');
        ?>

    </fieldset>
    <center><?= $this->Form->submit(__('次へ'), array('name' => 'kakunin')) ?></center>
    <?= $this->Form->end() ?>
    <br>
    <br>

<?php endif; ?>
