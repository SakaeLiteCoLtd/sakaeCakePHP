<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\User $user
 */
 error_reporting(0);
?>
<?php if ($username != "" && $delete_flag != ""): ?>
<body onload="document.all.OK.click();" >
    <?= $this->Flash->render() ?>
    <?= $this->Form->create() ?>
    <fieldset>
<table align="center" border="2" bordercolor="#E6FFFF" cellpadding="0" cellspacing="0" style="border-bottom: solid;border-width: 1px">
  <?= $this->Form->control('username', array('value'=>$username,'type'=>'hidden', 'label'=>false)) ?>
	<?= $this->Form->control('delete_flag', array('type'=>'hidden','value'=>$delete_flag,'label'=>false)) ?>
</table>
    </fieldset>
    <center><input type="submit" value="ログインしています…" name="OK"></center>
    <br>
    <br>
    <br>
    <br>
</body>
    <?= $this->Form->end() ?>

<?php elseif ($username != "" && $delete_flag == "") : ?>
  <table align="center" border="2" bordercolor="#E6FFFF" cellpadding="0" cellspacing="0" style="border-bottom: solid;border-width: 1px">
    <br>
    <br>
    <tr>
      <td bgcolor="#FFDEAD" ><font color="red">※ユーザー名が登録されていません。</font></td>
  	</tr>
  </table>
  <br>
  <br>

<?php else : ?>
  <table align="center" border="2" bordercolor="#E6FFFF" cellpadding="0" cellspacing="0" style="border-bottom: solid;border-width: 1px">
    <br>
    <br>
    <tr>
      <td bgcolor="#FFDEAD" ><font color="red">※ログインしてください</font></td>
  	</tr>
  </table>
  <br>
  <br>
<?php endif; ?>
