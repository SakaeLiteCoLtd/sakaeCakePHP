<?php
$this->layout = 'defaultshinki';
?>
<?php
 use App\myClass\Shinkimenus\htmlShinkimenu;//myClassフォルダに配置したクラスを使用

 $htmlShinkimenu = new htmlShinkimenu();
 $htmlShinkis = $htmlShinkimenu->Shinkimenus();
?>
<hr size="5" style="margin: 0.5rem">
<table style="margin-bottom:0px" width="750" border="0" align="center" cellpadding="0" cellspacing="0" bordercolor="#CCCCCC">
<?php
   echo $htmlShinkis;
?>
</table>
<hr size="5" style="margin: 0.5rem">
<table style="margin-bottom:0px" width="500" border="0" align="center" cellpadding="0" cellspacing="0" bordercolor="#CCCCCC">
  <tr style="background-color: #E6FFFF">
    <td style="padding: 0.1rem 0.1rem;"><a href="qr/index.php"><?php echo $this->Html->image('Labelimg/genryoudaitai.gif',array('width'=>'85','height'=>'36','url'=>array('controller'=>'daitais', 'action'=>'index')));?></td>
  </tr>
</table>
<hr size="5" style="margin: 0.5rem">
<br>
<?=$this->Form->create($Materials, ['url' => ['action' => 'editform']]) ?>
<br>
<legend align="center"><font color="black"><?= __("代替名一覧") ?></font></legend>
<br>
<table align="center" border="2" bordercolor="#E6FFFF" cellpadding="0" cellspacing="0">
  <tbody border="2" bordercolor="#E6FFFF" bgcolor="#FFFFCC" style="border-bottom: solid;border-width: 1px">
        <thead>
            <tr border="2" bordercolor="#E6FFFF" bgcolor="#FFFFCC">
              <td width="200" height="30" colspan="20" nowrap="nowrap"><div align="center"><strong style="font-size: 12pt; color:blue">グレード_色（21字以上）</strong></div></td>
              <td width="200" height="30" colspan="20" nowrap="nowrap"><div align="center"><strong style="font-size: 12pt; color:blue">代替名</strong></div></td>
              <td width="50" height="30" colspan="20" nowrap="nowrap"><div align="center"><strong style="font-size: 12pt; color:blue"></strong></div></td>
            </tr>
        </thead>
        <tbody border="2" bordercolor="#E6FFFF" bgcolor="#FFFFCC">
          <?php for($i=0; $i<count($arrMaterials); $i++): ?>
            <tr style="border-bottom: solid;border-width: 1px">
              <td colspan="20" nowrap="nowrap"><?= h($arrMaterials[$i]["grade"]."_".$arrMaterials[$i]["color"]) ?></td>
              <td colspan="20" nowrap="nowrap"><?= h($arrMaterials[$i]["name_substitute"]) ?></td>
              <?php
              echo "<td colspan='20' nowrap='nowrap'><div align='center'>";
              echo $this->Form->submit("編集" , ['action'=>'hensyu', 'name' => $arrMaterials[$i]["id"]]) ;
              echo "</div></td>";
              ?>
            </tr>
           <?php endfor;?>
        </tbody>
    </table>
<br><br><br>
