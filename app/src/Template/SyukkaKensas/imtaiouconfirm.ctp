<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\Staff $staff
 */
 use Cake\ORM\TableRegistry;//独立したテーブルを扱う
$this->KensahyouHeads = TableRegistry::get('kensahyouHeads');//kensahyouHeadsテーブルを使う
$this->Products = TableRegistry::get('products');//productsテーブルを使う
?>

<?= $this->Form->create($entity, ['url' => ['action' => 'impreadd']]) ?>

<?php
      $username = $this->request->Session()->read('Auth.User.username');
      $session = $this->request->getSession();

      for($n=1; $n<=9; $n++){
              $resultArray = Array();
                  $_SESSION['kikakudata'][$n] = array(
                    'product_code' => $_POST['product_code'],
                    'kensahyuo_num' => $n,
                    "kind_kensa" => $_POST["kind_kensa_{$n}"],
                    "size_num" => $_POST["size_num_{$n}"],
                  );
      }
?>
<br>

<br>
              <p align="center"><?php echo $this->Html->image('ShinkiTourokuMenu/touroku.gif',array('width'=>'157','height'=>'50'));?></p>

<hr size="5">
<div align="center"><strong><font color="red">＊下記のように登録します</font></strong></div>
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
            echo $this->request->getData("kind_kensa_{$i}") ;
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
            echo $this->request->getData("size_num_{$i}") ;
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
<?php
      echo $this->Form->hidden('product_code' ,['value'=>$product_code]);
?>
</fieldset>
        <p align="center"><?= $this->Form->button('戻る', ['onclick' => 'history.back()', 'type' => 'button']) ?>
        <?= $this->Form->button(__('登録'), array('name' => 'touroku')) ?></p>

        <?= $this->Form->end() ?>
