<?php
 use App\myClass\EDImenus\htmlEDImenu;//myClassフォルダに配置したクラスを使用
 $htmlEDImenu = new htmlEDImenu();
 $htmlEDIs = $htmlEDImenu->EDImenus();

 use Cake\ORM\TableRegistry;//独立したテーブルを扱う
 $this->Customers = TableRegistry::get('customers');
 ?>
 <hr size="5" style="margin: 0.5rem">
 <table style="margin-bottom:0px" width="750" border="0" align="center" cellpadding="0" cellspacing="0" bordercolor="#CCCCCC">
 <?php
    echo $htmlEDIs;
 ?>
 </table>
 <hr size="5" style="margin: 0.5rem">
 <table style="margin-bottom:0px" width="750" border="0" align="center" cellpadding="0" cellspacing="0" bordercolor="#CCCCCC">
   <td style="padding: 0.1rem 0.1rem; text-align: center"><a href="qr/index.php"><?php echo $this->Html->image('Labelimg/subYobidashi.gif',array('width'=>'85','height'=>'36','url'=>array('action'=>'kensakuform')));?></td>
 </table>
 <hr size="5" style="margin: 0.5rem">

 <?= $this->Form->create($OrderSpecials, ['url' => ['action' => 'editform']]) ?>

 <br>
 <legend align="center"><font color="black"><?= __("量産品以外一覧") ?></font></legend>
 <br>
 <table align="center" border="2" bordercolor="#E6FFFF" cellpadding="0" cellspacing="0">
   <tbody border="2" bordercolor="#E6FFFF" bgcolor="#FFFFCC" style="border-bottom: solid;border-width: 1px">
     <thead>
         <tr border="2" bordercolor="#E6FFFF" bgcolor="#FFFFCC">
           <td width="150" colspan="20" nowrap="nowrap"><div align="center"><strong style="font-size: 12pt; color:blue">会社名</strong></div></td>
           <td width="200" colspan="20" nowrap="nowrap"><div align="center"><strong style="font-size: 12pt; color:blue">注文名</strong></div></td>
           <td width="80" colspan="20" nowrap="nowrap"><div align="center"><strong style="font-size: 12pt; color:blue">納入日</strong></div></td>
           <td width="70" colspan="20" nowrap="nowrap"><div align="center"><strong style="font-size: 12pt; color:blue">単価</strong></div></td>
           <td width="70" colspan="20" nowrap="nowrap"><div align="center"><strong style="font-size: 12pt; color:blue">数量</strong></div></td>
           <td width="70" colspan="20" nowrap="nowrap"><div align="center"><strong style="font-size: 12pt; color:blue">状況</strong></div></td>
           <td width="50" colspan="20" nowrap="nowrap"><div align="center"><strong style="font-size: 12pt; color:blue"></strong></div></td>
         </tr>
     </thead>
     <tbody border="2" bordercolor="#E6FFFF" bgcolor="#FFFFCC">
       <?php for($i=0; $i<count($arrOrderSpecials); $i++): ?>
         <tr style="border-bottom: solid;border-width: 1px">

           <?php
           $Customers = $this->Customers->find()->where(['customer_code' => $arrOrderSpecials[$i]["cs_id"]])->toArray();
           $cs_name = $Customers[0]->name;

           if($arrOrderSpecials[$i]["kannou"] > 0){
             $kannou = "完納";
           }else{
             $kannou = "未納";
           }
           ?>

           <td colspan="20" nowrap="nowrap"><?= h($cs_name) ?></td>
           <td colspan="20" nowrap="nowrap"><?= h($arrOrderSpecials[$i]["order_name"]) ?></td>
           <td colspan="20" nowrap="nowrap"><?= h($arrOrderSpecials[$i]["date_deliver"]->format('Y-m-d')) ?></td>
           <td colspan="20" nowrap="nowrap"><?= h($arrOrderSpecials[$i]["price"]) ?></td>
           <td colspan="20" nowrap="nowrap"><?= h($arrOrderSpecials[$i]["amount"]) ?></td>
           <td colspan="20" nowrap="nowrap"><?= h($kannou) ?></td>
           <?php
           echo "<td colspan='20' nowrap='nowrap'><div align='center'>";
           echo $this->Form->submit("編集" , ['action'=>'hensyu', 'name' => $arrOrderSpecials[$i]["id"]]) ;
           echo "</div></td>";
           ?>
         </tr>
        <?php endfor;?>
     </tbody>
   </table>
 <br><br><br>
