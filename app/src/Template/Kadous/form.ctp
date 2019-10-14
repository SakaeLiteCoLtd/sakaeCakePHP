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

<?php if(!isset($confirm)): ?>

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
for($i=1; $i<=$tuika1; $i++){//１号機
      echo "<tr style='border-bottom: 0px;border-width: 0px'>\n";
      echo "<td rowspan='2'  height='6' colspan='20' nowrap='nowrap'>\n";
      echo "<input type='text' name=product_code1_".$i." size='6'/>\n";
      echo "</td>\n";
      echo "<td colspan='3' nowrap='nowrap' style='border-bottom: 0px'><div align='center'><strong style='font-size: 15pt; color:blue'>\n";
      echo "開始";
      echo "</strong></div></td>\n";
      echo "<td colspan='37' nowrap='nowrap' style='border-bottom: 0px'><div align='center'>\n";
      echo "<input type='datetime-local' value=$dateye name=starting_tm1_".$i." size='6'/>\n";
      echo "</div></td>\n";
      echo "<td rowspan='2' colspan='20' nowrap='nowrap'>\n";
      echo "<input type='text' name=amount_shot1_".$i." size='6'/>\n";
      echo "</td>\n";
      echo "<td rowspan='2'  height='6' colspan='20' nowrap='nowrap'>\n";
      echo "<input type='text' name=cycle_shot1_".$i." size='6'/>\n";
      echo "</td>\n";
      echo "</tr>\n";
      echo "<tr style='border-bottom: 0px;border-width: 0px'>\n";
      echo "<td colspan='3' nowrap='nowrap'><div align='center'><strong style='font-size: 15pt; color:blue'>\n";
      echo "終了";
      echo "</strong></div></td>\n";
      echo "<td colspan='37'><div align='center'>\n";
      echo "<input type='datetime-local' value=$dateto name=finishing_tm1_".$i." size='6'/>\n";
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
for($i=1; $i<=$tuika2; $i++){//２号機
      echo "<tr style='border-bottom: 0px;border-width: 0px'>\n";
      echo "<td rowspan='2'  height='6' colspan='20' nowrap='nowrap'>\n";
      echo "<input type='text' name=product_code2_".$i." size='6'/>\n";
      echo "</td>\n";
      echo "<td colspan='3' nowrap='nowrap' style='border-bottom: 0px'><div align='center'><strong style='font-size: 15pt; color:blue'>\n";
      echo "開始";
      echo "</strong></div></td>\n";
      echo "<td colspan='37' nowrap='nowrap' style='border-bottom: 0px'><div align='center'>\n";
      echo "<input type='datetime-local' value=$dateye name=starting_tm2_".$i." size='6'/>\n";
      echo "</div></td>\n";
      echo "<td rowspan='2' colspan='20' nowrap='nowrap'>\n";
      echo "<input type='text' name=amount_shot2_".$i." size='6'/>\n";
      echo "</td>\n";
      echo "<td rowspan='2'  height='6' colspan='20' nowrap='nowrap'>\n";
      echo "<input type='text' name=cycle_shot2_".$i." size='6'/>\n";
      echo "</td>\n";
      echo "</tr>\n";
      echo "<tr style='border-bottom: 0px;border-width: 0px'>\n";
      echo "<td colspan='3' nowrap='nowrap'><div align='center'><strong style='font-size: 15pt; color:blue'>\n";
      echo "終了";
      echo "</strong></div></td>\n";
      echo "<td colspan='37'><div align='center'>\n";
      echo "<input type='datetime-local' value=$dateto name=finishing_tm2_".$i." size='6'/>\n";
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

<p align="center"><?= $this->Form->button(__('確認'), array('name' => 'confirm', 'value'=>"1")) ?></p>


<br>
<br>
<br>



<?php else: //確認押したとき ?>

 <br>
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
   ${"riron_shot1_".$i} = ${"kadoujikan1_".$i}/${"cycle_shot1_".$i};
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
               'seikeiki_code' => "",
               'starting_tm' => ${"starting_tm1_".$n},
               'finishing_tm' => ${"finishing_tm1_".$n},
               'cycle_shot' => $_POST["cycle_shot1_{$n}"],
               'amount_shot' => $_POST["amount_shot1_{$n}"],
               'accomp_rate' => ${"accomp_rate1_".$n},
               "present_kensahyou" => 0,
             );
   }
   $this->set('m',$m);//1行上の$roleをctpで使えるようにセット
/*
   echo "<pre>";
   print_r($_SESSION['karikadouseikei']);
   echo "</pre>";
*/
  ?>


 <table align="center" border="2" bordercolor="#E6FFFF" cellpadding="0" cellspacing="0">
   <caption style="text-align: left">２号機</caption>
   <tbody border="2" bordercolor="#E6FFFF" bgcolor="#FFFFCC" style="border-bottom: solid;border-width: 1px">
     <tr style="border-bottom: 0px;border-width: 0px">
       <td width="250" height="60" colspan="10" nowrap="nowrap"><div align="center"><strong style="font-size: 20pt; color:blue">品番</strong></div></td>
       <td width="200" colspan="10" nowrap="nowrap"><div align="center"><strong style="font-size: 15pt; color:blue">成形時間</strong></div></td>
       <td width="200" colspan="10" nowrap="nowrap"><div align="center"><strong style="font-size: 15pt; color:blue">ショット数</strong></div></td>
       <td width="200" colspan="10" nowrap="nowrap"><div align="center"><strong style="font-size: 15pt; color:blue">理論ショット数</strong></div></td>
       <td width="200" colspan="10" nowrap="nowrap"><div align="center"><strong style="font-size: 15pt; color:blue">達成率</strong></div></td>
     </tr>


 <?php
 for($i=1; $i<=$tuika2; $i++){//2号機
   ${"amount_shot2_".$i} = $this->request->getData("amount_shot2_{$i}");
   ${"cycle_shot2_".$i} = $this->request->getData("cycle_shot2_{$i}");
   ${"starting_tm2_".$i} = strtotime($this->request->getData("starting_tm2_{$i}"));
   ${"kadoujikan2_".$i} = ((strtotime($this->request->getData("finishing_tm2_{$i}")) - strtotime($this->request->getData("starting_tm2_{$i}"))));
   ${"riron_shot2_".$i} = ${"kadoujikan2_".$i}/${"cycle_shot2_".$i};
   ${"accomp_rate2_".$i} = round(100*${"amount_shot2_".$i}/${"riron_shot2_".$i}, 0);
       echo "<tr style='border-bottom: 0px;border-width: 0px'>\n";
       echo "<td rowspan='2'  height='10' colspan='10' nowrap='nowrap' style='font-size: 18pt'><div align='center'>\n";
       echo $this->request->getData("product_code2_{$i}");
       echo "</div></td>\n";
       echo "</strong></div></td>\n";
       echo "<td colspan='10' nowrap='nowrap' style='font-size: 18pt'><div align='center'>\n";
       echo ${"kadoujikan2_".$i}/3600;
       echo "</div></td>\n";
       echo "<td rowspan='2' colspan='10' nowrap='nowrap' style='font-size: 18pt'><div align='center'>\n";
       echo $this->request->getData("amount_shot2_{$i}");
       echo "</div></td>\n";
       echo "<td rowspan='2'  height='6' colspan='10' nowrap='nowrap' style='font-size: 18pt'><div align='center'>\n";
       echo ${"riron_shot2_".$i};
       echo "</div></td>\n";
       echo "<td rowspan='2'  height='6' colspan='10' nowrap='nowrap'><div align='center' style='font-size: 18pt; color:red'>\n";
       echo ${"accomp_rate2_".$i}."%";
       echo "</div></td>\n";
       echo "</tr>\n";
       echo "<tr style='border-bottom: 0px;border-width: 0px'>\n";
       echo "</tr>\n";
   }
  ?>

  <?php
  for($n=1; $n<=$tuika2; $n++){
    $m = $m + 1;
    ${"starting_tm2_".$n} = substr($_POST["starting_tm2_{$n}"], 0, 10)." ".substr($_POST["starting_tm2_{$n}"], 11, 5);
    ${"finishing_tm2_".$n} = substr($_POST["finishing_tm2_{$n}"], 0, 10)." ".substr($_POST["finishing_tm2_{$n}"], 11, 5);
          $resultArray = Array();
            $_SESSION['karikadouseikei'][$m] = array(
              'product_code' => $_POST["product_code2_{$n}"],
              'seikeiki' => 1,
              'seikeiki_code' => "",
              'starting_tm' => ${"starting_tm2_".$n},
              'finishing_tm' => ${"finishing_tm2_".$n},
              'cycle_shot' => $_POST["cycle_shot2_{$n}"],
              'amount_shot' => $_POST["amount_shot2_{$n}"],
              'accomp_rate' => ${"accomp_rate2_".$n},
              "present_kensahyou" => 0,
            );
  }
  $this->set('m',$m);//1行上の$roleをctpで使えるようにセット
/*
  echo "<pre>";
  print_r($_SESSION['karikadouseikei']);
  echo "</pre>";
*/
   ?>

 </table>
  <br>
  <br>
  <br>

  <p align="center"><?= $this->Form->button(__('登録'), array('name' => 'touroku', 'value'=>"1")) ?></p>


<?php endif; ?>
