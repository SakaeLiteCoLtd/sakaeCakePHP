<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\Deliver $product
 */
 use App\myClass\Shinkimenus\htmlShinkimenu;//myClassフォルダに配置したクラスを使用

 $htmlShinkimenu = new htmlShinkimenu();
 $htmldenpyomenus = $htmlShinkimenu->denpyomenus();
?>
<?php
  $username = $this->request->Session()->read('Auth.User.username');

  header('Expires:-1');
  header('Cache-Control:');
  header('Pragma:');
  echo $this->Form->create($OrderToSuppliers, ['url' => ['action' => 'yobizaikodo']]);
?>
<?php
//納期のかぶりをチェック
$arrdate_deliver = array();//空の配列を作る
for ($j=0;$j<=$tuika;$j++){
  $arrdate_deliver[] = $arrOrderToSupplier[$j]['date_deliver'];//配列に追加する
}

$uniquearrdate_deliver = array_unique($arrdate_deliver, SORT_REGULAR);//重複削除
$cntuniquearrdate_deliver = count($uniquearrdate_deliver);

  if($cntuniquearrdate_deliver == $tuika){
    $deliver_check = 1;
  }else{
    $deliver_check = 0;
  }

?>

<hr size="5" style="margin: 0.5rem">
<table style="margin-bottom:0px" width="750" border="0" align="center" cellpadding="0" cellspacing="0" bordercolor="#CCCCCC">
<?php
echo $htmldenpyomenus;
?>
</table>
 <hr size="5" style="margin: 0.5rem">
 <table style="margin-bottom:0px" width="750" border="0" align="center" cellpadding="0" cellspacing="0" bordercolor="#CCCCCC">
 <tr style="background-color: #E6FFFF">
   <td style="padding: 0.1rem 0.1rem;"><a href="qr/index.php"><?php echo $this->Html->image('Labelimg/hattyusumi.gif',array('width'=>'85','height'=>'36','url'=>array('controller'=>'orderEdis','action'=>'denpyouhenkoukensaku')));?></td>
   <td style="padding: 0.1rem 0.1rem;"><a href="qr/index.php"><?php echo $this->Html->image('Labelimg/yobizaiko.gif',array('width'=>'85','height'=>'36','url'=>array('controller'=>'orderEdis','action'=>'yobizaikopreadd')));?></td>
 </tr>
 </table>
 <hr size="5" style="margin: 0.5rem">
 <br>
 <legend align="center"><strong style="font-size: 13pt; color:blue"><?= __("予備在庫発注") ?></strong></legend>
<br>

<?php if($deliver_check == 0): //納期がかぶっていない場合 ?>

<table width="200" align="left" border="2" bordercolor="#E6FFFF" cellpadding="0" cellspacing="0" style="border-bottom: solid;border-width: 1px">
  <tr>
    <td bgcolor="#FFFFCC" style="font-size: 12pt;"><strong style="font-size: 11pt; color:blue">担当者</strong></td>
 </tr>
 <tr>
   <td bgcolor="#FFFFCC" style="font-size: 12pt;"><strong style="font-size: 10pt"><?= __($Staff) ?></strong></td>
</tr>
</table>
<br><br><br>
<br><br><br>
<table align="left" border="2" bordercolor="#E6FFFF" cellpadding="0" cellspacing="0">
  <tr style="border-bottom: solid;border-width: 1px">
    <td bgcolor="#FFFFCC"><strong style="font-size: 13pt; color:blue">品番</strong></td>
    <td bgcolor="#FFFFCC"><strong style="font-size: 13pt; color:blue">品名</strong></td>
  </tr>
  <tr style="border-bottom: solid;border-width: 1px">
    <td width="350"  bgcolor="#FFFFCC" style="font-size: 12pt;"><?= h($product_code) ?></td>
    <td width="350"  bgcolor="#FFFFCC" style="font-size: 12pt;"><?= h($product_name) ?></td>
  </tr>
</table>
<br><br><br>
<br><br><br>
<table align="left" border="2" bordercolor="#E6FFFF" cellpadding="0" cellspacing="0">
  <tr style="border-bottom: solid;border-width: 1px">
    <td bgcolor="#FFFFCC"><strong style="font-size: 13pt; color:blue">発注先</strong></td>
    <td bgcolor="#FFFFCC"><strong style="font-size: 13pt; color:blue">発注日</strong></td>
  </tr>
  <tr style="border-bottom: solid;border-width: 1px">
    <td width="400"  bgcolor="#FFFFCC" style="font-size: 12pt;"><?= h($Supplier) ?></td>
    <td width="300"  bgcolor="#FFFFCC" style="font-size: 12pt;"><?= h(date('Y-m-d')) ?></td>
  </tr>
</table>
<br><br><br>
<br><br><br>


<table align="left" border="2" bordercolor="#E6FFFF" cellpadding="0" cellspacing="0">
<tr bgcolor="#E6FFFF" >
  <td align="left" rowspan="2" width="50" bgcolor="#E6FFFF" style="border: none"><div align="right"><?= $this->Form->submit(__('登録'), array('name' => 'touroku')); ?></div></td>
  <td width="300" colspan="40" nowrap="nowrap" bgcolor="#E6FFFF" style="border: none"><div align="center"><strong style="font-size: 15pt; color:blue"></strong></div></td>
  <td width="300" colspan="50" nowrap="nowrap" bgcolor="#E6FFFF" style="border: none"><div align="center"><strong style="font-size: 15pt; color:blue"></strong></div></td>
</tr>
</table>

<table align="left" border="2" bordercolor="#E6FFFF" cellpadding="0" cellspacing="0">
  <tr style="border-bottom: solid;border-width: 1px">
    <td width='100'  bgcolor="#FFFFCC"><strong style="font-size: 13pt; color:blue">No.</strong></td>
    <td width='200'  bgcolor="#FFFFCC"><strong style="font-size: 13pt; color:blue">数量</strong></td>
    <td width='400'  bgcolor="#FFFFCC"><strong style="font-size: 13pt; color:blue">納期</strong></td>
  </tr>

  <?php for($i=0; $i<=$tuika; $i++): ?>
  <tr style="border-bottom: solid;border-width: 1px">
    <td bgcolor="#FFFFCC"><?= h($i+1) ?></td>
    <td bgcolor="#FFFFCC"><?= h($arrOrderToSupplier[$i]['amount']) ?></td>
    <td bgcolor="#FFFFCC"><?= h($arrOrderToSupplier[$i]['date_deliver']) ?></td>
  </tr>
  <?= $this->Form->control('num', array('type'=>'hidden', 'value'=>$i, 'label'=>false)) ?>
  <?php endfor;?>
</table>

<br><br><br><br>
<br><br><br><br>
<br><br><br><br>
<br><br><br>

<?php else: //分納追加（削除）を押された場合?>

  <br>
    <legend align="center"><strong style="font-size: 11pt; color:red"><?= "※納期が被っています。納期を変更してください。" ?></strong></legend>
  <br><br><br>

<?php endif; ?>
