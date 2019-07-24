<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\ImKikakus $imKikakus
 */
?>
<nav class="large-3 medium-4 columns" id="actions-sidebar">
    <ul class="side-nav">
        <li class="heading"><?= __('Actions') ?></li>
        <li><?= $this->Html->link(__('Edit Im Kikakus'), ['action' => 'edit', $imKikakus->id]) ?> </li>
        <li><?= $this->Form->postLink(__('Delete Im Kikakus'), ['action' => 'delete', $imKikakus->id], ['confirm' => __('Are you sure you want to delete # {0}?', $imKikakus->id)]) ?> </li>
        <li><?= $this->Html->link(__('List Im Kikakus'), ['action' => 'index']) ?> </li>
        <li><?= $this->Html->link(__('New Im Kikakus'), ['action' => 'add']) ?> </li>
        <li><?= $this->Html->link(__('List Im Sokuteidata Heads'), ['controller' => 'ImSokuteidataHeads', 'action' => 'index']) ?> </li>
        <li><?= $this->Html->link(__('New Im Sokuteidata Head'), ['controller' => 'ImSokuteidataHeads', 'action' => 'add']) ?> </li>
    </ul>
</nav>
<div class="imKikakus view large-9 medium-8 columns content">
    <h3><?= h($imKikakus->id) ?></h3>
    <table class="vertical-table">
        <tr>
            <th scope="row"><?= __('Id') ?></th>
            <td><?= h($imKikakus->id) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Im Sokuteidata Head') ?></th>
            <td><?= $imKikakus->has('im_sokuteidata_head') ? $this->Html->link($imKikakus->im_sokuteidata_head->id, ['controller' => 'ImSokuteidataHeads', 'action' => 'view', $imKikakus->im_sokuteidata_head->id]) : '' ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Size Num') ?></th>
            <td><?= $this->Number->format($imKikakus->size_num) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Size') ?></th>
            <td><?= $this->Number->format($imKikakus->size) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Upper') ?></th>
            <td><?= $this->Number->format($imKikakus->upper) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Lower') ?></th>
            <td><?= $this->Number->format($imKikakus->lower) ?></td>
        </tr>
    </table>
</div>
