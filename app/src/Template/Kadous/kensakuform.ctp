<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\Staff[]|\Cake\Collection\CollectionInterface $staffs
 */
?>
        <?php
          $username = $this->request->Session()->read('Auth.User.username');

          header('Expires:-1');
          header('Cache-Control:');
          header('Pragma:');
?>

<?=$this->Form->create($KadouSeikeis, ['url' => ['action' => 'kensakuview']]) ?>
<?php
 use App\myClass\Kadous\htmlKadoumenu;//myClassフォルダに配置したクラスを使用
 $htmlKadoumenu = new htmlKadoumenu();
 $htmlKadoumenus = $htmlKadoumenu->Kadoumenus();
 ?>
 <hr size="5" style="margin: 0.5rem">
 <table style="margin-bottom:0px" width="750" border="0" align="center" cellpadding="0" cellspacing="0" bordercolor="#CCCCCC">
 <?php
    echo $htmlKadoumenus;
 ?>
 </table>
 <hr size="5" style="margin: 0.5rem">

<table align="center" border="2" bordercolor="#E6FFFF" cellpadding="0" cellspacing="0">
  <tbody border="2" bordercolor="#E6FFFF" bgcolor="#FFFFCC" style="border-bottom: solid;border-width: 1px">
    <tr style="border-bottom: 0px;border-width: 0px">
      <td width="250" height="40" colspan="20" nowrap="nowrap"><div align="center"><strong style="font-size: 15pt; color:blue">品番</strong></div></td>
      <td width="500" colspan="40" nowrap="nowrap"><div align="center"><strong style="font-size: 15pt; color:blue">成形時間</strong></div></td>
      <td width="250" height="40" colspan="20" nowrap="nowrap"><div align="center"><strong style="font-size: 13pt; color:blue">成型機</strong></div></td>
    </tr>


<?php
      $dateYMD = date('Y-m-d');
      $dateYMD1 = strtotime($dateYMD);
      $dayye = date('Y-m-d', strtotime('-1 day', $dateYMD1));

      echo "<tr style='border-bottom: 0px;border-width: 0px'>\n";
      echo "<td rowspan='2'  height='6' colspan='20'>\n";
      echo "<input type='text' name=product_code size='6'/>\n";
      echo "</td>\n";
      echo "<td width='50' colspan='3' style='border-bottom: 0px'><div align='center'><strong style='font-size: 15pt; color:blue'>\n";
      echo "開始";
      echo "</strong></div></td>\n";
  //    echo "<td width='350' colspan='37' style='border-bottom: 0px'><div align='center'>\n";
  //    echo "<input type='date' value=$dayye name=date_sta empty=Please select size='6'/>\n";
  //    echo "</div></td>\n";

  ?>
  <td width="350" colspan="37" style="border-bottom: 0px;border-width: 1px"><div align="center"><?= $this->Form->input("date_sta", array('type' => 'date', 'value' => $dayye, 'monthNames' => false, 'label'=>false)); ?></div></td>
  <?php

      echo "<td rowspan='2' height='6' colspan='20'>\n";
      echo "<input type='text' name=seikeiki size='6'/>\n";
      echo "</td>\n";
      echo "</tr>\n";
      echo "<tr style='border-bottom: 0px;border-width: 0px'>\n";
      echo "<td colspan='3'><div align='center'><strong style='font-size: 15pt; color:blue'>\n";
      echo "終了";
      echo "</strong></div></td>\n";
//      echo "<td colspan='37'><div align='center'>\n";
//      echo "<input type='date' value=$dateYMD name=date_fin size='6'/>\n";
//      echo "</div></td>\n";

?>
<td colspan="37" style="border-bottom: solid;border-width: 1px"><div align="center"><?= $this->Form->input("date_fin", array('type' => 'date', 'value' => $dateYMD, 'monthNames' => false, 'label'=>false)); ?></div></td>
<?php

      echo "</tr>\n";

 ?>
<br>
  <tr bgcolor="#E6FFFF" >
    <td width="100" colspan="30" nowrap="nowrap" bgcolor="#E6FFFF" style="border: none"><div align="center"><strong style="font-size: 15pt; color:blue"></strong></div></td>
    <td width="100" colspan="30" nowrap="nowrap" bgcolor="#E6FFFF" style="border: none"><div align="center"><strong style="font-size: 15pt; color:blue"></strong></div></td>
    <td align="right" rowspan="2"  colspan="20" width="250" bgcolor="#E6FFFF" style="border: none"><div align="right"><?= $this->Form->submit(__('検索'), array('name' => 'kensaku')); ?></div></td>
  </tr>
</table>
</fieldset>

<?=$this->Form->end() ?>
