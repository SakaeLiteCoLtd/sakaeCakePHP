<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\ImSokuteidataHead $imSokuteidataHead
 */
?>
<nav class="large-3 medium-4 columns" id="actions-sidebar">
    <ul class="side-nav">
        <li class="heading"><?= __('Actions') ?></li>
        <li><?= $this->Html->link(__('Edit Im Sokuteidata Head'), ['action' => 'edit', $imSokuteidataHead->id]) ?> </li>
        <li><?= $this->Form->postLink(__('Delete Im Sokuteidata Head'), ['action' => 'delete', $imSokuteidataHead->id], ['confirm' => __('Are you sure you want to delete # {0}?', $imSokuteidataHead->id)]) ?> </li>
        <li><?= $this->Html->link(__('List Im Sokuteidata Heads'), ['action' => 'index']) ?> </li>
        <li><?= $this->Html->link(__('New Im Sokuteidata Head'), ['action' => 'add']) ?> </li>
        <li><?= $this->Html->link(__('List Products'), ['controller' => 'Products', 'action' => 'index']) ?> </li>
        <li><?= $this->Html->link(__('New Product'), ['controller' => 'Products', 'action' => 'add']) ?> </li>
    </ul>
</nav>
<div class="imSokuteidataHeads view large-9 medium-8 columns content">
    <h3><?= h($imSokuteidataHead->id) ?></h3>
    <table class="vertical-table">
        <tr>
            <th scope="row"><?= __('Id') ?></th>
            <td><?= h($imSokuteidataHead->id) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Product') ?></th>
            <td><?= $imSokuteidataHead->has('product') ? $this->Html->link($imSokuteidataHead->product->id, ['controller' => 'Products', 'action' => 'view', $imSokuteidataHead->product->id]) : '' ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Kind Kensa') ?></th>
            <td><?= h($imSokuteidataHead->kind_kensa) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Lot Num') ?></th>
            <td><?= h($imSokuteidataHead->lot_num) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Created Staff') ?></th>
            <td><?= h($imSokuteidataHead->created_staff) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Updated Staff') ?></th>
            <td><?= h($imSokuteidataHead->updated_staff) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Torikomi') ?></th>
            <td><?= $this->Number->format($imSokuteidataHead->torikomi) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Delete Flag') ?></th>
            <td><?= $this->Number->format($imSokuteidataHead->delete_flag) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Inspec Date') ?></th>
            <td><?= h($imSokuteidataHead->inspec_date) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Created At') ?></th>
            <td><?= h($imSokuteidataHead->created_at) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Updated At') ?></th>
            <td><?= h($imSokuteidataHead->updated_at) ?></td>
        </tr>
    </table>
</div>
