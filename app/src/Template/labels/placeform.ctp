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
?>

<?=$this->Form->create($labelElementPlaces, ['url' => ['action' => 'placeconfirm']]) ?>
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
<legend align="center"><strong style="font-size: 15pt; color:blue"><?= __('ラベル納品場所登録') ?></strong></legend>
<br><br>
<table align="center" border="2" bordercolor="#E6FFFF" cellpadding="0" cellspacing="0" style="border-bottom: solid;border-width: 1px">
  <tr>
		<td bgcolor="#FFFFCC" style="width: 100px">納品場所１</td>
		<td bgcolor="#FFFFCC" style="width: 700px"><?= $this->Form->control('place1', array('type'=>'text', 'label'=>false,'autofocus'=>true)) ?></td>
	</tr>
  <tr>
		<td bgcolor="#FFFFCC">納品場所２</td>
		<td bgcolor="#FFFFCC"><?= $this->Form->control('place2', array('type'=>'text', 'label'=>false)) ?></td>
	</tr>
</table>
<br>
<legend align="center"><strong style="font-size: 13pt; color:red"><?= __('１行しか必要ないときは、納入場所１の空欄のみに記入する。') ?></strong></legend>

<br>
<table align="center" border="2" bordercolor="#E6FFFF" cellpadding="0" cellspacing="0">
<tr>
  <td style="border-style: none;"><div align="center"><?= $this->Form->submit(__('確認'), array('name' => 'kakunin')); ?></div></td>
</tr>
</table>

<?=$this->Form->end() ?>
