<?php
 use App\myClass\Logins\htmlLogin;//myClassフォルダに配置したクラスを使用
 $htmlPrelogin = new htmlLogin();
 $htmlPrelogin = $htmlPrelogin->Preloginview();
?>

<?= $this->Flash->render() ?>
<?= $this->Form->create($MotoLots, ['url' => ['action' => 'hasulotlogin']]) ?>

<br><br>
<legend align="center"><font color="red" size="3"><?= __($mess) ?></font></legend>

<?php
   echo $htmlPrelogin;
?>

<?= $this->Form->end() ?>
