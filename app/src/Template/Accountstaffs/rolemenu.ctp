<?php
$this->layout = 'defaultaccount';
?>

<?php
use App\myClass\Shinkimenus\htmlShinkimenu;//myClassフォルダに配置したクラスを使用
?>
<?php
    $htmlShinkimenu = new htmlShinkimenu();
    $htmlaccountmenus = $htmlShinkimenu->accountmenus();
?>
<hr size="5" style="margin: 0.5rem">
<table style="margin-bottom:0px" width="750" border="0" align="center" cellpadding="0" cellspacing="0" bordercolor="#CCCCCC">
  <?php
       echo $htmlaccountmenus;
  ?>
</table>
<hr size="5" style="margin: 0.5rem">
<table style="margin-bottom:0px" width="500" border="0" align="center" cellpadding="0" cellspacing="0" bordercolor="#CCCCCC">
  <tr style="background-color: #E6FFFF">
    <td style="padding: 0.1rem 0.1rem;"><a href="qr/index.php"><?php echo $this->Html->image('Labelimg/roletouroku.gif',array('width'=>'105','url'=>array('action'=>'rolemenu')));?></td>
  </tr>
</table>
<hr size="5" style="margin: 0.5rem">

<?= $this->Form->create($user, ['url' => ['action' => 'roleeditform']]) ?>

<table align="center" border="2" bordercolor="#E6FFFF" cellpadding="0" cellspacing="0">
  <tbody border="2" bordercolor="#E6FFFF" bgcolor="#FFFFCC" style="border-bottom: solid;border-width: 1px">
        <thead>
            <tr border="2" bordercolor="#E6FFFF" bgcolor="#FFFFCC">
              <td width="150" height="30" colspan="20" nowrap="nowrap"><div align="center"><strong style="font-size: 12pt; color:blue">ユーザー名</strong></div></td>
              <td width="150" height="30" colspan="20" nowrap="nowrap"><div align="center"><strong style="font-size: 12pt; color:blue">社員名</strong></div></td>
              <td width="150" height="30" colspan="20" nowrap="nowrap"><div align="center"><strong style="font-size: 12pt; color:blue">権限</strong></div></td>
              <td width="50" height="30" colspan="20" nowrap="nowrap"><div align="center"><strong style="font-size: 12pt; color:blue"></strong></div></td>
            </tr>
        </thead>
        <tbody border="2" bordercolor="#E6FFFF" bgcolor="#FFFFCC">
          <?php for($i=0; $i<count($arrUsers); $i++): ?>
            <tr style="border-bottom: solid;border-width: 1px">
              <td colspan="20" nowrap="nowrap"><?= h($arrUsers[$i]["username"]) ?></td>
              <td colspan="20" nowrap="nowrap"><?= h($arrUsers[$i]["staff_name"]) ?></td>
              <td colspan="20" nowrap="nowrap"><?= h($arrUsers[$i]["role_name"]) ?></td>
              <?php
              echo "<td colspan='20' nowrap='nowrap'><div align='center'>";
              echo $this->Form->submit("編集" , ['action'=>'hensyu', 'name' => $arrUsers[$i]["id"]]) ;
              echo "</div></td>";
              ?>
            </tr>
           <?php endfor;?>
        </tbody>
    </table>
<br><br><br>
