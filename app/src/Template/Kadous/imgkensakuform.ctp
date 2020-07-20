<?php
$this->layout = 'defaultkadous';
?>

<?php
//   header('Content-Type: image/gif');
//   readfile('C:/Users/info/Desktop/kadouimg/RF51-B471HH/20/07/02/RF51-B471HH_200702_test2.gif');
?>

<?php
  $username = $this->request->Session()->read('Auth.User.username');

  header('Expires:-1');
  header('Cache-Control:');
  header('Pragma:');
  echo $this->Form->create($KadouSeikei, ['url' => ['action' => 'imgkensakuichiran']]);
?>

 <hr size="5" style="margin: 0.5rem">
<br>

<legend align="center"><font color="red"><?= __($mes) ?></font></legend>

<table style="margin-bottom:0px" width="750" border="0" align="center" cellpadding="0" cellspacing="0" bordercolor="#CCCCCC">
  <tr style="background-color: #E6FFFF">
    <td style="padding: 0.1rem 0.1rem; text-align: center"><?php echo $this->Html->image($gif1);?></td>
    <td style="padding: 0.1rem 0.1rem; text-align: center"><?php echo $this->Html->image($gif2);?></td>
  </tr>
  <tr style="background-color: #E6FFFF">
    <td style="padding: 0.1rem 0.1rem; text-align: center"><?php echo $this->Html->image($gif1);?></td>
    <td style="padding: 0.1rem 0.1rem; text-align: center"><?php echo $this->Html->image($gif2);?></td>
  </tr>
 </table>

 <br>

<table align="center" border="2" bordercolor="#E6FFFF" cellpadding="0" cellspacing="0">
  <tbody border="2" bordercolor="#E6FFFF" bgcolor="#FFFFCC">
    <tr>
      <td width="250" style="border-bottom: solid;border-width: 1px"><div align="center"><strong style="font-size: 11pt; color:blue">品番</strong></div></td>
      <td width="250" style="border-bottom: solid;border-width: 1px"><div align="center"><strong style="font-size: 11pt; color:blue">日時絞込</strong></div></td>
      <td width="250" style="border-bottom: solid;border-width: 1px"><div align="center"><strong style="font-size: 11pt; color:blue">グラフ種類</strong></div></td>
    </tr>
    <td width="250" style="border-bottom: solid;border-width: 1px"><div align="center"><?= $this->Form->input("product", array('type' => 'text', 'value' => $this->request->getData('product'), 'label'=>false, 'autofocus'=>true)); ?></div></td>
    <td width="250" style="border-bottom: solid;border-width: 1px"><div align="center"><?= $this->Form->input("date", array('type' => 'date', 'value' => $date_sta, 'monthNames' => false, 'label'=>false)); ?></div></td>
    <td width="250" style="border-bottom: solid;border-width: 1px"><?= $this->Form->input('type', ["type"=>"select", "empty"=>"", "options"=>$arrImgtype, 'label'=>false]); ?></td>
</table>
<br>

<table align="center" border="2" bordercolor="#E6FFFF" cellpadding="0" cellspacing="0">
<tr>
  <td style="border-style: none;"><div align="center"><?= $this->Form->submit('グラフ呼出', array('name' => 'yobidasi')); ?></div></td>
</tr>
</table>

<br>
