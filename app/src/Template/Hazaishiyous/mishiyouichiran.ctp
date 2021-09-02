<?php
 use App\myClass\Genryoumenu\htmlGenryoumenu;//myClassフォルダに配置したクラスを使用
 $htmlGenryoumenu = new htmlGenryoumenu();
 $htmlGenryou = $htmlGenryoumenu->Genryoumenus();

 echo $this->Form->create($stockEndMaterials, ['url' => ['action' => 'mishiyouichiran']]);

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
    <td style="padding: 0.1rem 0.1rem;"><a href="qr/index.php"><?php echo $this->Html->image('Labelimg/hazaisiyousuuryou.gif',array('width'=>'85','url'=>array('controller'=>'Hazaishiyous', 'action'=>'menu')));?></td>
  </tr>
</table>
<hr size="5" style="margin: 0.5rem">
 <table style="margin-bottom:0px" width="750" border="0" align="center" cellpadding="0" cellspacing="0" bordercolor="#CCCCCC">
  <tr style="background-color: #E6FFFF">
    <td style="padding: 0.1rem 0.1rem;"><a href="qr/index.php"><?php echo $this->Html->image('Labelimg/hazaimishiyoukensakublue.gif',array('width'=>'85','url'=>array('action'=>'mishiyoukensakuform')));?></td>
  </tr>
</table>
<hr size="5" style="margin: 0.5rem">
<br>
<table style="margin-bottom:0px" width="750" border="0" align="center" cellpadding="0" cellspacing="0" bordercolor="#CCCCCC">
   <tr style="background-color: #E6FFFF">
     <td bgcolor="#E6FFFF"><strong style="font-size: 11pt; color:black"><?= h("未使用端材一覧") ?></strong></td>
   </tr>
 </table>
 <br>
<table align="center" border="2" bordercolor="#E6FFFF" cellpadding="0" cellspacing="0">
  <tbody border="2" bordercolor="#E6FFFF" bgcolor="#FFFFCC" style="border-bottom: solid;border-width: 1px">
          <tr border="2" bordercolor="#E6FFFF" bgcolor="#FFFFCC">
            <td width="150" height="20" colspan="20" nowrap="nowrap"><div align="center"><strong style="font-size: 10pt; color:blue">端材</strong></div></td>
          </tr>
          <tr style="border-bottom: solid;border-width: 1px">
            <td colspan="20" nowrap="nowrap"><?= h($materialgrade_color) ?></td>
          </tr>
        </tbody>
      </table>
<br><br>
<table align="center" border="2" bordercolor="#E6FFFF" cellpadding="0" cellspacing="0">
  <tbody border="2" bordercolor="#E6FFFF" bgcolor="#FFFFCC" style="border-bottom: solid;border-width: 1px">
          <tr border="2" bordercolor="#E6FFFF" bgcolor="#FFFFCC">
            <td width="150" colspan="20" nowrap="nowrap"><div align="center"><strong style="font-size: 10pt; color:blue">端材</strong></div></td>
            <td width="150" colspan="20" nowrap="nowrap"><div align="center"><strong style="font-size: 10pt; color:blue">ロットNo.</strong></div></td>
            <td width="150" colspan="20" nowrap="nowrap"><div align="center"><strong style="font-size: 10pt; color:blue">端材ステータス</strong></div></td>
            <td width="100" colspan="20" nowrap="nowrap"><div align="center"><strong style="font-size: 10pt; color:blue">数量(kg)</strong></div></td>
            <td width="150" colspan="20" nowrap="nowrap"><div align="center"><strong style="font-size: 10pt; color:blue">TAB取込日時</strong></div></td>
            <td width="100" colspan="20" nowrap="nowrap"><div align="center"><strong style="font-size: 10pt; color:blue">合計数量(kg)</strong></div></td>
          </tr>

          <?php for($i=0; $i<count($arrShiyouhazais); $i++): ?>

            <tr style="border-bottom: solid;border-width: 1px">

            <?php
                $num = $arrShiyouhazais[$i]['num'];

                if($i == 0){
                  echo "<td colspan='20' nowrap='nowrap' rowspan=$num><div align='center'>";
                  echo $arrShiyouhazais[$i]["grade_color"];
                  echo "</div></td>";
                }

                if($i > 0 && $arrShiyouhazais[$i-1]["grade_color"] != $arrShiyouhazais[$i]["grade_color"]){
                  echo "<td colspan='20' nowrap='nowrap' rowspan=$num><div align='center'>";
                  echo $arrShiyouhazais[$i]["grade_color"];
                  echo "</div></td>";
                }

            ?>

                <td colspan="20" nowrap="nowrap"><?= h($arrShiyouhazais[$i]["lot_num"]) ?></td>
                <td colspan="20" nowrap="nowrap"><?= h($arrShiyouhazais[$i]["status_material"]) ?></td>
                <td colspan="20" nowrap="nowrap"><?= h($arrShiyouhazais[$i]["amount"]) ?></td>
                <td colspan="20" nowrap="nowrap"><?= h($arrShiyouhazais[$i]["import_tab_at"]) ?></td>

                <?php
                    $num = $arrShiyouhazais[$i]['num'];

                    if($i == 0){
                      echo "<td colspan='20' nowrap='nowrap' rowspan=$num><div align='center'>";
                      echo $arrShiyouhazais[$i]["totalamount"];
                      echo "</div></td>";
                    }

                    if($i > 0 && $arrShiyouhazais[$i-1]["grade_color"] != $arrShiyouhazais[$i]["grade_color"]){
                      echo "<td colspan='20' nowrap='nowrap' rowspan=$num><div align='center'>";
                      echo $arrShiyouhazais[$i]["totalamount"];
                      echo "</div></td>";
                    }

                ?>

              </tr>
            <?php endfor;?>

          </tbody>
        </table>
<br><br>
