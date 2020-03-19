<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\User $user
 */
error_reporting(0);
?>

<?php if ($username != "" && $delete_flag != ""): ?>
<body oncontextmenu='return false' onload="document.all.OK.click();" >
    <?= $this->Flash->render() ?>
    <?= $this->Form->create() ?>
    <fieldset>
  <?= $this->Form->control('username', array('type'=>'hidden', 'value'=>$username, 'label'=>false)) ?>
	<?= $this->Form->control('delete_flag', array('type'=>'hidden', 'value'=>$delete_flag, 'label'=>false)) ?>
    </fieldset>
    <center><input type="submit" value="ページを移動しています…" name="OK" style="background-color:#E6FFFF; border-width: 0px"></center>
    <br><br><br>
</body>
    <?= $this->Form->end() ?>

<?php elseif ($username != "" && $delete_flag == "") : ?>
  <table align="center" border="2" bordercolor="#E6FFFF" cellpadding="0" cellspacing="0" style="border-bottom: solid;border-width: 1px">
    <br><br><br><br><br>
    <tr>
      <td bgcolor="#FFDEAD" ><font color="red">※ユーザー名が登録されていません。</font></td>
  	</tr>
  </table>
    <br><br><br><br><br><br><br>

<?php else : ?>
  <table align="center" border="2" bordercolor="#E6FFFF" cellpadding="0" cellspacing="0" style="border-bottom: solid;border-width: 1px">
  <br><br>
    <tr>
      <td bgcolor="#FFDEAD" ><font color="red">※ログインしてください</font></td>
  	</tr>
  </table>
  <br><br>
<?php endif; ?>
