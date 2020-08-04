<?php
$this->layout = 'defaultshinki';
?>
<?php
use Cake\ORM\TableRegistry;//独立したテーブルを扱う
$this->Staffs = TableRegistry::get('staffs');
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
<table style="margin-bottom:0px" width="750" border="0" align="center" cellpadding="0" cellspacing="0" bordercolor="#CCCCCC">
<tr style="background-color: #E6FFFF">
  <td style="padding: 0.1rem 0.1rem;"><a href="qr/index.php"><?php echo $this->Html->image('Labelimg/label_touroku.gif',array('width'=>'85','height'=>'36','url'=>array('action'=>'syoumouhinform')));?></td>
  <td style="padding: 0.1rem 0.1rem;"><a href="qr/index.php"><?php echo $this->Html->image('Labelimg/subYobidashi.gif',array('width'=>'85','height'=>'36','url'=>array('action'=>'syoumouhinyobidashi')));?></td>
</tr>
</table>
<hr size="5" style="margin: 0.5rem">

  <?= $this->Form->create($syoumouSuppliers, ['url' => ['action' => 'menu']]) ?>
<br><br>
  <table align="center" border="2" bordercolor="#E6FFFF" cellpadding="0" cellspacing="0">
    <tbody border="2" bordercolor="#E6FFFF" bgcolor="#FFFFCC" style="border-bottom: solid;border-width: 1px">
          <thead>
              <tr border="2" bordercolor="#E6FFFF" bgcolor="#FFFFCC">
                <td width="30" height="30" colspan="20" nowrap="nowrap"><div align="center"><strong style="font-size: 13pt; color:blue"></strong></div></td>
                <td width="200" height="30" colspan="20" nowrap="nowrap"><div align="center"><strong style="font-size: 13pt; color:blue">業者名</strong></div></td>
                <td width="200" height="30" colspan="20" nowrap="nowrap"><div align="center"><strong style="font-size: 13pt; color:blue">ふりがな</strong></div></td>
                <td width="120" height="30" colspan="20" nowrap="nowrap"><div align="center"><strong style="font-size: 13pt; color:blue">登録者</strong></div></td>
              </tr>
          </thead>
          <tbody border="2" bordercolor="#E6FFFF" bgcolor="#FFFFCC">
            <?php for($i=0; $i<count($SyoumouSuppliers); $i++): ?>
            <tr style="border-bottom: solid;border-width: 1px">

              <?php
              $created_staff = $SyoumouSuppliers[$i]->created_staff;
              $Staffs = $this->Staffs->find()->where(['id' => $created_staff])->toArray();
              if(isset($Staffs[0])){
                $staff = $Staffs[0]->f_name." ".$Staffs[0]->l_name;
              }else{
                $Staffs2 = $this->Staffs->find()->where(['staff_code' => $created_staff])->toArray();
                if(isset($Staffs2[0])){
                  $staff = $Staffs2[0]->f_name." ".$Staffs2[0]->l_name;
                }else{
                  $staff = "";
                }
              }
              ?>

              <td colspan="20" nowrap="nowrap"><font><?= h($i+1) ?></font></td>
              <td colspan="20" nowrap="nowrap"><font><?= h($SyoumouSuppliers[$i]->name) ?></font></td>
              <td colspan="20" nowrap="nowrap"><font><?= h($SyoumouSuppliers[$i]->furigana) ?></font></td>
              <td colspan="20" nowrap="nowrap"><font><?= h($staff) ?></font></td>
            </tr>
          <?php endfor;?>
          </tbody>
      </table>
  <br><br>
