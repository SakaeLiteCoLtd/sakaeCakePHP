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
          echo $this->Form->create($KariKadouSeikeis, ['url' => ['action' => 'kariform']]);
?>

<?php if(!isset($confirm)): ?>



  <?php   /*ここから１号機*/    ?>
  <table align="center" border="2" bordercolor="#E6FFFF" cellpadding="0" cellspacing="0">
    <caption style="text-align: left">１号機</caption>
    <tbody border="2" bordercolor="#E6FFFF" bgcolor="#FFFFCC" style="border-bottom: solid;border-width: 1px">
      <tr style="border-bottom: 0px;border-width: 0px">
        <td width="250" height="30" colspan="20" nowrap="nowrap"><div align="center"><strong style="font-size: 13pt; color:blue">品番</strong></div></td>
        <td width="400" colspan="40" nowrap="nowrap"><div align="center"><strong style="font-size: 13pt; color:blue">成形時間</strong></div></td>
        <td width="200" colspan="20" nowrap="nowrap"><div align="center"><strong style="font-size: 10pt; color:blue">生産ショット数</strong></div></td>
        <td width="200" colspan="20" nowrap="nowrap"><div align="center"><strong style="font-size: 10pt; color:blue">成形サイクル</strong></div></td>
      </tr>

  <?php
  $j = 1;
     for($i=1; $i<=${"n".$j}; $i++){//１号機
      if(null == ($this->request->getData('check'.$j.$i))){//削除のチェックがついていなかった場合
      ${"product_code".$i} = ${"arrP".$j.$i}[0]['product_code'];
      ${"hyoujistarting_tm".$i} = substr(${"arrP".$j.$i}[0]['starting_tm'], 0, 10)."T".substr(${"arrP".$j.$i}[0]['starting_tm'], 11, 5);
      ${"hyoujifinishing_tm".$i} = substr(${"arrP".$j.$i}[0]['finishing_tm'], 0, 10)."T".substr(${"arrP".$j.$i}[0]['finishing_tm'], 11, 5);

      echo "<pre>";
      print_r($j."---".$i."---");
      print_r(${"arrP".$j.$i});
      echo "</pre>";


          echo "<tr style='border-bottom: 0px;border-width: 0px'>\n";
          echo "<td rowspan='2' colspan='20' nowrap='nowrap'>\n";
          echo "<input type='text' value=${"product_code".$i} name=product_code".$j.$i." size='6'/>\n";
          echo "</td>\n";
          echo "<td colspan='3' nowrap='nowrap' style='border-bottom: 0px'><div align='center'><strong style='font-size: 15pt; color:blue'>\n";
          echo "開始";
          echo "</strong></div></td>\n";
          echo "<td colspan='37' nowrap='nowrap' style='border-bottom: 0px'><div align='center'>\n";
          echo "<input type='datetime-local' value=${"hyoujistarting_tm".$i} name=starting_tm".$j.$i." size='6'/>\n";
          echo "</div></td>\n";
          echo "<td rowspan='2' colspan='20' nowrap='nowrap'>\n";
          echo "<input type='text' name=amount_shot1_".$i." size='6'/>\n";
          echo "</td>\n";
          echo "<td rowspan='2'  height='6' colspan='20' nowrap='nowrap'>\n";
          echo "<input type='text' name=cycle_shot1_".$i." size='6'/>\n";
          echo "</td>\n";
          echo "</tr>\n";
          echo "</div></td>\n";
          echo "<tr style='border-bottom: 0px;border-width: 0px'>\n";
          echo "<td colspan='3' nowrap='nowrap'><div align='center'><strong style='font-size: 15pt; color:blue'>\n";
          echo "終了";
          echo "</strong></div></td>\n";
          echo "<td colspan='37'><div align='center'>\n";
          echo "<input type='datetime-local' value=${"hyoujifinishing_tm".$i} name=finishing_tm".$j.$i." size='6'/>\n";
          echo "</div></td>\n";
          echo "</tr>\n";
        }
      }
    echo $this->Form->hidden('n'.$j ,['value'=>${"n".$j}]);

  //以下追加または削除を押された場合
    if(null !== ($this->request->getData('tuika'.$j.$j))){//追加の場合
      ${"tuika".$j} = ${"tuika".$j} + 1;
      ${"ntuika".$j} = ${"n".$j} + ${"tuika".$j};
      echo $this->Form->hidden('ntuika'.$j ,['value'=>${"ntuika".$j}]);
    }elseif (null !== ($this->request->getData('sakujo'.$j.$j)) && ${"tuika".$j} != 0) {//追加後の追加取り消しの場合
      ${"tuika".$j} = ${"tuika".$j} - 1;
      ${"ntuika".$j} = ${"n".$j} + ${"tuika".$j};
      echo $this->Form->hidden('ntuika'.$j ,['value'=>${"ntuika".$j}]);
    }
      for($i=${"n".$j}+1; $i<=${"ntuika".$j}; $i++){
        if(null == ($this->request->getData('check'.$j.$i))){//削除のチェックがついていなかった場合
          $hyoujistarting_tm1 = substr(${"arrP".$j."1"}['starting_tm'], 0, 10)."T08:00";
          $hyoujifinishing_tm1 = substr(${"arrP".$j."1"}['finishing_tm'], 0, 10)."T08:00";

          echo "<tr style='border-bottom: 0px;border-width: 0px'>\n";
          echo "<td rowspan='2'  height='6' colspan='20' nowrap='nowrap'>\n";
          echo "<input type='text' name=product_code".$j.$i." size='6'/>\n";
          echo "</td>\n";
          echo "<td colspan='3' nowrap='nowrap' style='border-bottom: 0px'><div align='center'><strong style='font-size: 15pt; color:blue'>\n";
          echo "開始";
          echo "</strong></div></td>\n";
          echo "<td colspan='37' nowrap='nowrap' style='border-bottom: 0px'><div align='center'>\n";
          echo "<input type='datetime-local' value=$hyoujistarting_tm1 name=starting_tm".$j.$i." size='6'/>\n";
          echo "</div></td>\n";
          echo "<td rowspan='2' colspan='20' nowrap='nowrap'>\n";
          echo "<input type='text' name=yoteimaisu".$j.$i." size='6'/>\n";
          echo "</td>\n";
          echo "<td rowspan='2'  height='6' colspan='20' nowrap='nowrap'>\n";
          echo "<input type='text' value=1  name=hakoNo".$j.$i." size='6'/>\n";
          echo "</td>\n";
          echo "</tr>\n";
          echo "<tr style='border-bottom: 0px;border-width: 0px'>\n";
          echo "<td colspan='3' nowrap='nowrap'><div align='center'><strong style='font-size: 15pt; color:blue'>\n";
          echo "終了";
          echo "</strong></div></td>\n";
          echo "<td colspan='37'><div align='center'>\n";
          echo "<input type='datetime-local' value=$hyoujifinishing_tm1 name=finishing_tm".$j.$i." size='6'/>\n";
          echo "</div></td>\n";
          echo "</tr>\n";
        }
      }
   ?>
   <tr bgcolor="#E6FFFF" >
     <td width="550" colspan="40" nowrap="nowrap" bgcolor="#E6FFFF" style="border: none"><div align="center"><strong style="font-size: 15pt; color:blue"></strong></div></td>
     <td width="550" colspan="50" nowrap="nowrap" bgcolor="#E6FFFF" style="border: none"><div align="center"><strong style="font-size: 15pt; color:blue"></strong></div></td>
     <td align="right" rowspan="2" width="50" bgcolor="#E6FFFF" style="border: none"><div align="right"><?= $this->Form->control('追加', array('type'=>'submit', 'name' => 'tuika11', 'value'=>1, 'label'=>false)) ?></div></td>
     <td align="right" rowspan="2" width="50" bgcolor="#E6FFFF" style="border: none"><div align="right"><?= $this->Form->control('追加取り消し', array('type'=>'submit', 'name' => 'sakujo11', 'value'=>1, 'label'=>false)) ?></div></td>
   </tr>
  </table>
  <br>
  <?php   /*ここまで１号機*/    ?>


<?php   /*ここから１号機*/    ?>

<br>
<br>
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
  <tbody border="2" bordercolor="#E6FFFF" bgcolor="#ffc0cb" style="border-bottom: solid;border-width: 1px">
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
for($i=1; $i<=$tuika3; $i++){//３号機
      echo "<tr style='border-bottom: 0px;border-width: 0px'>\n";
      echo "<td rowspan='2'  height='6' colspan='20' nowrap='nowrap'>\n";
      echo "<input type='text' name=product_code3_".$i." size='6'/>\n";
      echo "</td>\n";
      echo "<td colspan='3' nowrap='nowrap' style='border-bottom: 0px'><div align='center'><strong style='font-size: 15pt; color:blue'>\n";
      echo "開始";
      echo "</strong></div></td>\n";
      echo "<td colspan='37' nowrap='nowrap' style='border-bottom: 0px'><div align='center'>\n";
      echo "<input type='datetime-local' value=$dateye name=starting_tm3_".$i." size='6'/>\n";
      echo "</div></td>\n";
      echo "<td rowspan='2' colspan='20' nowrap='nowrap'>\n";
      echo "<input type='text' name=amount_shot3_".$i." size='6'/>\n";
      echo "</td>\n";
      echo "<td rowspan='2'  height='6' colspan='20' nowrap='nowrap'>\n";
      echo "<input type='text' name=cycle_shot3_".$i." size='6'/>\n";
      echo "</td>\n";
      echo "</tr>\n";
      echo "<tr style='border-bottom: 0px;border-width: 0px'>\n";
      echo "<td colspan='3' nowrap='nowrap'><div align='center'><strong style='font-size: 15pt; color:blue'>\n";
      echo "終了";
      echo "</strong></div></td>\n";
      echo "<td colspan='37'><div align='center'>\n";
      echo "<input type='datetime-local' value=$dateto name=finishing_tm3_".$i." size='6'/>\n";
      echo "</div></td>\n";
      echo "</tr>\n";
  }
 ?>

 <tr bgcolor="#E6FFFF" >
   <td width="550" colspan="40" nowrap="nowrap" bgcolor="#E6FFFF" style="border: none"><div align="center"><strong style="font-size: 15pt; color:blue"></strong></div></td>
   <td width="550" colspan="50" nowrap="nowrap" bgcolor="#E6FFFF" style="border: none"><div align="center"><strong style="font-size: 15pt; color:blue"></strong></div></td>
   <td align="right" rowspan="2" width="50" bgcolor="#E6FFFF" style="border: none"><div align="right"><?= $this->Form->submit(__('追加'), array('name' => 'tuika33')); ?></div></td>
   <td align="right" rowspan="2" width="50" bgcolor="#E6FFFF" style="border: none"><div align="right"><?= $this->Form->submit(__('削除'), array('name' => 'sakujo33')); ?></div></td>
 </tr>
</table>

 <?php   /*ここから４号機*/    ?>

 <br>
 <table align="center" border="2" bordercolor="#E6FFFF" cellpadding="0" cellspacing="0">
   <caption style="text-align: left">４号機</caption>
   <tbody border="2" bordercolor="#E6FFFF" bgcolor="#ffc0cb" style="border-bottom: solid;border-width: 1px">
     <tr style="border-bottom: 0px;border-width: 0px">
       <td width="250" height="60" colspan="20" nowrap="nowrap"><div align="center"><strong style="font-size: 20pt; color:blue">品番</strong></div></td>
       <td width="500" colspan="40" nowrap="nowrap"><div align="center"><strong style="font-size: 15pt; color:blue">成形時間</strong></div></td>
       <td width="250" colspan="20" nowrap="nowrap"><div align="center"><strong style="font-size: 10pt; color:blue">生産ショット数</strong></div></td>
       <td width="250" colspan="20" nowrap="nowrap"><div align="center"><strong style="font-size: 10pt; color:blue">成形サイクル</strong></div></td>
     </tr>

 <?php
 for($i=1; $i<=$tuika4; $i++){//4号機
       echo "<tr style='border-bottom: 0px;border-width: 0px'>\n";
       echo "<td rowspan='2'  height='6' colspan='20' nowrap='nowrap'>\n";
       echo "<input type='text' name=product_code4_".$i." size='6'/>\n";
       echo "</td>\n";
       echo "<td colspan='3' nowrap='nowrap' style='border-bottom: 0px'><div align='center'><strong style='font-size: 15pt; color:blue'>\n";
       echo "開始";
       echo "</strong></div></td>\n";
       echo "<td colspan='37' nowrap='nowrap' style='border-bottom: 0px'><div align='center'>\n";
       echo "<input type='datetime-local' value=$dateye name=starting_tm4_".$i." size='6'/>\n";
       echo "</div></td>\n";
       echo "<td rowspan='2' colspan='20' nowrap='nowrap'>\n";
       echo "<input type='text' name=amount_shot4_".$i." size='6'/>\n";
       echo "</td>\n";
       echo "<td rowspan='2'  height='6' colspan='20' nowrap='nowrap'>\n";
       echo "<input type='text' name=cycle_shot4_".$i." size='6'/>\n";
       echo "</td>\n";
       echo "</tr>\n";
       echo "<tr style='border-bottom: 0px;border-width: 0px'>\n";
       echo "<td colspan='3' nowrap='nowrap'><div align='center'><strong style='font-size: 15pt; color:blue'>\n";
       echo "終了";
       echo "</strong></div></td>\n";
       echo "<td colspan='37'><div align='center'>\n";
       echo "<input type='datetime-local' value=$dateto name=finishing_tm4_".$i." size='6'/>\n";
       echo "</div></td>\n";
       echo "</tr>\n";
   }
  ?>

  <tr bgcolor="#E6FFFF" >
    <td width="550" colspan="40" nowrap="nowrap" bgcolor="#E6FFFF" style="border: none"><div align="center"><strong style="font-size: 15pt; color:blue"></strong></div></td>
    <td width="550" colspan="50" nowrap="nowrap" bgcolor="#E6FFFF" style="border: none"><div align="center"><strong style="font-size: 15pt; color:blue"></strong></div></td>
    <td align="right" rowspan="2" width="50" bgcolor="#E6FFFF" style="border: none"><div align="right"><?= $this->Form->submit(__('追加'), array('name' => 'tuika44')); ?></div></td>
    <td align="right" rowspan="2" width="50" bgcolor="#E6FFFF" style="border: none"><div align="right"><?= $this->Form->submit(__('削除'), array('name' => 'sakujo44')); ?></div></td>
  </tr>
</table>

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
for($i=1; $i<=$tuika5; $i++){//5号機
      echo "<tr style='border-bottom: 0px;border-width: 0px'>\n";
      echo "<td rowspan='2'  height='6' colspan='20' nowrap='nowrap'>\n";
      echo "<input type='text' name=product_code5_".$i." size='6'/>\n";
      echo "</td>\n";
      echo "<td colspan='3' nowrap='nowrap' style='border-bottom: 0px'><div align='center'><strong style='font-size: 15pt; color:blue'>\n";
      echo "開始";
      echo "</strong></div></td>\n";
      echo "<td colspan='37' nowrap='nowrap' style='border-bottom: 0px'><div align='center'>\n";
      echo "<input type='datetime-local' value=$dateye name=starting_tm5_".$i." size='6'/>\n";
      echo "</div></td>\n";
      echo "<td rowspan='2' colspan='20' nowrap='nowrap'>\n";
      echo "<input type='text' name=amount_shot5_".$i." size='6'/>\n";
      echo "</td>\n";
      echo "<td rowspan='2'  height='6' colspan='20' nowrap='nowrap'>\n";
      echo "<input type='text' name=cycle_shot5_".$i." size='6'/>\n";
      echo "</td>\n";
      echo "</tr>\n";
      echo "<tr style='border-bottom: 0px;border-width: 0px'>\n";
      echo "<td colspan='3' nowrap='nowrap'><div align='center'><strong style='font-size: 15pt; color:blue'>\n";
      echo "終了";
      echo "</strong></div></td>\n";
      echo "<td colspan='37'><div align='center'>\n";
      echo "<input type='datetime-local' value=$dateto name=finishing_tm5_".$i." size='6'/>\n";
      echo "</div></td>\n";
      echo "</tr>\n";
  }
 ?>

 <tr bgcolor="#E6FFFF" >
   <td width="550" colspan="40" nowrap="nowrap" bgcolor="#E6FFFF" style="border: none"><div align="center"><strong style="font-size: 15pt; color:blue"></strong></div></td>
   <td width="550" colspan="50" nowrap="nowrap" bgcolor="#E6FFFF" style="border: none"><div align="center"><strong style="font-size: 15pt; color:blue"></strong></div></td>
   <td align="right" rowspan="2" width="50" bgcolor="#E6FFFF" style="border: none"><div align="right"><?= $this->Form->submit(__('追加'), array('name' => 'tuika55')); ?></div></td>
   <td align="right" rowspan="2" width="50" bgcolor="#E6FFFF" style="border: none"><div align="right"><?= $this->Form->submit(__('削除'), array('name' => 'sakujo55')); ?></div></td>
 </tr>
</table>

<?php   /*ここから６号機*/    ?>

<br>
<table align="center" border="2" bordercolor="#E6FFFF" cellpadding="0" cellspacing="0">
  <caption style="text-align: left">６号機</caption>
  <tbody border="2" bordercolor="#E6FFFF" bgcolor="#ffc0cb" style="border-bottom: solid;border-width: 1px">
    <tr style="border-bottom: 0px;border-width: 0px">
      <td width="250" height="60" colspan="20" nowrap="nowrap"><div align="center"><strong style="font-size: 20pt; color:blue">品番</strong></div></td>
      <td width="500" colspan="40" nowrap="nowrap"><div align="center"><strong style="font-size: 15pt; color:blue">成形時間</strong></div></td>
      <td width="250" colspan="20" nowrap="nowrap"><div align="center"><strong style="font-size: 10pt; color:blue">生産ショット数</strong></div></td>
      <td width="250" colspan="20" nowrap="nowrap"><div align="center"><strong style="font-size: 10pt; color:blue">成形サイクル</strong></div></td>
    </tr>

<?php
for($i=1; $i<=$tuika6; $i++){//6号機
      echo "<tr style='border-bottom: 0px;border-width: 0px'>\n";
      echo "<td rowspan='2'  height='6' colspan='20' nowrap='nowrap'>\n";
      echo "<input type='text' name=product_code6_".$i." size='6'/>\n";
      echo "</td>\n";
      echo "<td colspan='3' nowrap='nowrap' style='border-bottom: 0px'><div align='center'><strong style='font-size: 15pt; color:blue'>\n";
      echo "開始";
      echo "</strong></div></td>\n";
      echo "<td colspan='37' nowrap='nowrap' style='border-bottom: 0px'><div align='center'>\n";
      echo "<input type='datetime-local' value=$dateye name=starting_tm6_".$i." size='6'/>\n";
      echo "</div></td>\n";
      echo "<td rowspan='2' colspan='20' nowrap='nowrap'>\n";
      echo "<input type='text' name=amount_shot6_".$i." size='6'/>\n";
      echo "</td>\n";
      echo "<td rowspan='2'  height='6' colspan='20' nowrap='nowrap'>\n";
      echo "<input type='text' name=cycle_shot6_".$i." size='6'/>\n";
      echo "</td>\n";
      echo "</tr>\n";
      echo "<tr style='border-bottom: 0px;border-width: 0px'>\n";
      echo "<td colspan='3' nowrap='nowrap'><div align='center'><strong style='font-size: 15pt; color:blue'>\n";
      echo "終了";
      echo "</strong></div></td>\n";
      echo "<td colspan='37'><div align='center'>\n";
      echo "<input type='datetime-local' value=$dateto name=finishing_tm6_".$i." size='6'/>\n";
      echo "</div></td>\n";
      echo "</tr>\n";
  }
 ?>

 <tr bgcolor="#E6FFFF" >
   <td width="550" colspan="40" nowrap="nowrap" bgcolor="#E6FFFF" style="border: none"><div align="center"><strong style="font-size: 15pt; color:blue"></strong></div></td>
   <td width="550" colspan="50" nowrap="nowrap" bgcolor="#E6FFFF" style="border: none"><div align="center"><strong style="font-size: 15pt; color:blue"></strong></div></td>
   <td align="right" rowspan="2" width="50" bgcolor="#E6FFFF" style="border: none"><div align="right"><?= $this->Form->submit(__('追加'), array('name' => 'tuika66')); ?></div></td>
   <td align="right" rowspan="2" width="50" bgcolor="#E6FFFF" style="border: none"><div align="right"><?= $this->Form->submit(__('削除'), array('name' => 'sakujo66')); ?></div></td>
 </tr>
</table>

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
for($i=1; $i<=$tuika7; $i++){//7号機
      echo "<tr style='border-bottom: 0px;border-width: 0px'>\n";
      echo "<td rowspan='2'  height='6' colspan='20' nowrap='nowrap'>\n";
      echo "<input type='text' name=product_code7_".$i." size='6'/>\n";
      echo "</td>\n";
      echo "<td colspan='3' nowrap='nowrap' style='border-bottom: 0px'><div align='center'><strong style='font-size: 15pt; color:blue'>\n";
      echo "開始";
      echo "</strong></div></td>\n";
      echo "<td colspan='37' nowrap='nowrap' style='border-bottom: 0px'><div align='center'>\n";
      echo "<input type='datetime-local' value=$dateye name=starting_tm7_".$i." size='6'/>\n";
      echo "</div></td>\n";
      echo "<td rowspan='2' colspan='20' nowrap='nowrap'>\n";
      echo "<input type='text' name=amount_shot7_".$i." size='6'/>\n";
      echo "</td>\n";
      echo "<td rowspan='2'  height='6' colspan='20' nowrap='nowrap'>\n";
      echo "<input type='text' name=cycle_shot7_".$i." size='6'/>\n";
      echo "</td>\n";
      echo "</tr>\n";
      echo "<tr style='border-bottom: 0px;border-width: 0px'>\n";
      echo "<td colspan='3' nowrap='nowrap'><div align='center'><strong style='font-size: 15pt; color:blue'>\n";
      echo "終了";
      echo "</strong></div></td>\n";
      echo "<td colspan='37'><div align='center'>\n";
      echo "<input type='datetime-local' value=$dateto name=finishing_tm7_".$i." size='6'/>\n";
      echo "</div></td>\n";
      echo "</tr>\n";
  }
 ?>

 <tr bgcolor="#E6FFFF" >
   <td width="550" colspan="40" nowrap="nowrap" bgcolor="#E6FFFF" style="border: none"><div align="center"><strong style="font-size: 15pt; color:blue"></strong></div></td>
   <td width="550" colspan="50" nowrap="nowrap" bgcolor="#E6FFFF" style="border: none"><div align="center"><strong style="font-size: 15pt; color:blue"></strong></div></td>
   <td align="right" rowspan="2" width="50" bgcolor="#E6FFFF" style="border: none"><div align="right"><?= $this->Form->submit(__('追加'), array('name' => 'tuika77')); ?></div></td>
   <td align="right" rowspan="2" width="50" bgcolor="#E6FFFF" style="border: none"><div align="right"><?= $this->Form->submit(__('削除'), array('name' => 'sakujo77')); ?></div></td>
 </tr>
</table>

<?php   /*ここから８号機*/    ?>

<br>
<table align="center" border="2" bordercolor="#E6FFFF" cellpadding="0" cellspacing="0">
  <caption style="text-align: left">８号機</caption>
  <tbody border="2" bordercolor="#E6FFFF" bgcolor="#ffc0cb" style="border-bottom: solid;border-width: 1px">
    <tr style="border-bottom: 0px;border-width: 0px">
      <td width="250" height="60" colspan="20" nowrap="nowrap"><div align="center"><strong style="font-size: 20pt; color:blue">品番</strong></div></td>
      <td width="500" colspan="40" nowrap="nowrap"><div align="center"><strong style="font-size: 15pt; color:blue">成形時間</strong></div></td>
      <td width="250" colspan="20" nowrap="nowrap"><div align="center"><strong style="font-size: 10pt; color:blue">生産ショット数</strong></div></td>
      <td width="250" colspan="20" nowrap="nowrap"><div align="center"><strong style="font-size: 10pt; color:blue">成形サイクル</strong></div></td>
    </tr>

<?php
for($i=1; $i<=$tuika8; $i++){//8号機
      echo "<tr style='border-bottom: 0px;border-width: 0px'>\n";
      echo "<td rowspan='2'  height='6' colspan='20' nowrap='nowrap'>\n";
      echo "<input type='text' name=product_code8_".$i." size='6'/>\n";
      echo "</td>\n";
      echo "<td colspan='3' nowrap='nowrap' style='border-bottom: 0px'><div align='center'><strong style='font-size: 15pt; color:blue'>\n";
      echo "開始";
      echo "</strong></div></td>\n";
      echo "<td colspan='37' nowrap='nowrap' style='border-bottom: 0px'><div align='center'>\n";
      echo "<input type='datetime-local' value=$dateye name=starting_tm8_".$i." size='6'/>\n";
      echo "</div></td>\n";
      echo "<td rowspan='2' colspan='20' nowrap='nowrap'>\n";
      echo "<input type='text' name=amount_shot8_".$i." size='6'/>\n";
      echo "</td>\n";
      echo "<td rowspan='2'  height='6' colspan='20' nowrap='nowrap'>\n";
      echo "<input type='text' name=cycle_shot8_".$i." size='6'/>\n";
      echo "</td>\n";
      echo "</tr>\n";
      echo "<tr style='border-bottom: 0px;border-width: 0px'>\n";
      echo "<td colspan='3' nowrap='nowrap'><div align='center'><strong style='font-size: 15pt; color:blue'>\n";
      echo "終了";
      echo "</strong></div></td>\n";
      echo "<td colspan='37'><div align='center'>\n";
      echo "<input type='datetime-local' value=$dateto name=finishing_tm8_".$i." size='6'/>\n";
      echo "</div></td>\n";
      echo "</tr>\n";
  }
 ?>

 <tr bgcolor="#E6FFFF" >
   <td width="550" colspan="40" nowrap="nowrap" bgcolor="#E6FFFF" style="border: none"><div align="center"><strong style="font-size: 15pt; color:blue"></strong></div></td>
   <td width="550" colspan="50" nowrap="nowrap" bgcolor="#E6FFFF" style="border: none"><div align="center"><strong style="font-size: 15pt; color:blue"></strong></div></td>
   <td align="right" rowspan="2" width="50" bgcolor="#E6FFFF" style="border: none"><div align="right"><?= $this->Form->submit(__('追加'), array('name' => 'tuika88')); ?></div></td>
   <td align="right" rowspan="2" width="50" bgcolor="#E6FFFF" style="border: none"><div align="right"><?= $this->Form->submit(__('削除'), array('name' => 'sakujo88')); ?></div></td>
 </tr>
</table>

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
for($i=1; $i<=$tuika9; $i++){//9号機
      echo "<tr style='border-bottom: 0px;border-width: 0px'>\n";
      echo "<td rowspan='2'  height='6' colspan='20' nowrap='nowrap'>\n";
      echo "<input type='text' name=product_code9_".$i." size='6'/>\n";
      echo "</td>\n";
      echo "<td colspan='3' nowrap='nowrap' style='border-bottom: 0px'><div align='center'><strong style='font-size: 15pt; color:blue'>\n";
      echo "開始";
      echo "</strong></div></td>\n";
      echo "<td colspan='37' nowrap='nowrap' style='border-bottom: 0px'><div align='center'>\n";
      echo "<input type='datetime-local' value=$dateye name=starting_tm9_".$i." size='6'/>\n";
      echo "</div></td>\n";
      echo "<td rowspan='2' colspan='20' nowrap='nowrap'>\n";
      echo "<input type='text' name=amount_shot9_".$i." size='6'/>\n";
      echo "</td>\n";
      echo "<td rowspan='2'  height='6' colspan='20' nowrap='nowrap'>\n";
      echo "<input type='text' name=cycle_shot9_".$i." size='6'/>\n";
      echo "</td>\n";
      echo "</tr>\n";
      echo "<tr style='border-bottom: 0px;border-width: 0px'>\n";
      echo "<td colspan='3' nowrap='nowrap'><div align='center'><strong style='font-size: 15pt; color:blue'>\n";
      echo "終了";
      echo "</strong></div></td>\n";
      echo "<td colspan='37'><div align='center'>\n";
      echo "<input type='datetime-local' value=$dateto name=finishing_tm9_".$i." size='6'/>\n";
      echo "</div></td>\n";
      echo "</tr>\n";
  }
 ?>

 <tr bgcolor="#E6FFFF" >
   <td width="550" colspan="40" nowrap="nowrap" bgcolor="#E6FFFF" style="border: none"><div align="center"><strong style="font-size: 15pt; color:blue"></strong></div></td>
   <td width="550" colspan="50" nowrap="nowrap" bgcolor="#E6FFFF" style="border: none"><div align="center"><strong style="font-size: 15pt; color:blue"></strong></div></td>
   <td align="right" rowspan="2" width="50" bgcolor="#E6FFFF" style="border: none"><div align="right"><?= $this->Form->submit(__('追加'), array('name' => 'tuika99')); ?></div></td>
   <td align="right" rowspan="2" width="50" bgcolor="#E6FFFF" style="border: none"><div align="right"><?= $this->Form->submit(__('削除'), array('name' => 'sakujo99')); ?></div></td>
 </tr>
</table>

<fieldset>
  <?= $this->Form->control('formset', array('type'=>'hidden', 'value'=>"1", 'label'=>false)) ?>
  <?= $this->Form->control('tuika1', array('type'=>'hidden', 'value'=>$tuika1, 'label'=>false)) ?>
  <?= $this->Form->control('tuika2', array('type'=>'hidden', 'value'=>$tuika2, 'label'=>false)) ?>
  <?= $this->Form->control('tuika3', array('type'=>'hidden', 'value'=>$tuika3, 'label'=>false)) ?>
  <?= $this->Form->control('tuika4', array('type'=>'hidden', 'value'=>$tuika4, 'label'=>false)) ?>
  <?= $this->Form->control('tuika5', array('type'=>'hidden', 'value'=>$tuika5, 'label'=>false)) ?>
  <?= $this->Form->control('tuika6', array('type'=>'hidden', 'value'=>$tuika6, 'label'=>false)) ?>
  <?= $this->Form->control('tuika7', array('type'=>'hidden', 'value'=>$tuika7, 'label'=>false)) ?>
  <?= $this->Form->control('tuika8', array('type'=>'hidden', 'value'=>$tuika8, 'label'=>false)) ?>
  <?= $this->Form->control('tuika9', array('type'=>'hidden', 'value'=>$tuika9, 'label'=>false)) ?>
  <?= $this->Form->control('dateye', array('type'=>'hidden', 'value'=>$dateye, 'label'=>false)) ?>
  <?= $this->Form->control('dateto', array('type'=>'hidden', 'value'=>$dateto, 'label'=>false)) ?>
</fieldset>

<p align="center"><?= $this->Form->button(__('確認'), array('name' => 'confirm', 'value'=>"1")) ?></p>


<br>
<br>
<br>



<?php else: //確認押したとき ?>

  <br>
  <br>
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
   $m1 = $m;
   $this->set('m1',$m1);//1行上の$roleをctpで使えるようにセット
/*
   echo "<pre>";
   print_r($_SESSION['karikadouseikei']);
   echo "</pre>";
*/
  ?>


 <table align="center" border="2" bordercolor="#E6FFFF" cellpadding="0" cellspacing="0">
   <caption style="text-align: left">２号機</caption>
   <tbody border="2" bordercolor="#E6FFFF" bgcolor="#ffc0cb" style="border-bottom: solid;border-width: 1px">
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
   ${"riron_shot2_".$i} = round(${"kadoujikan2_".$i}/${"cycle_shot2_".$i}, 0);
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
              'seikeiki' => 2,
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
  $m2 = $m;
  $this->set('m2',$m2);//1行上の$roleをctpで使えるようにセット

   ?>

 </table>
  <br>
  <br>

  <table align="center" border="2" bordercolor="#E6FFFF" cellpadding="0" cellspacing="0">
    <caption style="text-align: left">３号機</caption>
    <tbody border="2" bordercolor="#E6FFFF" bgcolor="#FFFFCC" style="border-bottom: solid;border-width: 1px">
      <tr style="border-bottom: 0px;border-width: 0px">
        <td width="250" height="60" colspan="10" nowrap="nowrap"><div align="center"><strong style="font-size: 20pt; color:blue">品番</strong></div></td>
        <td width="200" colspan="10" nowrap="nowrap"><div align="center"><strong style="font-size: 15pt; color:blue">成形時間</strong></div></td>
        <td width="200" colspan="10" nowrap="nowrap"><div align="center"><strong style="font-size: 15pt; color:blue">ショット数</strong></div></td>
        <td width="200" colspan="10" nowrap="nowrap"><div align="center"><strong style="font-size: 15pt; color:blue">理論ショット数</strong></div></td>
        <td width="200" colspan="10" nowrap="nowrap"><div align="center"><strong style="font-size: 15pt; color:blue">達成率</strong></div></td>
      </tr>


  <?php
  for($i=1; $i<=$tuika3; $i++){//3号機
    ${"amount_shot3_".$i} = $this->request->getData("amount_shot3_{$i}");
    ${"cycle_shot3_".$i} = $this->request->getData("cycle_shot3_{$i}");
    ${"starting_tm3_".$i} = strtotime($this->request->getData("starting_tm3_{$i}"));
    ${"kadoujikan3_".$i} = ((strtotime($this->request->getData("finishing_tm3_{$i}")) - strtotime($this->request->getData("starting_tm3_{$i}"))));
    ${"riron_shot3_".$i} = round(${"kadoujikan3_".$i}/${"cycle_shot3_".$i}, 0);
    ${"accomp_rate3_".$i} = round(100*${"amount_shot3_".$i}/${"riron_shot3_".$i}, 0);
        echo "<tr style='border-bottom: 0px;border-width: 0px'>\n";
        echo "<td rowspan='2'  height='10' colspan='10' nowrap='nowrap' style='font-size: 18pt'><div align='center'>\n";
        echo $this->request->getData("product_code3_{$i}");
        echo "</div></td>\n";
        echo "</strong></div></td>\n";
        echo "<td colspan='10' nowrap='nowrap' style='font-size: 18pt'><div align='center'>\n";
        echo ${"kadoujikan3_".$i}/3600;
        echo "</div></td>\n";
        echo "<td rowspan='2' colspan='10' nowrap='nowrap' style='font-size: 18pt'><div align='center'>\n";
        echo $this->request->getData("amount_shot3_{$i}");
        echo "</div></td>\n";
        echo "<td rowspan='2'  height='6' colspan='10' nowrap='nowrap' style='font-size: 18pt'><div align='center'>\n";
        echo ${"riron_shot3_".$i};
        echo "</div></td>\n";
        echo "<td rowspan='2'  height='6' colspan='10' nowrap='nowrap'><div align='center' style='font-size: 18pt; color:red'>\n";
        echo ${"accomp_rate3_".$i}."%";
        echo "</div></td>\n";
        echo "</tr>\n";
        echo "<tr style='border-bottom: 0px;border-width: 0px'>\n";
        echo "</tr>\n";
    }
   ?>

   <?php
   for($n=1; $n<=$tuika3; $n++){
     $m = $m + 1;
     ${"starting_tm3_".$n} = substr($_POST["starting_tm3_{$n}"], 0, 10)." ".substr($_POST["starting_tm3_{$n}"], 11, 5);
     ${"finishing_tm3_".$n} = substr($_POST["finishing_tm3_{$n}"], 0, 10)." ".substr($_POST["finishing_tm3_{$n}"], 11, 5);
           $resultArray = Array();
             $_SESSION['karikadouseikei'][$m] = array(
               'product_code' => $_POST["product_code3_{$n}"],
               'seikeiki' => 3,
               'seikeiki_code' => "",
               'starting_tm' => ${"starting_tm3_".$n},
               'finishing_tm' => ${"finishing_tm3_".$n},
               'cycle_shot' => $_POST["cycle_shot3_{$n}"],
               'amount_shot' => $_POST["amount_shot3_{$n}"],
               'accomp_rate' => ${"accomp_rate3_".$n},
               "present_kensahyou" => 0,
             );
   }
   $this->set('m',$m);//1行上の$roleをctpで使えるようにセット
   $m3 = $m;
   $this->set('m3',$m3);//1行上の$roleをctpで使えるようにセット

    ?>

  </table>
  <br>

  <br>
  <table align="center" border="2" bordercolor="#E6FFFF" cellpadding="0" cellspacing="0">
    <caption style="text-align: left">４号機</caption>
    <tbody border="2" bordercolor="#E6FFFF" bgcolor="#ffc0cb" style="border-bottom: solid;border-width: 1px">
      <tr style="border-bottom: 0px;border-width: 0px">
        <td width="250" height="60" colspan="10" nowrap="nowrap"><div align="center"><strong style="font-size: 20pt; color:blue">品番</strong></div></td>
        <td width="200" colspan="10" nowrap="nowrap"><div align="center"><strong style="font-size: 15pt; color:blue">成形時間</strong></div></td>
        <td width="200" colspan="10" nowrap="nowrap"><div align="center"><strong style="font-size: 15pt; color:blue">ショット数</strong></div></td>
        <td width="200" colspan="10" nowrap="nowrap"><div align="center"><strong style="font-size: 15pt; color:blue">理論ショット数</strong></div></td>
        <td width="200" colspan="10" nowrap="nowrap"><div align="center"><strong style="font-size: 15pt; color:blue">達成率</strong></div></td>
      </tr>


  <?php
  for($i=1; $i<=$tuika4; $i++){//4号機
    ${"amount_shot4_".$i} = $this->request->getData("amount_shot4_{$i}");
    ${"cycle_shot4_".$i} = $this->request->getData("cycle_shot4_{$i}");
    ${"starting_tm4_".$i} = strtotime($this->request->getData("starting_tm4_{$i}"));
    ${"kadoujikan4_".$i} = ((strtotime($this->request->getData("finishing_tm4_{$i}")) - strtotime($this->request->getData("starting_tm4_{$i}"))));
    ${"riron_shot4_".$i} = round(${"kadoujikan4_".$i}/${"cycle_shot4_".$i}, 0);
    ${"accomp_rate4_".$i} = round(100*${"amount_shot4_".$i}/${"riron_shot4_".$i}, 0);
        echo "<tr style='border-bottom: 0px;border-width: 0px'>\n";
        echo "<td rowspan='2'  height='10' colspan='10' nowrap='nowrap' style='font-size: 18pt'><div align='center'>\n";
        echo $this->request->getData("product_code4_{$i}");
        echo "</div></td>\n";
        echo "</strong></div></td>\n";
        echo "<td colspan='10' nowrap='nowrap' style='font-size: 18pt'><div align='center'>\n";
        echo ${"kadoujikan4_".$i}/3600;
        echo "</div></td>\n";
        echo "<td rowspan='2' colspan='10' nowrap='nowrap' style='font-size: 18pt'><div align='center'>\n";
        echo $this->request->getData("amount_shot4_{$i}");
        echo "</div></td>\n";
        echo "<td rowspan='2'  height='6' colspan='10' nowrap='nowrap' style='font-size: 18pt'><div align='center'>\n";
        echo ${"riron_shot4_".$i};
        echo "</div></td>\n";
        echo "<td rowspan='2'  height='6' colspan='10' nowrap='nowrap'><div align='center' style='font-size: 18pt; color:red'>\n";
        echo ${"accomp_rate4_".$i}."%";
        echo "</div></td>\n";
        echo "</tr>\n";
        echo "<tr style='border-bottom: 0px;border-width: 0px'>\n";
        echo "</tr>\n";
    }
   ?>

   <?php
   for($n=1; $n<=$tuika4; $n++){
     $m = $m + 1;
     ${"starting_tm4_".$n} = substr($_POST["starting_tm4_{$n}"], 0, 10)." ".substr($_POST["starting_tm4_{$n}"], 11, 5);
     ${"finishing_tm4_".$n} = substr($_POST["finishing_tm4_{$n}"], 0, 10)." ".substr($_POST["finishing_tm4_{$n}"], 11, 5);
           $resultArray = Array();
             $_SESSION['karikadouseikei'][$m] = array(
               'product_code' => $_POST["product_code4_{$n}"],
               'seikeiki' => 4,
               'seikeiki_code' => "",
               'starting_tm' => ${"starting_tm4_".$n},
               'finishing_tm' => ${"finishing_tm4_".$n},
               'cycle_shot' => $_POST["cycle_shot4_{$n}"],
               'amount_shot' => $_POST["amount_shot4_{$n}"],
               'accomp_rate' => ${"accomp_rate4_".$n},
               "present_kensahyou" => 0,
             );
   }
   $this->set('m',$m);//1行上の$roleをctpで使えるようにセット
   $m4 = $m;
   $this->set('m4',$m4);//1行上の$roleをctpで使えるようにセット

    ?>

  </table>
  <br>
  <br>
<table align="center" border="2" bordercolor="#E6FFFF" cellpadding="0" cellspacing="0">
    <caption style="text-align: left">５号機</caption>
    <tbody border="2" bordercolor="#E6FFFF" bgcolor="#FFFFCC" style="border-bottom: solid;border-width: 1px">
      <tr style="border-bottom: 0px;border-width: 0px">
        <td width="250" height="60" colspan="10" nowrap="nowrap"><div align="center"><strong style="font-size: 20pt; color:blue">品番</strong></div></td>
        <td width="200" colspan="10" nowrap="nowrap"><div align="center"><strong style="font-size: 15pt; color:blue">成形時間</strong></div></td>
        <td width="200" colspan="10" nowrap="nowrap"><div align="center"><strong style="font-size: 15pt; color:blue">ショット数</strong></div></td>
        <td width="200" colspan="10" nowrap="nowrap"><div align="center"><strong style="font-size: 15pt; color:blue">理論ショット数</strong></div></td>
        <td width="200" colspan="10" nowrap="nowrap"><div align="center"><strong style="font-size: 15pt; color:blue">達成率</strong></div></td>
      </tr>


  <?php
  for($i=1; $i<=$tuika5; $i++){//５号機
    ${"amount_shot5_".$i} = $this->request->getData("amount_shot5_{$i}");
    ${"cycle_shot5_".$i} = $this->request->getData("cycle_shot5_{$i}");
    ${"starting_tm5_".$i} = strtotime($this->request->getData("starting_tm5_{$i}"));
    ${"kadoujikan5_".$i} = ((strtotime($this->request->getData("finishing_tm5_{$i}")) - strtotime($this->request->getData("starting_tm5_{$i}"))));
    ${"riron_shot5_".$i} = round(${"kadoujikan5_".$i}/${"cycle_shot5_".$i}, 0);
    ${"accomp_rate5_".$i} = round(100*${"amount_shot5_".$i}/${"riron_shot5_".$i}, 0);
        echo "<tr style='border-bottom: 0px;border-width: 0px'>\n";
        echo "<td rowspan='2'  height='10' colspan='10' nowrap='nowrap' style='font-size: 18pt'><div align='center'>\n";
        echo $this->request->getData("product_code5_{$i}");
        echo "</div></td>\n";
        echo "</strong></div></td>\n";
        echo "<td colspan='10' nowrap='nowrap' style='font-size: 18pt'><div align='center'>\n";
        echo ${"kadoujikan5_".$i}/3600;
        echo "</div></td>\n";
        echo "<td rowspan='2' colspan='10' nowrap='nowrap' style='font-size: 18pt'><div align='center'>\n";
        echo $this->request->getData("amount_shot5_{$i}");
        echo "</div></td>\n";
        echo "<td rowspan='2'  height='6' colspan='10' nowrap='nowrap' style='font-size: 18pt'><div align='center'>\n";
        echo ${"riron_shot5_".$i};
        echo "</div></td>\n";
        echo "<td rowspan='2'  height='6' colspan='10' nowrap='nowrap'><div align='center' style='font-size: 18pt; color:red'>\n";
        echo ${"accomp_rate5_".$i}."%";
        echo "</div></td>\n";
        echo "</tr>\n";
        echo "<tr style='border-bottom: 0px;border-width: 0px'>\n";
        echo "</tr>\n";
    }
   ?>

   <?php
   for($n=1; $n<=$tuika5; $n++){
     $m = $m + 1;
     ${"starting_tm5_".$n} = substr($_POST["starting_tm5_{$n}"], 0, 10)." ".substr($_POST["starting_tm5_{$n}"], 11, 5);
     ${"finishing_tm5_".$n} = substr($_POST["finishing_tm5_{$n}"], 0, 10)." ".substr($_POST["finishing_tm5_{$n}"], 11, 5);
           $resultArray = Array();
             $_SESSION['karikadouseikei'][$m] = array(
               'product_code' => $_POST["product_code5_{$n}"],
               'seikeiki' => 5,
               'seikeiki_code' => "",
               'starting_tm' => ${"starting_tm5_".$n},
               'finishing_tm' => ${"finishing_tm5_".$n},
               'cycle_shot' => $_POST["cycle_shot5_{$n}"],
               'amount_shot' => $_POST["amount_shot5_{$n}"],
               'accomp_rate' => ${"accomp_rate5_".$n},
               "present_kensahyou" => 0,
             );
   }
   $this->set('m',$m);//1行上の$roleをctpで使えるようにセット
   $m5 = $m;
   $this->set('m5',$m5);//1行上の$roleをctpで使えるようにセット

    ?>

  </table>

  <br>
  <br>
  <table align="center" border="2" bordercolor="#E6FFFF" cellpadding="0" cellspacing="0">
    <caption style="text-align: left">６号機</caption>
    <tbody border="2" bordercolor="#E6FFFF" bgcolor="#ffc0cb" style="border-bottom: solid;border-width: 1px">
      <tr style="border-bottom: 0px;border-width: 0px">
        <td width="250" height="60" colspan="10" nowrap="nowrap"><div align="center"><strong style="font-size: 20pt; color:blue">品番</strong></div></td>
        <td width="200" colspan="10" nowrap="nowrap"><div align="center"><strong style="font-size: 15pt; color:blue">成形時間</strong></div></td>
        <td width="200" colspan="10" nowrap="nowrap"><div align="center"><strong style="font-size: 15pt; color:blue">ショット数</strong></div></td>
        <td width="200" colspan="10" nowrap="nowrap"><div align="center"><strong style="font-size: 15pt; color:blue">理論ショット数</strong></div></td>
        <td width="200" colspan="10" nowrap="nowrap"><div align="center"><strong style="font-size: 15pt; color:blue">達成率</strong></div></td>
      </tr>


  <?php
  for($i=1; $i<=$tuika6; $i++){//６号機
    ${"amount_shot6_".$i} = $this->request->getData("amount_shot6_{$i}");
    ${"cycle_shot6_".$i} = $this->request->getData("cycle_shot6_{$i}");
    ${"starting_tm6_".$i} = strtotime($this->request->getData("starting_tm6_{$i}"));
    ${"kadoujikan6_".$i} = ((strtotime($this->request->getData("finishing_tm6_{$i}")) - strtotime($this->request->getData("starting_tm6_{$i}"))));
    ${"riron_shot6_".$i} = round(${"kadoujikan6_".$i}/${"cycle_shot6_".$i}, 0);
    ${"accomp_rate6_".$i} = round(100*${"amount_shot6_".$i}/${"riron_shot6_".$i}, 0);
        echo "<tr style='border-bottom: 0px;border-width: 0px'>\n";
        echo "<td rowspan='2'  height='10' colspan='10' nowrap='nowrap' style='font-size: 18pt'><div align='center'>\n";
        echo $this->request->getData("product_code6_{$i}");
        echo "</div></td>\n";
        echo "</strong></div></td>\n";
        echo "<td colspan='10' nowrap='nowrap' style='font-size: 18pt'><div align='center'>\n";
        echo ${"kadoujikan6_".$i}/3600;
        echo "</div></td>\n";
        echo "<td rowspan='2' colspan='10' nowrap='nowrap' style='font-size: 18pt'><div align='center'>\n";
        echo $this->request->getData("amount_shot6_{$i}");
        echo "</div></td>\n";
        echo "<td rowspan='2'  height='6' colspan='10' nowrap='nowrap' style='font-size: 18pt'><div align='center'>\n";
        echo ${"riron_shot6_".$i};
        echo "</div></td>\n";
        echo "<td rowspan='2'  height='6' colspan='10' nowrap='nowrap'><div align='center' style='font-size: 18pt; color:red'>\n";
        echo ${"accomp_rate6_".$i}."%";
        echo "</div></td>\n";
        echo "</tr>\n";
        echo "<tr style='border-bottom: 0px;border-width: 0px'>\n";
        echo "</tr>\n";
    }
   ?>

   <?php
   for($n=1; $n<=$tuika6; $n++){
     $m = $m + 1;
     ${"starting_tm6_".$n} = substr($_POST["starting_tm6_{$n}"], 0, 10)." ".substr($_POST["starting_tm6_{$n}"], 11, 6);
     ${"finishing_tm6_".$n} = substr($_POST["finishing_tm6_{$n}"], 0, 10)." ".substr($_POST["finishing_tm6_{$n}"], 11, 6);
           $resultArray = Array();
             $_SESSION['karikadouseikei'][$m] = array(
               'product_code' => $_POST["product_code6_{$n}"],
               'seikeiki' => 6,
               'seikeiki_code' => "",
               'starting_tm' => ${"starting_tm6_".$n},
               'finishing_tm' => ${"finishing_tm6_".$n},
               'cycle_shot' => $_POST["cycle_shot6_{$n}"],
               'amount_shot' => $_POST["amount_shot6_{$n}"],
               'accomp_rate' => ${"accomp_rate6_".$n},
               "present_kensahyou" => 0,
             );
   }
   $this->set('m',$m);//1行上の$roleをctpで使えるようにセット
   $m6 = $m;
   $this->set('m6',$m6);//1行上の$roleをctpで使えるようにセット

    ?>

  </table>
  <br>

  <br>
  <table align="center" border="2" bordercolor="#E6FFFF" cellpadding="0" cellspacing="0">
    <caption style="text-align: left">７号機</caption>
    <tbody border="2" bordercolor="#E6FFFF" bgcolor="#FFFFCC" style="border-bottom: solid;border-width: 1px">
      <tr style="border-bottom: 0px;border-width: 0px">
        <td width="250" height="60" colspan="10" nowrap="nowrap"><div align="center"><strong style="font-size: 20pt; color:blue">品番</strong></div></td>
        <td width="200" colspan="10" nowrap="nowrap"><div align="center"><strong style="font-size: 15pt; color:blue">成形時間</strong></div></td>
        <td width="200" colspan="10" nowrap="nowrap"><div align="center"><strong style="font-size: 15pt; color:blue">ショット数</strong></div></td>
        <td width="200" colspan="10" nowrap="nowrap"><div align="center"><strong style="font-size: 15pt; color:blue">理論ショット数</strong></div></td>
        <td width="200" colspan="10" nowrap="nowrap"><div align="center"><strong style="font-size: 15pt; color:blue">達成率</strong></div></td>
      </tr>


  <?php
  for($i=1; $i<=$tuika7; $i++){//7号機
    ${"amount_shot7_".$i} = $this->request->getData("amount_shot7_{$i}");
    ${"cycle_shot7_".$i} = $this->request->getData("cycle_shot7_{$i}");
    ${"starting_tm7_".$i} = strtotime($this->request->getData("starting_tm7_{$i}"));
    ${"kadoujikan7_".$i} = ((strtotime($this->request->getData("finishing_tm7_{$i}")) - strtotime($this->request->getData("starting_tm7_{$i}"))));
    ${"riron_shot7_".$i} = round(${"kadoujikan7_".$i}/${"cycle_shot7_".$i}, 0);
    ${"accomp_rate7_".$i} = round(100*${"amount_shot7_".$i}/${"riron_shot7_".$i}, 0);
        echo "<tr style='border-bottom: 0px;border-width: 0px'>\n";
        echo "<td rowspan='2'  height='10' colspan='10' nowrap='nowrap' style='font-size: 18pt'><div align='center'>\n";
        echo $this->request->getData("product_code7_{$i}");
        echo "</div></td>\n";
        echo "</strong></div></td>\n";
        echo "<td colspan='10' nowrap='nowrap' style='font-size: 18pt'><div align='center'>\n";
        echo ${"kadoujikan7_".$i}/3600;
        echo "</div></td>\n";
        echo "<td rowspan='2' colspan='10' nowrap='nowrap' style='font-size: 18pt'><div align='center'>\n";
        echo $this->request->getData("amount_shot7_{$i}");
        echo "</div></td>\n";
        echo "<td rowspan='2'  height='6' colspan='10' nowrap='nowrap' style='font-size: 18pt'><div align='center'>\n";
        echo ${"riron_shot7_".$i};
        echo "</div></td>\n";
        echo "<td rowspan='2'  height='6' colspan='10' nowrap='nowrap'><div align='center' style='font-size: 18pt; color:red'>\n";
        echo ${"accomp_rate7_".$i}."%";
        echo "</div></td>\n";
        echo "</tr>\n";
        echo "<tr style='border-bottom: 0px;border-width: 0px'>\n";
        echo "</tr>\n";
    }
   ?>

   <?php
   for($n=1; $n<=$tuika7; $n++){
     $m = $m + 1;
     ${"starting_tm7_".$n} = substr($_POST["starting_tm7_{$n}"], 0, 10)." ".substr($_POST["starting_tm7_{$n}"], 11, 5);
     ${"finishing_tm7_".$n} = substr($_POST["finishing_tm7_{$n}"], 0, 10)." ".substr($_POST["finishing_tm7_{$n}"], 11, 5);
           $resultArray = Array();
             $_SESSION['karikadouseikei'][$m] = array(
               'product_code' => $_POST["product_code7_{$n}"],
               'seikeiki' => 7,
               'seikeiki_code' => "",
               'starting_tm' => ${"starting_tm7_".$n},
               'finishing_tm' => ${"finishing_tm7_".$n},
               'cycle_shot' => $_POST["cycle_shot7_{$n}"],
               'amount_shot' => $_POST["amount_shot7_{$n}"],
               'accomp_rate' => ${"accomp_rate7_".$n},
               "present_kensahyou" => 0,
             );
   }
   $this->set('m',$m);//1行上の$roleをctpで使えるようにセット
   $m7 = $m;
   $this->set('m7',$m7);//1行上の$roleをctpで使えるようにセット

    ?>

  </table>
  <br>
<br>
  <table align="center" border="2" bordercolor="#E6FFFF" cellpadding="0" cellspacing="0">
    <caption style="text-align: left">８号機</caption>
    <tbody border="2" bordercolor="#E6FFFF" bgcolor="#ffc0cb" style="border-bottom: solid;border-width: 1px">
      <tr style="border-bottom: 0px;border-width: 0px">
        <td width="250" height="60" colspan="10" nowrap="nowrap"><div align="center"><strong style="font-size: 20pt; color:blue">品番</strong></div></td>
        <td width="200" colspan="10" nowrap="nowrap"><div align="center"><strong style="font-size: 15pt; color:blue">成形時間</strong></div></td>
        <td width="200" colspan="10" nowrap="nowrap"><div align="center"><strong style="font-size: 15pt; color:blue">ショット数</strong></div></td>
        <td width="200" colspan="10" nowrap="nowrap"><div align="center"><strong style="font-size: 15pt; color:blue">理論ショット数</strong></div></td>
        <td width="200" colspan="10" nowrap="nowrap"><div align="center"><strong style="font-size: 15pt; color:blue">達成率</strong></div></td>
      </tr>


  <?php
  for($i=1; $i<=$tuika8; $i++){//8号機
    ${"amount_shot8_".$i} = $this->request->getData("amount_shot8_{$i}");
    ${"cycle_shot8_".$i} = $this->request->getData("cycle_shot8_{$i}");
    ${"starting_tm8_".$i} = strtotime($this->request->getData("starting_tm8_{$i}"));
    ${"kadoujikan8_".$i} = ((strtotime($this->request->getData("finishing_tm8_{$i}")) - strtotime($this->request->getData("starting_tm8_{$i}"))));
    ${"riron_shot8_".$i} = round(${"kadoujikan8_".$i}/${"cycle_shot8_".$i}, 0);
    ${"accomp_rate8_".$i} = round(100*${"amount_shot8_".$i}/${"riron_shot8_".$i}, 0);
        echo "<tr style='border-bottom: 0px;border-width: 0px'>\n";
        echo "<td rowspan='2'  height='10' colspan='10' nowrap='nowrap' style='font-size: 18pt'><div align='center'>\n";
        echo $this->request->getData("product_code8_{$i}");
        echo "</div></td>\n";
        echo "</strong></div></td>\n";
        echo "<td colspan='10' nowrap='nowrap' style='font-size: 18pt'><div align='center'>\n";
        echo ${"kadoujikan8_".$i}/3600;
        echo "</div></td>\n";
        echo "<td rowspan='2' colspan='10' nowrap='nowrap' style='font-size: 18pt'><div align='center'>\n";
        echo $this->request->getData("amount_shot8_{$i}");
        echo "</div></td>\n";
        echo "<td rowspan='2'  height='6' colspan='10' nowrap='nowrap' style='font-size: 18pt'><div align='center'>\n";
        echo ${"riron_shot8_".$i};
        echo "</div></td>\n";
        echo "<td rowspan='2'  height='6' colspan='10' nowrap='nowrap'><div align='center' style='font-size: 18pt; color:red'>\n";
        echo ${"accomp_rate8_".$i}."%";
        echo "</div></td>\n";
        echo "</tr>\n";
        echo "<tr style='border-bottom: 0px;border-width: 0px'>\n";
        echo "</tr>\n";
    }
   ?>

   <?php
   for($n=1; $n<=$tuika8; $n++){
     $m = $m + 1;
     ${"starting_tm8_".$n} = substr($_POST["starting_tm8_{$n}"], 0, 10)." ".substr($_POST["starting_tm8_{$n}"], 11, 5);
     ${"finishing_tm8_".$n} = substr($_POST["finishing_tm8_{$n}"], 0, 10)." ".substr($_POST["finishing_tm8_{$n}"], 11, 5);
           $resultArray = Array();
             $_SESSION['karikadouseikei'][$m] = array(
               'product_code' => $_POST["product_code8_{$n}"],
               'seikeiki' => 8,
               'seikeiki_code' => "",
               'starting_tm' => ${"starting_tm8_".$n},
               'finishing_tm' => ${"finishing_tm8_".$n},
               'cycle_shot' => $_POST["cycle_shot8_{$n}"],
               'amount_shot' => $_POST["amount_shot8_{$n}"],
               'accomp_rate' => ${"accomp_rate8_".$n},
               "present_kensahyou" => 0,
             );
   }
   $this->set('m',$m);//1行上の$roleをctpで使えるようにセット
   $m8 = $m;
   $this->set('m8',$m8);//1行上の$roleをctpで使えるようにセット

    ?>

  </table>
  <br>
<br>
  <table align="center" border="2" bordercolor="#E6FFFF" cellpadding="0" cellspacing="0">
    <caption style="text-align: left">９号機</caption>
    <tbody border="2" bordercolor="#E6FFFF" bgcolor="#FFFFCC" style="border-bottom: solid;border-width: 1px">
      <tr style="border-bottom: 0px;border-width: 0px">
        <td width="250" height="60" colspan="10" nowrap="nowrap"><div align="center"><strong style="font-size: 20pt; color:blue">品番</strong></div></td>
        <td width="200" colspan="10" nowrap="nowrap"><div align="center"><strong style="font-size: 15pt; color:blue">成形時間</strong></div></td>
        <td width="200" colspan="10" nowrap="nowrap"><div align="center"><strong style="font-size: 15pt; color:blue">ショット数</strong></div></td>
        <td width="200" colspan="10" nowrap="nowrap"><div align="center"><strong style="font-size: 15pt; color:blue">理論ショット数</strong></div></td>
        <td width="200" colspan="10" nowrap="nowrap"><div align="center"><strong style="font-size: 15pt; color:blue">達成率</strong></div></td>
      </tr>


  <?php
  for($i=1; $i<=$tuika9; $i++){//9号機
    ${"amount_shot9_".$i} = $this->request->getData("amount_shot9_{$i}");
    ${"cycle_shot9_".$i} = $this->request->getData("cycle_shot9_{$i}");
    ${"starting_tm9_".$i} = strtotime($this->request->getData("starting_tm9_{$i}"));
    ${"kadoujikan9_".$i} = ((strtotime($this->request->getData("finishing_tm9_{$i}")) - strtotime($this->request->getData("starting_tm9_{$i}"))));
    ${"riron_shot9_".$i} = round(${"kadoujikan9_".$i}/${"cycle_shot9_".$i}, 0);
    ${"accomp_rate9_".$i} = round(100*${"amount_shot9_".$i}/${"riron_shot9_".$i}, 0);
        echo "<tr style='border-bottom: 0px;border-width: 0px'>\n";
        echo "<td rowspan='2'  height='10' colspan='10' nowrap='nowrap' style='font-size: 18pt'><div align='center'>\n";
        echo $this->request->getData("product_code9_{$i}");
        echo "</div></td>\n";
        echo "</strong></div></td>\n";
        echo "<td colspan='10' nowrap='nowrap' style='font-size: 18pt'><div align='center'>\n";
        echo ${"kadoujikan9_".$i}/3600;
        echo "</div></td>\n";
        echo "<td rowspan='2' colspan='10' nowrap='nowrap' style='font-size: 18pt'><div align='center'>\n";
        echo $this->request->getData("amount_shot9_{$i}");
        echo "</div></td>\n";
        echo "<td rowspan='2'  height='6' colspan='10' nowrap='nowrap' style='font-size: 18pt'><div align='center'>\n";
        echo ${"riron_shot9_".$i};
        echo "</div></td>\n";
        echo "<td rowspan='2'  height='6' colspan='10' nowrap='nowrap'><div align='center' style='font-size: 18pt; color:red'>\n";
        echo ${"accomp_rate9_".$i}."%";
        echo "</div></td>\n";
        echo "</tr>\n";
        echo "<tr style='border-bottom: 0px;border-width: 0px'>\n";
        echo "</tr>\n";
    }
   ?>

   <?php
   for($n=1; $n<=$tuika9; $n++){
     $m = $m + 1;
     ${"starting_tm9_".$n} = substr($_POST["starting_tm9_{$n}"], 0, 10)." ".substr($_POST["starting_tm9_{$n}"], 11, 5);
     ${"finishing_tm9_".$n} = substr($_POST["finishing_tm9_{$n}"], 0, 10)." ".substr($_POST["finishing_tm9_{$n}"], 11, 5);
           $resultArray = Array();
             $_SESSION['karikadouseikei'][$m] = array(
               'product_code' => $_POST["product_code9_{$n}"],
               'seikeiki' => 9,
               'seikeiki_code' => "",
               'starting_tm' => ${"starting_tm9_".$n},
               'finishing_tm' => ${"finishing_tm9_".$n},
               'cycle_shot' => $_POST["cycle_shot9_{$n}"],
               'amount_shot' => $_POST["amount_shot9_{$n}"],
               'accomp_rate' => ${"accomp_rate9_".$n},
               "present_kensahyou" => 0,
             );
   }
   $this->set('m',$m);//1行上の$roleをctpで使えるようにセット
   $m9 = $m;
   $this->set('m9',$m9);//1行上の$roleをctpで使えるようにセット

    ?>

  </table>

  <br>
  <br>

  <p align="center"><?= $this->Form->button(__('登録'), array('name' => 'touroku', 'value'=>"1")) ?></p>


<?php endif; ?>
