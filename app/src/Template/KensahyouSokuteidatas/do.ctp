<?php
/**
 * AuthHelper: Authの変数にアクセスできる
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\Staff $staff
 */
use Cake\ORM\TableRegistry;//独立したテーブルを扱う
$this->KensahyouHeads = TableRegistry::get('kensahyouHeads');//productsテーブルを使う
$this->Products = TableRegistry::get('products');//productsテーブルを使う
?>

<?php
          $username = $this->request->Session()->read('Auth.User.username');
          echo $this->Form->create($kensahyouSokuteidata, ['url' => ['action' => 'index1']]);
?>

              <p align="center"><?php echo $this->Html->image('ShinkiTourokuMenu/touroku.gif',array('width'=>'157','height'=>'50'));?></p>

<hr size="5">

<div align="center"><strong><font color="red">＊下記のように登録されました</font></strong></div>
<br>

    <table width="1200" border="1" align="center" bordercolor="#000000" bgcolor="#FFFFFF" style="background-color: #FFFFFF">
        <tr style="border-bottom: solid;border-width: 1px">
          <td colspan="5" nowrap="nowrap"><div align="center"><strong>部品番号</strong></div></td>
          <td colspan="9" nowrap="nowrap"><?= h($product_code) ?></td>
          <td colspan="5" nowrap="nowrap"><div align="center"><strong>部品名</strong></div></td>
          <td colspan="9" nowrap="nowrap"><?= h($Productname) ?></td>
        </tr>
        <tr style="border-bottom: solid;border-width: 1px">
          <td colspan="5" nowrap="nowrap"><div align="center"><strong>新規バージョン</strong></div></td>
          <td colspan="9"><?= h($KensahyouHeadver) ?></td>
          <td colspan="14" nowrap="nowrap">&nbsp;</td>
        </tr>
        <tr style="border-bottom: solid;border-width: 1px">
          <td colspan="5" nowrap="nowrap"><div align="center"><strong>製造年月日</strong></div></td>
          <td colspan="9"><?= h($_SESSION['sokuteidata'][1]['manu_date']) ?></td>
          <td colspan="5" nowrap="nowrap"><div align="center"><strong>検査年月日</strong></div></td>
          <td colspan="9"><?= h($_SESSION['sokuteidata'][1]['inspec_date']) ?></td>
        </tr>

<?php
     echo $htmlKensahyouHeader;
?>

        <?php
            $lowerArraygyou = Array();
            for($q=1; $q<=8; $q++){
              echo '<tr style="border-bottom: solid;border-width: 1px"><td nowrap="nowrap" colspan="4"><div align="center"><strong>';
              echo $q;
              echo '</strong></div></td>';

              $lowerArray = Array();
              for($r=1; $r<=8; $r++){
                  echo '<td colspan="2"><div align="center">';
                  echo $_SESSION['sokuteidata']["{$q}"]["result_size_{$r}"] ;
                  echo '</div></td>';
              }
              echo "<td colspan='2'>\n";
              echo "</td>\n";
              echo "<td colspan='2'>\n";
              echo $_SESSION['sokuteidata']["{$q}"]["situation_dist"];
              echo "</td>\n";
                echo "<td colspan='2'></td>\n";
                echo "<td colspan='2'>\n";
                echo $_SESSION['sokuteidata']["{$q}"]["result_weight"];
                echo "</td>\n";
            }
        ?>
        </tr>

          <td height="120" colspan="28" style="border-bottom: solid;border-width: 1px">
            <strong>備考：</strong><br>
                  <?= h($KensahyouHeadbik) ?>
              </td>
        </tr>
       <tr>
</table>

<br>
<br>
        <p align="center"><?= $this->Form->button(__('top'), array('name' => 'top')) ?></p>
        <?= $this->Form->end() ?>
