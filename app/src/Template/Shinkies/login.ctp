<?php
$this->layout = 'defaultshinki';
?>

<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\User $user
 */
 error_reporting(0);

/*session_start();
header('Expires:-1');
header('Cache-Control:');
header('Pragma:');
*/
?>

<?php if ($passCheck == 1): ?>
<body oncontextmenu='return false' onload="document.all.OK.click();" >

  <?= $this->Form->create($user, ['url' => ['action' => 'menu']]) ?>
  <br><br><br>
    <center><input type="submit" value="ログインしています…" name="OK" style="background-color:#E6FFFF; border-width: 0px"></center>
    <br><br><br>
</body>
    <?= $this->Form->end() ?>

  <?php elseif ($passCheck == 2) : ?>
    <br><br>
    <legend align="center"><font color="red"><?= __("※パスワードが間違っています。") ?></font></legend>
    <br><br>
    <br><br>

  <?php elseif ($passCheck == 4) : ?>
    <br><br>
    <legend align="center"><font color="red"><?= __("※社員IDが間違っています。") ?></font></legend>
    <br><br>
    <br><br>

<?php else : ?>
  <br><br>
  <legend align="center"><font color="red"><?= __("※そのIDはこのメニューにログインする権限がありません。") ?></font></legend>
  <br><br>
  <br><br>
<?php endif; ?>
