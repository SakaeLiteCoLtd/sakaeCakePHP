<?php
 use App\myClass\Genryoumenu\htmlGenryoumenu;//myClassフォルダに配置したクラスを使用
 $htmlGenryoumenu = new htmlGenryoumenu();
 $htmlGenryou = $htmlGenryoumenu->Genryoumenus();
 ?>
 <hr size="5" style="margin: 0.5rem">
 <table style="margin-bottom:0px" width="750" border="0" align="center" cellpadding="0" cellspacing="0" bordercolor="#CCCCCC">
 <?php
    echo $htmlGenryou;
 ?>
 </table>
 <hr size="5" style="margin: 0.5rem">
 <?= $this->Form->create($OrderMaterials, ['url' => ['action' => 'tourokuzumiitiran']]) ?>

 <br>
    <div align="left"><font color="blue" size="3"><?= __("　　　登録済検索") ?></font></div>
 <br>
 <table align="center" border="2" bordercolor="#E6FFFF" cellpadding="0" cellspacing="0">
   <tbody border="2" bordercolor="#E6FFFF" bgcolor="#FFFFCC" style="border-bottom: solid;border-width: 1px">
     <tr style="border-bottom: 0px;border-width: 0px">
       <td width="300" colspan="40" nowrap="nowrap"><div align="center"><strong style="font-size: 11pt; color:blue">発注日</strong></div></td>
       <td width="300" colspan="40" nowrap="nowrap"><div align="center"><strong style="font-size: 11pt; color:blue">入庫日</strong></div></td>
     </tr>

     <?php
     $dateYMD = date('Y-m-d');
     $dateYMD1 = strtotime($dateYMD);
     $dayye = date('Y-m-d', strtotime('-1 day', $dateYMD1));
     $dayyey = date('Y', strtotime('-1 day', $dateYMD1));
     $dayyem = date('m', strtotime('-1 day', $dateYMD1));
     $dayyed = date('d', strtotime('-1 day', $dateYMD1));
     $dayyetoy = date('Y');
     $dayyetom = date('m');
     $dayyetod = date('d');

     echo "<tr style='border-bottom: 0px;border-width: 0px'>\n";
     echo "<td colspan='10' style='border-bottom: 0px'><div align='center'><strong style='font-size: 11pt; color:blue'>\n";
     echo "開始";
     echo "</strong></div></td>\n";

   ?>
   <td width="80" colspan="10" style="border-right-style: none;border-bottom: 0px;border-width: 1px"><div align="center"><?= $this->Form->input("hattyu_date_sta_year", array('type' => 'select', "options"=>$arrYears, 'value' => "2009", 'label'=>false)); ?></div></td>
   <td width="80" colspan="10" style="border-right-style: none;border-left-style: none;border-bottom: 0px;border-width: 1px"><div align="center"><?= $this->Form->input("hattyu_date_sta_month", array('type' => 'select', "options"=>$arrMonths, 'value' => "1", 'monthNames' => false, 'label'=>false)); ?></div></td>
   <td width="80" colspan="10" style="border-left-style: none;border-bottom: 0px;border-width: 1px"><div align="center"><?= $this->Form->input("hattyu_date_sta_date", array('type' => 'select', "options"=>$arrDays, 'value' => "1", 'label'=>false)); ?></div></td>

   <?php

   echo "<td colspan='10' style='border-bottom: 0px'><div align='center'><strong style='font-size: 11pt; color:blue'>\n";
   echo "開始";
   echo "</strong></div></td>\n";

 ?>
 <td width="80" colspan="10" style="border-right-style: none;border-bottom: 0px;border-width: 1px"><div align="center"><?= $this->Form->input("nyuuko_date_sta_year", array('type' => 'select', "options"=>$arrYears, 'value' => "2009", 'label'=>false)); ?></div></td>
 <td width="80" colspan="10" style="border-right-style: none;border-left-style: none;border-bottom: 0px;border-width: 1px"><div align="center"><?= $this->Form->input("nyuuko_date_sta_month", array('type' => 'select', "options"=>$arrMonths, 'value' => "1", 'monthNames' => false, 'label'=>false)); ?></div></td>
 <td width="80" colspan="10" style="border-left-style: none;border-bottom: 0px;border-width: 1px"><div align="center"><?= $this->Form->input("nyuuko_date_sta_date", array('type' => 'select', "options"=>$arrDays, 'value' => "1", 'label'=>false)); ?></div></td>
 <?php
   echo "<tr style='border-bottom: 0px;border-width: 0px'>\n";
   echo "<td colspan='10'><div align='center'><strong style='font-size: 11pt; color:blue'>\n";
   echo "終了";
   echo "</strong></div></td>\n";
 ?>
 <td width="80" colspan="10" style="border-right-style: none;border-width: 1px"><div align="center"><?= $this->Form->input("hattyu_date_fin_year", array('type' => 'select', "options"=>$arrYears, 'value' => $dayyetoy, 'label'=>false)); ?></div></td>
 <td width="80" colspan="10" style="border-right-style: none;border-left-style: none;border-width: 1px"><div align="center"><?= $this->Form->input("hattyu_date_fin_month", array('type' => 'select', "options"=>$arrMonths, 'value' => $dayyetom, 'monthNames' => false, 'label'=>false)); ?></div></td>
 <td width="80" colspan="10" style="border-left-style: none;border-width: 1px"><div align="center"><?= $this->Form->input("hattyu_date_fin_date", array('type' => 'select', "options"=>$arrDays, 'value' => $dayyetod, 'label'=>false)); ?></div></td>

 <?php
   echo "<td colspan='10'><div align='center'><strong style='font-size: 11pt; color:blue'>\n";
   echo "終了";
   echo "</strong></div></td>\n";
 ?>
 <td width="80" colspan="10" style="border-right-style: none;border-width: 1px"><div align="center"><?= $this->Form->input("nyuuko_date_fin_year", array('type' => 'select', "options"=>$arrYears, 'value' => $dayyetoy, 'label'=>false)); ?></div></td>
 <td width="80" colspan="10" style="border-right-style: none;border-left-style: none;border-width: 1px"><div align="center"><?= $this->Form->input("nyuuko_date_fin_month", array('type' => 'select', "options"=>$arrMonths, 'value' => $dayyetom, 'monthNames' => false, 'label'=>false)); ?></div></td>
 <td width="80" colspan="10" style="border-left-style: none;border-width: 1px"><div align="center"><?= $this->Form->input("nyuuko_date_fin_date", array('type' => 'select', "options"=>$arrDays, 'value' => $dayyetod, 'label'=>false)); ?></div></td>
 <?php
 echo "</tr>\n";
 ?>
</table>

 <br>

 <table align="center" border="2" bordercolor="#E6FFFF" cellpadding="0" cellspacing="0" style="border-bottom: solid;border-width: 1px">
   <tr>
     <td width="210" bgcolor="#FFFFCC" style="font-size: 12pt;padding: 0.2rem"><strong style="font-size: 11pt; color:blue">グレード</strong></td>
     <td width="210"  bgcolor="#FFFFCC" style="font-size: 12pt;padding: 0.2rem"><strong style="font-size: 11pt; color:blue">色番号</strong></td>
     <td width="220" bgcolor="#FFFFCC" style="font-size: 12pt;padding: 0.2rem"><strong style="font-size: 11pt; color:blue">納入先</strong></td>
 	</tr>
   <tr>
     <td bgcolor="#FFFFCC" style="padding: 0.2rem"><?= $this->Form->control('m_grade', array('type'=>'text', 'label'=>false, 'autofocus'=>true)) ?></td>
     <td bgcolor="#FFFFCC" style="padding: 0.2rem"><?= $this->Form->control('col_num', array('type'=>'text', 'label'=>false)) ?></td>
     <td bgcolor="#FFFFCC" style="padding: 0.2rem"><?= $this->Form->input("deliv_cp", ["type"=>"select", "options"=>$arrDelivCp, 'label'=>false]) ?></td>
 	</tr>
 </table>

 <br>

     <table align="center" border="2" bordercolor="#E6FFFF" cellpadding="0" cellspacing="0">
       <tr bgcolor="#E6FFFF" >
         <td width="100" colspan="30" nowrap="nowrap" bgcolor="#E6FFFF" style="border: none"><div align="center"><strong style="font-size: 15pt; color:blue"></strong></div></td>
         <td align="center" rowspan="2"  colspan="20" width="250" bgcolor="#E6FFFF" style="border: none"><div align="center"><?= $this->Form->submit(__('呼出'), array('name' => 'kensaku')); ?></div></td>
         <td width="100" colspan="30" nowrap="nowrap" bgcolor="#E6FFFF" style="border: none"><div align="center"><strong style="font-size: 15pt; color:blue"></strong></div></td>
       </tr>
     </table>
   </fieldset>

 <?=$this->Form->end() ?>
