<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\ImSokuteidataResult $imSokuteidataResult
 */
?>
<nav class="large-3 medium-4 columns" id="actions-sidebar">
    <ul class="side-nav">
        <li class="heading"><?= __('Actions') ?></li>
        <li><?= $this->Html->link(__('Edit Im Sokuteidata Result'), ['action' => 'edit', $imSokuteidataResult->id]) ?> </li>
        <li><?= $this->Form->postLink(__('Delete Im Sokuteidata Result'), ['action' => 'delete', $imSokuteidataResult->id], ['confirm' => __('Are you sure you want to delete # {0}?', $imSokuteidataResult->id)]) ?> </li>
        <li><?= $this->Html->link(__('List Im Sokuteidata Results'), ['action' => 'index']) ?> </li>
        <li><?= $this->Html->link(__('New Im Sokuteidata Result'), ['action' => 'add']) ?> </li>
        <li><?= $this->Html->link(__('List Im Sokuteidata Heads'), ['controller' => 'ImSokuteidataHeads', 'action' => 'index']) ?> </li>
        <li><?= $this->Html->link(__('New Im Sokuteidata Head'), ['controller' => 'ImSokuteidataHeads', 'action' => 'add']) ?> </li>
    </ul>
</nav>
<div class="imSokuteidataResults view large-9 medium-8 columns content">
    <h3><?= h($imSokuteidataResult->id) ?></h3>
    <table class="vertical-table">
        <tr>
            <th scope="row"><?= __('Id') ?></th>
            <td><?= h($imSokuteidataResult->id) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Im Sokuteidata Head') ?></th>
            <td><?= $imSokuteidataResult->has('im_sokuteidata_head') ? $this->Html->link($imSokuteidataResult->im_sokuteidata_head->id, ['controller' => 'ImSokuteidataHeads', 'action' => 'view', $imSokuteidataResult->im_sokuteidata_head->id]) : '' ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Serial') ?></th>
            <td><?= h($imSokuteidataResult->serial) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Status') ?></th>
            <td><?= h($imSokuteidataResult->status) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Size Num') ?></th>
            <td><?= $this->Number->format($imSokuteidataResult->size_num) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Result') ?></th>
            <td><?= $this->Number->format($imSokuteidataResult->result) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Inspec Datetime') ?></th>
            <td><?= h($imSokuteidataResult->inspec_datetime) ?></td>
        </tr>
    </table>
</div>
