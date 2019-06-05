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
            $options2 = [
	            '0' => 'edit this data　',
	            '1' => 'delete this data' 
                    ];

        	$Product = $this->Products->find()->where(['id' => $product_id])->toArray();
        	$Productcode = $Product[0]->product_code;
        	$this->set('Productcode',$Productcode);
        ?>

    <?= $this->Form->create($kensahyouHead) ?>
    <fieldset>
<table align="center" border="2" bordercolor="#E6FFFF" cellpadding="0" cellspacing="0">
        <tbody border="2" bordercolor="#E6FFFF" bgcolor="#FFFFCC">
            <th scope="row"><?= __('type_im') ?></th>
		<td><?= $this->Form->input("type_im", array('type' => 'value', 'label'=>false)); ?></td>
	</tr>
        <tbody border="2" bordercolor="#E6FFFF" bgcolor="#FFFFCC">
            <th scope="row"><?= __('maisu') ?></th>
		<td><?= $this->Form->input("maisu", array('type' => 'value', 'label'=>false)); ?></td>
	</tr>

</table>

    <table width="650" border="1" align="center" bordercolor="#000000" bgcolor="#FFFFFF">
        <tr>
          <td colspan="2" nowrap="nowrap"><div align="right"><strong>部品番号</strong></div></td>
          <td colspan="7" nowrap="nowrap"><?= h($product_id) ?></td>
        </tr>
        <tr>
          <td colspan="2" nowrap="nowrap"><div align="right"><strong>新規バージョン</strong></div></td>
          <td colspan="5"><?= $this->Form->input("version", array('type' => 'value', 'label'=>false)); ?></td>
        </tr>
        <tr>
          <td colspan="2">&nbsp;</td>
          <td width="24"><div align="center"><strong>A</strong></div></td>
          <td width="38"><div align="center"><strong>B</strong></div></td>
          <td width="38"><div align="center"><strong>C</strong></div></td>
          <td width="38"><div align="center"><strong>D</strong></div></td>
          <td width="38"><div align="center"><strong>E</strong></div></td>
          <td width="38"><div align="center"><strong>F</strong></div></td>
          <td width="38"><div align="center"><strong>G</strong></div></td>
          <td width="38"><div align="center"><strong>H</strong></div></td>
          <td width="60" nowrap="nowrap"><div align="center"><font size="-3"><strong>ソリ・フレ</strong></font></div></td>
          <td width="51" nowrap="nowrap"><div align="center"><font size="-1"><strong>単重</strong></font></div></td>
        </tr>
        <tr>
          <td width="33" rowspan="3" nowrap="nowrap"><div align="center"><strong>規格</strong></div></td>
          <td width="45" nowrap="nowrap"><div align="center"><strong>上限</strong></div></td>
          <td>      <div align="center">
            <input type="text" name="upper_1" value="" size="6"/>    
          </div></td>
          <td>      <div align="center">
            <input type="text" name="upper_2"   value="" size="6"/>    
          </div></td>
          <td>      <div align="center">
            <input type="text" name="upper_3"   value="" size="6"/>    
          </div></td>
          <td>      <div align="center">
            <input type="text" name="upper_4"   value="" size="6"/>    
          </div></td>
          <td>      <div align="center">
            <input type="text" name="upper_5"   value="" size="6"/>    
          </div></td>
          <td>      <div align="center">
            <input type="text" name="upper_6"   value="" size="6"/>    
          </div></td>
          <td>      <div align="center">
            <input type="text" name="upper_7"   value="" size="6"/>    
          </div></td>
          <td>      <div align="center">
            <input type="text" name="upper_8"   value="" size="6"/>    
          </div></td>
          <td><div align="center"></div></td>
          <td rowspan="3">&nbsp;</td>
        </tr>
        <tr>
          <td nowrap="nowrap"><div align="center"><strong>下限</strong></div></td>
          <td>      <div align="center">
            <input type="text" name="lower_1"   value="" size="6"/>    
          </div></td>
          <td>      <div align="center">
            <input type="text" name="lower_2"   value="" size="6"/>    
          </div></td>
          <td>      <div align="center">
            <input type="text" name="lower_3"   value="" size="6"/>    
          </div></td>
          <td>      <div align="center">
            <input type="text" name="lower_4"   value="" size="6"/>    
          </div></td>
          <td>      <div align="center">
            <input type="text" name="lower_5"   value="" size="6"/>    
          </div></td>
          <td>      <div align="center">
            <input type="text" name="lower_6"   value="" size="6"/>    
          </div></td>
          <td>      <div align="center">
            <input type="text" name="lower_7"   value="" size="6"/>    
          </div></td>
          <td>      <div align="center">
            <input type="text" name="lower_8"   value="" size="6"/>    
          </div></td>
          <td><div align="center"></div></td>
        </tr>
        <tr>
          <td nowrap="nowrap"><div align="center"><strong>寸法</strong></div></td>
          <td>      <div align="center">
            <input type="text" name="size_1"   value="" size="6"/>    
          </div></td>
          <td>      <div align="center">
            <input type="text" name="size_2"   value="" size="6"/>    
          </div></td>
          <td>      <div align="center">
            <input type="text" name="size_3"   value="" size="6"/>    
          </div></td>
          <td>      <div align="center">
            <input type="text" name="size_4"   value="" size="6"/>    
          </div></td>
          <td>      <div align="center">
            <input type="text" name="size_5"   value="" size="6"/>    
          </div></td>
          <td>      <div align="center">
            <input type="text" name="size_6"   value="" size="6"/>    
          </div></td>
          <td>      <div align="center">
            <input type="text" name="size_7"   value="" size="6"/>    
          </div></td>
          <td>      <div align="center">
            <input type="text" name="size_8"   value="" size="6"/>    
          </div></td>
          <td>      <div align="center">
            <input type="text" name="size_9"  value="" size="6"/>    
          </div></td>
        </tr>
        <tr>
          <td height="120" colspan="14">
	      <strong>備考：</strong><br>
              <textarea name="bik"  cols="120" rows="10"></textarea>
          </td>
        </tr>
       <tr>
</table>
<strong>*備考の欄内にはソリ・フレ値・外観の検査基準を外観の規格欄内の値と関連付けてください。</strong>

        <?php
            echo $this->Form->hidden('status');
//            echo $this->Form->hidden('delete_flag');
            echo $this->Form->hidden('created_staff', ['empty' => true]);
            echo $this->Form->hidden('updated_staff');
        ?>
    </fieldset>
    <center><?= $this->Form->button(__('confirm'), array('name' => 'kakunin')) ?></center>
    <?= $this->Form->end() ?>

