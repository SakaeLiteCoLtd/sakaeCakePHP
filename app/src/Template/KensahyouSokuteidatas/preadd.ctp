<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\User $user
 */
/*
if($gaikancount > 0){
  $test_alert =
  "<script type='text/javascript'>alert('
  外観に「out」が含まれています。このまま続ける場合はOKで進めてください。戻る場合はブラウザの戻るボタンを押してください。');</script>";
  echo $test_alert;
}
*/
?>

<br>
    <?= $this->Flash->render() ?>
    <?= $this->Form->create($kensahyouSokuteidata, ['url' => ['action' => 'login']]) ?>
    <br><br>
    <legend align="center"><strong style="font-size: 11pt; color:blue"><?= __("社員ID登録") ?></strong></legend>
    <fieldset>
<table align="center" border="2" bordercolor="#E6FFFF" cellpadding="0" cellspacing="0" style="border-bottom: solid;border-width: 1px">
  <tr>
    <td bgcolor="#FFFFCC" style="font-size: 12pt;"><strong style="font-size: 11pt; color:blue">社員ID</strong></td>
		<td bgcolor="#FFFFCC"><?= $this->Form->control('username', array('type'=>'text', 'label'=>false, 'autofocus'=>true)) ?></td>
	</tr>
</table>
    </fieldset>

    <table align="center" border="2" bordercolor="#E6FFFF" cellpadding="0" cellspacing="0">
    <tr>
    <td style="border-style: none;"><div align="center"><?= $this->Form->submit('ログイン', array('name' => 'login')); ?></div></td>
  </tr>
  </table>
<br>

<?= $this->Form->control('kensahyou_heads_id', array('type'=>'hidden', 'value'=>$_POST["kensahyou_heads_id"], 'label'=>false)) ?>
<?= $this->Form->control('product_code', array('type'=>'hidden', 'value'=>$_POST["product_code"], 'label'=>false)) ?>
<?= $this->Form->control('lot_num', array('type'=>'hidden', 'value'=>$_POST["lot_num"], 'label'=>false)) ?>
<?= $this->Form->control('maisu', array('type'=>'hidden', 'value'=>$_POST["maisu"], 'label'=>false)) ?>
<?= $this->Form->control('manu_date', array('type'=>'hidden', 'value'=>$_POST["manu_date"], 'label'=>false)) ?>
<?= $this->Form->control('inspec_date', array('type'=>'hidden', 'value'=>$_POST["inspec_date"], 'label'=>false)) ?>
<?= $this->Form->control('delete_flag', array('type'=>'hidden', 'value'=>$_POST["delete_flag"], 'label'=>false)) ?>
<?= $this->Form->control('updated_staff', array('type'=>'hidden', 'value'=>$_POST["updated_staff"], 'label'=>false)) ?>
<?= $this->Form->control('kadouseikeiId', array('type'=>'hidden', 'value'=>$_POST["kadouseikeiId"], 'label'=>false)) ?>

<?php for($n=1; $n<=8; $n++): ?>

  <?= $this->Form->control('cavi_num_'.$n, array('type'=>'hidden', 'value'=>$n, 'label'=>false)) ?>

  <?php for($m=1; $m<=9*$_POST["maisu"]; $m++): ?>

  <?= $this->Form->control('result_size_'.$n.'_'.$m, array('type'=>'hidden', 'value'=>$_POST["result_size_{$n}_{$m}"], 'label'=>false)) ?>

<?php endfor;?>

  <?= $this->Form->control('result_weight_'.$n, array('type'=>'hidden', 'value'=>$_POST["result_weight_{$n}"], 'label'=>false)) ?>
  <?= $this->Form->control('situation_dist1_'.$n, array('type'=>'hidden', 'value'=>$_POST["situation_dist1_{$n}"], 'label'=>false)) ?>
  <?= $this->Form->control('situation_dist2_'.$n, array('type'=>'hidden', 'value'=>$_POST["situation_dist2_{$n}"], 'label'=>false)) ?>

<?php endfor;?>

    <?= $this->Form->end() ?>
