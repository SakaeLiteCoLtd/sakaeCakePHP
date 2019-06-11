<?php
/**
 * AuthHelper: Authの変数にアクセスできる
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\Deliver $priceMaterial
 */
?>
<?= $this->Form->create($priceMaterial, ['url' => ['action' => 'index']]) ?>

<?php
            $username = $this->request->Session()->read('Auth.User.username');
?>
              <p align="center"><?php echo $this->Html->image('ShinkiTourokuMenu/touroku.gif',array('width'=>'157','height'=>'50'));?></p>

<hr size="5">



<legend align="center"><font color="red"><?= __('＊下記のように登録されました。') ?></font></legend>
    <table align="center" border="2" bordercolor="#E6FFFF" cellpadding="0" cellspacing="0" style="border-bottom: solid;border-width: 1px">
        <tbody border="2" bordercolor="#E6FFFF" bgcolor="#FFFFCC">
            <th scope="row"><?= __('material_id') ?></th>
            <td><?= h($this->request->getData('material_id')) ?></td>
        </tr>
        <tbody border="2" bordercolor="#E6FFFF" bgcolor="#FFFFCC">
            <th scope="row"><?= __('supplier_id') ?></th>
            <td><?= h($this->request->getData('supplier_id')) ?></td>
        </tr>
        <tbody border="2" bordercolor="#E6FFFF" bgcolor="#FFFFCC">
            <th scope="row"><?= __('lot_low') ?></th>
            <td><?= h($this->request->getData('lot_low')) ?></td>
        </tr>
        <tbody border="2" bordercolor="#E6FFFF" bgcolor="#FFFFCC">
            <th scope="row"><?= __('lot_upper') ?></th>
            <td><?= h($this->request->getData('lot_upper')) ?></td>
        </tr>
        <tbody border="2" bordercolor="#E6FFFF" bgcolor="#FFFFCC">
            <th scope="row"><?= __('price') ?></th>
            <td><?= h($this->request->getData('price')) ?></td>
        </tr>
        <tbody border="2" bordercolor="#E6FFFF" bgcolor="#FFFFCC">
            <th scope="row"><?= __('start') ?></th>
            <td><?= h($this->request->getData('start')) ?></td>
        </tr>
        <tbody border="2" bordercolor="#E6FFFF" bgcolor="#FFFFCC">
            <th scope="row"><?= __('finish') ?></th>
            <td><?= h($this->request->getData('finish')) ?></td>
        </tr>
        <tbody border="2" bordercolor="#E6FFFF" bgcolor="#FFFFCC">
            <th scope="row"><?= __('status') ?></th>
            <td><?= h($this->request->getData('status')) ?></td>
        </tr>
        <tbody border="2" bordercolor="#E6FFFF" bgcolor="#FFEFD5">
            <th scope="row"><?= __('登録日時') ?></th>
            <td><?= h($priceMaterial->created_at) ?></td>
        </tr>
        <tbody border="2" bordercolor="#E6FFFF" bgcolor="#FFEFD5">
            <th scope="row"><?= __('登録者') ?></th>
            <td><?= h($CreatedStaff) ?></td>
    </table>
<br>
<br>
        <p align="center"><?= $this->Form->button(__('top'), array('name' => 'top')) ?></p>
        <?= $this->Form->end() ?>

