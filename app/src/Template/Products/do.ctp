<?php
/**
 * AuthHelper: Authの変数にアクセスできる
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\Deliver $product
 */
?>
<?= $this->Form->create($product, ['url' => ['action' => 'index']]) ?>

<?php
            $username = $this->request->Session()->read('Auth.User.username');
?>
              <p align="center"><?php echo $this->Html->image('ShinkiTourokuMenu/touroku.gif',array('width'=>'157','height'=>'50'));?></p>

<hr size="5">



<legend align="center"><font color="red"><?= __('＊下記のように登録されました。') ?></font></legend>
    <table align="center" border="2" bordercolor="#E6FFFF" cellpadding="0" cellspacing="0" style="border-bottom: solid;border-width: 1px">
        <tbody border="2" bordercolor="#E6FFFF" bgcolor="#FFFFCC">
            <th scope="row"><?= __('product_code') ?></th>
            <td><?= h($this->request->getData('product_code')) ?></td>
        </tr>
        <tbody border="2" bordercolor="#E6FFFF" bgcolor="#FFFFCC">
            <th scope="row"><?= __('product_name') ?></th>
            <td><?= h($this->request->getData('product_name')) ?></td>
        </tr>
        <tbody border="2" bordercolor="#E6FFFF" bgcolor="#FFFFCC">
            <th scope="row"><?= __('customer_id') ?></th>
            <td><?= h($this->request->getData('customer_id')) ?></td>
        </tr>
        <tbody border="2" bordercolor="#E6FFFF" bgcolor="#FFFFCC">
            <th scope="row"><?= __('multiple_cs') ?></th>
            <td><?= h($this->request->getData('multiple_cs')) ?></td>
        </tr>
        <tbody border="2" bordercolor="#E6FFFF" bgcolor="#FFFFCC">
            <th scope="row"><?= __('material_id') ?></th>
            <td><?= h($this->request->getData('material_id')) ?></td>
        </tr>
        <tbody border="2" bordercolor="#E6FFFF" bgcolor="#FFFFCC">
            <th scope="row"><?= __('weight') ?></th>
            <td><?= h($this->request->getData('weight')) ?></td>
        </tr>
        <tbody border="2" bordercolor="#E6FFFF" bgcolor="#FFFFCC">
            <th scope="row"><?= __('torisu') ?></th>
            <td><?= h($this->request->getData('torisu')) ?></td>
        </tr>
        <tbody border="2" bordercolor="#E6FFFF" bgcolor="#FFFFCC">
            <th scope="row"><?= __('cycle') ?></th>
            <td><?= h($this->request->getData('cycle')) ?></td>
        </tr>
        <tbody border="2" bordercolor="#E6FFFF" bgcolor="#FFFFCC">
            <th scope="row"><?= __('primary_p') ?></th>
            <td><?= h($this->request->getData('primary_p')) ?></td>
        </tr>
        <tbody border="2" bordercolor="#E6FFFF" bgcolor="#FFFFCC">
            <th scope="row"><?= __('gaityu') ?></th>
            <td><?= h($this->request->getData('gaityu')) ?></td>
        </tr>
        <tbody border="2" bordercolor="#E6FFFF" bgcolor="#FFFFCC">
            <th scope="row"><?= __('status') ?></th>
            <td><?= h($this->request->getData('status')) ?></td>
        </tr>
        <tbody border="2" bordercolor="#E6FFFF" bgcolor="#FFEFD5">
            <th scope="row"><?= __('登録日時') ?></th>
            <td><?= h($product->created_at) ?></td>
        </tr>
        <tbody border="2" bordercolor="#E6FFFF" bgcolor="#FFEFD5">
            <th scope="row"><?= __('登録者') ?></th>
            <td><?= h($CreatedStaff) ?></td>
    </table>
<br>
<br>
        <p align="center"><?= $this->Form->button(__('top'), array('name' => 'top')) ?></p>
        <?= $this->Form->end() ?>
