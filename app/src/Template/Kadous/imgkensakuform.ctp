<?php
//$this->layout = 'defaultkadous';
?>

<?php
  // header('Content-Type: image/png');
   //readfile('C:/Users/info/Desktop/kadouimg/RF51-B471HH/20/07/02/RF51-B471HH_200702_test2.gif');
   //readfile('/home/centosuser/kadouimg/RF51-B471HH/20/07/02/RF51-B471HH_200702_test2.gif');
  // readfile("img/$gif1");
//    readfile('/home/centosuser/kadouimg/RF51-B471HH/20/07/02/RF51-B471HH_200702_test2.gif');
?>

<?php
  $username = $this->request->Session()->read('Auth.User.username');

  header('Expires:-1');
  header('Cache-Control:');
  header('Pragma:');
  echo $this->Form->create($KadouSeikei, ['url' => ['action' => 'imgkensakuform']]);
?>
<?php
 use App\myClass\Kadous\htmlKadoumenu;//myClassフォルダに配置したクラスを使用
 $htmlKadoumenu = new htmlKadoumenu();
 $htmlKadoumenus = $htmlKadoumenu->Kadoumenus();
 ?>
 <hr size="5" style="margin: 0.5rem">
 <table style="margin-bottom:0px" width="750" border="0" align="center" cellpadding="0" cellspacing="0" bordercolor="#CCCCCC">
 <?php
    echo $htmlKadoumenus;
 ?>
 </table>

 <hr size="5" style="margin: 0.5rem">
<br>

<legend align="center"><font color="red"><?= __($mes) ?></font></legend>


<table align="center" border="2" bordercolor="#E6FFFF" cellpadding="0" cellspacing="0">
  <tbody border="2" bordercolor="#E6FFFF" bgcolor="#FFFFCC">
    <tr>
      <td width="100" style="border-bottom: solid;border-width: 1px"><div align="center"><strong style="font-size: 11pt; color:blue">成形機</strong></div></td>
      <td width="250" style="border-bottom: solid;border-width: 1px"><div align="center"><strong style="font-size: 11pt; color:blue">品番</strong></div></td>
      <td width="300" style="border-bottom: solid;border-width: 1px"><div align="center"><strong style="font-size: 11pt; color:blue">日報開始日時絞込</strong></div></td>
      <td width="250" style="border-bottom: solid;border-width: 1px"><div align="center"><strong style="font-size: 11pt; color:blue">プライオリティ</strong></div></td>
      <td width="250" style="border-bottom: solid;border-width: 1px"><div align="center"><strong style="font-size: 11pt; color:blue">グラフ種類</strong></div></td>
    </tr>
    <td width="100" style="border-bottom: solid;border-width: 1px"><div align="center"><?= h($seikeiki." 号機") ?></div></td>
    <td width="250" style="border-bottom: solid;border-width: 1px"><div align="center"><?= h($product_code) ?></div></td>
    <td width="300" style="border-bottom: solid;border-width: 1px"><div align="center"><?= $this->Form->input("date", array('type' => 'date', 'value' => $date_sta, 'monthNames' => false, 'label'=>false)); ?></div></td>
    <td width="250" style="border-bottom: solid;border-width: 1px"><?= $this->Form->input('priority', ["type"=>"select", "empty"=>"", "options"=>$arrImgpriority, 'label'=>false]); ?></td>
    <td width="250" style="border-bottom: solid;border-width: 1px"><?= $this->Form->input('type', ["type"=>"select", "empty"=>"", "options"=>$arrImgtype, 'label'=>false]); ?></td>
</table>

<br>

<table align="center" border="2" bordercolor="#E6FFFF" cellpadding="0" cellspacing="0">
  <tr>
    <td style="border-style: none;"><div align="left"><?= $this->Form->submit('前へ', array('name' => 'neg')); ?></div></td>
    <td  width="500" style="border-style: none;"><div align="left"></div></td>
    <td style="border-style: none;"><div align="center"><?= $this->Form->submit('グラフ呼出', array('name' => 'yobidasi')); ?></div></td>
    <td  width="500" style="border-style: none;"><div align="left"></div></td>
    <td style="border-style: none;"><div align="right"><?= $this->Form->submit('次へ', array('name' => 'poj')); ?></div></td>
  </tr>
</table>

<br><br>

<table style="margin-bottom:0px" width="1000" border="0" align="center" cellpadding="0" cellspacing="0" bordercolor="#CCCCCC">
   <tr style="background-color: #E6FFFF">
     <td style="padding: 0.1rem 0.1rem; text-align: center"><?php echo $this->Html->image('Labelimg/img_pink.png',array('width'=>'40','height'=>'30'));?><?= h(" : ".$lot_codes1) ?></td>
     <td style="padding: 0.1rem 0.1rem; text-align: center"><?php echo $this->Html->image('Labelimg/img_blue.png',array('width'=>'40','height'=>'30'));?><?= h(" : ".$lot_codes2) ?></td>
     <td style="padding: 0.1rem 0.1rem; text-align: center"><?php echo $this->Html->image('Labelimg/img_green.png',array('width'=>'40','height'=>'30'));?><?= h(" : ".$lot_codes3) ?></td>
   </tr>
 </table>

<br><br>

<table style="margin-bottom:0px" width="1350" border="0" align="center" cellpadding="0" cellspacing="0" bordercolor="#CCCCCC">
  <tr style="background-color: #E6FFFF">
    <td style="padding: 0.1rem 0.1rem; text-align: center"><?php echo $this->Html->image($gif1);?></td>
    <td style="padding: 0.1rem 0.1rem; text-align: center"><?php echo $this->Html->image($gif2);?></td>
    <td style="padding: 0.1rem 0.1rem; text-align: center"><?php echo $this->Html->image($gif3);?></td>
    <td style="padding: 0.1rem 0.1rem; text-align: center"><?php echo $this->Html->image($gif4);?></td>
  </tr>
  <tr style="background-color: #E6FFFF">
    <td style="padding: 0.1rem 0.1rem; text-align: center"><?php echo $this->Html->image($gif5);?></td>
    <td style="padding: 0.1rem 0.1rem; text-align: center"><?php echo $this->Html->image($gif6);?></td>
    <td style="padding: 0.1rem 0.1rem; text-align: center"><?php echo $this->Html->image($gif7);?></td>
    <td style="padding: 0.1rem 0.1rem; text-align: center"><?php echo $this->Html->image($gif8);?></td>
  </tr>
 </table>

<?= $this->Form->control('seikeiki', array('type'=>'hidden', 'value'=>$seikeiki, 'label'=>false)) ?>
<?= $this->Form->control('product_code', array('type'=>'hidden', 'value'=>$product_code, 'label'=>false)) ?>

<br><br><br>
