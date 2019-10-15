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


<?php for ($j=1;$j<10;$j++): ?>
  <?php for ($i=1;$i<${"n".$j}+1;$i++): ?>
    <?php foreach (${"arrP".$j.$i} as ${"arrP".$j.$i}): ?>
    <?php endforeach; ?>
  <?php endfor;?>
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
$j = 1;
  for($i=1; $i<=${"n".$j}; $i++){//１号機
    ${"product_code".$i} = ${"arrP".$j.$i}['product_code'];
    ${"hyoujistarting_tm".$i} = substr(${"arrP".$j.$i}['starting_tm'], 0, 10)."T".substr(${"arrP".$j.$i}['starting_tm'], 11, 5);
    ${"hyoujifinishing_tm".$i} = substr(${"arrP".$j.$i}['finishing_tm'], 0, 10)."T".substr(${"arrP".$j.$i}['finishing_tm'], 11, 5);
    ${"cycle_shot".$i} = ${"arrP".$j.$i}['cycle_shot'];
    ${"amount_shot".$i} = ${"arrP".$j.$i}['amount_shot'];
    ${"accomp_rate".$i} = ${"arrP".$j.$i}['accomp_rate'];
    ${"id".$i} = ${"arrP".$j.$i}['id'];
    ${"seikeiki".$i} = ${"arrP".$j.$i}['seikeiki'];
    ${"seikeiki_code".$i} = ${"arrP".$j.$i}['seikeiki_code'];
    ${"present_kensahyou".$i} = ${"arrP".$j.$i}['present_kensahyou'];
    ${"created_at".$i} = ${"arrP".$j.$i}['created_at'];
    ${"created_staff".$i} = ${"arrP".$j.$i}['created_staff'];

      echo "<tr style='border-bottom: 0px;border-width: 0px'>\n";
      echo "<td rowspan='2'  height='6' colspan='20' nowrap='nowrap'>\n";
      echo "<input type='text' value=${"product_code".$i} name=product_code".$j.$i." size='6'/>\n";
      echo "</td>\n";
      echo "<td colspan='3' nowrap='nowrap' style='border-bottom: 0px'><div align='center'><strong style='font-size: 15pt; color:blue'>\n";
      echo "開始";
      echo "</strong></div></td>\n";
      echo "<td colspan='37' nowrap='nowrap' style='border-bottom: 0px'><div align='center'>\n";
      echo "<input type='datetime-local' value=${"hyoujistarting_tm".$i} name=starting_tm".$j.$i." size='6'/>\n";
      echo "</div></td>\n";
      echo "<td rowspan='2' colspan='20' nowrap='nowrap'>\n";
      echo "<input type='text' value=${"amount_shot".$i}  name=amount_shot".$j.$i." size='6'/>\n";
      echo "</td>\n";
      echo "<td rowspan='2'  height='6' colspan='20' nowrap='nowrap'>\n";
      echo "<input type='text' value=${"cycle_shot".$i}  name=cycle_shot".$j.$i." size='6'/>\n";
      echo "</td>\n";
      echo "</tr>\n";
      echo "<tr style='border-bottom: 0px;border-width: 0px'>\n";
      echo "<td colspan='3' nowrap='nowrap'><div align='center'><strong style='font-size: 15pt; color:blue'>\n";
      echo "終了";
      echo "</strong></div></td>\n";
      echo "<td colspan='37'><div align='center'>\n";
      echo "<input type='datetime-local' value=${"hyoujifinishing_tm".$i} name=finishing_tm".$j.$i." size='6'/>\n";
      echo "</div></td>\n";
      echo "</tr>\n";

      echo "<input type='hidden' value=${"id".$i}  name=id".$j.$i." size='6'/>\n";
      echo "<input type='hidden' value=${"seikeiki".$i}  name=seikeiki".$j.$i." size='6'/>\n";
      echo "<input type='hidden' value=${"seikeiki_code".$i}  name=seikeiki_code".$j.$i." size='6'/>\n";
      echo "<input type='hidden' value=${"accomp_rate".$i}  name=accomp_rate".$j.$i." size='6'/>\n";
      echo "<input type='hidden' value=${"seikeiki_code".$i}  name=seikeiki_code".$j.$i." size='6'/>\n";
      echo "<input type='hidden' value=${"present_kensahyou".$i}  name=present_kensahyou".$j.$i." size='6'/>\n";
      echo "<input type='hidden' value=${"created_at".$i}  name=created_at".$j.$i." size='6'/>\n";
      echo "<input type='hidden' value=${"created_staff".$i}  name=created_staff".$j.$i." size='6'/>\n";

    }
  echo $this->Form->hidden('n'.$j ,['value'=>${"n".$j}]);
 ?>
</table>
<br>
<?php   /*ここまで１号機*/    ?>
<?php   /*ここから２号機*/    ?>

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
$j = 2;
  for($i=1; $i<=${"n".$j}; $i++){//２号機
    ${"product_code".$i} = ${"arrP".$j.$i}['product_code'];
    ${"hyoujistarting_tm".$i} = substr(${"arrP".$j.$i}['starting_tm'], 0, 10)."T".substr(${"arrP".$j.$i}['starting_tm'], 11, 5);
    ${"hyoujifinishing_tm".$i} = substr(${"arrP".$j.$i}['finishing_tm'], 0, 10)."T".substr(${"arrP".$j.$i}['finishing_tm'], 11, 5);
    ${"cycle_shot".$i} = ${"arrP".$j.$i}['cycle_shot'];
    ${"amount_shot".$i} = ${"arrP".$j.$i}['amount_shot'];
    ${"accomp_rate".$i} = ${"arrP".$j.$i}['accomp_rate'];
    ${"id".$i} = ${"arrP".$j.$i}['id'];
    ${"seikeiki".$i} = ${"arrP".$j.$i}['seikeiki'];
    ${"seikeiki_code".$i} = ${"arrP".$j.$i}['seikeiki_code'];
    ${"present_kensahyou".$i} = ${"arrP".$j.$i}['present_kensahyou'];
    ${"created_at".$i} = ${"arrP".$j.$i}['created_at'];
    ${"created_staff".$i} = ${"arrP".$j.$i}['created_staff'];

      echo "<tr style='border-bottom: 0px;border-width: 0px'>\n";
      echo "<td rowspan='2'  height='6' colspan='20' nowrap='nowrap'>\n";
      echo "<input type='text' value=${"product_code".$i} name=product_code".$j.$i." size='6'/>\n";
      echo "</td>\n";
      echo "<td colspan='3' nowrap='nowrap' style='border-bottom: 0px'><div align='center'><strong style='font-size: 15pt; color:blue'>\n";
      echo "開始";
      echo "</strong></div></td>\n";
      echo "<td colspan='37' nowrap='nowrap' style='border-bottom: 0px'><div align='center'>\n";
      echo "<input type='datetime-local' value=${"hyoujistarting_tm".$i} name=starting_tm".$j.$i." size='6'/>\n";
      echo "</div></td>\n";
      echo "<td rowspan='2' colspan='20' nowrap='nowrap'>\n";
      echo "<input type='text' value=${"amount_shot".$i}  name=amount_shot".$j.$i." size='6'/>\n";
      echo "</td>\n";
      echo "<td rowspan='2'  height='6' colspan='20' nowrap='nowrap'>\n";
      echo "<input type='text' value=${"cycle_shot".$i}  name=cycle_shot".$j.$i." size='6'/>\n";
      echo "</td>\n";
      echo "</tr>\n";
      echo "<tr style='border-bottom: 0px;border-width: 0px'>\n";
      echo "<td colspan='3' nowrap='nowrap'><div align='center'><strong style='font-size: 15pt; color:blue'>\n";
      echo "終了";
      echo "</strong></div></td>\n";
      echo "<td colspan='37'><div align='center'>\n";
      echo "<input type='datetime-local' value=${"hyoujifinishing_tm".$i} name=finishing_tm".$j.$i." size='6'/>\n";
      echo "</div></td>\n";
      echo "</tr>\n";

      echo "<input type='hidden' value=${"id".$i}  name=id".$j.$i." size='6'/>\n";
      echo "<input type='hidden' value=${"seikeiki".$i}  name=seikeiki".$j.$i." size='6'/>\n";
      echo "<input type='hidden' value=${"seikeiki_code".$i}  name=seikeiki_code".$j.$i." size='6'/>\n";
      echo "<input type='hidden' value=${"accomp_rate".$i}  name=accomp_rate".$j.$i." size='6'/>\n";
      echo "<input type='hidden' value=${"seikeiki_code".$i}  name=seikeiki_code".$j.$i." size='6'/>\n";
      echo "<input type='hidden' value=${"present_kensahyou".$i}  name=present_kensahyou".$j.$i." size='6'/>\n";
      echo "<input type='hidden' value=${"created_at".$i}  name=created_at".$j.$i." size='6'/>\n";
      echo "<input type='hidden' value=${"created_staff".$i}  name=created_staff".$j.$i." size='6'/>\n";

    }
  echo $this->Form->hidden('n'.$j ,['value'=>${"n".$j}]);
 ?>
</table>
<br>
<?php   /*ここまで２号機*/    ?>
<?php   /*ここから３号機*/    ?>
<br>
<table align="center" border="2" bordercolor="#E6FFFF" cellpadding="0" cellspacing="0">
  <caption style="text-align: left">３号機</caption>
  <tbody border="2" bordercolor="#E6FFFF" bgcolor="#FFFFCC" style="border-bottom: solid;border-width: 1px">
    <tr style="border-bottom: 0px;border-width: 0px">
      <td width="250" height="60" colspan="20" nowrap="nowrap"><div align="center"><strong style="font-size: 20pt; color:blue">品番</strong></div></td>
      <td width="500" colspan="40" nowrap="nowrap"><div align="center"><strong style="font-size: 15pt; color:blue">成形時間</strong></div></td>
      <td width="250" colspan="20" nowrap="nowrap"><div align="center"><strong style="font-size: 10pt; color:blue">生産ショット数</strong></div></td>
      <td width="250" colspan="20" nowrap="nowrap"><div align="center"><strong style="font-size: 10pt; color:blue">成形サイクル</strong></div></td>
    </tr>


<?php
$j = 3;
  for($i=1; $i<=${"n".$j}; $i++){
    ${"product_code".$i} = ${"arrP".$j.$i}['product_code'];
    ${"hyoujistarting_tm".$i} = substr(${"arrP".$j.$i}['starting_tm'], 0, 10)."T".substr(${"arrP".$j.$i}['starting_tm'], 11, 5);
    ${"hyoujifinishing_tm".$i} = substr(${"arrP".$j.$i}['finishing_tm'], 0, 10)."T".substr(${"arrP".$j.$i}['finishing_tm'], 11, 5);
    ${"cycle_shot".$i} = ${"arrP".$j.$i}['cycle_shot'];
    ${"amount_shot".$i} = ${"arrP".$j.$i}['amount_shot'];
    ${"accomp_rate".$i} = ${"arrP".$j.$i}['accomp_rate'];
    ${"id".$i} = ${"arrP".$j.$i}['id'];
    ${"seikeiki".$i} = ${"arrP".$j.$i}['seikeiki'];
    ${"seikeiki_code".$i} = ${"arrP".$j.$i}['seikeiki_code'];
    ${"present_kensahyou".$i} = ${"arrP".$j.$i}['present_kensahyou'];
    ${"created_at".$i} = ${"arrP".$j.$i}['created_at'];
    ${"created_staff".$i} = ${"arrP".$j.$i}['created_staff'];

      echo "<tr style='border-bottom: 0px;border-width: 0px'>\n";
      echo "<td rowspan='2'  height='6' colspan='20' nowrap='nowrap'>\n";
      echo "<input type='text' value=${"product_code".$i} name=product_code".$j.$i." size='6'/>\n";
      echo "</td>\n";
      echo "<td colspan='3' nowrap='nowrap' style='border-bottom: 0px'><div align='center'><strong style='font-size: 15pt; color:blue'>\n";
      echo "開始";
      echo "</strong></div></td>\n";
      echo "<td colspan='37' nowrap='nowrap' style='border-bottom: 0px'><div align='center'>\n";
      echo "<input type='datetime-local' value=${"hyoujistarting_tm".$i} name=starting_tm".$j.$i." size='6'/>\n";
      echo "</div></td>\n";
      echo "<td rowspan='2' colspan='20' nowrap='nowrap'>\n";
      echo "<input type='text' value=${"amount_shot".$i}  name=amount_shot".$j.$i." size='6'/>\n";
      echo "</td>\n";
      echo "<td rowspan='2'  height='6' colspan='20' nowrap='nowrap'>\n";
      echo "<input type='text' value=${"cycle_shot".$i}  name=cycle_shot".$j.$i." size='6'/>\n";
      echo "</td>\n";
      echo "</tr>\n";
      echo "<tr style='border-bottom: 0px;border-width: 0px'>\n";
      echo "<td colspan='3' nowrap='nowrap'><div align='center'><strong style='font-size: 15pt; color:blue'>\n";
      echo "終了";
      echo "</strong></div></td>\n";
      echo "<td colspan='37'><div align='center'>\n";
      echo "<input type='datetime-local' value=${"hyoujifinishing_tm".$i} name=finishing_tm".$j.$i." size='6'/>\n";
      echo "</div></td>\n";
      echo "</tr>\n";

      echo "<input type='hidden' value=${"id".$i}  name=id".$j.$i." size='6'/>\n";
      echo "<input type='hidden' value=${"seikeiki".$i}  name=seikeiki".$j.$i." size='6'/>\n";
      echo "<input type='hidden' value=${"seikeiki_code".$i}  name=seikeiki_code".$j.$i." size='6'/>\n";
      echo "<input type='hidden' value=${"accomp_rate".$i}  name=accomp_rate".$j.$i." size='6'/>\n";
      echo "<input type='hidden' value=${"seikeiki_code".$i}  name=seikeiki_code".$j.$i." size='6'/>\n";
      echo "<input type='hidden' value=${"present_kensahyou".$i}  name=present_kensahyou".$j.$i." size='6'/>\n";
      echo "<input type='hidden' value=${"created_at".$i}  name=created_at".$j.$i." size='6'/>\n";
      echo "<input type='hidden' value=${"created_staff".$i}  name=created_staff".$j.$i." size='6'/>\n";

    }
  echo $this->Form->hidden('n'.$j ,['value'=>${"n".$j}]);
 ?>
</table>
<br>
<?php   /*ここまで３号機*/    ?>
<?php   /*ここから４号機*/    ?>
<br>
<table align="center" border="2" bordercolor="#E6FFFF" cellpadding="0" cellspacing="0">
  <caption style="text-align: left">４号機</caption>
  <tbody border="2" bordercolor="#E6FFFF" bgcolor="#FFFFCC" style="border-bottom: solid;border-width: 1px">
    <tr style="border-bottom: 0px;border-width: 0px">
      <td width="250" height="60" colspan="20" nowrap="nowrap"><div align="center"><strong style="font-size: 20pt; color:blue">品番</strong></div></td>
      <td width="500" colspan="40" nowrap="nowrap"><div align="center"><strong style="font-size: 15pt; color:blue">成形時間</strong></div></td>
      <td width="250" colspan="20" nowrap="nowrap"><div align="center"><strong style="font-size: 10pt; color:blue">生産ショット数</strong></div></td>
      <td width="250" colspan="20" nowrap="nowrap"><div align="center"><strong style="font-size: 10pt; color:blue">成形サイクル</strong></div></td>
    </tr>


<?php
$j = 4;
  for($i=1; $i<=${"n".$j}; $i++){
    ${"product_code".$i} = ${"arrP".$j.$i}['product_code'];
    ${"hyoujistarting_tm".$i} = substr(${"arrP".$j.$i}['starting_tm'], 0, 10)."T".substr(${"arrP".$j.$i}['starting_tm'], 11, 5);
    ${"hyoujifinishing_tm".$i} = substr(${"arrP".$j.$i}['finishing_tm'], 0, 10)."T".substr(${"arrP".$j.$i}['finishing_tm'], 11, 5);
    ${"cycle_shot".$i} = ${"arrP".$j.$i}['cycle_shot'];
    ${"amount_shot".$i} = ${"arrP".$j.$i}['amount_shot'];
    ${"accomp_rate".$i} = ${"arrP".$j.$i}['accomp_rate'];
    ${"id".$i} = ${"arrP".$j.$i}['id'];
    ${"seikeiki".$i} = ${"arrP".$j.$i}['seikeiki'];
    ${"seikeiki_code".$i} = ${"arrP".$j.$i}['seikeiki_code'];
    ${"present_kensahyou".$i} = ${"arrP".$j.$i}['present_kensahyou'];
    ${"created_at".$i} = ${"arrP".$j.$i}['created_at'];
    ${"created_staff".$i} = ${"arrP".$j.$i}['created_staff'];

      echo "<tr style='border-bottom: 0px;border-width: 0px'>\n";
      echo "<td rowspan='2'  height='6' colspan='20' nowrap='nowrap'>\n";
      echo "<input type='text' value=${"product_code".$i} name=product_code".$j.$i." size='6'/>\n";
      echo "</td>\n";
      echo "<td colspan='3' nowrap='nowrap' style='border-bottom: 0px'><div align='center'><strong style='font-size: 15pt; color:blue'>\n";
      echo "開始";
      echo "</strong></div></td>\n";
      echo "<td colspan='37' nowrap='nowrap' style='border-bottom: 0px'><div align='center'>\n";
      echo "<input type='datetime-local' value=${"hyoujistarting_tm".$i} name=starting_tm".$j.$i." size='6'/>\n";
      echo "</div></td>\n";
      echo "<td rowspan='2' colspan='20' nowrap='nowrap'>\n";
      echo "<input type='text' value=${"amount_shot".$i}  name=amount_shot".$j.$i." size='6'/>\n";
      echo "</td>\n";
      echo "<td rowspan='2'  height='6' colspan='20' nowrap='nowrap'>\n";
      echo "<input type='text' value=${"cycle_shot".$i}  name=cycle_shot".$j.$i." size='6'/>\n";
      echo "</td>\n";
      echo "</tr>\n";
      echo "<tr style='border-bottom: 0px;border-width: 0px'>\n";
      echo "<td colspan='3' nowrap='nowrap'><div align='center'><strong style='font-size: 15pt; color:blue'>\n";
      echo "終了";
      echo "</strong></div></td>\n";
      echo "<td colspan='37'><div align='center'>\n";
      echo "<input type='datetime-local' value=${"hyoujifinishing_tm".$i} name=finishing_tm".$j.$i." size='6'/>\n";
      echo "</div></td>\n";
      echo "</tr>\n";

      echo "<input type='hidden' value=${"id".$i}  name=id".$j.$i." size='6'/>\n";
      echo "<input type='hidden' value=${"seikeiki".$i}  name=seikeiki".$j.$i." size='6'/>\n";
      echo "<input type='hidden' value=${"seikeiki_code".$i}  name=seikeiki_code".$j.$i." size='6'/>\n";
      echo "<input type='hidden' value=${"accomp_rate".$i}  name=accomp_rate".$j.$i." size='6'/>\n";
      echo "<input type='hidden' value=${"seikeiki_code".$i}  name=seikeiki_code".$j.$i." size='6'/>\n";
      echo "<input type='hidden' value=${"present_kensahyou".$i}  name=present_kensahyou".$j.$i." size='6'/>\n";
      echo "<input type='hidden' value=${"created_at".$i}  name=created_at".$j.$i." size='6'/>\n";
      echo "<input type='hidden' value=${"created_staff".$i}  name=created_staff".$j.$i." size='6'/>\n";

    }
  echo $this->Form->hidden('n'.$j ,['value'=>${"n".$j}]);
 ?>
</table>
<br>
<?php   /*ここまで４号機*/    ?>
<?php   /*ここから５号機*/    ?>
<br>
<table align="center" border="2" bordercolor="#E6FFFF" cellpadding="0" cellspacing="0">
  <caption style="text-align: left">５号機</caption>
  <tbody border="2" bordercolor="#E6FFFF" bgcolor="#FFFFCC" style="border-bottom: solid;border-width: 1px">
    <tr style="border-bottom: 0px;border-width: 0px">
      <td width="250" height="60" colspan="20" nowrap="nowrap"><div align="center"><strong style="font-size: 20pt; color:blue">品番</strong></div></td>
      <td width="500" colspan="40" nowrap="nowrap"><div align="center"><strong style="font-size: 15pt; color:blue">成形時間</strong></div></td>
      <td width="250" colspan="20" nowrap="nowrap"><div align="center"><strong style="font-size: 10pt; color:blue">生産ショット数</strong></div></td>
      <td width="250" colspan="20" nowrap="nowrap"><div align="center"><strong style="font-size: 10pt; color:blue">成形サイクル</strong></div></td>
    </tr>


<?php
$j = 5;
  for($i=1; $i<=${"n".$j}; $i++){
    ${"product_code".$i} = ${"arrP".$j.$i}['product_code'];
    ${"hyoujistarting_tm".$i} = substr(${"arrP".$j.$i}['starting_tm'], 0, 10)."T".substr(${"arrP".$j.$i}['starting_tm'], 11, 5);
    ${"hyoujifinishing_tm".$i} = substr(${"arrP".$j.$i}['finishing_tm'], 0, 10)."T".substr(${"arrP".$j.$i}['finishing_tm'], 11, 5);
    ${"cycle_shot".$i} = ${"arrP".$j.$i}['cycle_shot'];
    ${"amount_shot".$i} = ${"arrP".$j.$i}['amount_shot'];
    ${"accomp_rate".$i} = ${"arrP".$j.$i}['accomp_rate'];
    ${"id".$i} = ${"arrP".$j.$i}['id'];
    ${"seikeiki".$i} = ${"arrP".$j.$i}['seikeiki'];
    ${"seikeiki_code".$i} = ${"arrP".$j.$i}['seikeiki_code'];
    ${"present_kensahyou".$i} = ${"arrP".$j.$i}['present_kensahyou'];
    ${"created_at".$i} = ${"arrP".$j.$i}['created_at'];
    ${"created_staff".$i} = ${"arrP".$j.$i}['created_staff'];

      echo "<tr style='border-bottom: 0px;border-width: 0px'>\n";
      echo "<td rowspan='2'  height='6' colspan='20' nowrap='nowrap'>\n";
      echo "<input type='text' value=${"product_code".$i} name=product_code".$j.$i." size='6'/>\n";
      echo "</td>\n";
      echo "<td colspan='3' nowrap='nowrap' style='border-bottom: 0px'><div align='center'><strong style='font-size: 15pt; color:blue'>\n";
      echo "開始";
      echo "</strong></div></td>\n";
      echo "<td colspan='37' nowrap='nowrap' style='border-bottom: 0px'><div align='center'>\n";
      echo "<input type='datetime-local' value=${"hyoujistarting_tm".$i} name=starting_tm".$j.$i." size='6'/>\n";
      echo "</div></td>\n";
      echo "<td rowspan='2' colspan='20' nowrap='nowrap'>\n";
      echo "<input type='text' value=${"amount_shot".$i}  name=amount_shot".$j.$i." size='6'/>\n";
      echo "</td>\n";
      echo "<td rowspan='2'  height='6' colspan='20' nowrap='nowrap'>\n";
      echo "<input type='text' value=${"cycle_shot".$i}  name=cycle_shot".$j.$i." size='6'/>\n";
      echo "</td>\n";
      echo "</tr>\n";
      echo "<tr style='border-bottom: 0px;border-width: 0px'>\n";
      echo "<td colspan='3' nowrap='nowrap'><div align='center'><strong style='font-size: 15pt; color:blue'>\n";
      echo "終了";
      echo "</strong></div></td>\n";
      echo "<td colspan='37'><div align='center'>\n";
      echo "<input type='datetime-local' value=${"hyoujifinishing_tm".$i} name=finishing_tm".$j.$i." size='6'/>\n";
      echo "</div></td>\n";
      echo "</tr>\n";

      echo "<input type='hidden' value=${"id".$i}  name=id".$j.$i." size='6'/>\n";
      echo "<input type='hidden' value=${"seikeiki".$i}  name=seikeiki".$j.$i." size='6'/>\n";
      echo "<input type='hidden' value=${"seikeiki_code".$i}  name=seikeiki_code".$j.$i." size='6'/>\n";
      echo "<input type='hidden' value=${"accomp_rate".$i}  name=accomp_rate".$j.$i." size='6'/>\n";
      echo "<input type='hidden' value=${"seikeiki_code".$i}  name=seikeiki_code".$j.$i." size='6'/>\n";
      echo "<input type='hidden' value=${"present_kensahyou".$i}  name=present_kensahyou".$j.$i." size='6'/>\n";
      echo "<input type='hidden' value=${"created_at".$i}  name=created_at".$j.$i." size='6'/>\n";
      echo "<input type='hidden' value=${"created_staff".$i}  name=created_staff".$j.$i." size='6'/>\n";

    }
  echo $this->Form->hidden('n'.$j ,['value'=>${"n".$j}]);
 ?>
</table>
<br>
<?php   /*ここまで５号機*/    ?>
<?php   /*ここから６号機*/    ?>
<br>
<table align="center" border="2" bordercolor="#E6FFFF" cellpadding="0" cellspacing="0">
  <caption style="text-align: left">６号機</caption>
  <tbody border="2" bordercolor="#E6FFFF" bgcolor="#FFFFCC" style="border-bottom: solid;border-width: 1px">
    <tr style="border-bottom: 0px;border-width: 0px">
      <td width="250" height="60" colspan="20" nowrap="nowrap"><div align="center"><strong style="font-size: 20pt; color:blue">品番</strong></div></td>
      <td width="500" colspan="40" nowrap="nowrap"><div align="center"><strong style="font-size: 15pt; color:blue">成形時間</strong></div></td>
      <td width="250" colspan="20" nowrap="nowrap"><div align="center"><strong style="font-size: 10pt; color:blue">生産ショット数</strong></div></td>
      <td width="250" colspan="20" nowrap="nowrap"><div align="center"><strong style="font-size: 10pt; color:blue">成形サイクル</strong></div></td>
    </tr>


<?php
$j = 6;
  for($i=1; $i<=${"n".$j}; $i++){
    ${"product_code".$i} = ${"arrP".$j.$i}['product_code'];
    ${"hyoujistarting_tm".$i} = substr(${"arrP".$j.$i}['starting_tm'], 0, 10)."T".substr(${"arrP".$j.$i}['starting_tm'], 11, 5);
    ${"hyoujifinishing_tm".$i} = substr(${"arrP".$j.$i}['finishing_tm'], 0, 10)."T".substr(${"arrP".$j.$i}['finishing_tm'], 11, 5);
    ${"cycle_shot".$i} = ${"arrP".$j.$i}['cycle_shot'];
    ${"amount_shot".$i} = ${"arrP".$j.$i}['amount_shot'];
    ${"accomp_rate".$i} = ${"arrP".$j.$i}['accomp_rate'];
    ${"id".$i} = ${"arrP".$j.$i}['id'];
    ${"seikeiki".$i} = ${"arrP".$j.$i}['seikeiki'];
    ${"seikeiki_code".$i} = ${"arrP".$j.$i}['seikeiki_code'];
    ${"present_kensahyou".$i} = ${"arrP".$j.$i}['present_kensahyou'];
    ${"created_at".$i} = ${"arrP".$j.$i}['created_at'];
    ${"created_staff".$i} = ${"arrP".$j.$i}['created_staff'];

      echo "<tr style='border-bottom: 0px;border-width: 0px'>\n";
      echo "<td rowspan='2'  height='6' colspan='20' nowrap='nowrap'>\n";
      echo "<input type='text' value=${"product_code".$i} name=product_code".$j.$i." size='6'/>\n";
      echo "</td>\n";
      echo "<td colspan='3' nowrap='nowrap' style='border-bottom: 0px'><div align='center'><strong style='font-size: 15pt; color:blue'>\n";
      echo "開始";
      echo "</strong></div></td>\n";
      echo "<td colspan='37' nowrap='nowrap' style='border-bottom: 0px'><div align='center'>\n";
      echo "<input type='datetime-local' value=${"hyoujistarting_tm".$i} name=starting_tm".$j.$i." size='6'/>\n";
      echo "</div></td>\n";
      echo "<td rowspan='2' colspan='20' nowrap='nowrap'>\n";
      echo "<input type='text' value=${"amount_shot".$i}  name=amount_shot".$j.$i." size='6'/>\n";
      echo "</td>\n";
      echo "<td rowspan='2'  height='6' colspan='20' nowrap='nowrap'>\n";
      echo "<input type='text' value=${"cycle_shot".$i}  name=cycle_shot".$j.$i." size='6'/>\n";
      echo "</td>\n";
      echo "</tr>\n";
      echo "<tr style='border-bottom: 0px;border-width: 0px'>\n";
      echo "<td colspan='3' nowrap='nowrap'><div align='center'><strong style='font-size: 15pt; color:blue'>\n";
      echo "終了";
      echo "</strong></div></td>\n";
      echo "<td colspan='37'><div align='center'>\n";
      echo "<input type='datetime-local' value=${"hyoujifinishing_tm".$i} name=finishing_tm".$j.$i." size='6'/>\n";
      echo "</div></td>\n";
      echo "</tr>\n";

      echo "<input type='hidden' value=${"id".$i}  name=id".$j.$i." size='6'/>\n";
      echo "<input type='hidden' value=${"seikeiki".$i}  name=seikeiki".$j.$i." size='6'/>\n";
      echo "<input type='hidden' value=${"seikeiki_code".$i}  name=seikeiki_code".$j.$i." size='6'/>\n";
      echo "<input type='hidden' value=${"accomp_rate".$i}  name=accomp_rate".$j.$i." size='6'/>\n";
      echo "<input type='hidden' value=${"seikeiki_code".$i}  name=seikeiki_code".$j.$i." size='6'/>\n";
      echo "<input type='hidden' value=${"present_kensahyou".$i}  name=present_kensahyou".$j.$i." size='6'/>\n";
      echo "<input type='hidden' value=${"created_at".$i}  name=created_at".$j.$i." size='6'/>\n";
      echo "<input type='hidden' value=${"created_staff".$i}  name=created_staff".$j.$i." size='6'/>\n";

    }
  echo $this->Form->hidden('n'.$j ,['value'=>${"n".$j}]);
 ?>
</table>
<br>
<?php   /*ここまで６号機*/    ?>
<?php   /*ここから７号機*/    ?>
<br>
<table align="center" border="2" bordercolor="#E6FFFF" cellpadding="0" cellspacing="0">
  <caption style="text-align: left">７号機</caption>
  <tbody border="2" bordercolor="#E6FFFF" bgcolor="#FFFFCC" style="border-bottom: solid;border-width: 1px">
    <tr style="border-bottom: 0px;border-width: 0px">
      <td width="250" height="60" colspan="20" nowrap="nowrap"><div align="center"><strong style="font-size: 20pt; color:blue">品番</strong></div></td>
      <td width="500" colspan="40" nowrap="nowrap"><div align="center"><strong style="font-size: 15pt; color:blue">成形時間</strong></div></td>
      <td width="250" colspan="20" nowrap="nowrap"><div align="center"><strong style="font-size: 10pt; color:blue">生産ショット数</strong></div></td>
      <td width="250" colspan="20" nowrap="nowrap"><div align="center"><strong style="font-size: 10pt; color:blue">成形サイクル</strong></div></td>
    </tr>


<?php
$j = 7;
  for($i=1; $i<=${"n".$j}; $i++){
    ${"product_code".$i} = ${"arrP".$j.$i}['product_code'];
    ${"hyoujistarting_tm".$i} = substr(${"arrP".$j.$i}['starting_tm'], 0, 10)."T".substr(${"arrP".$j.$i}['starting_tm'], 11, 5);
    ${"hyoujifinishing_tm".$i} = substr(${"arrP".$j.$i}['finishing_tm'], 0, 10)."T".substr(${"arrP".$j.$i}['finishing_tm'], 11, 5);
    ${"cycle_shot".$i} = ${"arrP".$j.$i}['cycle_shot'];
    ${"amount_shot".$i} = ${"arrP".$j.$i}['amount_shot'];
    ${"accomp_rate".$i} = ${"arrP".$j.$i}['accomp_rate'];
    ${"id".$i} = ${"arrP".$j.$i}['id'];
    ${"seikeiki".$i} = ${"arrP".$j.$i}['seikeiki'];
    ${"seikeiki_code".$i} = ${"arrP".$j.$i}['seikeiki_code'];
    ${"present_kensahyou".$i} = ${"arrP".$j.$i}['present_kensahyou'];
    ${"created_at".$i} = ${"arrP".$j.$i}['created_at'];
    ${"created_staff".$i} = ${"arrP".$j.$i}['created_staff'];

      echo "<tr style='border-bottom: 0px;border-width: 0px'>\n";
      echo "<td rowspan='2'  height='6' colspan='20' nowrap='nowrap'>\n";
      echo "<input type='text' value=${"product_code".$i} name=product_code".$j.$i." size='6'/>\n";
      echo "</td>\n";
      echo "<td colspan='3' nowrap='nowrap' style='border-bottom: 0px'><div align='center'><strong style='font-size: 15pt; color:blue'>\n";
      echo "開始";
      echo "</strong></div></td>\n";
      echo "<td colspan='37' nowrap='nowrap' style='border-bottom: 0px'><div align='center'>\n";
      echo "<input type='datetime-local' value=${"hyoujistarting_tm".$i} name=starting_tm".$j.$i." size='6'/>\n";
      echo "</div></td>\n";
      echo "<td rowspan='2' colspan='20' nowrap='nowrap'>\n";
      echo "<input type='text' value=${"amount_shot".$i}  name=amount_shot".$j.$i." size='6'/>\n";
      echo "</td>\n";
      echo "<td rowspan='2'  height='6' colspan='20' nowrap='nowrap'>\n";
      echo "<input type='text' value=${"cycle_shot".$i}  name=cycle_shot".$j.$i." size='6'/>\n";
      echo "</td>\n";
      echo "</tr>\n";
      echo "<tr style='border-bottom: 0px;border-width: 0px'>\n";
      echo "<td colspan='3' nowrap='nowrap'><div align='center'><strong style='font-size: 15pt; color:blue'>\n";
      echo "終了";
      echo "</strong></div></td>\n";
      echo "<td colspan='37'><div align='center'>\n";
      echo "<input type='datetime-local' value=${"hyoujifinishing_tm".$i} name=finishing_tm".$j.$i." size='6'/>\n";
      echo "</div></td>\n";
      echo "</tr>\n";

      echo "<input type='hidden' value=${"id".$i}  name=id".$j.$i." size='6'/>\n";
      echo "<input type='hidden' value=${"seikeiki".$i}  name=seikeiki".$j.$i." size='6'/>\n";
      echo "<input type='hidden' value=${"seikeiki_code".$i}  name=seikeiki_code".$j.$i." size='6'/>\n";
      echo "<input type='hidden' value=${"accomp_rate".$i}  name=accomp_rate".$j.$i." size='6'/>\n";
      echo "<input type='hidden' value=${"seikeiki_code".$i}  name=seikeiki_code".$j.$i." size='6'/>\n";
      echo "<input type='hidden' value=${"present_kensahyou".$i}  name=present_kensahyou".$j.$i." size='6'/>\n";
      echo "<input type='hidden' value=${"created_at".$i}  name=created_at".$j.$i." size='6'/>\n";
      echo "<input type='hidden' value=${"created_staff".$i}  name=created_staff".$j.$i." size='6'/>\n";

    }
  echo $this->Form->hidden('n'.$j ,['value'=>${"n".$j}]);
 ?>
</table>
<br>
<?php   /*ここまで７号機*/    ?>
<?php   /*ここから８号機*/    ?>
<br>
<table align="center" border="2" bordercolor="#E6FFFF" cellpadding="0" cellspacing="0">
  <caption style="text-align: left">８号機</caption>
  <tbody border="2" bordercolor="#E6FFFF" bgcolor="#FFFFCC" style="border-bottom: solid;border-width: 1px">
    <tr style="border-bottom: 0px;border-width: 0px">
      <td width="250" height="60" colspan="20" nowrap="nowrap"><div align="center"><strong style="font-size: 20pt; color:blue">品番</strong></div></td>
      <td width="500" colspan="40" nowrap="nowrap"><div align="center"><strong style="font-size: 15pt; color:blue">成形時間</strong></div></td>
      <td width="250" colspan="20" nowrap="nowrap"><div align="center"><strong style="font-size: 10pt; color:blue">生産ショット数</strong></div></td>
      <td width="250" colspan="20" nowrap="nowrap"><div align="center"><strong style="font-size: 10pt; color:blue">成形サイクル</strong></div></td>
    </tr>


<?php
$j = 8;
  for($i=1; $i<=${"n".$j}; $i++){
    ${"product_code".$i} = ${"arrP".$j.$i}['product_code'];
    ${"hyoujistarting_tm".$i} = substr(${"arrP".$j.$i}['starting_tm'], 0, 10)."T".substr(${"arrP".$j.$i}['starting_tm'], 11, 5);
    ${"hyoujifinishing_tm".$i} = substr(${"arrP".$j.$i}['finishing_tm'], 0, 10)."T".substr(${"arrP".$j.$i}['finishing_tm'], 11, 5);
    ${"cycle_shot".$i} = ${"arrP".$j.$i}['cycle_shot'];
    ${"amount_shot".$i} = ${"arrP".$j.$i}['amount_shot'];
    ${"accomp_rate".$i} = ${"arrP".$j.$i}['accomp_rate'];
    ${"id".$i} = ${"arrP".$j.$i}['id'];
    ${"seikeiki".$i} = ${"arrP".$j.$i}['seikeiki'];
    ${"seikeiki_code".$i} = ${"arrP".$j.$i}['seikeiki_code'];
    ${"present_kensahyou".$i} = ${"arrP".$j.$i}['present_kensahyou'];
    ${"created_at".$i} = ${"arrP".$j.$i}['created_at'];
    ${"created_staff".$i} = ${"arrP".$j.$i}['created_staff'];

      echo "<tr style='border-bottom: 0px;border-width: 0px'>\n";
      echo "<td rowspan='2'  height='6' colspan='20' nowrap='nowrap'>\n";
      echo "<input type='text' value=${"product_code".$i} name=product_code".$j.$i." size='6'/>\n";
      echo "</td>\n";
      echo "<td colspan='3' nowrap='nowrap' style='border-bottom: 0px'><div align='center'><strong style='font-size: 15pt; color:blue'>\n";
      echo "開始";
      echo "</strong></div></td>\n";
      echo "<td colspan='37' nowrap='nowrap' style='border-bottom: 0px'><div align='center'>\n";
      echo "<input type='datetime-local' value=${"hyoujistarting_tm".$i} name=starting_tm".$j.$i." size='6'/>\n";
      echo "</div></td>\n";
      echo "<td rowspan='2' colspan='20' nowrap='nowrap'>\n";
      echo "<input type='text' value=${"amount_shot".$i}  name=amount_shot".$j.$i." size='6'/>\n";
      echo "</td>\n";
      echo "<td rowspan='2'  height='6' colspan='20' nowrap='nowrap'>\n";
      echo "<input type='text' value=${"cycle_shot".$i}  name=cycle_shot".$j.$i." size='6'/>\n";
      echo "</td>\n";
      echo "</tr>\n";
      echo "<tr style='border-bottom: 0px;border-width: 0px'>\n";
      echo "<td colspan='3' nowrap='nowrap'><div align='center'><strong style='font-size: 15pt; color:blue'>\n";
      echo "終了";
      echo "</strong></div></td>\n";
      echo "<td colspan='37'><div align='center'>\n";
      echo "<input type='datetime-local' value=${"hyoujifinishing_tm".$i} name=finishing_tm".$j.$i." size='6'/>\n";
      echo "</div></td>\n";
      echo "</tr>\n";

      echo "<input type='hidden' value=${"id".$i}  name=id".$j.$i." size='6'/>\n";
      echo "<input type='hidden' value=${"seikeiki".$i}  name=seikeiki".$j.$i." size='6'/>\n";
      echo "<input type='hidden' value=${"seikeiki_code".$i}  name=seikeiki_code".$j.$i." size='6'/>\n";
      echo "<input type='hidden' value=${"accomp_rate".$i}  name=accomp_rate".$j.$i." size='6'/>\n";
      echo "<input type='hidden' value=${"seikeiki_code".$i}  name=seikeiki_code".$j.$i." size='6'/>\n";
      echo "<input type='hidden' value=${"present_kensahyou".$i}  name=present_kensahyou".$j.$i." size='6'/>\n";
      echo "<input type='hidden' value=${"created_at".$i}  name=created_at".$j.$i." size='6'/>\n";
      echo "<input type='hidden' value=${"created_staff".$i}  name=created_staff".$j.$i." size='6'/>\n";

    }
  echo $this->Form->hidden('n'.$j ,['value'=>${"n".$j}]);
 ?>
</table>
<br>
<?php   /*ここまで８号機*/    ?>
<?php   /*ここから９号機*/    ?>
<br>
<table align="center" border="2" bordercolor="#E6FFFF" cellpadding="0" cellspacing="0">
  <caption style="text-align: left">９号機</caption>
  <tbody border="2" bordercolor="#E6FFFF" bgcolor="#FFFFCC" style="border-bottom: solid;border-width: 1px">
    <tr style="border-bottom: 0px;border-width: 0px">
      <td width="250" height="60" colspan="20" nowrap="nowrap"><div align="center"><strong style="font-size: 20pt; color:blue">品番</strong></div></td>
      <td width="500" colspan="40" nowrap="nowrap"><div align="center"><strong style="font-size: 15pt; color:blue">成形時間</strong></div></td>
      <td width="250" colspan="20" nowrap="nowrap"><div align="center"><strong style="font-size: 10pt; color:blue">生産ショット数</strong></div></td>
      <td width="250" colspan="20" nowrap="nowrap"><div align="center"><strong style="font-size: 10pt; color:blue">成形サイクル</strong></div></td>
    </tr>


<?php
$j = 9;
  for($i=1; $i<=${"n".$j}; $i++){
    ${"product_code".$i} = ${"arrP".$j.$i}['product_code'];
    ${"hyoujistarting_tm".$i} = substr(${"arrP".$j.$i}['starting_tm'], 0, 10)."T".substr(${"arrP".$j.$i}['starting_tm'], 11, 5);
    ${"hyoujifinishing_tm".$i} = substr(${"arrP".$j.$i}['finishing_tm'], 0, 10)."T".substr(${"arrP".$j.$i}['finishing_tm'], 11, 5);
    ${"cycle_shot".$i} = ${"arrP".$j.$i}['cycle_shot'];
    ${"amount_shot".$i} = ${"arrP".$j.$i}['amount_shot'];
    ${"accomp_rate".$i} = ${"arrP".$j.$i}['accomp_rate'];
    ${"id".$i} = ${"arrP".$j.$i}['id'];
    ${"seikeiki".$i} = ${"arrP".$j.$i}['seikeiki'];
    ${"seikeiki_code".$i} = ${"arrP".$j.$i}['seikeiki_code'];
    ${"present_kensahyou".$i} = ${"arrP".$j.$i}['present_kensahyou'];
    ${"created_at".$i} = ${"arrP".$j.$i}['created_at'];
    ${"created_staff".$i} = ${"arrP".$j.$i}['created_staff'];

      echo "<tr style='border-bottom: 0px;border-width: 0px'>\n";
      echo "<td rowspan='2'  height='6' colspan='20' nowrap='nowrap'>\n";
      echo "<input type='text' value=${"product_code".$i} name=product_code".$j.$i." size='6'/>\n";
      echo "</td>\n";
      echo "<td colspan='3' nowrap='nowrap' style='border-bottom: 0px'><div align='center'><strong style='font-size: 15pt; color:blue'>\n";
      echo "開始";
      echo "</strong></div></td>\n";
      echo "<td colspan='37' nowrap='nowrap' style='border-bottom: 0px'><div align='center'>\n";
      echo "<input type='datetime-local' value=${"hyoujistarting_tm".$i} name=starting_tm".$j.$i." size='6'/>\n";
      echo "</div></td>\n";
      echo "<td rowspan='2' colspan='20' nowrap='nowrap'>\n";
      echo "<input type='text' value=${"amount_shot".$i}  name=amount_shot".$j.$i." size='6'/>\n";
      echo "</td>\n";
      echo "<td rowspan='2'  height='6' colspan='20' nowrap='nowrap'>\n";
      echo "<input type='text' value=${"cycle_shot".$i}  name=cycle_shot".$j.$i." size='6'/>\n";
      echo "</td>\n";
      echo "</tr>\n";
      echo "<tr style='border-bottom: 0px;border-width: 0px'>\n";
      echo "<td colspan='3' nowrap='nowrap'><div align='center'><strong style='font-size: 15pt; color:blue'>\n";
      echo "終了";
      echo "</strong></div></td>\n";
      echo "<td colspan='37'><div align='center'>\n";
      echo "<input type='datetime-local' value=${"hyoujifinishing_tm".$i} name=finishing_tm".$j.$i." size='6'/>\n";
      echo "</div></td>\n";
      echo "</tr>\n";

      echo "<input type='hidden' value=${"id".$i}  name=id".$j.$i." size='6'/>\n";
      echo "<input type='hidden' value=${"seikeiki".$i}  name=seikeiki".$j.$i." size='6'/>\n";
      echo "<input type='hidden' value=${"seikeiki_code".$i}  name=seikeiki_code".$j.$i." size='6'/>\n";
      echo "<input type='hidden' value=${"accomp_rate".$i}  name=accomp_rate".$j.$i." size='6'/>\n";
      echo "<input type='hidden' value=${"seikeiki_code".$i}  name=seikeiki_code".$j.$i." size='6'/>\n";
      echo "<input type='hidden' value=${"present_kensahyou".$i}  name=present_kensahyou".$j.$i." size='6'/>\n";
      echo "<input type='hidden' value=${"created_at".$i}  name=created_at".$j.$i." size='6'/>\n";
      echo "<input type='hidden' value=${"created_staff".$i}  name=created_staff".$j.$i." size='6'/>\n";

    }
  echo $this->Form->hidden('n'.$j ,['value'=>${"n".$j}]);
 ?>
</table>
<br>
<?php   /*ここまで９号機*/    ?>

<br>

<p align="center"><?= $this->Form->button(__('確認'), array('name' => 'confirm', 'value'=>"1")) ?></p>


<br>
