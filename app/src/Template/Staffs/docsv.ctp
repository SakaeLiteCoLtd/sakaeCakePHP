<?php
/**
 * AuthHelper: Authの変数にアクセスできる
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\Staff $staff
 */
?>
<?php
          $username = $this->request->Session()->read('Auth.User.username');
//          echo $this->Form->create($staff, ['url' => ['action' => 'index']]);
?>
                <?php
            	    echo "<pre>";
                    print_r('以下のデータが登録されました。');
                    echo "<br>";
                    print_r($this->request->getData('staffdata'));
                    echo "<br>";
                ?>
<?= $this->Form->end() ?>
