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

    <?= $this->Flash->render() ?>
    <?= $this->Form->create() ?>
    <fieldset>
<table align="center" border="2" bordercolor="#E6FFFF" cellpadding="0" cellspacing="0" style="border-bottom: solid;border-width: 1px">
        <tr>
		<td bgcolor="#FFDEAD" style="width: 100px">username</td>
		<td bgcolor="#FFDEAD"><?= $this->Form->control('username', array('type'=>'text', 'label'=>false)) ?></td>
	</tr>
        <tr>
		<td bgcolor="#FFDEAD">password</td>
		<td bgcolor="#FFDEAD"><?= $this->Form->control('password', array('label'=>false)) ?></td>
	</tr>
</table>
    </fieldset>
    <center><?= $this->Form->button(__('login')) ?></center>
    <?= $this->Form->end() ?>
