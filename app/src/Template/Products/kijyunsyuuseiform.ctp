<?php
$this->layout = 'defaultshinki';
?>
<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\Deliver $product
 */
 use App\myClass\Shinkimenus\htmlShinkimenu;//myClassフォルダに配置したクラスを使用

 $htmlShinkimenu = new htmlShinkimenu();
 $htmlShinkis = $htmlShinkimenu->Shinkimenus();
?>
        <?php
          $username = $this->request->Session()->read('Auth.User.username');

          header('Expires:-1');
          header('Cache-Control:');
          header('Pragma:');
          echo $this->Form->create($ZensuProducts, ['url' => ['action' => 'kijyunsyuuseiconfirm']]);

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
   <td style="padding: 0.1rem 0.1rem;"><a href="qr/index.php"><?php echo $this->Html->image('Labelimg/label_kensaku.gif',array('width'=>'85','height'=>'36','url'=>array('controller'=>'products','action'=>'kijyunyobidasiform')));?></td>
   <td style="padding: 0.1rem 0.1rem;"><a href="qr/index.php"><?php echo $this->Html->image('Labelimg/label_touroku.gif',array('width'=>'85','height'=>'36','url'=>array('controller'=>'products','action'=>'kijyunsyuuseikensaku')));?></td>
 </tr>
 </table>
 <hr size="5" style="margin: 0.5rem">
 <br>
 <legend align="center"><strong style="font-size: 13pt; color:blue"><?= __("外観検査基準時間修正") ?></strong></legend>
<br>

<table align="center" border="2" bordercolor="#E6FFFF" cellpadding="0" cellspacing="0">
  <tbody border="2" bordercolor="#E6FFFF" bgcolor="#FFFFCC" style="border-bottom: solid;border-width: 1px">
    <tr style="border-bottom: 0px;border-width: 0px">
      <td width="300" colspan="40" nowrap="nowrap"><div align="center"><strong style="font-size: 13pt; color:blue">品番</strong></div></td>
    </tr>
    <tr style="border-bottom: 0px;border-width: 0px">
      <td bgcolor="#FFFFCC"><?= h($this->request->getData('product_code')) ?></td>
    </tr>
  </table>
<table align="center" border="2" bordercolor="#E6FFFF" cellpadding="0" cellspacing="0">
  <table align="center" border="2" bordercolor="#E6FFFF" cellpadding="0" cellspacing="0">
    <tbody border="2" bordercolor="#E6FFFF" bgcolor="#FFFFCC" style="border-bottom: solid;border-width: 1px">
      <tr style="border-bottom: 0px;border-width: 0px">
        <td width="300" colspan="2" bgcolor="#FFFFCC" style="font-size: 12pt"><strong style="font-size: 11pt; color:blue">外観検査基準時間</strong></td>
      </tr>
      <tr style="border-bottom: 0px;border-width: 0px">
        <td width="220" bgcolor="#FFFFCC" style="border-right-style: none"><?= $this->Form->control('kijyun', array('type'=>'text', 'label'=>false, 'autofocus'=>true)) ?></td>
        <td width="80" bgcolor="#FFFFCC" style="border-left-style: none"><strong style="font-size: 11pt; color:blue">分</strong></td>
      </tr>
    </table>
  <br>

  <?php
  echo $this->Form->hidden('product_code' ,['value'=>$this->request->getData('product_code')]);
  echo $this->Form->hidden('ZensuProductId' ,['value'=>$ZensuProductId]);
  ?>

  <table align="center" border="2" bordercolor="#E6FFFF" cellpadding="0" cellspacing="0">
    <tr bgcolor="#E6FFFF" >
      <td align="center" rowspan="2" width="30" bgcolor="#E6FFFF" style="border: none"><div align="center"><?= $this->Form->submit(__('確認'), array('name' => 'confirm', 'value'=>"1")); ?></div></td>
    </tr>
  </table>

<br><br><br>
