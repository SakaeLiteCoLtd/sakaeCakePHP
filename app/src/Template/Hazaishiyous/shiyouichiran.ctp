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
<table style="margin-bottom:0px" width="1100" border="0" align="center" cellpadding="0" cellspacing="0" bordercolor="#CCCCCC">
  <tr style="background-color: #E6FFFF">
    <td style="padding: 0.1rem 0.1rem;"><a href="qr/index.php"><?php echo $this->Html->image('Labelimg/hazaisiyousuuryou.gif',array('width'=>'85','url'=>array('controller'=>'Hazaishiyous', 'action'=>'menu')));?></td>
  </tr>
</table>
<hr size="5" style="margin: 0.5rem">
 <table style="margin-bottom:0px" width="750" border="0" align="center" cellpadding="0" cellspacing="0" bordercolor="#CCCCCC">
  <tr style="background-color: #E6FFFF">
    <td style="padding: 0.1rem 0.1rem;"><a href="qr/index.php"><?php echo $this->Html->image('Labelimg/hazaisiyouichiranblue.gif',array('width'=>'85','url'=>array('action'=>'shiyoukensaku')));?></td>
  </tr>
</table>
<hr size="5" style="margin: 0.5rem">
<br>
<table align="center" border="2" bordercolor="#E6FFFF" cellpadding="0" cellspacing="0">
  <tbody border="2" bordercolor="#E6FFFF" bgcolor="#FFFFCC">
    <tr>
      <td width="100" style="border-bottom: solid;border-width: 1px" colspan="20" nowrap="nowrap"><strong style="font-size: 12pt; color:blue"><?= h("呼出日") ?></strong></td>
      <td width="150" style="border-bottom: solid;border-width: 1px" colspan="20" nowrap="nowrap"><strong style="font-size: 12pt"><?= h($dateYMD) ?></strong></td>
    </tr>
  </tbody>
</table>
<br>
<br>
<table align="center" border="2" bordercolor="#E6FFFF" cellpadding="0" cellspacing="0">
  <tbody border="2" bordercolor="#E6FFFF" bgcolor="#FFFFCC" style="border-bottom: solid;border-width: 1px">
          <tr border="2" bordercolor="#E6FFFF" bgcolor="#FFFFCC">
            <td height="20" width="50" colspan="20" nowrap="nowrap"><div align="center"><strong style="font-size: 9pt; color:blue">成形機</strong></div></td>
            <td width="150" colspan="20" nowrap="nowrap"><div align="center"><strong style="font-size: 10pt; color:blue">品番</strong></div></td>
            <td width="150" colspan="20" nowrap="nowrap"><div align="center"><strong style="font-size: 10pt; color:blue">品名</strong></div></td>
            <td width="150" colspan="20" nowrap="nowrap"><div align="center"><strong style="font-size: 10pt; color:blue">端材</strong></div></td>
            <td width="150" colspan="20" nowrap="nowrap"><div align="center"><strong style="font-size: 10pt; color:blue">ロットNo.</strong></div></td>
            <td width="150" colspan="20" nowrap="nowrap"><div align="center"><strong style="font-size: 10pt; color:blue">端材ステータス</strong></div></td>
            <td width="100" colspan="20" nowrap="nowrap"><div align="center"><strong style="font-size: 10pt; color:blue">数量(kg)</strong></div></td>

            <?php if($datecheck < 1): ?>

              <td width="30" colspan="20" nowrap="nowrap"><strong style="font-size: 10pt; color:blue">状況</strong></td>

            <?php else: ?>
            <?php endif; ?>

          </tr>
          <?php for($i=0; $i<count($arrShiyouhazai); $i++): ?>

          <tr style="border-bottom: solid;border-width: 1px">

            <?php
                $num = $arrShiyouhazai[$i]['num'];

                if($i == 0){
                  echo "<td colspan='20' nowrap='nowrap' rowspan=$num><div align='center'>";
                  echo $arrShiyouhazai[$i]["seikeiki"]." 号機";
                  echo "</div></td>";
                  echo "<td colspan='20' nowrap='nowrap' rowspan=$num><div align='center'>";
                  echo $arrShiyouhazai[$i]["product_code"];
                  echo "</div></td>";
                  echo "<td colspan='20' nowrap='nowrap' rowspan=$num><div align='center'>";
                  echo $arrShiyouhazai[$i]["product_name"];
                  echo "</div></td>";
                }

                if($i > 0 && $arrShiyouhazai[$i-1]["product_code"] != $arrShiyouhazai[$i]["product_code"]){
                  echo "<td colspan='20' nowrap='nowrap' rowspan=$num><div align='center'>";
                  echo $arrShiyouhazai[$i]["seikeiki"]." 号機";
                  echo "</div></td>";
                  echo "<td colspan='20' nowrap='nowrap' rowspan=$num><div align='center'>";
                  echo $arrShiyouhazai[$i]["product_code"];
                  echo "</div></td>";
                  echo "<td colspan='20' nowrap='nowrap' rowspan=$num><div align='center'>";
                  echo $arrShiyouhazai[$i]["product_name"];
                  echo "</div></td>";
                }

            ?>

            <td colspan="20" nowrap="nowrap"><?= h($arrShiyouhazai[$i]["grade_color"]) ?></td>
            <td colspan="20" nowrap="nowrap"><?= h($arrShiyouhazai[$i]["lot_num"]) ?></td>
            <td colspan="20" nowrap="nowrap"><?= h($arrShiyouhazai[$i]["status_material"]) ?></td>
            <td colspan="20" nowrap="nowrap"><?= h($arrShiyouhazai[$i]["amount"]) ?></td>

            <?php if($datecheck < 1): ?>

              <?php if($arrShiyouhazai[$i]["usedcheck"] === "使用"): ?>
                <td colspan="20" nowrap="nowrap"><strong style="font-size: 10pt; color:blue"><?= h($arrShiyouhazai[$i]["usedcheck"]) ?></strong></td>
              <?php else: ?>
                <td colspan="20" nowrap="nowrap"><strong style="font-size: 10pt; color:red"><?= h($arrShiyouhazai[$i]["usedcheck"]) ?></strong></td>
              <?php endif; ?>

            <?php else: ?>
            <?php endif; ?>

          </tr>

          <?php endfor;?>

      </tbody>
    </table>
<br><br><br>
