<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\ImKikakus[]|\Cake\Collection\CollectionInterface $imKikakus
 */
?>
<nav class="large-3 medium-4 columns" id="actions-sidebar">
    <ul class="side-nav">
        <li class="heading"><?= __('Actions') ?></li>
        <li><?= $this->Html->link(__('New Im Kikakus'), ['action' => 'add']) ?></li>
        <li><?= $this->Html->link(__('List Im Sokuteidata Heads'), ['controller' => 'ImSokuteidataHeads', 'action' => 'index']) ?></li>
        <li><?= $this->Html->link(__('New Im Sokuteidata Head'), ['controller' => 'ImSokuteidataHeads', 'action' => 'add']) ?></li>
    </ul>
</nav>
<div class="imKikakus index large-9 medium-8 columns content">
    <h3><?= __('Im Kikakus') ?></h3>
    <table cellpadding="0" cellspacing="0">
        <thead>
            <tr>
                <th scope="col"><?= $this->Paginator->sort('id') ?></th>
                <th scope="col"><?= $this->Paginator->sort('im_sokuteidata_head_id') ?></th>
                <th scope="col"><?= $this->Paginator->sort('size_num') ?></th>
                <th scope="col"><?= $this->Paginator->sort('size') ?></th>
                <th scope="col"><?= $this->Paginator->sort('upper') ?></th>
                <th scope="col"><?= $this->Paginator->sort('lower') ?></th>
                <th scope="col" class="actions"><?= __('Actions') ?></th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($imKikakus as $imKikakus): ?>
            <tr>
                <td><?= h($imKikakus->id) ?></td>
                <td><?= $imKikakus->has('im_sokuteidata_head') ? $this->Html->link($imKikakus->im_sokuteidata_head->id, ['controller' => 'ImSokuteidataHeads', 'action' => 'view', $imKikakus->im_sokuteidata_head->id]) : '' ?></td>
                <td><?= $this->Number->format($imKikakus->size_num) ?></td>
                <td><?= $this->Number->format($imKikakus->size) ?></td>
                <td><?= $this->Number->format($imKikakus->upper) ?></td>
                <td><?= $this->Number->format($imKikakus->lower) ?></td>
                <td class="actions">
                    <?= $this->Html->link(__('View'), ['action' => 'view', $imKikakus->id]) ?>
                    <?= $this->Html->link(__('Edit'), ['action' => 'edit', $imKikakus->id]) ?>
                    <?= $this->Form->postLink(__('Delete'), ['action' => 'delete', $imKikakus->id], ['confirm' => __('Are you sure you want to delete # {0}?', $imKikakus->id)]) ?>
                </td>
            </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
    <div class="paginator">
        <ul class="pagination">
            <?= $this->Paginator->first('<< ' . __('first')) ?>
            <?= $this->Paginator->prev('< ' . __('previous')) ?>
            <?= $this->Paginator->numbers() ?>
            <?= $this->Paginator->next(__('next') . ' >') ?>
            <?= $this->Paginator->last(__('last') . ' >>') ?>
        </ul>
        <p><?= $this->Paginator->counter(['format' => __('Page {{page}} of {{pages}}, showing {{current}} record(s) out of {{count}} total')]) ?></p>
    </div>
</div>
