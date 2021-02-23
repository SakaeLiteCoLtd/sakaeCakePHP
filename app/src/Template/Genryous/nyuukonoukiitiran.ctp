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
    <div align="left"><font color="blue" size="3"><?= __("　　　納期変更") ?></font></div>
 <br>

<?=$this->Form->create($OrderMaterials, ['url' => ['action' => 'nyuukonoukipreadd']]) ?>
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
            <td width="150" height="30" colspan="20" nowrap="nowrap"><div align="center"><strong style="font-size: 10pt; color:#FF66FF">新指定納期</strong></div></td>
            <td width="60" height="30" colspan="20" nowrap="nowrap"><div align="center"><strong style="font-size: 9pt; color:#FF66FF"></strong></div></td>
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
            $check_flag = $arrOrderMaterials[$i]['check_flag'];
            ?>

            <td colspan="20" nowrap="nowrap"><font color="blue"><?= h($arrOrderMaterials[$i]["id_order"]) ?></font></td>
            <td colspan="20" nowrap="nowrap"><font color="blue"><?= h($arrOrderMaterials[$i]["grade"]) ?></font></td>
            <td colspan="20" nowrap="nowrap"><font color="blue"><?= h($arrOrderMaterials[$i]["color"]) ?></font></td>
            <td colspan="20" nowrap="nowrap"><font color="blue"><?= h($arrOrderMaterials[$i]["amount"]) ?></font></td>
            <td colspan="20" nowrap="nowrap"><font color="blue"><?= h($company) ?></font></td>
            <td colspan="20" nowrap="nowrap"><font color="blue"><?= h($arrOrderMaterials[$i]["date_stored"]) ?></font></td>
            <td colspan="20" nowrap="nowrap"><div align="center"><?= $this->Form->control("date_stored".$i, array('type' => 'date', 'monthNames' => false, 'label'=>false)); ?></div></td>
            <?php
            echo "<td colspan='20' nowrap='nowrap'><div align='center'>";
            echo $this->Form->submit("更新" , ['action'=>'nyuukotyoukakousin', 'name' => $i]) ;
            echo "</div></td>";
            ?>
            <?= $this->Form->control('id'.$i, array('type'=>'hidden', 'value'=>$arrOrderMaterials[$i]["id"], 'label'=>false)) ?>

          </tr>
        <?php endfor;?>
        </tbody>
    </table>
<br><br>
