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

          echo $this->Form->hidden('product_code' ,['value'=>$product_code ]) ;
          echo $this->Form->create($kensahyouSokuteidata, ['url' => ['action' => 'form']]);
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

         <?php if($check == 1): ?>

    <fieldset>
<div align="center"><strong><font color="red">＊ロット番号を入力して取り込みボタンを押してください</font></strong></div>
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
          <td colspan="7"><?= $this->Form->input("lot_num", array('pattern' => '^[0-9A-Za-z.-]+$', 'title' => "半角英数字で入力して下さい。", 'type' => 'text', 'label'=>false, 'autofocus'=>true)); ?></td>
          <td colspan="2" nowrap="nowrap"><div align="center"><?= $this->Form->submit(__('取り込み'), array('name' => 'top')); ?></div></td>
        </tr>
        <tr style="border-bottom: solid;border-width: 1px">
          <td colspan="5" nowrap="nowrap"><div align="center"><strong>製造年月日</strong></div></td>
          <td colspan="9"><?= $this->Form->input("manu_date", array('type' => 'date', 'monthNames' => false, 'label'=>false, 'value'=>$manu_date)); ?></td>
          <td colspan="5" nowrap="nowrap"><div align="center"><strong>検査年月日</strong></div></td>
          <td colspan="9"><?= $this->Form->input("inspec_date", array('type' => 'date', 'monthNames' => false, 'label'=>false)); ?></td>
        </tr>
</table>
        <?php
            echo $this->Form->hidden('kensahyou_heads_id' ,['value'=>$KensahyouHeadid]);
            echo $this->Form->hidden('product_code' ,['value'=>$product_code]) ;
            echo $this->Form->hidden('delete_flag' ,['value'=>0]);
        ?>
    </fieldset>

    <fieldset>
    <?= $this->Form->control('product_code1', array('type'=>'hidden', 'value'=>$product_code, 'label'=>false)) ?>
    <?= $this->Form->control('product_name1', array('type'=>'hidden', 'value'=>$Productname, 'label'=>false)) ?>
    <?= $this->Form->control('kadouseikeiId', array('type'=>'hidden', 'value'=>$kadouseikeiId, 'label'=>false)) ?>
    </fieldset>

    <?= $this->Form->end() ?>

    <?php else: ?>
    <br><br>
    <div align="center"><strong><font color="red">＊その品番は検査表ヘッダーが登録されていません。</font></strong></div>
    <br><br>
      <?php endif; ?>
