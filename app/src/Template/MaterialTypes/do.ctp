<?php
/**
 * AuthHelper: Authの変数にアクセスできる
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\MaterialType $materialType
 */
?>
<?= $this->Form->create($materialType, ['url' => ['action' => 'index']]) ?>

<?php
  $username = $this->request->Session()->read('Auth.User.username');
  $session = $this->request->getSession();
  $name = $session->read('materialTypedata.name');
?>
<hr size="5">
              <p align="center"><?php echo $this->Html->image('ShinkiTourokuMenu/touroku.gif',array('width'=>'157','height'=>'50'));?></p>

<hr size="5">

<legend align="center"><font color="red"><?= __($mes) ?></font></legend>
    <table align="center" border="2" bordercolor="#E6FFFF" cellpadding="0" cellspacing="0" style="border-bottom: solid;border-width: 1px">
        <tbody border="2" bordercolor="#E6FFFF" bgcolor="#FFFFCC">
            <th scope="row"><?= __('name') ?></th>
            <td><?= h($name) ?></td>
        </tr>
    </table>
<br>
<br>
        <p align="center"><?= $this->Form->button(__('top'), array('name' => 'top')) ?></p>
        <?= $this->Form->end() ?>
