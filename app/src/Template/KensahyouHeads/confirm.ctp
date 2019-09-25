<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\Staff $staff
 */
 use Cake\ORM\TableRegistry;//独立したテーブルを扱う
$this->KensahyouHeads = TableRegistry::get('kensahyouHeads');//productsテーブルを使う
$this->Products = TableRegistry::get('products');//productsテーブルを使う
?>

<?= $this->Form->create($kensahyouHead, ['url' => ['action' => 'preadd']]) ?>
        <?php
            $username = $this->request->Session()->read('Auth.User.username');
            header('Expires:-1');
            header('Cache-Control:');
            header('Pragma:');

            echo $this->Form->hidden('product_id' ,['value'=>$_POST['product_id'] ]) ;
            echo $this->Form->hidden('version' ,['value'=>$_POST['version'] ]) ;
            echo $this->Form->hidden('type_im' ,['value'=>$_POST['type_im'] ]) ;
            echo $this->Form->hidden('maisu' ,['value'=>$_POST['maisu'] ]) ;

            $Array = Array();
            for($i=1; $i<=8; $i++){
              echo $this->Form->hidden("upper_$i" ,['value'=>$_POST["upper_$i"] ]) ;
              echo $this->Form->hidden("lower_$i" ,['value'=>$_POST["lower_$i"] ]) ;
              echo $this->Form->hidden("size_$i" ,['value'=>$_POST["size_$i"] ]) ;
            }

            echo $this->Form->hidden("size_9" ,['value'=>$_POST["size_9"] ]) ;
            echo $this->Form->hidden("bik" ,['value'=>$_POST["bik"] ]) ;
            echo $this->Form->hidden('status' ,['value'=>$_POST['status'] ]) ;
            echo $this->Form->hidden('delete_flag' ,['value'=>$_POST['delete_flag'] ]) ;
            echo $this->Form->hidden('created_staff' ,['value'=>$_POST['created_staff'] ]) ;
            echo $this->Form->hidden('updated_staff' ,['value'=>null ]) ;

            $_SESSION['sokuteidata'] = array(
              'product_id' => $_POST['product_id'],
              'version' => $_POST['version'],
              'type_im' => $_POST['type_im'],
              'maisu' => $_POST['maisu'],
              "upper_1" =>$_POST["upper_1"],
              "upper_2" =>$_POST["upper_2"],
              "upper_3" =>$_POST["upper_3"],
              "upper_4" =>$_POST["upper_4"],
              "upper_5" =>$_POST["upper_5"],
              "upper_6" =>$_POST["upper_6"],
              "upper_7" =>$_POST["upper_7"],
              "upper_8" =>$_POST["upper_8"],
              "lower_1" =>$_POST["lower_1"],
              "lower_2" =>$_POST["lower_2"],
              "lower_3" =>$_POST["lower_3"],
              "lower_4" =>$_POST["lower_4"],
              "lower_5" =>$_POST["lower_5"],
              "lower_6" =>$_POST["lower_6"],
              "lower_7" =>$_POST["lower_7"],
              "lower_8" =>$_POST["lower_8"],
              "size_1" =>$_POST["size_1"],
              "size_2" =>$_POST["size_2"],
              "size_3" =>$_POST["size_3"],
              "size_4" =>$_POST["size_4"],
              "size_5" =>$_POST["size_5"],
              "size_6" =>$_POST["size_6"],
              "size_7" =>$_POST["size_7"],
              "size_8" =>$_POST["size_8"],
              "size_9" =>$_POST["size_9"],
              "bik" =>$_POST["bik"],
              "status" =>$_POST["status"],
              "delete_flag" =>$_POST["delete_flag"],
            );

        ?>
              <p align="center"><?php echo $this->Html->image('ShinkiTourokuMenu/touroku.gif',array('width'=>'157','height'=>'50'));?></p>

<hr size="5">
<div align="center"><strong><font color="red">＊下記のように登録します</font></strong></div>
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
          <td colspan="8"><?= h($this->request->getData('type_im')) ?></td>
        </tr>
        <tr style="border-bottom: solid;border-width: 1px">
          <td colspan="4" nowrap="nowrap"><div align="center"><strong>枚数</strong></div></td>
          <td colspan="8"><?= h($this->request->getData('maisu')) ?></td>
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
            $Array = Array();
            for($j=1; $j<=8; $j++){
            echo '<td colspan="2"><div align="center">';
            echo $this->request->getData("upper_$j") ;
            echo '</div></td>';
            }
        ?>

          <td colspan="2"><div align="center"></div></td>
          <td rowspan="3" colspan="2">&nbsp;</td>
        </tr>
        <tr style="border-bottom: solid;border-width: 1px">
          <td nowrap="nowrap" colspan="2"><div align="center"><strong>下限</strong></div></td>

        <?php
            $Array = Array();
            for($k=1; $k<=8; $k++){
            echo '<td colspan="2"><div align="center">';
            echo $this->request->getData("lower_$k") ;
            echo '</div></td>';
            }
        ?>

          <td colspan="2"><div align="center"></div></td>
        </tr>
        <tr style="border-bottom: solid;border-width: 1px">
          <td nowrap="nowrap" colspan="2"><div align="center"><strong>寸法</strong></div></td>

        <?php
            $Array = Array();
            for($l=1; $l<=9; $l++){
            echo '<td colspan="2"><div align="center">';
            echo $this->request->getData("size_$l") ;
            echo '</div></td>';
            }
        ?>

        </tr>

          <td height="120" colspan="24" style="border-bottom: solid;border-width: 1px">
	      <strong>備考：</strong><br>
              <div cols="120" rows="10"><?= h($this->request->getData('bik')) ?></div>
          </td>
        </tr>
       <tr>
</table>

<br>
<br>
        <p align="center"><?= $this->Form->button('back', ['onclick' => 'history.back()', 'type' => 'button']) ?>
        <?= $this->Form->button(__('OK'), array('name' => 'touroku')) ?></p>
        <?= $this->Form->end() ?>
