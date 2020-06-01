<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\Staff[]|\Cake\Collection\CollectionInterface $staffs
 */
use Cake\ORM\TableRegistry;//独立したテーブルを扱う

$this->Products = TableRegistry::get('products');//productsテーブルを使う
$this->Konpous = TableRegistry::get('konpous');//productsテーブルを使う

?>
        <?php
          $username = $this->request->Session()->read('Auth.User.username');

          header('Expires:-1');
          header('Cache-Control:');
          header('Pragma:');
          echo $this->Form->create($labelCsvs, ['url' => ['action' => 'kobetuform']]);
?>
<?php
 use App\myClass\Labelmenus\htmlLabelmenu;//myClassフォルダに配置したクラスを使用
 $htmlLabelmenu = new htmlLabelmenu();
 $htmlLabels = $htmlLabelmenu->Labelmenus();
 ?>
 <hr size="5" style="margin: 0.5rem">
 <table style="margin-bottom:0px" width="750" border="0" align="center" cellpadding="0" cellspacing="0" bordercolor="#CCCCCC">
 <?php
    echo $htmlLabels;
 ?>
 </table>
 <hr size="5" style="margin: 0.5rem">

<?php if(!isset($confirm) && !isset($touroku)): ?>

<br><br><br>

<table align="center" border="2" bordercolor="#E6FFFF" cellpadding="0" cellspacing="0">
  <tbody border="2" bordercolor="#E6FFFF" bgcolor="#FFFFCC" style="border-bottom: solid;border-width: 1px">
    <tr style="border-bottom: 0px;border-width: 0px">
      <td width="250" height="60" colspan="20" nowrap="nowrap"><div align="center"><strong style="font-size: 20pt; color:blue">品番</strong></div></td>
      <td width="400" colspan="40" nowrap="nowrap"><div align="center"><strong style="font-size: 15pt; color:blue">成形日</strong></div></td>
      <td width="150" colspan="20" nowrap="nowrap"><div align="center"><strong style="font-size: 10pt; color:blue">箱NO.</strong></div></td>
    </tr>

<?php
        echo "<tr style='border-bottom: 0px;border-width: 0px'>\n";
        echo "<td rowspan='2'  height='6' colspan='20' nowrap='nowrap'>\n";
        echo "<input type='text' name=product_code size='6'  autofocus/>\n";
        echo "</td>\n";
        ?>
        <td colspan="40" style="border-bottom: solid;border-width: 1px"><div align="center"><?= $this->Form->input("kobetudate", array('type' => 'date', 'monthNames' => false, 'label'=>false)); ?></div></td>
        <?php
        echo "<td rowspan='2'  height='6' colspan='20' nowrap='nowrap'>\n";
        echo "<input type='text' value=1  name=hakoNo size='6'/>\n";
        echo "</td>\n";
        echo "</tr>\n";
?>
<table align="right" border="2" bordercolor="#E6FFFF" cellpadding="0" cellspacing="0">
<tr bgcolor="#E6FFFF" >
  <td align="right" rowspan="2" width="30" bgcolor="#E6FFFF" style="border: none"><div align="center"><?= $this->Form->submit(__('確認'), array('name' => 'confirm', 'value'=>"1")); ?></div></td>
</tr>
</table>

<br><br><br>

<?php elseif(isset($confirm)): //確認押したとき ?>

<br><br><br>

<table align="center" border="2" bordercolor="#E6FFFF" cellpadding="0" cellspacing="0">
  <tbody border="2" bordercolor="#E6FFFF" bgcolor="#FFFFCC" style="border-bottom: solid;border-width: 1px">
    <tr style="border-bottom: 0px;border-width: 0px">
      <td width="250" height="60" colspan="20" nowrap="nowrap"><div align="center"><strong style="font-size: 20pt; color:blue">品番</strong></div></td>
      <td width="400" colspan="40" nowrap="nowrap"><div align="center"><strong style="font-size: 15pt; color:blue">成形日</strong></div></td>
      <td width="200" colspan="20" nowrap="nowrap"><div align="center"><strong style="font-size: 10pt; color:blue">箱NO.</strong></div></td>
    </tr>

    <?php
    $data = $this->request->getData();
    $datekobetu = $data['kobetudate']['year']."年".$data['kobetudate']['month']."月".$data['kobetudate']['day']."日";

            echo "<tr style='border-bottom: 0px;border-width: 0px'>\n";
            echo "<td rowspan='2'  height='6' colspan='20' nowrap='nowrap' style='font-size: 15pt'>\n";
            echo $product_code;
            echo "</td>\n";
            echo "<td colspan='40' nowrap='nowrap' style='font-size: 15pt'><div align='center'>\n";
            echo $datekobetu;
            echo "</div></td>\n";
            echo "<td rowspan='2'  height='6' colspan='20' nowrap='nowrap' style='font-size: 15pt'>\n";
            echo $data['hakoNo'];
            echo "</td>\n";
            echo "</tr>\n";
    ?>


 <?php
       $session = $this->request->getSession();
       $username = $this->request->Session()->read('Auth.User.username');
               $resultArray = Array();
                 $_SESSION['labeljunbi'] = array(
                   'product_code' => $product_code,
                   'kobetudate' => $_POST["kobetudate"],
                   'hakoNo' => $_POST["hakoNo"],
                   "present_kensahyou" => 0,
                 );
/*
   echo "<pre>";
   print_r($_SESSION['labeljunbi']);
   echo "</pre>";
*/
  ?>
 </table>
 <br>
 <table align="right" border="2" bordercolor="#E6FFFF" cellpadding="0" cellspacing="0">
 <tr>
   <td align="right" rowspan="2" width="50" bgcolor="#E6FFFF" style="border: none"><div align="center"><?= $this->Form->submit(__('csv登録'), array('name' => 'touroku', 'value'=>"1")); ?></div></td>
   <td style="border-style: none;"><div align="center"><?= $this->Form->submit('戻る', ['onclick' => 'history.back()', 'type' => 'button']); ?></div></td>
 </tr>
 </table>
<br>
  <fieldset>
    <?= $this->Form->control('formset', array('type'=>'hidden', 'value'=>"1", 'label'=>false)) ?>
  </fieldset>

<?php else: //csv押したとき ?>

  <br><br>

    <div align="center"><font color="red" size="4"><?= __($mes) ?></font></div>

  <br><br><br><br><br>

<?php endif; ?>
