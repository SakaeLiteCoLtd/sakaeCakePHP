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
        ?>

<?php if($KensaProduct == empty($arr)): ?>

    <?php foreach ($kensahyouHeads as $kensahyouHead): ?>

    <fieldset>
          <?php
          	$KensaProduct = $this->KensahyouHeads->find()->where(['product_id' => $product_id])->toArray();
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

          <?php
/*    <table align="center">/*編集テスト用
    <tr>
                <td class="actions">
                    <?= $this->Html->link(__('edit'), ['action' => 'edit', $kensahyouHead->id]) ?>
                </td>
　　</tr>
    </table>
*/          ?>

    <?php endforeach; ?>
<?=$this->Form->end() ?>

<?php else: ?>
    <?= $this->Form->create($kensahyouHead, ['url' => ['action' => 'confirm']]) ?>
    <fieldset>
<div align="center"><strong><font color="red">＊登録してください</font></strong></div>
<br>
    <table width="900" border="1" align="center" bordercolor="#000000" bgcolor="#FFFFFF" style="background-color: #FFFFFF">
        <tr style="border-bottom: solid;border-width: 1px">
          <td colspan="4" nowrap="nowrap"><div align="center"><strong>部品番号</strong></div></td>
          <td colspan="8" nowrap="nowrap"><?= h($Productcode) ?></td>
          <td colspan="4" nowrap="nowrap"><div align="center"><strong>部品名</strong></div></td>
          <td colspan="8" nowrap="nowrap"><?= h($Productname) ?></td>
        </tr>
        <tr style="border-bottom: solid;border-width: 1px">
          <td colspan="4" nowrap="nowrap"><div align="center"><strong>新規バージョン</strong></div></td>
          <td colspan="8"><?= h("1") ?></td>
          <td colspan="4" nowrap="nowrap"><div align="center"><strong>type_im</strong></div></td>
          <td colspan="8"><?= $this->Form->input("type_im", array('type' => 'value', 'label'=>false)); ?></td>
        </tr>
        <tr style="border-bottom: solid;border-width: 1px">
          <td colspan="4" nowrap="nowrap"><div align="center"><strong>枚数</strong></div></td>
          <td colspan="8"><?= $this->Form->input("maisu", array('type' => 'value', 'label'=>false)); ?></td>
          <td colspan="12" nowrap="nowrap">&nbsp;<input type="hidden" name="version" value="0"/></td>
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
        ?>

        </tr>
        
          <td height="120" colspan="24" style="border-bottom: solid;border-width: 1px">
	      <strong>備考：</strong><br>
              <textarea name="bik"  cols="120" rows="10"></textarea>
          </td>
        </tr>
       <tr>
</table>
<strong>　　*備考の欄内にはソリ・フレ値・外観の検査基準を外観の規格欄内の値と関連付けてください。</strong>

        <?php
            echo $this->Form->hidden('version' ,['value'=>0]);
            echo $this->Form->hidden('product_id' ,['value'=>$product_id]);
            echo $this->Form->hidden('status' ,['value'=>0]);
            echo $this->Form->hidden('delete_flag' ,['value'=>0]);
            echo $this->Form->hidden('created_staff', ['value'=>$staff_id]);
            echo $this->Form->hidden('updated_staff');
        ?>
    </fieldset>
    <center><?= $this->Form->button(__('confirm'), array('name' => 'kakunin')) ?></center>
    <?= $this->Form->end() ?>

<?php endif; ?>
