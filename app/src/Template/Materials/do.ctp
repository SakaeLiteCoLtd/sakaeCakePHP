<?php
/**
 * AuthHelper: Authの変数にアクセスできる
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\Material $material
 */
?>
<?= $this->Form->create($material, ['url' => ['action' => 'index']]) ?>

<?php
            $username = $this->request->Session()->read('Auth.User.username');
?>
              <p align="center"><?php echo $this->Html->image('ShinkiTourokuMenu/touroku.gif',array('width'=>'157','height'=>'50'));?></p>

<hr size="5">


<legend align="center"><font color="red"><?= __('＊下記のように登録されました。') ?></font></legend>
    <table align="center" border="2" bordercolor="#E6FFFF" cellpadding="0" cellspacing="0" style="border-bottom: solid;border-width: 1px">
        <tbody border="2" bordercolor="#E6FFFF" bgcolor="#FFFFCC">
            <th scope="row"><?= __('grade') ?></th>
            <td><?= h($this->request->getData('grade')) ?></td>
        </tr>
        <tbody border="2" bordercolor="#E6FFFF" bgcolor="#FFFFCC">
            <th scope="row"><?= __('color') ?></th>
            <td><?= h($this->request->getData('color')) ?></td>
        </tr>
        <tbody border="2" bordercolor="#E6FFFF" bgcolor="#FFFFCC">
            <th scope="row"><?= __('material_type_id') ?></th>
            <td><?= h($this->request->getData('material_type_id')) ?></td>
        </tr>
        <tbody border="2" bordercolor="#E6FFFF" bgcolor="#FFFFCC">
            <th scope="row"><?= __('tani') ?></th>
            <td><?= h($this->request->getData('tani')) ?></td>
        </tr>
        <tbody border="2" bordercolor="#E6FFFF" bgcolor="#FFFFCC">
            <th scope="row"><?= __('multiple_sup') ?></th>
            <td><?= h($this->request->getData('multiple_sup')) ?></td>
        </tr>
        <tbody border="2" bordercolor="#E6FFFF" bgcolor="#FFFFCC">
            <th scope="row"><?= __('Status') ?></th>
            <td><?= h($this->request->getData('status')) ?></td>
        <tbody border="2" bordercolor="#E6FFFF" bgcolor="#FFEFD5">
            <th scope="row"><?= __('登録日時') ?></th>
            <td><?= h($material->created_at) ?></td>
        </tr>
        <tbody border="2" bordercolor="#E6FFFF" bgcolor="#FFEFD5">
            <th scope="row"><?= __('登録者') ?></th>
            <td><?= h($CreatedStaff) ?></td>
    </table>
<br>
<br>
        <p align="center"><?= $this->Form->button(__('top'), array('name' => 'top')) ?></p>
        <?= $this->Form->end() ?>
