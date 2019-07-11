<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\User $user
 */
?>
<!DOCTYPE html>
<html>
<head>
    <?= $this->Html->charset() ?>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>
        <?= $cakeDescription ?>:
        <?= $this->fetch('title') ?>
    </title>
    <?= $this->Html->meta('icon') ?>

    <?= $this->Html->css('base1.css') ?>
    <?= $this->Html->css('cake.css') ?>

    <?= $this->fetch('meta') ?>
    <?= $this->fetch('css') ?>
    <?= $this->fetch('script') ?>
</head>
</html>
<br>
    <?= $this->Flash->render() ?>
    <?= $this->Form->create() ?>
    <fieldset>
<table align="center" border="2" bordercolor="#E6FFFF" cellpadding="0" cellspacing="0" style="border-bottom: solid;border-width: 1px">
        <tr>
    <td bgcolor="#FFDEAD" ><?= h($username) ?>　でログインします</td>
	</tr>
  <?= $this->Form->control('username', array('value'=>$username,'type'=>'hidden', 'label'=>false)) ?>
		<?= $this->Form->control('delete_flag', array('type'=>'hidden','value'=>$delete_flag,'label'=>false)) ?>
</table>
    </fieldset>
    <center><?= $this->Form->button(__('OK')) ?></center>
<br>
    <?= $this->Form->end() ?>
