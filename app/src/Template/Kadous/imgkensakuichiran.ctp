<?php
//$this->layout = 'defaultkadous';
?>
<?php
  $username = $this->request->Session()->read('Auth.User.username');

  header('Expires:-1');
  header('Cache-Control:');
  header('Pragma:');
  echo $this->Form->create($KadouSeikei, ['url' => ['action' => 'imgkensakuichiran']]);
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

<?php if ($typecheck == 1): ?>

<legend align="center"><font color="red"><?= __($mes) ?></font></legend>

<?php
$roop = floor(count($arrPngfiles) / 4);
?>

<?php for($i=1; $i<=$roop+1; $i++): ?>
  <?php

  $i1 = $i*4 - 4;
  $i2 = $i*4 - 3;
  $i3 = $i*4 - 2;
  $i4 = $i*4 - 1;

  if($i1 >= count($arrPngfiles)){
    ${"gif".$i1} = "none/none.png";
  }
  if($i2 >= count($arrPngfiles)){
    ${"gif".$i2} = "none/none.png";
  }
  if($i3 >= count($arrPngfiles)){
    ${"gif".$i3} = "none/none.png";
  }
  if($i4 >= count($arrPngfiles)){
    ${"gif".$i4} = "none/none.png";
  }

  ?>
<table style="margin-bottom:0px" width="1350" border="0" align="center" cellpadding="0" cellspacing="0" bordercolor="#CCCCCC">
  <tr style="background-color: #E6FFFF">
    <td style="padding: 0.1rem 0.1rem; text-align: center"><?php echo $this->Html->image(${"gif".$i1});?></td>
    <td style="padding: 0.1rem 0.1rem; text-align: center"><?php echo $this->Html->image(${"gif".$i2});?></td>
    <td style="padding: 0.1rem 0.1rem; text-align: center"><?php echo $this->Html->image(${"gif".$i3});?></td>
    <td style="padding: 0.1rem 0.1rem; text-align: center"><?php echo $this->Html->image(${"gif".$i4});?></td>
  </tr>
</table>

<?php endfor;?>


<?php elseif ($typecheck == 3) : ?>

  <legend align="center"><font color="red"><?= __($mes) ?></font></legend>

  <table style="margin-bottom:0px" width="1350" border="0" align="center" cellpadding="0" cellspacing="0" bordercolor="#CCCCCC">
    <tr style="background-color: #E6FFFF">
      <td style="padding: 0.1rem 0.1rem; text-align: center">
        <?php
        echo $this->Html->image($gif,array('width'=>'550','height'=>'500'));
        ?>
       </td>
    </tr>
   </table>

<?php else : ?>

  <legend align="center"><font color="red"><?= __($mes) ?></font></legend>

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

<?php endif; ?>


 <br>



<table align="center" border="2" bordercolor="#E6FFFF" cellpadding="0" cellspacing="0">
  <tbody border="2" bordercolor="#E6FFFF" bgcolor="#FFFFCC">
    <tr>
      <td width="100" style="border-bottom: solid;border-width: 1px"><div align="center"><strong style="font-size: 11pt; color:blue">成形機</strong></div></td>
      <td width="250" style="border-bottom: solid;border-width: 1px"><div align="center"><strong style="font-size: 11pt; color:blue">品番</strong></div></td>
      <td width="300" style="border-bottom: solid;border-width: 1px"><div align="center"><strong style="font-size: 11pt; color:blue">日時絞込</strong></div></td>
      <td width="250" style="border-bottom: solid;border-width: 1px"><div align="center"><strong style="font-size: 11pt; color:blue">プライオリティ</strong></div></td>
      <td width="250" style="border-bottom: solid;border-width: 1px"><div align="center"><strong style="font-size: 11pt; color:blue">グラフ種類</strong></div></td>
    </tr>
    <td width="100" style="border-bottom: solid;border-width: 1px"><div align="center"><?= h($seikeiki." 号機") ?></div></td>
    <td width="250" style="border-bottom: solid;border-width: 1px"><div align="center"><?= h($this->request->getData('product_code')) ?></div></td>
    <td width="300" style="border-bottom: solid;border-width: 1px"><div align="center"><?= $this->Form->input("date", array('type' => 'date', 'value' => $this->request->getData('date'), 'monthNames' => false, 'label'=>false)); ?></div></td>
    <td width="250" style="border-bottom: solid;border-width: 1px"><?= $this->Form->input('priority', ["type"=>"select", "empty"=>"", "options"=>$arrImgpriority, 'label'=>false]); ?></td>
    <td width="250" style="border-bottom: solid;border-width: 1px"><?= $this->Form->input('type', ["type"=>"select", "empty"=>"", "options"=>$arrImgtype, 'label'=>false]); ?></td>
</table>
<br>

<table align="center" border="2" bordercolor="#E6FFFF" cellpadding="0" cellspacing="0">
<tr>
  <td style="border-style: none;"><div align="center"><?= $this->Form->submit('グラフ呼出', array('name' => 'yobidasi')); ?></div></td>
</tr>
</table>
<?= $this->Form->control('seikeiki', array('type'=>'hidden', 'value'=>$seikeiki, 'label'=>false)) ?>
<?= $this->Form->control('product_code', array('type'=>'hidden', 'value'=>$product_code, 'label'=>false)) ?>

<br>
