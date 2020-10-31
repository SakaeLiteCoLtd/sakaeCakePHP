<?php
 use App\myClass\Genryoumenu\htmlGenryoumenu;//myClassフォルダに配置したクラスを使用
 $htmlGenryoumenu = new htmlGenryoumenu();
 $htmlGenryou = $htmlGenryoumenu->Genryoumenus();
 $htmlnyuukomenus = $htmlGenryoumenu->nyuukomenus();

 use Cake\ORM\TableRegistry;//独立したテーブルを扱う
 $this->DeliverCompanies = TableRegistry::get('deliverCompanies');
 $this->Staffs = TableRegistry::get('staffs');
 ?>
 <hr size="5" style="margin: 0.5rem">
 <table style="margin-bottom:0px" width="1200" border="0" align="center" cellpadding="0" cellspacing="0" bordercolor="#CCCCCC">
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
    <div align="left"><font color="blue" size="3"><?= __("　　　期限超過一覧") ?></font></div>
 <br>
    <div align="center"><font color="red" size="3"><?= __($mes) ?></font></div>
 <br>

<?=$this->Form->create($OrderMaterials, ['url' => ['action' => 'nyuukonouki']]) ?>
<table align="center" border="2" bordercolor="#E6FFFF" cellpadding="0" cellspacing="0">
<tr>
<td style="border-style: none;"><div align="center"><?= $this->Form->submit('一覧へ', array('name' => 'itiran')); ?></div></td>
</tr>
</table>
<br>

<table align="center" border="2" bordercolor="#E6FFFF" cellpadding="0" cellspacing="0">
  <tbody border="2" bordercolor="#E6FFFF" bgcolor="#FFFFCC" style="border-bottom: solid;border-width: 1px">
        <thead>
          <tr border="2" bordercolor="#E6FFFF" bgcolor="#FFFFCC">
            <td width="100" height="30" colspan="20" nowrap="nowrap"><div align="center"><strong style="font-size: 10pt; color:#FF66FF">ID</strong></div></td>
            <td width="80" height="30" colspan="20" nowrap="nowrap"><div align="center"><strong style="font-size: 10pt; color:#FF66FF">グレード</strong></div></td>
            <td width="80" height="30" colspan="20" nowrap="nowrap"><div align="center"><strong style="font-size: 10pt; color:#FF66FF">色番号</strong></div></td>
            <td width="80" height="30" colspan="20" nowrap="nowrap"><div align="center"><strong style="font-size: 10pt; color:#FF66FF">数量</strong></div></td>
            <td width="100" height="30" colspan="20" nowrap="nowrap"><div align="center"><strong style="font-size: 10pt; color:#FF66FF">納入先</strong></div></td>
            <td width="100" height="30" colspan="20" nowrap="nowrap"><div align="center"><strong style="font-size: 10pt; color:#FF66FF">指定納期</strong></div></td>
            <td width="200" height="30" colspan="20" nowrap="nowrap"><div align="center"><strong style="font-size: 10pt; color:#FF66FF">業者連絡</strong></div></td>
            <td width="150" height="30" colspan="20" nowrap="nowrap"><div align="center"><strong style="font-size: 10pt; color:#FF66FF">実際入荷日</strong></div></td>
            <td width="100" height="30" colspan="20" nowrap="nowrap"><div align="center"><strong style="font-size: 10pt; color:#FF66FF">ロットNO.</strong></div></td>
            <td width="100" height="30" colspan="20" nowrap="nowrap"><div align="center"><strong style="font-size: 10pt; color:#FF66FF">入荷確認</strong></div></td>
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
            $num_lot = $arrOrderMaterials[$i]['num_lot'];
            $check_flag = $arrOrderMaterials[$i]['check_flag'];
            ?>

            <td colspan="20" nowrap="nowrap"><font color="blue"><?= h($arrOrderMaterials[$i]["date_order"]) ?></font></td>
            <td colspan="20" nowrap="nowrap"><font color="blue"><?= h($arrOrderMaterials[$i]["grade"]) ?></font></td>
            <td colspan="20" nowrap="nowrap"><font color="blue"><?= h($arrOrderMaterials[$i]["color"]) ?></font></td>
            <td colspan="20" nowrap="nowrap"><font color="blue"><?= h($arrOrderMaterials[$i]["amount"]) ?></font></td>
            <td colspan="20" nowrap="nowrap"><font color="blue"><?= h($company) ?></font></td>
            <td colspan="20" nowrap="nowrap"><font color="blue"><?= h($arrOrderMaterials[$i]["date_stored"]) ?></font></td>
            <td colspan="20" nowrap="nowrap"><div align="center"><?= $this->Form->input("check_flag", array('type' => 'select', "options"=>$arrGyousya, 'value'=>$check_flag, 'label'=>false)); ?></div></td>
            <td colspan="20" nowrap="nowrap"><div align="center"><?= $this->Form->input("date_nyuuka", array('type' => 'date', 'monthNames' => false, 'label'=>false)); ?></div></td>
            <td colspan="20" nowrap="nowrap"><div align="center"><?= $this->Form->control("num_lot", array('type' => 'text', 'label'=>false)); ?></div></td>
            <td colspan="20" nowrap="nowrap"><div align="center"><?= $this->Form->control("flg", array('type' => 'select', "options"=>$arrFlag, 'label'=>false)); ?></div></td>
          </tr>
        <?php endfor;?>
        </tbody>
    </table>
<br><br>
