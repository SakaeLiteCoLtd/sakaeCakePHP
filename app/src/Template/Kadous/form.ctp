<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\Staff[]|\Cake\Collection\CollectionInterface $staffs
 */
use Cake\ORM\TableRegistry;//独立したテーブルを扱う

//$this->KariKadouSeikeis = TableRegistry::get('kariKadouSeikeis');

?>
        <?php
          $username = $this->request->Session()->read('Auth.User.username');

          header('Expires:-1');
          header('Cache-Control:');
          header('Pragma:');
          echo $this->Form->create($KadouSeikeis, ['url' => ['action' => 'confirm']]);
?>


  <?php for ($i=1;$i<$n1+1;$i++): ?>
    <?php foreach (${"arrP".$i} as ${"arrP".$i}): ?>
    <?php endforeach; ?>
  <?php endfor;?>

<?php   /*ここから１号機*/    ?>

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
for($i=1; $i<=$n1; $i++){//１号機
  ${"product_code1_".$i} = ${"arrP".$i}['product_code'];
  ${"hyoujistarting_tm1_".$i} = substr(${"arrP".$i}['starting_tm'], 0, 10)."T".substr(${"arrP".$i}['starting_tm'], 11, 5);
  ${"hyoujifinishing_tm1_".$i} = substr(${"arrP".$i}['finishing_tm'], 0, 10)."T".substr(${"arrP".$i}['finishing_tm'], 11, 5);
  ${"cycle_shot1_".$i} = ${"arrP".$i}['cycle_shot'];
  ${"amount_shot1_".$i} = ${"arrP".$i}['amount_shot'];

      echo "<tr style='border-bottom: 0px;border-width: 0px'>\n";
      echo "<td rowspan='2'  height='6' colspan='20' nowrap='nowrap'>\n";
      echo "<input type='text' value=${"product_code1_".$i} name=product_code1_".$i." size='6'/>\n";
      echo "</td>\n";
      echo "<td colspan='3' nowrap='nowrap' style='border-bottom: 0px'><div align='center'><strong style='font-size: 15pt; color:blue'>\n";
      echo "開始";
      echo "</strong></div></td>\n";
      echo "<td colspan='37' nowrap='nowrap' style='border-bottom: 0px'><div align='center'>\n";
      echo "<input type='datetime-local' value=${"hyoujistarting_tm1_".$i} name=starting_tm1_".$i." size='6'/>\n";
      echo "</div></td>\n";
      echo "<td rowspan='2' colspan='20' nowrap='nowrap'>\n";
      echo "<input type='text' value=${"cycle_shot1_".$i}  name=amount_shot1_".$i." size='6'/>\n";
      echo "</td>\n";
      echo "<td rowspan='2'  height='6' colspan='20' nowrap='nowrap'>\n";
      echo "<input type='text' value=${"amount_shot1_".$i}  name=cycle_shot1_".$i." size='6'/>\n";
      echo "</td>\n";
      echo "</tr>\n";
      echo "<tr style='border-bottom: 0px;border-width: 0px'>\n";
      echo "<td colspan='3' nowrap='nowrap'><div align='center'><strong style='font-size: 15pt; color:blue'>\n";
      echo "終了";
      echo "</strong></div></td>\n";
      echo "<td colspan='37'><div align='center'>\n";
      echo "<input type='datetime-local' value=${"hyoujifinishing_tm1_".$i} name=finishing_tm1_".$i." size='6'/>\n";
      echo "</div></td>\n";
      echo "</tr>\n";

      echo "<input type='hidden' value=${"hyoujifinishing_tm1_".$i}  name=test".$i." size='6'/>\n";
      echo "<input type='hidden' value=${"hyoujifinishing_tm1_".$i}  name=test".$i." size='6'/>\n";
      echo "<input type='hidden' value=${"hyoujifinishing_tm1_".$i}  name=test".$i." size='6'/>\n";
      echo "<input type='hidden' value=${"hyoujifinishing_tm1_".$i}  name=test".$i." size='6'/>\n";
      echo "<input type='hidden' value=${"hyoujifinishing_tm1_".$i}  name=test".$i." size='6'/>\n";

  }
 ?>


</table>
<br>
<br>

<p align="center"><?= $this->Form->button(__('確認'), array('name' => 'confirm', 'value'=>"1")) ?></p>


<br>
