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
<?= $this->Form->create($kensahyouHead, ['url' => ['controller'=>'SyukkaKensas','action' => 'index2']]) ?>

<?php
          $username = $this->request->Session()->read('Auth.User.username');
?>
<br>
              <p align="center"><?php echo $this->Html->image('ShinkiTourokuMenu/touroku.gif',array('width'=>'157','height'=>'50'));?></p>

<hr size="5">
<div align="center"><strong><font color="red">＊下記のように登録されました</font></strong></div>
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
          <td colspan="9"><?= h("1") ?></td>
          <td colspan="5" nowrap="nowrap"><div align="center"><strong>type_im</strong></div></td>
          <td colspan="9"><?= h($_SESSION['sokuteidata']["type_im"]) ?></td>
        </tr>
        <tr style="border-bottom: solid;border-width: 1px">
          <td colspan="5" nowrap="nowrap"><div align="center"><strong>枚数</strong></div></td>
          <td colspan="9"><?= h($_SESSION['sokuteidata']["maisu"]) ?></td>
          <td colspan="14" nowrap="nowrap">&nbsp;<input type="hidden" name="version" value="0"/></td>
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
            $Array = Array();
            for($i=1; $i<=8; $i++){
            echo '<td colspan="2"><div align="center">';
            echo $_SESSION['sokuteidata']["upper_{$i}"] ;
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
            $Array = Array();
            for($j=1; $j<=8; $j++){
            echo '<td colspan="2"><div align="center">';
            echo $_SESSION['sokuteidata']["lower_{$j}"] ;
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
            $Array = Array();
            for($k=1; $k<=9; $k++){
            echo '<td colspan="2"><div align="center">';
            echo $_SESSION['sokuteidata']["size_{$k}"] ;
            echo '</div></td>';
            }
            echo '<td colspan="2"><div align="center">';
            echo $_SESSION['sokuteidata']["text_10"] ;
            echo '</div></td>';
            echo '<td colspan="2"><div align="center">';
            echo $_SESSION['sokuteidata']["text_11"] ;
            echo '</div></td>';

        ?>

        </tr>

        <td height="120" colspan="28" style="vertical-align: top; border-bottom: solid;border-width: 1px;text-align: left">
          <strong style="text-align: left">備考：</strong><br>
              <div cols="120" rows="10"><?= h($_SESSION['sokuteidata']['bik']) ?></div>
          </td>
        </tr>
       <tr>
</table>
<br>
<table align="center" border="2" bordercolor="#E6FFFF" cellpadding="0" cellspacing="0">
<tr>
  <td style="border-style: none;"><div align="center"><?= $this->Form->submit(__('トップ'), array('name' => 'top')); ?></div></td>
</tr>
</table>
<br>
