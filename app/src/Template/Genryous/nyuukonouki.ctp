<?php
 use App\myClass\Genryoumenu\htmlGenryoumenu;//myClassフォルダに配置したクラスを使用
 $htmlGenryoumenu = new htmlGenryoumenu();
 $htmlGenryou = $htmlGenryoumenu->Genryoumenus();
 $htmlnyuukomenus = $htmlGenryoumenu->nyuukomenus();
?>
 <hr size="5" style="margin: 0.5rem">
 <table style="margin-bottom:0px" width="750" border="0" align="center" cellpadding="0" cellspacing="0" bordercolor="#CCCCCC">
 <?php
    echo $htmlGenryou;
 ?>
 </table>
 <hr size="5" style="margin: 0.5rem">
 <table style="margin-bottom:0px" width="750" border="0" align="center" cellpadding="0" cellspacing="0" bordercolor="#CCCCCC">
 <?php
    echo $htmlnyuukomenus;
 ?>
 </table>
 <hr size="5" style="margin: 0.5rem">
 <?= $this->Form->create($OrderMaterials, ['url' => ['action' => 'nyuukonoukiitiran']]) ?>

 <br>
    <div align="left"><font color="blue" size="3"><?= __("　　　納期変更呼出") ?></font></div>
 <br>
 <table align="center" border="2" bordercolor="#E6FFFF" cellpadding="0" cellspacing="0" style="border-bottom: solid;border-width: 1px">
   <tr>
     <td width="210" bgcolor="#FFFFCC" style="font-size: 12pt;padding: 0.2rem"><strong style="font-size: 11pt; color:blue">グレード</strong></td>
     <td width="210"  bgcolor="#FFFFCC" style="font-size: 12pt;padding: 0.2rem"><strong style="font-size: 11pt; color:blue">色番号</strong></td>
 	</tr>
   <tr>
     <td bgcolor="#FFFFCC" style="padding: 0.2rem"><?= $this->Form->control('m_grade', array('type'=>'text', 'label'=>false, 'autofocus'=>true)) ?></td>
     <td bgcolor="#FFFFCC" style="padding: 0.2rem"><?= $this->Form->control('col_num', array('type'=>'text', 'label'=>false)) ?></td>
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
