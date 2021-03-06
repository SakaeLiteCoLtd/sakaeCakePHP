<?php


/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\User $user
 */
?>
<?php //phpinfo();
?>

<?= $this->Html->css('cake.css') ?>

<div id="modal-content">
	<p>「閉じる」か「背景」をクリックするとモーダルウィンドウを終了します。</p>
	<p><a id="modal-close" class="button-link">閉じる</a></p>
</div>

<br>
    <?= $this->Flash->render() ?>
    <?= $this->Form->create($staff, ['url' => ['action' => 'login']]) ?>
    <br><br>
    <legend align="center"><strong style="font-size: 11pt; color:blue"><?= __("社員ID登録") ?></strong></legend>
    <fieldset>
<table align="center" border="2" bordercolor="#E6FFFF" cellpadding="0" cellspacing="0" style="border-bottom: solid;border-width: 1px">
  <tr>
    <td bgcolor="#FFFFCC" style="font-size: 12pt;"><strong style="font-size: 11pt; color:blue">社員ID</strong></td>
		<td bgcolor="#FFFFCC"><?= $this->Form->control('username', array('type'=>'text', 'label'=>false)) ?></td>
	</tr>
</table>
    </fieldset>

    <table align="center" border="2" bordercolor="#E6FFFF" cellpadding="0" cellspacing="0">
    <tr>
    <td style="border-style: none;"><div align="center"><?= $this->Form->submit('ログイン', array('name' => 'login')); ?></div></td>
  </tr>
  </table>
<br>
    <?= $this->Form->end() ?>
