<?php
$this->layout = 'defaultshinki';
?>
<?php
use Cake\ORM\TableRegistry;//独立したテーブルを扱う
$this->OutsourceHandys = TableRegistry::get('outsourceHandys');
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
  <td style="padding: 0.1rem 0.1rem;"><a href="qr/index.php"><?php echo $this->Html->image('Labelimg/label_touroku.gif',array('width'=>'85','height'=>'36','url'=>array('action'=>'nyusyukkoform')));?></td>
  <td style="padding: 0.1rem 0.1rem;"><a href="qr/index.php"><?php echo $this->Html->image('Labelimg/subYobidashi.gif',array('width'=>'85','height'=>'36','url'=>array('action'=>'nyusyukkoyobidashi')));?></td>
</tr>
</table>
<hr size="5" style="margin: 0.5rem">

  <?= $this->Form->create($productSuppliers, ['url' => ['action' => 'menu']]) ?>
<br><br>
  <table align="center" border="2" bordercolor="#E6FFFF" cellpadding="0" cellspacing="0">
    <tbody border="2" bordercolor="#E6FFFF" bgcolor="#FFFFCC" style="border-bottom: solid;border-width: 1px">
          <thead>
              <tr border="2" bordercolor="#E6FFFF" bgcolor="#FFFFCC">
                <td width="200" height="30" colspan="20" nowrap="nowrap"><div align="center"><strong style="font-size: 13pt; color:blue">入出庫業者</strong></div></td>
                <td width="200" height="30" colspan="20" nowrap="nowrap"><div align="center"><strong style="font-size: 13pt; color:blue">ハンディ表示</strong></div></td>
              </tr>
          </thead>
          <tbody border="2" bordercolor="#E6FFFF" bgcolor="#FFFFCC">
            <?php for($i=0; $i<count($ProductSuppliers); $i++): ?>
            <tr style="border-bottom: solid;border-width: 1px">

              <?php
              $handy_id = $ProductSuppliers[$i]->handy_id;
              $OutsourceHandys = $this->OutsourceHandys->find()->where(['id' => $handy_id])->toArray();
              if(isset($OutsourceHandys[0])){
                $OutsourceHandy_name = $OutsourceHandys[0]->name;
              }else{
                $Suppliername = "";
              }
              ?>

              <td colspan="20" nowrap="nowrap"><font><?= h($ProductSuppliers[$i]->name) ?></font></td>
              <td colspan="20" nowrap="nowrap"><font><?= h($OutsourceHandy_name) ?></font></td>
            </tr>
          <?php endfor;?>
          </tbody>
      </table>
  <br><br>
