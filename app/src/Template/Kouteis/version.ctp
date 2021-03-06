<?php
/**
 * AuthHelper: Authの変数にアクセスできる
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\Deliver $priceMaterial
 */
 use Cake\ORM\TableRegistry;//独立したテーブルを扱う
$this->KouteiKensahyouHeads = TableRegistry::get('kouteiKensahyouHeads');//productsテーブルを使う
$this->Products = TableRegistry::get('products');//productsテーブルを使う
?>
        <?php
          $username = $this->request->Session()->read('Auth.User.username');

          header('Expires:-1');
          header('Cache-Control:');
          header('Pragma:');
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

<?php if($KensaProduct == empty($arr)): ?>

    <?php foreach ($KouteiKensahyouHeads as $KouteiKensahyouHeads): ?>

    <fieldset>
          <?php
          	$KensaProduct = $this->KouteiKensahyouHeads->find()->where(['product_code' => $product_code ,'delete_flag' => '0'])->order(["version"=>"desc"])->toArray();
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
                    <a><?= $this->Html->link(__('編集'), ['action' => 'edit', $KouteiKensahyouHeads->id]) ?></a>
                </td>
        </tr>
    </table>

    <?php endforeach; ?>
<?=$this->Form->end() ?>

<?php else: ?>
    <?= $this->Form->create($KouteiKensahyouHeads, ['url' => ['action' => 'confirm']]) ?>
    <fieldset>
<div align="center"><strong><font color="red">＊登録してください</font></strong></div>
<br>
    <table width="1200" border="1" align="center" bordercolor="#000000" bgcolor="#FFFFFF" style="background-color: #FFFFFF">
        <tr style="border-bottom: solid;border-width: 1px">
          <td colspan="5" nowrap="nowrap"><div align="center"><strong>部品番号</strong></div></td>
          <td colspan="9" nowrap="nowrap"><?= h($Productcode) ?></td>
          <td colspan="5" nowrap="nowrap"><div align="center"><strong>部品名</strong></div></td>
          <td colspan="9" nowrap="nowrap"><?= h($Productname) ?></td>
        </tr>
        <tr style="border-bottom: solid;border-width: 1px">
          <td colspan="5" nowrap="nowrap"><div align="center"><strong>新規バージョン</strong></div></td>
          <td colspan="9"><?= h("0") ?></td>
          <td colspan="5" nowrap="nowrap"><div align="center"><strong>IMタイプ</strong></div></td>
          <td colspan="9"><?= $this->Form->input("type_im", ["type"=>"select","empty"=>"選択してください", "options"=>$arrType, 'label'=>false, 'required'=>true]) ?></td>
        </tr>
        <tr style="border-bottom: solid;border-width: 1px">
          <td colspan="4">&nbsp;</td>
          <td width="24" colspan="2"><div align="center"><strong>A</strong></div></td>
          <td width="38" colspan="2"><div align="center"><strong>B</strong></div></td>
          <td width="38" colspan="2"><div align="center"><strong>C</strong></div></td>
          <td width="38" colspan="2"><div align="center"><strong>D</strong></div></td>
          <td width="38" colspan="2"><div align="center"><strong>E</strong></div></td>
          <td width="38" colspan="2"><div align="center"><strong>F</strong></div></td>
          <td width="38" colspan="2"><div align="center"><strong>G</strong></div></td>
          <td width="38" colspan="2"><div align="center"><strong>H</strong></div></td>
          <td width="60" nowrap="nowrap" colspan="2"><div align="center"><font size="-3"><strong>ソリ・フレ</strong></font></div></td>
          <td width='60' nowrap='nowrap' colspan='2'><div align='center'><font size='-1'><strong>外観１</strong></font></div></td>
          <td width='60' nowrap='nowrap' colspan='2'><div align='center'><font size='-1'><strong>外観２</strong></font></div></td>
          <td width="51" nowrap="nowrap" colspan="2"><div align="center"><font size="-1"><strong>単重</strong></font></div></td>
        </tr>
        <tr style="border-bottom: solid;border-width: 1px">
          <td width="33" rowspan="3" nowrap="nowrap" colspan="2"><div align="center"><strong>規格</strong></div></td>
          <td width="45" nowrap="nowrap" colspan="2"><div align="center"><strong>上限</strong></div></td>

        <?php
            $upperArray = Array();
            for($i=1; $i<=8; $i++){
            echo '<td colspan="2"><div align="center">';
            echo '<input name=" upper_' . $i . '" type="text"  value="" size="6"/>';
            echo '</div></td>';
            }
            echo "<td colspan='2'>\n";
            echo "</td>\n";
            echo "<td colspan='2'>\n";
            echo "</td>\n";

        ?>

          <td colspan="2"><div align="center"></div></td>
          <td rowspan="3" colspan="2">&nbsp;</td>
        </tr>
        <tr style="border-bottom: solid;border-width: 1px">
          <td nowrap="nowrap" colspan="2"><div align="center"><strong>下限</strong></div></td>

        <?php
            $lowerArray = Array();
            for($i=1; $i<=8; $i++){
            echo '<td colspan="2"><div align="center">';
            echo '<input name=" lower_' . $i . '" type="text"  value="" size="6"/>';
            echo '</div></td>';
            }
            echo "<td colspan='2'>\n";
            echo "</td>\n";
            echo "<td colspan='2'>\n";
            echo "</td>\n";

        ?>

          <td colspan="2"><div align="center"></div></td>
        </tr>
        <tr style="border-bottom: solid;border-width: 1px">
          <td nowrap="nowrap" colspan="2"><div align="center"><strong>寸法</strong></div></td>

        <?php
            $sizeArray = Array();
            for($i=1; $i<=9; $i++){
            echo '<td colspan="2"><div align="center">';
            echo '<input name=" size_' . $i . '" type="text"  value="" size="6"/>';
            echo '</div></td>';
            }

                      $arrtext10 = [
                        '' => '',
                        '外観1' => '外観1'
                      ];
                      $arrtext11 = [
                        '' => '',
                        '外観2' => '外観2'
                      ];


            /*
            echo '<td colspan="2"><div align="center">';
            echo '<input name="text_10" type="text"  value="" size="6"/>';
            echo '</div></td>';
            echo '<td colspan="2"><div align="center">';
            echo '<input name="text_11" type="text"  value="" size="6"/>';
            echo '</div></td>';
*/
        ?>
        <td colspan="2"><div align="center"><?= $this->Form->input('text_10', ["type"=>"select", "options"=>$arrtext10, 'label'=>false]); ?></div></td>
        <td colspan="2"><div align="center"><?= $this->Form->input('text_11', ["type"=>"select", "options"=>$arrtext11, 'label'=>false]); ?></div></td>

        </tr>

        <td height="120" colspan="28" style="vertical-align: top; border-bottom: solid;border-width: 1px;text-align: left">
          <strong style="text-align: left">備考：</strong><br>
              <textarea name="bik"  cols="120" rows="10"></textarea>
          </td>
        </tr>
       <tr>
</table>
<table>
<td style="text-align: left">
  <strong>　*備考の欄内にはソリ・フレ値・外観の検査基準を外観の規格欄内の値と関連付けてください。</strong>
</td>
</table>

        <?php
            echo $this->Form->hidden('version' ,['value'=>0]);
            echo $this->Form->hidden('product_code' ,['value'=>$product_code]);
            echo $this->Form->hidden('status' ,['value'=>0]);
            echo $this->Form->hidden('delete_flag' ,['value'=>0]);
            echo $this->Form->hidden('updated_staff');
        ?>

    </fieldset>
    <center><?= $this->Form->submit(__('確認'), array('name' => 'kakunin')) ?></center>
    <?= $this->Form->end() ?>
    <br>
    <br>

<?php endif; ?>
