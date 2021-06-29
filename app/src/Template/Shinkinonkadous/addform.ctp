<?php
$this->layout = 'defaultshinki';
?>
<?php
 use App\myClass\Shinkimenus\htmlShinkimenu;//myClassフォルダに配置したクラスを使用

 $htmlShinkimenu = new htmlShinkimenu();
 $htmlShinkis = $htmlShinkimenu->Shinkimenus();
?>
<?php
  $username = $this->request->Session()->read('Auth.User.username');

  header('Expires:-1');
  header('Cache-Control:');
  header('Pragma:');
  echo $this->Form->create($user, ['url' => ['action' => 'addconfirm']]);
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
    <td style="padding: 0.1rem 0.1rem;"><?php echo $this->Html->image('Labelimg/chokusoushinki.gif',array('width'=>'105'));?></td>
  </tr>
</table>
<hr size="5" style="margin: 0.5rem">
<br>
<legend align="center"><font color="black"><?= __("検査外注製品") ?></legend>
<br>

<table align="center" border="2" bordercolor="#E6FFFF" cellpadding="0" cellspacing="0">
  <tbody border="2" bordercolor="#E6FFFF" bgcolor="#FFFFCC" style="border-bottom: solid;border-width: 1px">
    <tr style="border-bottom: 0px;border-width: 0px">
      <td width="200"><div align="center"><strong style="font-size: 13pt; color:blue">品番</strong></div></td>
      <td width="200"><div align="center"><strong style="font-size: 13pt; color:blue">仕入先</strong></div></td>
    </tr>
    <tr style="border-bottom: 0px;border-width: 0px">
      <td bgcolor="#FFFFCC" style="padding: 0.2rem"><?= $this->Form->control('product_code', array('type'=>'text', 'label'=>false, 'autofocus'=>true, 'required'=>true)) ?></td>
      <td bgcolor="#FFFFCC" style="padding: 0.2rem"><?= $this->Form->input("outsource_handy_id", ["type"=>"select", "empty"=>"選択してください", "options"=>$arrOutsourceHandy, 'label'=>false, 'required'=>true]) ?></td>
    </tr>
  </table>

<table align="center" border="2" bordercolor="#E6FFFF" cellpadding="0" cellspacing="0">
  <br>

<tr bgcolor="#E6FFFF" >
  <td align="center" rowspan="2" width="30" bgcolor="#E6FFFF" style="border: none"><div align="center"><?= $this->Form->submit(__('次へ'), array('name' => 'confirm', 'value'=>"1")); ?></div></td>
</tr>
</table>

<br><br><br>
