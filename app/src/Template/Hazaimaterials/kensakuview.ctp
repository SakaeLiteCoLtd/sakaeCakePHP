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
<table style="margin-bottom:0px" width="1000" border="0" align="center" cellpadding="0" cellspacing="0" bordercolor="#CCCCCC">
  <tr style="background-color: #E6FFFF">
      <td style="padding: 0.1rem 0.1rem;"><a href="qr/index.php"><?php echo $this->Html->image('Labelimg/hazairotkensaku.gif',array('width'=>'105','url'=>array('action'=>'kensakuform')));?></td>
  </tr>
</table>
<hr size="5" style="margin: 0.5rem">
<br>

 <legend align="left"><font color="black"><?= __("　　TAB取込済みデータ一覧") ?></font></legend>
 <br>
 <table align="center" width="1000" border="2" bordercolor="#E6FFFF" cellpadding="0" cellspacing="0">
   <tbody border="2" bordercolor="#E6FFFF" bgcolor="#FFFFCC" style="border-bottom: solid;border-width: 1px">
         <thead>
             <tr border="2" bordercolor="#E6FFFF" bgcolor="#FFFFCC">
               <td width="120" height="30" colspan="20" nowrap="nowrap"><div align="center"><strong style="font-size: 12pt; color:blue">端材</strong></div></td>
               <td width="120" height="30" colspan="20" nowrap="nowrap"><div align="center"><strong style="font-size: 12pt; color:blue">ロットNo.</strong></div></td>
               <td width="120" height="30" colspan="20" nowrap="nowrap"><div align="center"><strong style="font-size: 12pt; color:blue">端材ステイタス</strong></div></td>
               <td width="80" height="30" colspan="20" nowrap="nowrap"><div align="center"><strong style="font-size: 12pt; color:blue">数量</strong></div></td>
               <td width="80" height="30" colspan="20" nowrap="nowrap"><div align="center"><strong style="font-size: 12pt; color:blue">登録日</strong></div></td>
               <td width="80" height="30" colspan="20" nowrap="nowrap"><div align="center"><strong style="font-size: 12pt; color:blue">登録者</strong></div></td>
               <td width="80" height="30" colspan="20" nowrap="nowrap"><div align="center"><strong style="font-size: 12pt; color:blue">出荷状況</strong></div></td>
             </tr>
         </thead>
         <tbody border="2" bordercolor="#E6FFFF" bgcolor="#FFFFCC">
           <?php for($i=0; $i<count($arrStockEndMaterials); $i++): ?>
             <tr style="border-bottom: solid;border-width: 1px">
               <td colspan="20" nowrap="nowrap"><?= h($arrStockEndMaterials[$i]["hazai"]) ?></td>
               <td colspan="20" nowrap="nowrap"><?= h($arrStockEndMaterials[$i]["lot_num"]) ?></td>
               <td colspan="20" nowrap="nowrap"><?= h($arrStockEndMaterials[$i]["status_material"]) ?></td>
               <td colspan="20" nowrap="nowrap"><?= h($arrStockEndMaterials[$i]["amount"]."kg") ?></td>
               <td colspan="20" nowrap="nowrap"><?= h($arrStockEndMaterials[$i]["created_at"]) ?></td>
               <td colspan="20" nowrap="nowrap"><?= h($arrStockEndMaterials[$i]["staff_name"]) ?></td>

               <?php
               if(strlen($arrStockEndMaterials[$i]["shiped_staff"]) > 0){
                 $shiped = "出荷済み";
               }else{
                 $shiped = "出荷待ち";
               }
               ?>

               <td colspan="20" nowrap="nowrap"><?= h($shiped) ?></td>
             </tr>
            <?php endfor;?>
         </tbody>
     </table>
 <br><br><br><br>
