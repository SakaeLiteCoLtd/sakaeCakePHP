<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\Staff $staff
 */
 use Cake\ORM\TableRegistry;//独立したテーブルを扱う
?>

<table align="center" border="2" bordercolor="#E6FFFF" cellpadding="0" cellspacing="0">
  <caption style="text-align: left">１号機</caption>
  <tbody border="2" bordercolor="#E6FFFF" bgcolor="#FFFFCC" style="border-bottom: solid;border-width: 1px">
    <tr style="border-bottom: 0px;border-width: 0px">
      <td width="250" height="60" colspan="10" nowrap="nowrap"><div align="center"><strong style="font-size: 20pt; color:blue">品番</strong></div></td>
      <td width="200" colspan="10" nowrap="nowrap"><div align="center"><strong style="font-size: 15pt; color:blue">成形時間</strong></div></td>
      <td width="200" colspan="10" nowrap="nowrap"><div align="center"><strong style="font-size: 15pt; color:blue">ショット数</strong></div></td>
      <td width="200" colspan="10" nowrap="nowrap"><div align="center"><strong style="font-size: 15pt; color:blue">理論ショット数</strong></div></td>
      <td width="200" colspan="10" nowrap="nowrap"><div align="center"><strong style="font-size: 15pt; color:blue">達成率</strong></div></td>
    </tr>


<?php
for($i=1; $i<=$tuika1; $i++){//１号機
  ${"amount_shot1_".$i} = $this->request->getData("amount_shot1_{$i}");
  ${"cycle_shot1_".$i} = $this->request->getData("cycle_shot1_{$i}");
  ${"kadoujikan1_".$i} = ((strtotime($this->request->getData("finishing_tm1_{$i}")) - strtotime($this->request->getData("starting_tm1_{$i}"))));
  ${"riron_shot1_".$i} = round(${"kadoujikan1_".$i}/${"cycle_shot1_".$i}, 0);
  ${"accomp_rate1_".$i} = round(100*${"amount_shot1_".$i}/${"riron_shot1_".$i}, 0);
      echo "<tr style='border-bottom: 0px;border-width: 0px'>\n";
      echo "<td rowspan='2'  height='10' colspan='10' nowrap='nowrap' style='font-size: 18pt'><div align='center'>\n";
      echo $this->request->getData("product_code1_{$i}");
      echo "</div></td>\n";
      echo "</strong></div></td>\n";
      echo "<td colspan='10' nowrap='nowrap' style='font-size: 18pt'><div align='center'>\n";
      echo ${"kadoujikan1_".$i}/3600;
      echo "</div></td>\n";
      echo "<td rowspan='2' colspan='10' nowrap='nowrap' style='font-size: 18pt'><div align='center'>\n";
      echo $this->request->getData("amount_shot1_{$i}");
      echo "</div></td>\n";
      echo "<td rowspan='2'  height='6' colspan='10' nowrap='nowrap' style='font-size: 18pt'><div align='center'>\n";
      echo ${"riron_shot1_".$i};
      echo "</div></td>\n";
      echo "<td rowspan='2'  height='6' colspan='10' nowrap='nowrap'><div align='center' style='font-size: 18pt; color:red'>\n";
      echo ${"accomp_rate1_".$i}."%";
      echo "</div></td>\n";
      echo "</tr>\n";
      echo "<tr style='border-bottom: 0px;border-width: 0px'>\n";
      echo "</tr>\n";
  }
 ?>
</table>
<br>
<br>

<?php
  $session = $this->request->getSession();
  $username = $this->request->Session()->read('Auth.User.username');

  $m = 0;
  for($n=1; $n<=$tuika1; $n++){
    $m = $m + 1;
    ${"starting_tm1_".$n} = substr($_POST["starting_tm1_{$n}"], 0, 10)." ".substr($_POST["starting_tm1_{$n}"], 11, 5);
    ${"finishing_tm1_".$n} = substr($_POST["finishing_tm1_{$n}"], 0, 10)." ".substr($_POST["finishing_tm1_{$n}"], 11, 5);
          $resultArray = Array();
            $_SESSION['karikadouseikei'][$m] = array(
              'product_code' => $_POST["product_code1_{$n}"],
              'seikeiki' => 1,
              'seikeiki_code' => $m,
              'starting_tm' => ${"starting_tm1_".$n},
              'finishing_tm' => ${"finishing_tm1_".$n},
              'cycle_shot' => $_POST["cycle_shot1_{$n}"],
              'amount_shot' => $_POST["amount_shot1_{$n}"],
              'accomp_rate' => ${"accomp_rate1_".$n},
              "present_kensahyou" => 0,
            );
  }
  $this->set('m',$m);//1行上の$roleをctpで使えるようにセット
  $m1 = $m;
  $this->set('m1',$m1);//1行上の$roleをctpで使えるようにセット
/*
  echo "<pre>";
  print_r($_SESSION['karikadouseikei']);
  echo "</pre>";
*/
 ?>
