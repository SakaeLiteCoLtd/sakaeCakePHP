<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\Staff $staff
 */

///////////Model/Tableで、テーブルのnotemptyを変更

use Cake\ORM\TableRegistry;//独立したテーブルを扱う
$this->Staffs = TableRegistry::get('staffs');//staffsテーブルを使う
$this->Roles = TableRegistry::get('roles');//Rolesテーブルを使う
?>
<?=$this->Form->create($scheduleKouteis, ['url' => ['action' => 'docsv']])?>
<?php
  $username = $this->request->Session()->read('Auth.User.username');

  header('Expires:-1');
  header('Cache-Control:');
  header('Pragma:');

  echo $this->Form->create($scheduleKouteis, ['url' => ['action' => 'docsv']]);
?>

        <p align="center"><?= $this->Form->button('back', ['onclick' => 'history.back()', 'type' => 'button']) ?>
        <?= $this->Form->button(__('OK'), array('name' => 'touroku')) ?></p>

        <?= $this->Form->end() ?>
