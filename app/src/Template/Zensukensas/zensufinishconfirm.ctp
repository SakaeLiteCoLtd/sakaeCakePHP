<?php
 use App\myClass\Zensumenus\htmlzensumenu;//myClassフォルダに配置したクラスを使用
 $htmlzensumenu = new htmlzensumenu();
 $htmlzensus = $htmlzensumenu->zensumenus();
 $htmlzensusubs = $htmlzensumenu->zensussubmenus();
 $htmlzensustartends = $htmlzensumenu->zensustartend();
 use Cake\ORM\TableRegistry;//独立したテーブルを扱う
 $this->ContRejections = TableRegistry::get('contRejections');
?>
 <?php
 $username = $this->request->Session()->read('Auth.User.username');
 header('Expires:-1');
 header('Cache-Control:');
 header('Pragma:');
 ?>

 <hr size="5" style="margin: 0.5rem">
 <table style="margin-bottom:0px" width="750" border="0" align="center" cellpadding="0" cellspacing="0" bordercolor="#CCCCCC">
 <?php
    echo $htmlzensus;
 ?>
 </table>
 <hr size="5" style="margin: 0.5rem">
 <table style="margin-bottom:0px" width="750" border="0" align="center" cellpadding="0" cellspacing="0" bordercolor="#CCCCCC">
 <?php
    echo $htmlzensustartends;
 ?>
 </table>
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
    <?= $this->Form->create($ResultZensuHeads, ['url' => ['action' => 'zensufinishdo']]) ?>
    <br><br><br><br>

  <table align="left" border="2" bordercolor="#E6FFFF" cellpadding="0" cellspacing="0">
    <tr style="border-bottom: solid;border-width: 1px">
      <td bgcolor="#FFFFCC"><strong style="font-size: 13pt; color:blue">品番</strong></td>
      <td bgcolor="#FFFFCC"><strong style="font-size: 13pt; color:blue">品名</strong></td>
      <td bgcolor="#FFFFCC"><strong style="font-size: 13pt; color:blue">ロットNo.</strong></td>
    </tr>
    <tr style="border-bottom: solid;border-width: 1px">
      <td width="263"  bgcolor="#FFFFCC" style="font-size: 12pt;"><?= h($product_code) ?></td>
      <td width="263"  bgcolor="#FFFFCC" style="font-size: 12pt;"><?= h($product_name) ?></td>
      <td width="263"  bgcolor="#FFFFCC" style="font-size: 12pt;"><?= h($lot_num) ?></td>
    </tr>
</table>
<br><br><br>
<br><br><br>
<table align="left" border="2" bordercolor="#E6FFFF" cellpadding="0" cellspacing="0">
<tr bgcolor="#E6FFFF" >
  <td width="300" colspan="40" nowrap="nowrap" bgcolor="#E6FFFF" style="border: none"><div align="center"><strong style="font-size: 15pt; color:blue"></strong></div></td>
  <td width="300" colspan="50" nowrap="nowrap" bgcolor="#E6FFFF" style="border: none"><div align="center"><strong style="font-size: 15pt; color:blue"></strong></div></td>
</tr>
</table>

<table align="left" border="2" bordercolor="#E6FFFF" cellpadding="0" cellspacing="0">
  <tr style="border-bottom: solid;border-width: 1px">
    <td width='163'  bgcolor="#FFFFCC"><strong style="font-size: 13pt; color:blue">内容</strong></td>
    <td width='163'  bgcolor="#FFFFCC"><strong style="font-size: 13pt; color:blue">数量</strong></td>
    <td width='463'  bgcolor="#FFFFCC"><strong style="font-size: 13pt; color:blue">不良の説明</strong></td>
  </tr>

  <?php for($i=0; $i<=$tuika; $i++): ?>
    <?php
    $Cont = $this->ContRejections->find()->where(['id' => $data['cont'.$i]])->toArray();
    $cont = $Cont[0]->cont;
    ?>
  <tr style="border-bottom: solid;border-width: 1px">
    <td width="263"  bgcolor="#FFFFCC" style="font-size: 12pt;"><?= h($cont) ?></td>
    <td width="263"  bgcolor="#FFFFCC" style="font-size: 12pt;"><?= h($data['amount'.$i]) ?></td>
    <td width="263"  bgcolor="#FFFFCC" style="font-size: 12pt;"><?= h($data['bik'.$i]) ?></td>
  </tr>
  <?= $this->Form->control('num', array('type'=>'hidden', 'value'=>$i, 'label'=>false)) ?>
  <?php endfor;?>

</table>
<br>
<table align="left" border="2" bordercolor="#E6FFFF" cellpadding="0" cellspacing="0">
<tr bgcolor="#E6FFFF" >
  <td width="30" colspan="50" nowrap="nowrap" bgcolor="#E6FFFF" style="border: none"><div align="center"><strong style="font-size: 15pt; color:blue"></strong></div></td>
  <td align="right" rowspan="2" width="50" bgcolor="#E6FFFF" style="border: none"><div align="right"><?= $this->Form->submit(__('不良内容登録'), array('name' => 'kakunin')); ?></div></td>
  <td style="border-style: none;"><div align="center"><?= $this->Form->submit('戻る', ['onclick' => 'history.back()', 'type' => 'button']); ?></div></td>
</tr>
</table>
<?= $this->Form->control('product_code', array('type'=>'hidden', 'value'=>$product_code, 'label'=>false)) ?>
<?= $this->Form->control('product_name', array('type'=>'hidden', 'value'=>$product_name, 'label'=>false)) ?>
<?= $this->Form->control('lot_num', array('type'=>'hidden', 'value'=>$lot_num, 'label'=>false)) ?>
<?= $this->Form->control('Staff', array('type'=>'hidden', 'value'=>$Staff, 'label'=>false)) ?>
<?= $this->Form->control('staff_id', array('type'=>'hidden', 'value'=>$staff_id, 'label'=>false)) ?>
<?= $this->Form->control('result_zensu_head_id', array('type'=>'hidden', 'value'=>$result_zensu_head_id, 'label'=>false)) ?>
<?= $this->Form->control('datetime_finish', array('type'=>'hidden', 'value'=>date('Y-m-d h:m:s'), 'label'=>false)) ?>

<br><br><br><br><br><br><br><br><br><br>

<?php
echo "<pre>";
print_r($data);
echo "</pre>";
?>

<?= $this->Form->end() ?>
