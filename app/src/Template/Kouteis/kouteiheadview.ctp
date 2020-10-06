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

          echo $this->Form->create($kensahyouSokuteidata, ['url' => ['action' => 'indexhome']]);
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


    <fieldset>
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
     echo $htmlKensahyouHeader;
?>

<tr style="border-bottom: solid;border-width: 1px">
<td height="120" colspan="28" style="vertical-align: top; border-bottom: solid;border-width: 1px;text-align: left">
  <strong style="text-align: left">備考：</strong><br>
          <?= h($KensahyouHeadbik) ?>
      </td>
</tr>
</table>
<table>
<td style="text-align: left">
<strong>　*備考の欄内にはソリ・フレ値・外観の検査基準を外観の規格欄内の値と関連付けてください。</strong>
</td>
</table>

  </table>
  <br>
        <?php
              echo $this->Form->hidden('product_code' ,['value'=>$product_code]);
        ?>
    </fieldset>
    <?= $this->Form->end() ?>
    <br>
