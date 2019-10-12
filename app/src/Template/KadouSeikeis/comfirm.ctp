<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\Staff[]|\Cake\Collection\CollectionInterface $staffs
 */
use Cake\ORM\TableRegistry;//独立したテーブルを扱う

?>
        <?php
          $username = $this->request->Session()->read('Auth.User.username');

          header('Expires:-1');
          header('Cache-Control:');
          header('Pragma:');
          echo $this->Form->create($kadouSeikei, ['url' => ['action' => 'index']]);
?>



<p align="center"><?= $this->Form->button(__('確認'), array('name' => 'confirm')) ?></p>


<br>
<br>
<br>
