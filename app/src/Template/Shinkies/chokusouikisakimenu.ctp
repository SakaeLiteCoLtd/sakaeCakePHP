<?php
$this->layout = 'defaultshinki';
?>
<?php
use App\myClass\Shinkimenus\htmlShinkimenu;//myClassフォルダに配置したクラスを使用
use Cake\ORM\TableRegistry;//独立したテーブルを扱う
$this->Customers = TableRegistry::get('customers');//productsテーブルを使う

$htmlShinkimenu = new htmlShinkimenu();
$htmlShinkis = $htmlShinkimenu->Shinkimenus();
$htmlchokusoumenus = $htmlShinkimenu->chokusoumenus();
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
  <?php echo $this->Html->image('Labelimg/chokusouikisaki.gif',array('width'=>'105'));?>
</tr>
</table>
<hr size="5" style="margin: 0.5rem">
<table style="margin-bottom:0px" width="1000" border="0" align="center" cellpadding="0" cellspacing="0" bordercolor="#CCCCCC">
  <tr style="background-color: #E6FFFF">
    <td style="padding: 0.1rem 0.1rem;"><a href="qr/index.php"><?php echo $this->Html->image('Labelimg/chokusoushinki.gif',array('width'=>'105','url'=>array('action'=>'chokusouikisakiform')));?></td>
    <td style="padding: 0.1rem 0.1rem;"><a href="qr/index.php"><?php echo $this->Html->image('Labelimg/chokusouhensyuu.gif',array('width'=>'105','url'=>array('action'=>'chokusouikisakieditform')));?></td>
  </tr>

</table>
<hr size="5" style="margin: 0.5rem">
<br><br>
<table align="center" border="2" bordercolor="#E6FFFF" cellpadding="0" cellspacing="0">
  <tbody border="2" bordercolor="#E6FFFF" bgcolor="#FFFFCC" style="border-bottom: solid;border-width: 1px">
        <thead>
            <tr border="2" bordercolor="#E6FFFF" bgcolor="#FFFFCC">
              <td width="150" height="30" colspan="20" nowrap="nowrap"><div align="center"><strong style="font-size: 12pt; color:blue">ID</strong></div></td>
              <td width="200" height="30" colspan="20" nowrap="nowrap"><div align="center"><strong style="font-size: 12pt; color:blue">行先</strong></div></td>
              <td width="300" height="30" colspan="20" nowrap="nowrap"><div align="center"><strong style="font-size: 12pt; color:blue">顧客</strong></div></td>
              <td width="150" height="30" colspan="20" nowrap="nowrap"><div align="center"><strong style="font-size: 12pt; color:blue">現状</strong></div></td>
            </tr>
        </thead>
        <tbody border="2" bordercolor="#E6FFFF" bgcolor="#FFFFCC">
          <?php for($i=0; $i<count($arrPlaceDelivers); $i++): ?>
            <tr style="border-bottom: solid;border-width: 1px">
              <td width="150" colspan="20" nowrap="nowrap"><?= h($arrPlaceDelivers[$i]["id_from_order"]) ?></td>
              <td width="200" colspan="20" nowrap="nowrap"><?= h($arrPlaceDelivers[$i]["name"]) ?></td>
                <?php
                  $cs_code = $arrPlaceDelivers[$i]["cs_code"];
              		$Customers = $this->Customers->find()->where(['customer_code' => $cs_code])->toArray();
                  if(isset($Customers[0])){
                    $name = $Customers[0]->name;
                  }else{
                    $name = "";
                  }
                  if($arrPlaceDelivers[$i]["status"] == 1){
                    $status_hyouji = "不使用";
                  }else{
                    $status_hyouji = "使用中";
                  }
                ?>
                <td width="300" colspan="20" nowrap="nowrap"><?= h($name) ?></td>
                <td width="150" colspan="20" nowrap="nowrap"><?= h($status_hyouji) ?></td>
            </tr>
          <?php endfor;?>
        </tbody>
    </table>
<br><br>
