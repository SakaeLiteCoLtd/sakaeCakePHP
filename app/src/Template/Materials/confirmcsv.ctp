<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\Staff $staff
 */

///////////Model/Tableで、テーブルのnotemptyを変更

?>
<?=$this->Form->create($material, ['url' => ['action' => 'docsv']])?>
<br>
<?=$this->Form->input('CSV', array('type'=>'file' )); ?>
<br>
            <?php
              $username = $this->request->Session()->read('Auth.User.username');
            
              header('Expires:-1');
              header('Cache-Control:');
              header('Pragma:');

              echo $this->Form->create($material, ['url' => ['action' => 'docsv']]);
            ?>
            
        <p align="center"><?= $this->Form->button('back', ['onclick' => 'history.back()', 'type' => 'button']) ?>
        <?= $this->Form->button(__('OK'), array('name' => 'touroku')) ?></p>

        <?= $this->Form->end() ?>
