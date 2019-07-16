<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\User $user
 */
?>

<br>
    <?= $this->Flash->render() ?>
    <?= $this->Form->create($staff, ['url' => ['action' => 'login']]) ?>
    <br><br>
    <legend align="center"><font color="#00000"><?= __('＊ログインしてください') ?></font></legend>
    <fieldset>
<table align="center" border="2" bordercolor="#E6FFFF" cellpadding="0" cellspacing="0" style="border-bottom: solid;border-width: 1px">
  <tr>
		<td bgcolor="#FFDEAD" style="width: 100px">username</td>
		<td bgcolor="#FFDEAD"><?= $this->Form->control('username', array('type'=>'text', 'label'=>false)) ?></td>
	</tr>
</table>
    </fieldset>
    <center><?= $this->Form->button(__('login')) ?></center>
<br>
    <?= $this->Form->end() ?>
