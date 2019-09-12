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

          echo $this->Form->create($kensahyouSokuteidata, ['url' => ['action' => 'imtaiouconfirm']]);
        ?>

    <fieldset>
<div align="center"><strong><font color="red">＊入力してください</font></strong></div>
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
                    echo "<td colspan='2'><div align='center'><select name=kind_kensa_".$i.">\n";
      //              echo "<name=kind_kensa_".$i." options=$arrKindKensa size='6'/>\n";
                    foreach ($arrKindKensa as $value){
                    echo "<option name=kind_kensa_".$i." value=$value>$value</option>";
                    }
                    echo "</select></div></td>\n";
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
                    echo "<input type='text' name=size_num_".$i." value=''  size='6'/>\n";
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
        <?php
              echo $this->Form->hidden('product_id' ,['value'=>$product_id]);
        ?>
    </fieldset>
    <center><?= $this->Form->button(__('confirm'), array('name' => 'kakunin')) ?></center>
    <?= $this->Form->end() ?>
