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
          echo $this->Form->create($ImKikakuTaiou, ['url' => ['action' => 'index1']]);

          $session = $this->request->getSession();
          $sessiondata = $session->read();//postデータ取得し、$dataと名前を付ける
          $data = $sessiondata['kikakudata'];
?>
<br>

              <p align="center"><?php echo $this->Html->image('ShinkiTourokuMenu/touroku.gif',array('width'=>'157','height'=>'50'));?></p>

<hr size="5">

<div align="center"><strong><font color="red">＊下記のように登録されました</font></strong></div>
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

<?php
    echo "<tr style='border-bottom: solid;border-width: 1px'><td nowrap='nowrap' colspan='4'><div align='center'><strong>\n";
    echo "ＩＭ検査";
    echo "</strong></div></td>\n";
        $resultArray = Array();
        for($i=1; $i<=9; $i++){
            echo "<td colspan='2'><div align='center'>\n";
            echo $data["{$i}"]["kind_kensa"] ;
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
            echo "<td colspan='2'><div align='center'>\n";
            echo $data["{$i}"]["size_num"] ;
            echo "</div></td>\n";
        }
    echo "<td colspan='2'>\n";
    echo "</td>\n";
    echo "<td colspan='2'>\n";
    echo "</td>\n";
    echo "<td colspan='2'>\n";
    echo "</td>\n";
?>
</table>

<br>
<br>
        <p align="center"><?= $this->Form->button(__('top'), array('name' => 'top')) ?></p>
        <?= $this->Form->end() ?>
