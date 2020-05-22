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

<br>

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

          echo "<tr style='border-bottom: 0px;border-width: 0px'>\n";
          echo "<td rowspan='2' colspan='20' nowrap='nowrap'>\n";
          echo "<input type='text'  name=product_code".$j.$i." value=${"product_code".$j.$i} >\n";
          echo "</td>\n";
          echo "<td colspan='3' nowrap='nowrap' style='border-bottom: 0px'><div align='center'><strong style='font-size: 15pt; color:blue'>\n";
          echo "開始";
          echo "</strong></div></td>\n";
          echo "<td colspan='37' nowrap='nowrap' style='border-bottom: 0px'><div align='center'>\n";
          echo "<input type='datetime-local' value=${"hyoujistarting_tm".$j.$i} name=starting_tm".$j.$i." size='6'/>\n";
          echo "</div></td>\n";
          echo "<td rowspan='2' colspan='20' nowrap='nowrap'>\n";
          echo "<input type='text' name=amount_shot".$j.$i." value=${"amount_shot".$j.$i} >\n";
          echo "</td>\n";
          echo "<td rowspan='2'  height='6' colspan='20' nowrap='nowrap'>\n";
          echo "<input type='text' name=cycle_shot".$j.$i." value=${"cycle_shot".$j.$i} >\n";
          echo "</td>\n";
          echo "</tr>\n";
          echo "</div></td>\n";
          echo "<tr style='border-bottom: 0px;border-width: 0px'>\n";
          echo "<td colspan='3' nowrap='nowrap'><div align='center'><strong style='font-size: 15pt; color:blue'>\n";
          echo "終了";
          echo "</strong></div></td>\n";
          echo "<td colspan='37'><div align='center'>\n";
          echo "<input type='datetime-local' value=${"hyoujifinishing_tm".$j.$i} name=finishing_tm".$j.$i." size='6'/>\n";
          echo "</div></td>\n";
          echo "</tr>\n";
        }
        echo $this->Form->hidden('n'.$j ,['value'=>${"n".$j}]);
   ?>
   <tr bgcolor="#E6FFFF" >
     <td width="550" colspan="40" nowrap="nowrap" bgcolor="#E6FFFF" style="border: none"><div align="center"><strong style="font-size: 15pt; color:blue"></strong></div></td>
     <td width="550" colspan="50" nowrap="nowrap" bgcolor="#E6FFFF" style="border: none"><div align="center"><strong style="font-size: 15pt; color:blue"></strong></div></td>
     <td align="right" rowspan="2" width="50" bgcolor="#E6FFFF" style="border: none"><div align="right"><?= $this->Form->control('追加', array('type'=>'submit', 'name' => "tuika".$j, 'value'=>1, 'label'=>false)) ?></div></td>
     <td align="right" rowspan="2" width="50" bgcolor="#E6FFFF" style="border: none"><div align="right"><?= $this->Form->control('削除', array('type'=>'submit', 'name' => "sakujo".$j, 'value'=>1, 'label'=>false)) ?></div></td>
   </tr>
  </table>
  <br>
  <?php   /*ここまで１号機*/    ?>

  <?php   /*ここから２号機*/    ?>
  <table align="center" border="2" bordercolor="#E6FFFF" cellpadding="0" cellspacing="0">
    <caption style="text-align: left">２号機</caption>
    <tbody border="2" bordercolor="#E6FFFF" bgcolor="#ffc0cb" style="border-bottom: solid;border-width: 1px">
      <tr style="border-bottom: 0px;border-width: 0px">
        <td width="250" height="30" colspan="20" nowrap="nowrap"><div align="center"><strong style="font-size: 13pt; color:blue">品番</strong></div></td>
        <td width="400" colspan="40" nowrap="nowrap"><div align="center"><strong style="font-size: 13pt; color:blue">成形時間</strong></div></td>
        <td width="200" colspan="20" nowrap="nowrap"><div align="center"><strong style="font-size: 10pt; color:blue">生産ショット数</strong></div></td>
        <td width="200" colspan="20" nowrap="nowrap"><div align="center"><strong style="font-size: 10pt; color:blue">成形サイクル</strong></div></td>
      </tr>

  <?php
  $j = 2;
     for($i=1; $i<=${"n".$j}; $i++){//２号機

          echo "<tr style='border-bottom: 0px;border-width: 0px'>\n";
          echo "<td rowspan='2' colspan='20' nowrap='nowrap'>\n";
          echo "<input type='text'  name=product_code".$j.$i." value=${"product_code".$j.$i} >\n";
          echo "</td>\n";
          echo "<td colspan='3' nowrap='nowrap' style='border-bottom: 0px'><div align='center'><strong style='font-size: 15pt; color:blue'>\n";
          echo "開始";
          echo "</strong></div></td>\n";
          echo "<td colspan='37' nowrap='nowrap' style='border-bottom: 0px'><div align='center'>\n";
          echo "<input type='datetime-local' value=${"hyoujistarting_tm".$j.$i} name=starting_tm".$j.$i." size='6'/>\n";
          echo "</div></td>\n";
          echo "<td rowspan='2' colspan='20' nowrap='nowrap'>\n";
          echo "<input type='text' name=amount_shot".$j.$i." value=${"amount_shot".$j.$i} >\n";
          echo "</td>\n";
          echo "<td rowspan='2'  height='6' colspan='20' nowrap='nowrap'>\n";
          echo "<input type='text' name=cycle_shot".$j.$i." value=${"cycle_shot".$j.$i} >\n";
          echo "</td>\n";
          echo "</tr>\n";
          echo "</div></td>\n";
          echo "<tr style='border-bottom: 0px;border-width: 0px'>\n";
          echo "<td colspan='3' nowrap='nowrap'><div align='center'><strong style='font-size: 15pt; color:blue'>\n";
          echo "終了";
          echo "</strong></div></td>\n";
          echo "<td colspan='37'><div align='center'>\n";
          echo "<input type='datetime-local' value=${"hyoujifinishing_tm".$j.$i} name=finishing_tm".$j.$i." size='6'/>\n";
          echo "</div></td>\n";
          echo "</tr>\n";
        }
        echo $this->Form->hidden('n'.$j ,['value'=>${"n".$j}]);
   ?>
   <tr bgcolor="#E6FFFF" >
     <td width="550" colspan="40" nowrap="nowrap" bgcolor="#E6FFFF" style="border: none"><div align="center"><strong style="font-size: 15pt; color:blue"></strong></div></td>
     <td width="550" colspan="50" nowrap="nowrap" bgcolor="#E6FFFF" style="border: none"><div align="center"><strong style="font-size: 15pt; color:blue"></strong></div></td>
     <td align="right" rowspan="2" width="50" bgcolor="#E6FFFF" style="border: none"><div align="right"><?= $this->Form->control('追加', array('type'=>'submit', 'name' => "tuika".$j, 'value'=>1, 'label'=>false)) ?></div></td>
     <td align="right" rowspan="2" width="50" bgcolor="#E6FFFF" style="border: none"><div align="right"><?= $this->Form->control('削除', array('type'=>'submit', 'name' => "sakujo".$j, 'value'=>1, 'label'=>false)) ?></div></td>
   </tr>
  </table>
  <br>
  <?php   /*ここまで２号機*/    ?>

  <?php   /*ここから3号機*/    ?>
  <table align="center" border="2" bordercolor="#E6FFFF" cellpadding="0" cellspacing="0">
    <caption style="text-align: left">３号機</caption>
    <tbody border="2" bordercolor="#E6FFFF" bgcolor="#FFFFCC" style="border-bottom: solid;border-width: 1px">
      <tr style="border-bottom: 0px;border-width: 0px">
        <td width="250" height="30" colspan="20" nowrap="nowrap"><div align="center"><strong style="font-size: 13pt; color:blue">品番</strong></div></td>
        <td width="400" colspan="40" nowrap="nowrap"><div align="center"><strong style="font-size: 13pt; color:blue">成形時間</strong></div></td>
        <td width="200" colspan="20" nowrap="nowrap"><div align="center"><strong style="font-size: 10pt; color:blue">生産ショット数</strong></div></td>
        <td width="200" colspan="20" nowrap="nowrap"><div align="center"><strong style="font-size: 10pt; color:blue">成形サイクル</strong></div></td>
      </tr>

  <?php
  $j = 3;
     for($i=1; $i<=${"n".$j}; $i++){//3号機

          echo "<tr style='border-bottom: 0px;border-width: 0px'>\n";
          echo "<td rowspan='2' colspan='20' nowrap='nowrap'>\n";
          echo "<input type='text'  name=product_code".$j.$i." value=${"product_code".$j.$i} >\n";
          echo "</td>\n";
          echo "<td colspan='3' nowrap='nowrap' style='border-bottom: 0px'><div align='center'><strong style='font-size: 15pt; color:blue'>\n";
          echo "開始";
          echo "</strong></div></td>\n";
          echo "<td colspan='37' nowrap='nowrap' style='border-bottom: 0px'><div align='center'>\n";
          echo "<input type='datetime-local' value=${"hyoujistarting_tm".$j.$i} name=starting_tm".$j.$i." size='6'/>\n";
          echo "</div></td>\n";
          echo "<td rowspan='2' colspan='20' nowrap='nowrap'>\n";
          echo "<input type='text' name=amount_shot".$j.$i." value=${"amount_shot".$j.$i} >\n";
          echo "</td>\n";
          echo "<td rowspan='2'  height='6' colspan='20' nowrap='nowrap'>\n";
          echo "<input type='text' name=cycle_shot".$j.$i." value=${"cycle_shot".$j.$i} >\n";
          echo "</td>\n";
          echo "</tr>\n";
          echo "</div></td>\n";
          echo "<tr style='border-bottom: 0px;border-width: 0px'>\n";
          echo "<td colspan='3' nowrap='nowrap'><div align='center'><strong style='font-size: 15pt; color:blue'>\n";
          echo "終了";
          echo "</strong></div></td>\n";
          echo "<td colspan='37'><div align='center'>\n";
          echo "<input type='datetime-local' value=${"hyoujifinishing_tm".$j.$i} name=finishing_tm".$j.$i." size='6'/>\n";
          echo "</div></td>\n";
          echo "</tr>\n";
        }
        echo $this->Form->hidden('n'.$j ,['value'=>${"n".$j}]);
   ?>
   <tr bgcolor="#E6FFFF" >
     <td width="550" colspan="40" nowrap="nowrap" bgcolor="#E6FFFF" style="border: none"><div align="center"><strong style="font-size: 15pt; color:blue"></strong></div></td>
     <td width="550" colspan="50" nowrap="nowrap" bgcolor="#E6FFFF" style="border: none"><div align="center"><strong style="font-size: 15pt; color:blue"></strong></div></td>
     <td align="right" rowspan="2" width="50" bgcolor="#E6FFFF" style="border: none"><div align="right"><?= $this->Form->control('追加', array('type'=>'submit', 'name' => "tuika".$j, 'value'=>1, 'label'=>false)) ?></div></td>
     <td align="right" rowspan="2" width="50" bgcolor="#E6FFFF" style="border: none"><div align="right"><?= $this->Form->control('削除', array('type'=>'submit', 'name' => "sakujo".$j, 'value'=>1, 'label'=>false)) ?></div></td>
   </tr>
  </table>
  <br>
  <?php   /*ここまで3号機*/    ?>

  <?php   /*ここから4号機*/    ?>
  <table align="center" border="2" bordercolor="#E6FFFF" cellpadding="0" cellspacing="0">
    <caption style="text-align: left">４号機</caption>
    <tbody border="2" bordercolor="#E6FFFF" bgcolor="#ffc0cb" style="border-bottom: solid;border-width: 1px">
      <tr style="border-bottom: 0px;border-width: 0px">
        <td width="250" height="30" colspan="20" nowrap="nowrap"><div align="center"><strong style="font-size: 13pt; color:blue">品番</strong></div></td>
        <td width="400" colspan="40" nowrap="nowrap"><div align="center"><strong style="font-size: 13pt; color:blue">成形時間</strong></div></td>
        <td width="200" colspan="20" nowrap="nowrap"><div align="center"><strong style="font-size: 10pt; color:blue">生産ショット数</strong></div></td>
        <td width="200" colspan="20" nowrap="nowrap"><div align="center"><strong style="font-size: 10pt; color:blue">成形サイクル</strong></div></td>
      </tr>

  <?php
  $j = 4;
     for($i=1; $i<=${"n".$j}; $i++){//4号機

          echo "<tr style='border-bottom: 0px;border-width: 0px'>\n";
          echo "<td rowspan='2' colspan='20' nowrap='nowrap'>\n";
          echo "<input type='text'  name=product_code".$j.$i." value=${"product_code".$j.$i} >\n";
          echo "</td>\n";
          echo "<td colspan='3' nowrap='nowrap' style='border-bottom: 0px'><div align='center'><strong style='font-size: 15pt; color:blue'>\n";
          echo "開始";
          echo "</strong></div></td>\n";
          echo "<td colspan='37' nowrap='nowrap' style='border-bottom: 0px'><div align='center'>\n";
          echo "<input type='datetime-local' value=${"hyoujistarting_tm".$j.$i} name=starting_tm".$j.$i." size='6'/>\n";
          echo "</div></td>\n";
          echo "<td rowspan='2' colspan='20' nowrap='nowrap'>\n";
          echo "<input type='text' name=amount_shot".$j.$i." value=${"amount_shot".$j.$i} >\n";
          echo "</td>\n";
          echo "<td rowspan='2'  height='6' colspan='20' nowrap='nowrap'>\n";
          echo "<input type='text' name=cycle_shot".$j.$i." value=${"cycle_shot".$j.$i} >\n";
          echo "</td>\n";
          echo "</tr>\n";
          echo "</div></td>\n";
          echo "<tr style='border-bottom: 0px;border-width: 0px'>\n";
          echo "<td colspan='3' nowrap='nowrap'><div align='center'><strong style='font-size: 15pt; color:blue'>\n";
          echo "終了";
          echo "</strong></div></td>\n";
          echo "<td colspan='37'><div align='center'>\n";
          echo "<input type='datetime-local' value=${"hyoujifinishing_tm".$j.$i} name=finishing_tm".$j.$i." size='6'/>\n";
          echo "</div></td>\n";
          echo "</tr>\n";
        }
        echo $this->Form->hidden('n'.$j ,['value'=>${"n".$j}]);
   ?>
   <tr bgcolor="#E6FFFF" >
     <td width="550" colspan="40" nowrap="nowrap" bgcolor="#E6FFFF" style="border: none"><div align="center"><strong style="font-size: 15pt; color:blue"></strong></div></td>
     <td width="550" colspan="50" nowrap="nowrap" bgcolor="#E6FFFF" style="border: none"><div align="center"><strong style="font-size: 15pt; color:blue"></strong></div></td>
     <td align="right" rowspan="2" width="50" bgcolor="#E6FFFF" style="border: none"><div align="right"><?= $this->Form->control('追加', array('type'=>'submit', 'name' => "tuika".$j, 'value'=>1, 'label'=>false)) ?></div></td>
     <td align="right" rowspan="2" width="50" bgcolor="#E6FFFF" style="border: none"><div align="right"><?= $this->Form->control('削除', array('type'=>'submit', 'name' => "sakujo".$j, 'value'=>1, 'label'=>false)) ?></div></td>
   </tr>
  </table>
  <br>
  <?php   /*ここまで4号機*/    ?>

  <?php   /*ここから5号機*/    ?>
  <table align="center" border="2" bordercolor="#E6FFFF" cellpadding="0" cellspacing="0">
    <caption style="text-align: left">５号機</caption>
    <tbody border="2" bordercolor="#E6FFFF" bgcolor="#FFFFCC" style="border-bottom: solid;border-width: 1px">
      <tr style="border-bottom: 0px;border-width: 0px">
        <td width="250" height="30" colspan="20" nowrap="nowrap"><div align="center"><strong style="font-size: 13pt; color:blue">品番</strong></div></td>
        <td width="400" colspan="40" nowrap="nowrap"><div align="center"><strong style="font-size: 13pt; color:blue">成形時間</strong></div></td>
        <td width="200" colspan="20" nowrap="nowrap"><div align="center"><strong style="font-size: 10pt; color:blue">生産ショット数</strong></div></td>
        <td width="200" colspan="20" nowrap="nowrap"><div align="center"><strong style="font-size: 10pt; color:blue">成形サイクル</strong></div></td>
      </tr>

  <?php
  $j = 5;
     for($i=1; $i<=${"n".$j}; $i++){//5号機

          echo "<tr style='border-bottom: 0px;border-width: 0px'>\n";
          echo "<td rowspan='2' colspan='20' nowrap='nowrap'>\n";
          echo "<input type='text'  name=product_code".$j.$i." value=${"product_code".$j.$i} >\n";
          echo "</td>\n";
          echo "<td colspan='3' nowrap='nowrap' style='border-bottom: 0px'><div align='center'><strong style='font-size: 15pt; color:blue'>\n";
          echo "開始";
          echo "</strong></div></td>\n";
          echo "<td colspan='37' nowrap='nowrap' style='border-bottom: 0px'><div align='center'>\n";
          echo "<input type='datetime-local' value=${"hyoujistarting_tm".$j.$i} name=starting_tm".$j.$i." size='6'/>\n";
          echo "</div></td>\n";
          echo "<td rowspan='2' colspan='20' nowrap='nowrap'>\n";
          echo "<input type='text' name=amount_shot".$j.$i." value=${"amount_shot".$j.$i} >\n";
          echo "</td>\n";
          echo "<td rowspan='2'  height='6' colspan='20' nowrap='nowrap'>\n";
          echo "<input type='text' name=cycle_shot".$j.$i." value=${"cycle_shot".$j.$i} >\n";
          echo "</td>\n";
          echo "</tr>\n";
          echo "</div></td>\n";
          echo "<tr style='border-bottom: 0px;border-width: 0px'>\n";
          echo "<td colspan='3' nowrap='nowrap'><div align='center'><strong style='font-size: 15pt; color:blue'>\n";
          echo "終了";
          echo "</strong></div></td>\n";
          echo "<td colspan='37'><div align='center'>\n";
          echo "<input type='datetime-local' value=${"hyoujifinishing_tm".$j.$i} name=finishing_tm".$j.$i." size='6'/>\n";
          echo "</div></td>\n";
          echo "</tr>\n";
        }
        echo $this->Form->hidden('n'.$j ,['value'=>${"n".$j}]);
   ?>
   <tr bgcolor="#E6FFFF" >
     <td width="550" colspan="40" nowrap="nowrap" bgcolor="#E6FFFF" style="border: none"><div align="center"><strong style="font-size: 15pt; color:blue"></strong></div></td>
     <td width="550" colspan="50" nowrap="nowrap" bgcolor="#E6FFFF" style="border: none"><div align="center"><strong style="font-size: 15pt; color:blue"></strong></div></td>
     <td align="right" rowspan="2" width="50" bgcolor="#E6FFFF" style="border: none"><div align="right"><?= $this->Form->control('追加', array('type'=>'submit', 'name' => "tuika".$j, 'value'=>1, 'label'=>false)) ?></div></td>
     <td align="right" rowspan="2" width="50" bgcolor="#E6FFFF" style="border: none"><div align="right"><?= $this->Form->control('削除', array('type'=>'submit', 'name' => "sakujo".$j, 'value'=>1, 'label'=>false)) ?></div></td>
   </tr>
  </table>
  <br>
  <?php   /*ここまで5号機*/    ?>

  <?php   /*ここから6号機*/    ?>
  <table align="center" border="2" bordercolor="#E6FFFF" cellpadding="0" cellspacing="0">
    <caption style="text-align: left">６号機</caption>
    <tbody border="2" bordercolor="#E6FFFF" bgcolor="#ffc0cb" style="border-bottom: solid;border-width: 1px">
      <tr style="border-bottom: 0px;border-width: 0px">
        <td width="250" height="30" colspan="20" nowrap="nowrap"><div align="center"><strong style="font-size: 13pt; color:blue">品番</strong></div></td>
        <td width="400" colspan="40" nowrap="nowrap"><div align="center"><strong style="font-size: 13pt; color:blue">成形時間</strong></div></td>
        <td width="200" colspan="20" nowrap="nowrap"><div align="center"><strong style="font-size: 10pt; color:blue">生産ショット数</strong></div></td>
        <td width="200" colspan="20" nowrap="nowrap"><div align="center"><strong style="font-size: 10pt; color:blue">成形サイクル</strong></div></td>
      </tr>

  <?php
  $j = 6;
     for($i=1; $i<=${"n".$j}; $i++){//6号機

          echo "<tr style='border-bottom: 0px;border-width: 0px'>\n";
          echo "<td rowspan='2' colspan='20' nowrap='nowrap'>\n";
          echo "<input type='text'  name=product_code".$j.$i." value=${"product_code".$j.$i} >\n";
          echo "</td>\n";
          echo "<td colspan='3' nowrap='nowrap' style='border-bottom: 0px'><div align='center'><strong style='font-size: 15pt; color:blue'>\n";
          echo "開始";
          echo "</strong></div></td>\n";
          echo "<td colspan='37' nowrap='nowrap' style='border-bottom: 0px'><div align='center'>\n";
          echo "<input type='datetime-local' value=${"hyoujistarting_tm".$j.$i} name=starting_tm".$j.$i." size='6'/>\n";
          echo "</div></td>\n";
          echo "<td rowspan='2' colspan='20' nowrap='nowrap'>\n";
          echo "<input type='text' name=amount_shot".$j.$i." value=${"amount_shot".$j.$i} >\n";
          echo "</td>\n";
          echo "<td rowspan='2'  height='6' colspan='20' nowrap='nowrap'>\n";
          echo "<input type='text' name=cycle_shot".$j.$i." value=${"cycle_shot".$j.$i} >\n";
          echo "</td>\n";
          echo "</tr>\n";
          echo "</div></td>\n";
          echo "<tr style='border-bottom: 0px;border-width: 0px'>\n";
          echo "<td colspan='3' nowrap='nowrap'><div align='center'><strong style='font-size: 15pt; color:blue'>\n";
          echo "終了";
          echo "</strong></div></td>\n";
          echo "<td colspan='37'><div align='center'>\n";
          echo "<input type='datetime-local' value=${"hyoujifinishing_tm".$j.$i} name=finishing_tm".$j.$i." size='6'/>\n";
          echo "</div></td>\n";
          echo "</tr>\n";
        }
        echo $this->Form->hidden('n'.$j ,['value'=>${"n".$j}]);
   ?>
   <tr bgcolor="#E6FFFF" >
     <td width="550" colspan="40" nowrap="nowrap" bgcolor="#E6FFFF" style="border: none"><div align="center"><strong style="font-size: 15pt; color:blue"></strong></div></td>
     <td width="550" colspan="50" nowrap="nowrap" bgcolor="#E6FFFF" style="border: none"><div align="center"><strong style="font-size: 15pt; color:blue"></strong></div></td>
     <td align="right" rowspan="2" width="50" bgcolor="#E6FFFF" style="border: none"><div align="right"><?= $this->Form->control('追加', array('type'=>'submit', 'name' => "tuika".$j, 'value'=>1, 'label'=>false)) ?></div></td>
     <td align="right" rowspan="2" width="50" bgcolor="#E6FFFF" style="border: none"><div align="right"><?= $this->Form->control('削除', array('type'=>'submit', 'name' => "sakujo".$j, 'value'=>1, 'label'=>false)) ?></div></td>
   </tr>
  </table>
  <br>
  <?php   /*ここまで6号機*/    ?>

  <?php   /*ここから7号機*/    ?>
  <table align="center" border="2" bordercolor="#E6FFFF" cellpadding="0" cellspacing="0">
    <caption style="text-align: left">７号機</caption>
    <tbody border="2" bordercolor="#E6FFFF" bgcolor="#FFFFCC" style="border-bottom: solid;border-width: 1px">
      <tr style="border-bottom: 0px;border-width: 0px">
        <td width="250" height="30" colspan="20" nowrap="nowrap"><div align="center"><strong style="font-size: 13pt; color:blue">品番</strong></div></td>
        <td width="400" colspan="40" nowrap="nowrap"><div align="center"><strong style="font-size: 13pt; color:blue">成形時間</strong></div></td>
        <td width="200" colspan="20" nowrap="nowrap"><div align="center"><strong style="font-size: 10pt; color:blue">生産ショット数</strong></div></td>
        <td width="200" colspan="20" nowrap="nowrap"><div align="center"><strong style="font-size: 10pt; color:blue">成形サイクル</strong></div></td>
      </tr>

  <?php
  $j = 7;
     for($i=1; $i<=${"n".$j}; $i++){//7号機

          echo "<tr style='border-bottom: 0px;border-width: 0px'>\n";
          echo "<td rowspan='2' colspan='20' nowrap='nowrap'>\n";
          echo "<input type='text'  name=product_code".$j.$i." value=${"product_code".$j.$i} >\n";
          echo "</td>\n";
          echo "<td colspan='3' nowrap='nowrap' style='border-bottom: 0px'><div align='center'><strong style='font-size: 15pt; color:blue'>\n";
          echo "開始";
          echo "</strong></div></td>\n";
          echo "<td colspan='37' nowrap='nowrap' style='border-bottom: 0px'><div align='center'>\n";
          echo "<input type='datetime-local' value=${"hyoujistarting_tm".$j.$i} name=starting_tm".$j.$i." size='6'/>\n";
          echo "</div></td>\n";
          echo "<td rowspan='2' colspan='20' nowrap='nowrap'>\n";
          echo "<input type='text' name=amount_shot".$j.$i." value=${"amount_shot".$j.$i} >\n";
          echo "</td>\n";
          echo "<td rowspan='2'  height='6' colspan='20' nowrap='nowrap'>\n";
          echo "<input type='text' name=cycle_shot".$j.$i." value=${"cycle_shot".$j.$i} >\n";
          echo "</td>\n";
          echo "</tr>\n";
          echo "</div></td>\n";
          echo "<tr style='border-bottom: 0px;border-width: 0px'>\n";
          echo "<td colspan='3' nowrap='nowrap'><div align='center'><strong style='font-size: 15pt; color:blue'>\n";
          echo "終了";
          echo "</strong></div></td>\n";
          echo "<td colspan='37'><div align='center'>\n";
          echo "<input type='datetime-local' value=${"hyoujifinishing_tm".$j.$i} name=finishing_tm".$j.$i." size='6'/>\n";
          echo "</div></td>\n";
          echo "</tr>\n";
        }
        echo $this->Form->hidden('n'.$j ,['value'=>${"n".$j}]);
   ?>
   <tr bgcolor="#E6FFFF" >
     <td width="550" colspan="40" nowrap="nowrap" bgcolor="#E6FFFF" style="border: none"><div align="center"><strong style="font-size: 15pt; color:blue"></strong></div></td>
     <td width="550" colspan="50" nowrap="nowrap" bgcolor="#E6FFFF" style="border: none"><div align="center"><strong style="font-size: 15pt; color:blue"></strong></div></td>
     <td align="right" rowspan="2" width="50" bgcolor="#E6FFFF" style="border: none"><div align="right"><?= $this->Form->control('追加', array('type'=>'submit', 'name' => "tuika".$j, 'value'=>1, 'label'=>false)) ?></div></td>
     <td align="right" rowspan="2" width="50" bgcolor="#E6FFFF" style="border: none"><div align="right"><?= $this->Form->control('削除', array('type'=>'submit', 'name' => "sakujo".$j, 'value'=>1, 'label'=>false)) ?></div></td>
   </tr>
  </table>
  <br>
  <?php   /*ここまで7号機*/    ?>

  <?php   /*ここから8号機*/    ?>
  <table align="center" border="2" bordercolor="#E6FFFF" cellpadding="0" cellspacing="0">
    <caption style="text-align: left">８号機</caption>
    <tbody border="2" bordercolor="#E6FFFF" bgcolor="#ffc0cb" style="border-bottom: solid;border-width: 1px">
      <tr style="border-bottom: 0px;border-width: 0px">
        <td width="250" height="30" colspan="20" nowrap="nowrap"><div align="center"><strong style="font-size: 13pt; color:blue">品番</strong></div></td>
        <td width="400" colspan="40" nowrap="nowrap"><div align="center"><strong style="font-size: 13pt; color:blue">成形時間</strong></div></td>
        <td width="200" colspan="20" nowrap="nowrap"><div align="center"><strong style="font-size: 10pt; color:blue">生産ショット数</strong></div></td>
        <td width="200" colspan="20" nowrap="nowrap"><div align="center"><strong style="font-size: 10pt; color:blue">成形サイクル</strong></div></td>
      </tr>

  <?php
  $j = 8;
     for($i=1; $i<=${"n".$j}; $i++){//２号機

          echo "<tr style='border-bottom: 0px;border-width: 0px'>\n";
          echo "<td rowspan='2' colspan='20' nowrap='nowrap'>\n";
          echo "<input type='text'  name=product_code".$j.$i." value=${"product_code".$j.$i} >\n";
          echo "</td>\n";
          echo "<td colspan='3' nowrap='nowrap' style='border-bottom: 0px'><div align='center'><strong style='font-size: 15pt; color:blue'>\n";
          echo "開始";
          echo "</strong></div></td>\n";
          echo "<td colspan='37' nowrap='nowrap' style='border-bottom: 0px'><div align='center'>\n";
          echo "<input type='datetime-local' value=${"hyoujistarting_tm".$j.$i} name=starting_tm".$j.$i." size='6'/>\n";
          echo "</div></td>\n";
          echo "<td rowspan='2' colspan='20' nowrap='nowrap'>\n";
          echo "<input type='text' name=amount_shot".$j.$i." value=${"amount_shot".$j.$i} >\n";
          echo "</td>\n";
          echo "<td rowspan='2'  height='6' colspan='20' nowrap='nowrap'>\n";
          echo "<input type='text' name=cycle_shot".$j.$i." value=${"cycle_shot".$j.$i} >\n";
          echo "</td>\n";
          echo "</tr>\n";
          echo "</div></td>\n";
          echo "<tr style='border-bottom: 0px;border-width: 0px'>\n";
          echo "<td colspan='3' nowrap='nowrap'><div align='center'><strong style='font-size: 15pt; color:blue'>\n";
          echo "終了";
          echo "</strong></div></td>\n";
          echo "<td colspan='37'><div align='center'>\n";
          echo "<input type='datetime-local' value=${"hyoujifinishing_tm".$j.$i} name=finishing_tm".$j.$i." size='6'/>\n";
          echo "</div></td>\n";
          echo "</tr>\n";
        }
        echo $this->Form->hidden('n'.$j ,['value'=>${"n".$j}]);
   ?>
   <tr bgcolor="#E6FFFF" >
     <td width="550" colspan="40" nowrap="nowrap" bgcolor="#E6FFFF" style="border: none"><div align="center"><strong style="font-size: 15pt; color:blue"></strong></div></td>
     <td width="550" colspan="50" nowrap="nowrap" bgcolor="#E6FFFF" style="border: none"><div align="center"><strong style="font-size: 15pt; color:blue"></strong></div></td>
     <td align="right" rowspan="2" width="50" bgcolor="#E6FFFF" style="border: none"><div align="right"><?= $this->Form->control('追加', array('type'=>'submit', 'name' => "tuika".$j, 'value'=>1, 'label'=>false)) ?></div></td>
     <td align="right" rowspan="2" width="50" bgcolor="#E6FFFF" style="border: none"><div align="right"><?= $this->Form->control('削除', array('type'=>'submit', 'name' => "sakujo".$j, 'value'=>1, 'label'=>false)) ?></div></td>
   </tr>
  </table>
  <br>
  <?php   /*ここまで8号機*/    ?>

  <?php   /*ここから9号機*/    ?>
  <table align="center" border="2" bordercolor="#E6FFFF" cellpadding="0" cellspacing="0">
    <caption style="text-align: left">９号機</caption>
    <tbody border="2" bordercolor="#E6FFFF" bgcolor="#FFFFCC" style="border-bottom: solid;border-width: 1px">
      <tr style="border-bottom: 0px;border-width: 0px">
        <td width="250" height="30" colspan="20" nowrap="nowrap"><div align="center"><strong style="font-size: 13pt; color:blue">品番</strong></div></td>
        <td width="400" colspan="40" nowrap="nowrap"><div align="center"><strong style="font-size: 13pt; color:blue">成形時間</strong></div></td>
        <td width="200" colspan="20" nowrap="nowrap"><div align="center"><strong style="font-size: 10pt; color:blue">生産ショット数</strong></div></td>
        <td width="200" colspan="20" nowrap="nowrap"><div align="center"><strong style="font-size: 10pt; color:blue">成形サイクル</strong></div></td>
      </tr>

  <?php
  $j = 9;
     for($i=1; $i<=${"n".$j}; $i++){//9号機

          echo "<tr style='border-bottom: 0px;border-width: 0px'>\n";
          echo "<td rowspan='2' colspan='20' nowrap='nowrap'>\n";
          echo "<input type='text'  name=product_code".$j.$i." value=${"product_code".$j.$i} >\n";
          echo "</td>\n";
          echo "<td colspan='3' nowrap='nowrap' style='border-bottom: 0px'><div align='center'><strong style='font-size: 15pt; color:blue'>\n";
          echo "開始";
          echo "</strong></div></td>\n";
          echo "<td colspan='37' nowrap='nowrap' style='border-bottom: 0px'><div align='center'>\n";
          echo "<input type='datetime-local' value=${"hyoujistarting_tm".$j.$i} name=starting_tm".$j.$i." size='6'/>\n";
          echo "</div></td>\n";
          echo "<td rowspan='2' colspan='20' nowrap='nowrap'>\n";
          echo "<input type='text' name=amount_shot".$j.$i." value=${"amount_shot".$j.$i} >\n";
          echo "</td>\n";
          echo "<td rowspan='2'  height='6' colspan='20' nowrap='nowrap'>\n";
          echo "<input type='text' name=cycle_shot".$j.$i." value=${"cycle_shot".$j.$i} >\n";
          echo "</td>\n";
          echo "</tr>\n";
          echo "</div></td>\n";
          echo "<tr style='border-bottom: 0px;border-width: 0px'>\n";
          echo "<td colspan='3' nowrap='nowrap'><div align='center'><strong style='font-size: 15pt; color:blue'>\n";
          echo "終了";
          echo "</strong></div></td>\n";
          echo "<td colspan='37'><div align='center'>\n";
          echo "<input type='datetime-local' value=${"hyoujifinishing_tm".$j.$i} name=finishing_tm".$j.$i." size='6'/>\n";
          echo "</div></td>\n";
          echo "</tr>\n";
        }
        echo $this->Form->hidden('n'.$j ,['value'=>${"n".$j}]);
   ?>
   <tr bgcolor="#E6FFFF" >
     <td width="550" colspan="40" nowrap="nowrap" bgcolor="#E6FFFF" style="border: none"><div align="center"><strong style="font-size: 15pt; color:blue"></strong></div></td>
     <td width="550" colspan="50" nowrap="nowrap" bgcolor="#E6FFFF" style="border: none"><div align="center"><strong style="font-size: 15pt; color:blue"></strong></div></td>
     <td align="right" rowspan="2" width="50" bgcolor="#E6FFFF" style="border: none"><div align="right"><?= $this->Form->control('追加', array('type'=>'submit', 'name' => "tuika".$j, 'value'=>1, 'label'=>false)) ?></div></td>
     <td align="right" rowspan="2" width="50" bgcolor="#E6FFFF" style="border: none"><div align="right"><?= $this->Form->control('削除', array('type'=>'submit', 'name' => "sakujo".$j, 'value'=>1, 'label'=>false)) ?></div></td>
   </tr>
  </table>
  <br>
  <?php   /*ここまで9号機*/    ?>

<br>
<table align="center" border="2" bordercolor="#E6FFFF" cellpadding="0" cellspacing="0">
<tr bgcolor="#E6FFFF" >
  <td align="center" rowspan="2" width="50" bgcolor="#E6FFFF" style="border: none"><div align="center"><?= $this->Form->submit(__('確認'), array('name' => 'confirm', 'value'=>"1")); ?></div></td>
</tr>
</table>

<fieldset>
  <?= $this->Form->control('formset', array('type'=>'hidden', 'value'=>"1", 'label'=>false)) ?>
  <?= $this->Form->control('dateye', array('type'=>'hidden', 'value'=>$dateye, 'label'=>false)) ?>
  <?= $this->Form->control('dateto', array('type'=>'hidden', 'value'=>$dateto, 'label'=>false)) ?>
</fieldset>


<br>
<br>
<br>
