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
          echo $this->Form->create($user, ['url' => ['action' => 'chokusouikisakieditconfirm']]);

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
<table style="margin-bottom:0px" width="750" border="0" align="center" cellpadding="0" cellspacing="0" bordercolor="#CCCCCC">
  <tr style="background-color: #E6FFFF">
    <td style="padding: 0.1rem 0.1rem;"><?php echo $this->Html->image('Labelimg/chokusouhensyuu.gif',array('width'=>'105'));?></td>
  </tr>
</table>
<hr size="5" style="margin: 0.5rem">
<br>

<table align="center" border="2" bordercolor="#E6FFFF" cellpadding="0" cellspacing="0" style="border-bottom: solid;border-width: 1px">
        <tbody border="2" bordercolor="#E6FFFF" bgcolor="#FFFFCC">
          <td colspan="2"><div align="center"><strong style="font-size: 12pt; color:blue">顧客コード</strong></div></td>
        <tbody border="2" bordercolor="#E6FFFF" bgcolor="#FFFFCC">
          <td colspan="2" bgcolor="#FFFFCC"><?= $this->Form->input("cs_code", ["type"=>"select","empty"=>"選択してください", "options"=>$arrCustomer, 'value'=>"20003", 'label'=>false, 'required'=>true]) ?></td>
        <tbody border="2" bordercolor="#E6FFFF" bgcolor="#FFFFCC">
          <td><div align="center"><strong style="font-size: 12pt; color:blue">納入先ID</strong></div></td>
          <td style="border-left-style: none;"><div align="center"><strong style="font-size: 12pt; color:blue">ハンディ表示名</strong></div></td>
        <tbody border="2" bordercolor="#E6FFFF" bgcolor="#FFFFCC">
          <td><?= $this->Form->input("id_from_order", array('type' => 'value', 'value'=>$id_from_order, 'label'=>false)); ?></td>
          <td style="border-left-style: none;"><?= $this->Form->input("name", array('type' => 'value', 'value'=>$name, 'label'=>false)); ?></td>

          <tbody border="2" bordercolor="#E6FFFF" bgcolor="#FFFFCC">
            <td colspan="4" bgcolor="#FFFFCC"><strong style="font-size: 11pt; color:blue">使用・不使用</strong></td>
          <tbody border="2" bordercolor="#E6FFFF" bgcolor="#FFFFCC">
            <td bgcolor="#FFFFCC" style="border-right-style: none"><input type="radio" name="status" value="0" required><strong style="font-size: 11pt; color:blue">使用</strong></td>
            <td bgcolor="#FFFFCC" style="border-left-style: none"><input type="radio" name="status" value="1" required><strong style="font-size: 11pt; color:blue">不使用</strong></td>
</table>

<table align="center" border="2" bordercolor="#E6FFFF" cellpadding="0" cellspacing="0">
  <br>

<tr bgcolor="#E6FFFF" >
  <td align="center" rowspan="2" width="30" bgcolor="#E6FFFF" style="border: none"><div align="center"><?= $this->Form->submit(__('次へ'), array('name' => 'confirm', 'value'=>"1")); ?></div></td>
</tr>
</table>

<?= $this->Form->control('PlaceDeliversid', array('type'=>'hidden', 'value'=>$PlaceDeliversid, 'label'=>false)) ?>
<?= $this->Form->control('CustomersHandysid', array('type'=>'hidden', 'value'=>$CustomersHandysid, 'label'=>false)) ?>

<br><br><br>
