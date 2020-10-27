<?php
 use App\myClass\Genryoumenu\htmlGenryoumenu;//myClassフォルダに配置したクラスを使用
 $htmlGenryoumenu = new htmlGenryoumenu();
 $htmlGenryou = $htmlGenryoumenu->Genryoumenus();

 use Cake\ORM\TableRegistry;//独立したテーブルを扱う
 $this->DeliverCompanies = TableRegistry::get('deliverCompanies');
 $this->Staffs = TableRegistry::get('staffs');
 ?>
 <hr size="5" style="margin: 0.5rem">
 <table style="margin-bottom:0px" width="750" border="0" align="center" cellpadding="0" cellspacing="0" bordercolor="#CCCCCC">
 <?php
    echo $htmlGenryou;
 ?>
 </table>
 <hr size="5" style="margin: 0.5rem">
 <br>
    <div align="left"><font color=#FF66FF size="3"><?= __("　　　呼出結果一覧") ?></font></div>
 <br>
 <table align="center" border="2" bordercolor="#E6FFFF" cellpadding="0" cellspacing="0">
   <tbody border="2" bordercolor="#E6FFFF" bgcolor="#FFFFCC" style="border-bottom: solid;border-width: 1px">
         <thead>
           <tr border="2" bordercolor="#E6FFFF" bgcolor="#FFFFCC">
             <td width="150" height="30" colspan="20" nowrap="nowrap"><div align="center"><strong style="font-size: 10pt; color:#FF66FF">発注日</strong></div></td>
             <td width="100" height="30" colspan="20" nowrap="nowrap"><div align="center"><strong style="font-size: 10pt; color:#FF66FF">グレード</strong></div></td>
             <td width="100" height="30" colspan="20" nowrap="nowrap"><div align="center"><strong style="font-size: 10pt; color:#FF66FF">色番号</strong></div></td>
             <td width="80" height="30" colspan="20" nowrap="nowrap"><div align="center"><strong style="font-size: 10pt; color:#FF66FF">数量</strong></div></td>
             <td width="150" height="30" colspan="20" nowrap="nowrap"><div align="center"><strong style="font-size: 10pt; color:#FF66FF">入庫日</strong></div></td>
             <td width="200" height="30" colspan="20" nowrap="nowrap"><div align="center"><strong style="font-size: 10pt; color:#FF66FF">納入先</strong></div></td>
             <td width="100" height="30" colspan="20" nowrap="nowrap"><div align="center"><strong style="font-size: 10pt; color:#FF66FF">発注者</strong></div></td>
           </tr>
         </thead>
         <tbody border="2" bordercolor="#E6FFFF" bgcolor="#FFFFCC">
           <?php for($i=0; $i<count($arrOrderMaterials); $i++): ?>
           <tr style="border-bottom: solid;border-width: 1px">

             <?php
             $DeliverCompanies = $this->DeliverCompanies->find()
             ->where(['id' => $arrOrderMaterials[$i]["deliv_cp"]])->toArray();
             if(isset($DeliverCompanies[0])){
               $company = $DeliverCompanies[0]->company;
             }else{
               $company = "";
             }

             $Staffs = $this->Staffs->find()
             ->where(['staff_code' => $arrOrderMaterials[$i]["purchaser"]])->toArray();
             if(isset($Staffs[0])){
               $staff = $Staffs[0]->f_name." ".$Staffs[0]->l_name;
             }else{
               $staff = "";
             }
             ?>

             <td colspan="20" nowrap="nowrap"><font color="blue"><?= h($arrOrderMaterials[$i]["date_order"]) ?></font></td>
             <td colspan="20" nowrap="nowrap"><font color="blue"><?= h($arrOrderMaterials[$i]["grade"]) ?></font></td>
             <td colspan="20" nowrap="nowrap"><font color="blue"><?= h($arrOrderMaterials[$i]["color"]) ?></font></td>
             <td colspan="20" nowrap="nowrap"><font color="blue"><?= h($arrOrderMaterials[$i]["amount"]) ?></font></td>
             <td colspan="20" nowrap="nowrap"><font color="blue"><?= h($arrOrderMaterials[$i]["date_stored"]) ?></font></td>
             <td colspan="20" nowrap="nowrap"><font color="blue"><?= h($company) ?></font></td>
             <td colspan="20" nowrap="nowrap"><font color="blue"><?= h($staff) ?></font></td>
           </tr>
         <?php endfor;?>
         </tbody>
     </table>
 <br><br>
