 <?php
  use App\myClass\Labelmenus\htmlLabelmenu;//myClassフォルダに配置したクラスを使用
  $htmlLabelmenu = new htmlLabelmenu();
  $htmlLabels = $htmlLabelmenu->Labelmenus();
  ?>
  <hr size="5" style="margin: 0.5rem">
  <table style="margin-bottom:0px" width="750" border="0" align="center" cellpadding="0" cellspacing="0" bordercolor="#CCCCCC">
  <?php
     echo $htmlLabels;
  ?>
  </table>
  <hr size="5" style="margin: 0.5rem">
 <?php
   $username = $this->request->Session()->read('Auth.User.username');

   header('Expires:-1');
   header('Cache-Control:');
   header('Pragma:');
   echo $this->Form->create($orderEdis, ['url' => ['action' => 'hasuichiran']]);
/*
   $Data=$this->request->query();
   $Pro=$Data["Pro"];
   echo $this->Form->hidden('Pro' ,['value'=>$Pro]);
*/
?>

<br>
<br>
<table align="center" border="2" bordercolor="#E6FFFF" cellpadding="0" cellspacing="0">
  <tbody border="2" bordercolor="#E6FFFF" bgcolor="#FFFFCC">
    <tr>
      <td width="350" colspan="20" nowrap="nowrap"><div align="center"><strong style="font-size: 15pt; color:blue">納入日指定</strong></div></td>
      <td rowspan="2" width="150"  style="border-bottom: solid;border-width: 1px"><div align="center"><?= $this->Form->submit(__('呼出'), array('name' => 'yobidasi')); ?></div></td>
    </tr>
      <td width="250" colspan="20" style="border-bottom: solid;border-width: 1px"><div align="center"><?= $this->Form->input("data_yobidashi", array('type' => 'date', 'monthNames' => false, 'label'=>false)); ?></div></td>
</table>
<br>
<br>

<?=$this->Form->end() ?>
