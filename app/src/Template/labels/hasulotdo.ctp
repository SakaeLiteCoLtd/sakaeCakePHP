 <?php
 $username = $this->request->Session()->read('Auth.User.username');
 header('Expires:-1');
 header('Cache-Control:');
 header('Pragma:');
 ?>
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
 <br><br>
 <table width="200" align="left" border="2" bordercolor="#E6FFFF" cellpadding="0" cellspacing="0" style="border-bottom: solid;border-width: 1px">
   <tr>
     <td bgcolor="#FFFFCC" style="font-size: 12pt;"><strong style="font-size: 11pt; color:blue">担当者</strong></td>
 	</tr>
  <tr>
    <td bgcolor="#FFFFCC" style="font-size: 12pt;"><strong style="font-size: 10pt"><?= __($Staff) ?></strong></td>
 </tr>
 </table>
 <br><br><br>
    <?= $this->Flash->render() ?>
    <?= $this->Form->create($MotoLots, ['url' => ['action' => 'hasulotstafftouroku']]) ?>
    <br><br><br><br>

  <table align="left" border="2" bordercolor="#E6FFFF" cellpadding="0" cellspacing="0">
    <tr style="border-bottom: solid;border-width: 1px">
      <td bgcolor="#FFFFCC"><strong style="font-size: 13pt; color:blue">品番</strong></td>
      <td bgcolor="#FFFFCC"><strong style="font-size: 13pt; color:blue">ロットNo.</strong></td>
      <td bgcolor="#FFFFCC"><strong style="font-size: 13pt; color:blue">数量</strong></td>
    </tr>
    <tr style="border-bottom: solid;border-width: 1px">
      <td width="263"  bgcolor="#FFFFCC" style="font-size: 12pt;"><?= h($product_code1) ?></td>
      <td width="263"  bgcolor="#FFFFCC" style="font-size: 12pt;"><?= h($lot_num) ?></td>
      <td width="263"  bgcolor="#FFFFCC" style="font-size: 12pt;"><?= h($amount) ?></td>
    </tr>
</table>
<br><br><br>
<br><br><br>
<br>

<table align="left" border="2" bordercolor="#E6FFFF" cellpadding="0" cellspacing="0">
  <tr style="border-bottom: solid;border-width: 1px">
    <td width='250'  bgcolor="#FFFFCC"><strong style="font-size: 13pt; color:blue">元ロットNo.</strong></td>
    <td width='250'  bgcolor="#FFFFCC"><strong style="font-size: 13pt; color:blue">元ロット数量</strong></td>
  </tr>

  <?php for($i=0; $i<=$tuika; $i++): ?>
  <tr style="border-bottom: solid;border-width: 1px">
    <td width="250"  bgcolor="#FFFFCC" style="font-size: 12pt;"><?= h(${"lot_moto".$i}) ?></td>
    <td width="250"  bgcolor="#FFFFCC" style="font-size: 12pt;"><?= h(${"amount_moto".$i}) ?></td>
</tr>
  <?php endfor;?>

</table>
<br><br><br><br><br><br><br>
<legend align="left"><font color="red"><?= __('＊以上のように登録されました。') ?></font></legend>


<br><br><br>
    <?= $this->Form->end() ?>
