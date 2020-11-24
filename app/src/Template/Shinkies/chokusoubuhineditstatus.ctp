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
  echo $this->Form->create($user, ['url' => ['action' => 'chokusoubuhineditdo']]);
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
  <?php echo $this->Html->image('Labelimg/chokusoubuhin.gif',array('width'=>'105'));?>
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

<?php if($ProductChokusous_check != 1): ?>

  <table align="center" border="2" bordercolor="#E6FFFF" cellpadding="0" cellspacing="0" style="border-bottom: solid;border-width: 1px">
    <tr style="border-bottom: 0px;border-width: 0px">
      <td width="300" colspan="4" bgcolor="#FFFFCC"><div align="center"><strong style="font-size: 13pt; color:blue">品番</strong></div></td>
    </tr>
    <tr style="border-bottom: 0px;border-width: 0px">
      <td bgcolor="#FFFFCC"><?= h($product_code) ?></td>
    </tr>
  </table>

  <table align="center" border="2" bordercolor="#E6FFFF" cellpadding="0" cellspacing="0" style="border-bottom: solid;border-width: 1px">
    <tr style="border-bottom: 0px;border-width: 0px">
      <td width="300" colspan="4" bgcolor="#FFFFCC"><div align="center"><strong style="font-size: 13pt; color:blue">現状</strong></div></td>
    </tr>
    <tr style="border-bottom: 0px;border-width: 0px">
      <td bgcolor="#FFFFCC"><?= h($status_hyouji) ?></td>
    </tr>
  </table>

    <table align="center" border="2" bordercolor="#E6FFFF" cellpadding="0" cellspacing="0" style="border-bottom: solid;border-width: 1px">
    <tr style="border-bottom: 0px;border-width: 0px">
      <td width="300" colspan="4" bgcolor="#FFFFCC"><strong style="font-size: 11pt; color:blue">使用・不使用</strong></td>
    </tr>
    <tr>
      <td bgcolor="#FFFFCC" style="border-right-style: none"><strong style="font-size: 13pt; color:blue"></strong></td>
      <td bgcolor="#FFFFCC" style="border-right-style: none;border-left-style: none"><input type="radio" name="status" value="0" required><strong style="font-size: 11pt; color:blue">使用</strong></td>
      <td bgcolor="#FFFFCC" style="border-left-style: none;border-right-style: none"><input type="radio" name="status" value="1" required><strong style="font-size: 11pt; color:blue">不使用</strong></td>
      <td bgcolor="#FFFFCC" style="border-left-style: none"><strong style="font-size: 13pt; color:blue"></strong></td>
  </tr>
</table>

  <br>

  <?= $this->Form->control('product_code', array('type'=>'hidden', 'value'=>$product_code, 'label'=>false)) ?>

<tr bgcolor="#E6FFFF" >
  <td align="center" rowspan="2" width="30" bgcolor="#E6FFFF" style="border: none"><div align="center"><?= $this->Form->submit(__('更新'), array('name' => 'confirm', 'value'=>"1")); ?></div></td>
</tr>
</table>

<br><br><br>

<?php else: ?>

  <legend align="center"><font color="red"><?= __($status_hyouji) ?></font></legend>
  <table align="center" border="2" bordercolor="#E6FFFF" cellpadding="0" cellspacing="0">

  <tr bgcolor="#E6FFFF" >
    <td style="border-style: none;"><div align="center"><?= $this->Form->submit('戻る', ['onclick' => 'history.back()', 'type' => 'button']); ?></div></td>
  </tr>
<br>
</table>

  <br><br>

<?php endif; ?>
