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
 $htmlKouteismenus = $htmlSyukkakensamenu->Kouteismenu();
 ?>
 <hr size="5" style="margin: 0.5rem">
 <table style="margin-bottom:0px" width="750" border="0" align="center" cellpadding="0" cellspacing="0" bordercolor="#CCCCCC">
 <?php
    echo $htmlKouteismenus;
 ?>
 </table>
 <hr size="5" style="margin: 0.5rem">

	<?php
  echo $this->Form->create($KouteiImKikakuTaious, ['url' => ['action' => 'imtaioueditconfirm']]);
  $options2 = [
    '0' => 'データを編集',
    '1' => 'データを削除'
  ];
	?>

      <?php
    /*  <a align="center"><?= $this->Form->radio("delete_flag", $options2); ?></a> */
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
          echo "形状確認";
          echo "</strong></div></td>\n";
              $resultArray = Array();
              for($i=1; $i<=9; $i++){
                  echo "<td colspan='2'><div align='center'><select name=shape_detection_".$i.">\n";
                  foreach ($arr_shape_detection as $value){
                  echo "<option name=shape_detection_".$i." value=$value>$value</option>";
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
          echo $this->Form->hidden('product_code' ,['value'=>$product_code]);
          echo $this->Form->hidden('newversion' ,['value'=>$newversion]);
          ?>
      </fieldset>
      <center><?= $this->Form->button(__('確認'), array('name' => 'kakunin')) ?></center>
      <?= $this->Form->end() ?>
<br>
    <?= $this->Form->end() ?>
