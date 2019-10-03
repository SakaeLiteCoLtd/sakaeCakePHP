<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\Staff[]|\Cake\Collection\CollectionInterface $staffs
 */
use Cake\ORM\TableRegistry;//独立したテーブルを扱う
$this->Products = TableRegistry::get('products');//productsテーブルを使う
$this->KensahyouSokuteidatas = TableRegistry::get('kensahyouSokuteidatas');//kensahyouHeadsテーブルを使う
?>
<?php
          $username = $this->request->Session()->read('Auth.User.username');

          header('Expires:-1');
          header('Cache-Control:');
          header('Pragma:');
          echo $this->Form->create($kensahyouSokuteidatas, ['url' => ['action' => 'index']]);
?>

<fieldset>
<div align="center"><strong><font color="red">＊詳細表示</font></strong></div>
<br>
    <table width="1200" border="1" align="center" bordercolor="#000000" style="background-color: #FFFFFF" >
        <tr style="background-color: #FFFFFF;border-bottom: solid;border-width: 1px">
          <td colspan="5" nowrap="nowrap"><div align="center"><strong>部品番号</strong></div></td>
          <td colspan="9" nowrap="nowrap"><?= h($product_code) ?></td>
          <td colspan="5" nowrap="nowrap"><div align="center"><strong>部品名</strong></div></td>
          <td colspan="9" nowrap="nowrap"><?= h($Productname) ?></td>
        </tr>
        <tr style="background-color: #FFFFFF;border-bottom: solid;border-width: 1px">
          <td colspan="5" nowrap="nowrap"><div align="center"><strong>新規バージョン</strong></div></td>
          <td colspan="9"><?= h($KensahyouHeadver) ?></td>
          <td colspan="5" nowrap="nowrap"><div align="center"><strong>ロット番号</strong></div></td>
          <td colspan="9"><?= h($lot_num) ?></td>
        </tr>
        <tr style="background-color: #FFFFFF;border-bottom: solid;border-width: 1px">
          <td colspan="5" nowrap="nowrap"><div align="center"><strong>製造年月日</strong></div></td>
          <td colspan="9"><?= h($KensahyouHead_manu_date); ?></td>
          <td colspan="5" nowrap="nowrap"><div align="center"><strong>検査年月日</strong></div></td>
          <td colspan="9"><?= h($KensahyouHead_inspec_date); ?></td>
        </tr>

<?php
     echo $htmlKensahyouHeader;
?>

            <?php foreach ($kensahyouSokuteidatas as $KensahyouSokuteidata): ?>
                <tr style='background-color: #FFFFFF;border-bottom: solid;border-width: 1px'><td nowrap="nowrap" colspan="4"><div align="center"><strong><?= h($KensahyouSokuteidata->cavi_num) ?></strong></div></td>
                <?php
                      for($r=1; $r<=9; $r++){
                          echo '<td colspan="2" style="background-color: #FFFFFF;border-bottom: solid;border-width: 1px"><div align="center">';
                          echo $KensahyouSokuteidata->{"result_size_{$r}"} ;
                          echo '</div></td>';
                      }
                ?>
                <td colspan='2'><div align="center"><?= h($KensahyouSokuteidata->situation_dist) ?></div></td>
                <td colspan='2'><div align="center"></div></td>
                <td colspan='2'><div align="center"><?= h($KensahyouSokuteidata->result_weight) ?></div></td>
            <?php endforeach; ?>
        </tr>
          <td height="120" colspan="28" style="border-bottom: solid;border-width: 1px">
	      <strong>備考：</strong><br>
              <div cols="120" rows="10"><?= h($this->request->getData('bik')) ?></div>
          </td>
        </tr>
    </table>
<br>

</fieldset>
