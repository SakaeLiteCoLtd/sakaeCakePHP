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
  echo $this->Form->create($checkLots, ['url' => ['action' => 'torikomido']]);
?>
<br><br>
<legend align="center"><font color="red"><?= __('＊登録されました。') ?></font></legend>
<br>
