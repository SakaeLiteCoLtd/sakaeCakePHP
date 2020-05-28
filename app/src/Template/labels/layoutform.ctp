<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\Staff[]|\Cake\Collection\CollectionInterface $staffs
 */
?>
        <?php
          $username = $this->request->Session()->read('Auth.User.username');

          header('Expires:-1');
          header('Cache-Control:');
          header('Pragma:');

          $options = [
            '0' => '印字なし',
            '1' => 'セット'
                  ];
?>

<?=$this->Form->create($labelTypeProducts, ['url' => ['action' => 'layoutconfirm']]) ?>
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
<br>
<legend align="center"><strong style="font-size: 15pt; color:blue"><?= __('ラベル製品登録') ?></strong></legend>
<br><br>
<table align="center" border="2" bordercolor="#E6FFFF" cellpadding="0" cellspacing="0" style="border-bottom: solid;border-width: 1px">
  <tr>
		<td bgcolor="#FFFFCC" style="width: 130px">品番</td>
    <td bgcolor="#FFFFCC" style="width: 300px"><?= h($this->request->getData('product_code')) ?></td>
	</tr>
  <tr>
		<td bgcolor="#FFFFCC">納入先</td>
    <td bgcolor="#FFFFCC"><?= $this->Form->input("place", ["type"=>"select","empty"=>"選択してください", "options"=>$arrLabelElementPlace, 'label'=>false]); ?></td>
	</tr>
  <tr>
		<td bgcolor="#FFFFCC">梱包単位</td>
    <td bgcolor="#FFFFCC"><?= $this->Form->input("unit", ["type"=>"select","empty"=>"選択してください", "options"=>$options, 'label'=>false]); ?></td>
	</tr>
  <tr>
		<td bgcolor="#FFFFCC">ラベルタイプ</td>
		<td bgcolor="#FFFFCC"><?= h($this->request->getData('type')) ?></td>
	</tr>
</table>
<br>
<table align="center" border="2" bordercolor="#E6FFFF" cellpadding="0" cellspacing="0">
<tr>
  <td style="border-style: none;"><div align="center"><?= $this->Form->submit(__('確認'), array('name' => 'kakunin')); ?></div></td>
</tr>
</table>

<?= $this->Form->control('product_code', array('type'=>'hidden', 'value'=>$this->request->getData('product_code'), 'label'=>false)) ?>
<?= $this->Form->control('type', array('type'=>'hidden', 'value'=>$this->request->getData('type'), 'label'=>false)) ?>

<?=$this->Form->end() ?>
