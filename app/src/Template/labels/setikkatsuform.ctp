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

<?=$this->Form->create($labelSetikkatsues, ['url' => ['action' => 'setikkatsuconfirm']]) ?>

<hr size="5">
<table style="margin-bottom:0px" width="750" border="0" align="center" cellpadding="0" cellspacing="0" bordercolor="#CCCCCC">
          <tr style="background-color: #E6FFFF">
            <td style="padding: 0.1rem 0.1rem;"><a href="qr/index.php"><?php echo $this->Html->image('Labelimg/label_hakkou.gif',array('width'=>'105','height'=>'36','url'=>array('controller'=>'Labels','action'=>'index')));?></td>
            <td style="padding: 0.1rem 0.1rem;"><a href="qr/index.php"><?php echo $this->Html->image('Labelimg/label_touroku_place.gif',array('width'=>'105','height'=>'36','url'=>array('controller'=>'Labels','action'=>'placeform')));?></td>
          </tr>
</table>
<hr size="5">
<table style="margin-bottom:0px" width="750" border="0" align="center" cellpadding="0" cellspacing="0" bordercolor="#CCCCCC">
          <tr style="background-color: #E6FFFF">
            <td style="padding: 0.1rem 0.1rem;"><a href="qr/index.php"><?php echo $this->Html->image('Labelimg/label_hakkou.gif',array('width'=>'105','height'=>'36','url'=>array('controller'=>'Labels','action'=>'index')));?></td>
            <td style="padding: 0.1rem 0.1rem;"><a href="qr/index.php"><?php echo $this->Html->image('Labelimg/label_touroku_place.gif',array('width'=>'105','height'=>'36','url'=>array('controller'=>'Labels','action'=>'placeform')));?></td>
          </tr>
</table>
<hr size="5">
<br>
<legend align="center"><strong style="font-size: 15pt; color:blue"><?= __('セット取り登録') ?></strong></legend>
<br><br>
<table align="center" border="2" bordercolor="#E6FFFF" cellpadding="0" cellspacing="0" style="border-bottom: solid;border-width: 1px">
  <tr>
		<td bgcolor="#FFFFCC" style="width: 100px">品番１</td>
		<td bgcolor="#FFFFCC" style="width: 700px"><?= $this->Form->control('product_id1', array('type'=>'text', 'label'=>false)) ?></td>
	</tr>
  <tr>
		<td bgcolor="#FFFFCC">品番２</td>
		<td bgcolor="#FFFFCC"><?= $this->Form->control('product_id2', array('type'=>'text', 'label'=>false)) ?></td>
	</tr>
</table>
<br>
    <center><?= $this->Form->button(__('確認'), array('name' => 'kakunin')) ?></center>
<br>
</fieldset>

<?=$this->Form->end() ?>
