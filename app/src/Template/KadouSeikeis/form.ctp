<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\Staff[]|\Cake\Collection\CollectionInterface $staffs
 */
use Cake\ORM\TableRegistry;//独立したテーブルを扱う

$this->Products = TableRegistry::get('products');//productsテーブルを使う
?>
        <?php
          $username = $this->request->Session()->read('Auth.User.username');

          header('Expires:-1');
          header('Cache-Control:');
          header('Pragma:');
          echo $this->Form->create($kadouSeikeis, ['url' => ['action' => 'form']]);
?>

<br>
<table align="center" border="2" bordercolor="#E6FFFF" cellpadding="0" cellspacing="0">
  <caption style="text-align: left">１号機</caption>
  <tbody border="2" bordercolor="#E6FFFF" bgcolor="#FFFFCC" style="border-bottom: solid;border-width: 1px">
    <tr style="border-bottom: 0px;border-width: 0px">
      <td width="250" height="60" colspan="20" nowrap="nowrap"><div align="center"><strong style="font-size: 20pt; color:blue">品番</strong></div></td>
      <td width="500" colspan="40" nowrap="nowrap"><div align="center"><strong style="font-size: 15pt; color:blue">成形時間</strong></div></td>
      <td width="250" colspan="20" nowrap="nowrap"><div align="center"><strong style="font-size: 10pt; color:blue">生産ショット数</strong></div></td>
      <td width="250" colspan="20" nowrap="nowrap"><div align="center"><strong style="font-size: 10pt; color:blue">成形サイクル</strong></div></td>
    </tr>

    <?php
/*    <tr style="border-bottom: 0px;border-width: 0px">
      <td rowspan="2"  height="6" colspan="20" nowrap="nowrap"><?= $this->Form->input("product_code{$tuika1}", array('type' => 'text', 'label'=>false)); ?></td>
      <td colspan="3" nowrap="nowrap" style="border-bottom: 0px"><div align="center"><strong style="font-size: 15pt; color:blue">開始</strong></div></td>
      <td colspan="37" nowrap="nowrap" style="border-bottom: 0px"><div align="center"><?= $this->Form->input("starting_tm{$tuika1}", array('type' => 'date', 'monthNames' => false, 'label'=>false)); ?></div></td>
      <td rowspan="2" colspan="20" nowrap="nowrap"><?= $this->Form->input("amount_shot{$tuika1}", array('type' => 'text', 'label'=>false)); ?></td>
      <td rowspan="2" colspan="20" nowrap="nowrap"><?= $this->Form->input("cycle_shot{$tuika1}", array('type' => 'text', 'label'=>false)); ?></td>
    </tr>
    <tr style="border-bottom:  0px;border-width: 0px">
      <td colspan="3" nowrap="nowrap"><div align="center"><strong style="font-size: 15pt; color:blue">終了</strong></div></td>
      <td colspan="37"><div align="center"><?= $this->Form->input("finishing_tm{$tuika1}", array('type' => 'date', 'monthNames' => false, 'label'=>false)); ?></div></td>
    </tr>
*/    ?>


<?php
for($i=1; $i<=$tuika1; $i++){
      echo "<tr style='border-bottom: 0px;border-width: 0px'>\n";
      echo "<td rowspan='2'  height='6' colspan='20' nowrap='nowrap'>\n";
      echo "<input type='text' name=product_code_".$i." size='6'/>\n";
      echo "</td>\n";
      echo "<td colspan='3' nowrap='nowrap' style='border-bottom: 0px'><div align='center'><strong style='font-size: 15pt; color:blue'>\n";
      echo "開始";
      echo "</strong></div></td>\n";
      echo "<td colspan='37' nowrap='nowrap' style='border-bottom: 0px'><div align='center'>\n";
      echo "<input type='datetime-local' value=$dateye name=starting_tm_".$i." size='6'/>\n";
      echo "</div></td>\n";
      echo "<td rowspan='2' colspan='20' nowrap='nowrap'>\n";
      echo "<input type='text' name=amount_shot_".$i." size='6'/>\n";
      echo "</td>\n";
      echo "<td rowspan='2'  height='6' colspan='20' nowrap='nowrap'>\n";
      echo "<input type='text' name=cycle_shot_".$i." size='6'/>\n";
      echo "</td>\n";
      echo "</tr>\n";
      echo "<tr style='border-bottom: 0px;border-width: 0px'>\n";
      echo "<td colspan='3' nowrap='nowrap'><div align='center'><strong style='font-size: 15pt; color:blue'>\n";
      echo "終了";
      echo "</strong></div></td>\n";
      echo "<td colspan='37'><div align='center'>\n";
      echo "<input type='datetime-local' value=$dateto name=finishing_tm_".$i." size='6'/>\n";
      echo "</div></td>\n";
      echo "</tr>\n";
  }
 ?>

  <tr bgcolor="#E6FFFF" >
    <td width="550" colspan="40" nowrap="nowrap" bgcolor="#E6FFFF" style="border: none"><div align="center"><strong style="font-size: 15pt; color:blue"></strong></div></td>
    <td width="550" colspan="50" nowrap="nowrap" bgcolor="#E6FFFF" style="border: none"><div align="center"><strong style="font-size: 15pt; color:blue"></strong></div></td>
    <td align="right" rowspan="2" width="50" bgcolor="#E6FFFF" style="border: none"><div align="right"><?= $this->Form->submit(__('追加'), array('name' => 'tuika11')); ?></div></td>
    <td align="right" rowspan="2" width="50" bgcolor="#E6FFFF" style="border: none"><div align="right"><?= $this->Form->submit(__('削除'), array('name' => 'sakujo11')); ?></div></td>
  </tr>
</table>


<br>
<table align="center" border="2" bordercolor="#E6FFFF" cellpadding="0" cellspacing="0">
  <caption style="text-align: left">２号機</caption>
  <tbody border="2" bordercolor="#E6FFFF" bgcolor="#FFFFCC" style="border-bottom: solid;border-width: 1px">
    <tr style="border-bottom: 0px;border-width: 0px">
      <td width="250" height="60" colspan="20" nowrap="nowrap"><div align="center"><strong style="font-size: 20pt; color:blue">品番</strong></div></td>
      <td width="500" colspan="40" nowrap="nowrap"><div align="center"><strong style="font-size: 15pt; color:blue">成形時間</strong></div></td>
      <td width="250" colspan="20" nowrap="nowrap"><div align="center"><strong style="font-size: 10pt; color:blue">生産ショット数</strong></div></td>
      <td width="250" colspan="20" nowrap="nowrap"><div align="center"><strong style="font-size: 10pt; color:blue">成形サイクル</strong></div></td>
    </tr>

    <?php
/*    <tr style="border-bottom: 0px;border-width: 0px">
      <td rowspan="2"  height="6" colspan="20" nowrap="nowrap"><?= $this->Form->input("product_code{$tuika1}", array('type' => 'text', 'label'=>false)); ?></td>
      <td colspan="3" nowrap="nowrap" style="border-bottom: 0px"><div align="center"><strong style="font-size: 15pt; color:blue">開始</strong></div></td>
      <td colspan="37" nowrap="nowrap" style="border-bottom: 0px"><div align="center"><?= $this->Form->input("starting_tm{$tuika1}", array('type' => 'date', 'monthNames' => false, 'label'=>false)); ?></div></td>
      <td rowspan="2" colspan="20" nowrap="nowrap"><?= $this->Form->input("amount_shot{$tuika1}", array('type' => 'text', 'label'=>false)); ?></td>
      <td rowspan="2" colspan="20" nowrap="nowrap"><?= $this->Form->input("cycle_shot{$tuika1}", array('type' => 'text', 'label'=>false)); ?></td>
    </tr>
    <tr style="border-bottom:  0px;border-width: 0px">
      <td colspan="3" nowrap="nowrap"><div align="center"><strong style="font-size: 15pt; color:blue">終了</strong></div></td>
      <td colspan="37"><div align="center"><?= $this->Form->input("finishing_tm{$tuika1}", array('type' => 'date', 'monthNames' => false, 'label'=>false)); ?></div></td>
    </tr>
*/    ?>


<?php
for($i=1; $i<=$tuika2; $i++){
      echo "<tr style='border-bottom: 0px;border-width: 0px'>\n";
      echo "<td rowspan='2'  height='6' colspan='20' nowrap='nowrap'>\n";
      echo "<input type='text' name=product_code_".$i." size='6'/>\n";
      echo "</td>\n";
      echo "<td colspan='3' nowrap='nowrap' style='border-bottom: 0px'><div align='center'><strong style='font-size: 15pt; color:blue'>\n";
      echo "開始";
      echo "</strong></div></td>\n";
      echo "<td colspan='37' nowrap='nowrap' style='border-bottom: 0px'><div align='center'>\n";
      echo "<input type='datetime-local' value=$dateye name=starting_tm_".$i." size='6'/>\n";
      echo "</div></td>\n";
      echo "<td rowspan='2' colspan='20' nowrap='nowrap'>\n";
      echo "<input type='text' name=amount_shot_".$i." size='6'/>\n";
      echo "</td>\n";
      echo "<td rowspan='2'  height='6' colspan='20' nowrap='nowrap'>\n";
      echo "<input type='text' name=cycle_shot_".$i." size='6'/>\n";
      echo "</td>\n";
      echo "</tr>\n";
      echo "<tr style='border-bottom: 0px;border-width: 0px'>\n";
      echo "<td colspan='3' nowrap='nowrap'><div align='center'><strong style='font-size: 15pt; color:blue'>\n";
      echo "終了";
      echo "</strong></div></td>\n";
      echo "<td colspan='37'><div align='center'>\n";
      echo "<input type='datetime-local' value=$dateto name=finishing_tm_".$i." size='6'/>\n";
      echo "</div></td>\n";
      echo "</tr>\n";
  }
 ?>

  <tr bgcolor="#E6FFFF" >
    <td width="550" colspan="40" nowrap="nowrap" bgcolor="#E6FFFF" style="border: none"><div align="center"><strong style="font-size: 15pt; color:blue"></strong></div></td>
    <td width="550" colspan="50" nowrap="nowrap" bgcolor="#E6FFFF" style="border: none"><div align="center"><strong style="font-size: 15pt; color:blue"></strong></div></td>
    <td align="right" rowspan="2" width="50" bgcolor="#E6FFFF" style="border: none"><div align="right"><?= $this->Form->submit(__('追加'), array('name' => 'tuika22')); ?></div></td>
    <td align="right" rowspan="2" width="50" bgcolor="#E6FFFF" style="border: none"><div align="right"><?= $this->Form->submit(__('削除'), array('name' => 'sakujo22')); ?></div></td>
  </tr>
</table>

<fieldset>
  <?= $this->Form->control('formset', array('type'=>'hidden', 'value'=>"1", 'label'=>false)) ?>
  <?= $this->Form->control('tuika1', array('type'=>'hidden', 'value'=>$tuika1, 'label'=>false)) ?>
  <?= $this->Form->control('tuika2', array('type'=>'hidden', 'value'=>$tuika2, 'label'=>false)) ?>
  <?= $this->Form->control('dateye', array('type'=>'hidden', 'value'=>$dateye, 'label'=>false)) ?>
  <?= $this->Form->control('dateto', array('type'=>'hidden', 'value'=>$dateto, 'label'=>false)) ?>
</fieldset>

<br>
<br>
<br>
