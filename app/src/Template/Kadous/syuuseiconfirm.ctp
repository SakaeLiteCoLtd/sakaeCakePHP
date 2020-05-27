<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\User $user
 */
 header('Expires:-1');
 header('Cache-Control:');
 header('Pragma:');

?>
<?php
 use App\myClass\Kadous\htmlKadoumenu;//myClassフォルダに配置したクラスを使用
 $htmlKadoumenu = new htmlKadoumenu();
 $htmlKadoumenus = $htmlKadoumenu->Kadoumenus();
 ?>
 <hr size="5" style="margin: 0.5rem">
 <table style="margin-bottom:0px" width="900" border="0" align="center" cellpadding="0" cellspacing="0" bordercolor="#CCCCCC">
 <?php
    echo $htmlKadoumenus;
 ?>
 </table>
 <hr size="5" style="margin: 0.5rem">
    <?= $this->Flash->render() ?>
    <?= $this->Form->create($KadouSeikeis, ['url' => ['action' => 'syuuseipreadd']]) ?>
    <fieldset>
<br>
<table align="left" border="2" bordercolor="#E6FFFF" cellpadding="0" cellspacing="0" style="border-bottom: solid;border-width: 1px">
  <tr>
    <td width="200" bgcolor="#FFFFCC" style="font-size: 12pt;"><strong style="font-size: 11pt; color:blue">品番</strong></td>
    <td width="200" bgcolor="#FFFFCC" style="font-size: 12pt;"><strong style="font-size: 11pt; color:blue">品名</strong></td>
    <td  width="100" bgcolor="#FFFFCC" style="font-size: 12pt;"><strong style="font-size: 11pt; color:blue">成型機</strong></td>
	</tr>
  <tr>
    <td bgcolor="#FFFFCC"><?= __($product_code) ?></td>
    <td bgcolor="#FFFFCC"><?= __($product_name) ?></td>
    <td bgcolor="#FFFFCC"><?= __($seikeiki) ?><?= h(" 号機") ?></td>
	</tr>
</table>
<br><br><br><br><br><br>
<table align="left" border="2" bordercolor="#E6FFFF" cellpadding="0" cellspacing="0" style="border-bottom: solid;border-width: 1px">
  <tr>
    <td bgcolor="#FFFFCC" style="font-size: 12pt;"><strong style="font-size: 11pt; color:blue">開始時刻</strong></td>
    <td bgcolor="#FFFFCC" style="font-size: 12pt;"><strong style="font-size: 11pt; color:blue">終了時刻</strong></td>
    <td  width="180" bgcolor="#FFFFCC" style="font-size: 12pt;"><strong style="font-size: 11pt; color:blue">ショットサイクル</strong></td>
    <td  width="180" bgcolor="#FFFFCC" style="font-size: 12pt;"><strong style="font-size: 11pt; color:blue">ショット数</strong></td>
	</tr>
  <tr>
    <td bgcolor="#FFFFCC"><?= __($starting_tm) ?></td>
    <td bgcolor="#FFFFCC"><?= __($finishing_tm) ?></td>
    <td bgcolor="#FFFFCC"><?= __($cycle_shot) ?></td>
    <td bgcolor="#FFFFCC"><?= __($amount_shot) ?></td>
	</tr>
</table>
<br><br><br><br><br><br>
<table align="left" border="2" bordercolor="#E6FFFF" cellpadding="0" cellspacing="0" style="border-bottom: solid;border-width: 1px">
  <tr>
    <td width="300" bgcolor="#FFFFCC" style="font-size: 12pt;"><strong style="font-size: 11pt; color:blue">開始ロット</strong></td>
    <td width="300" bgcolor="#FFFFCC" style="font-size: 12pt;"><strong style="font-size: 11pt; color:blue">最終ロット</strong></td>
	</tr>
  <tr>
    <td bgcolor="#FFFFCC"><?= __($first_lot_num) ?></td>
    <td bgcolor="#FFFFCC"><?= __($last_lot_num) ?></td>
	</tr>
</table>
<br><br>

<?= $this->Form->control('starting_tm_moto', array('type'=>'hidden', 'value'=>$starting_tm_moto, 'label'=>false)) ?>

    </fieldset>
    <table align="center" border="2" bordercolor="#E6FFFF" cellpadding="0" cellspacing="0">
    <tr>
      <td style="border-style: none;"><div align="center"><?= $this->Form->submit('戻る', ['onclick' => 'history.back()', 'type' => 'button']); ?></div></td>
      <td style="border-style: none;"><div align="center"><?= $this->Form->submit('変更登録', array('name' => 'touroku')); ?></div></td>
  </tr>
  </table>
<br><br><br>
    <?= $this->Form->end() ?>
