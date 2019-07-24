<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\ImSokuteidataResult[]|\Cake\Collection\CollectionInterface $imSokuteidataResults
 */
?>
<nav class="large-3 medium-4 columns" id="actions-sidebar">
    <ul class="side-nav">
        <li class="heading"><?= __('Actions') ?></li>
        <li><?= $this->Html->link(__('New Im Sokuteidata Result'), ['action' => 'add']) ?></li>
        <li><?= $this->Html->link(__('List Im Sokuteidata Heads'), ['controller' => 'ImSokuteidataHeads', 'action' => 'index']) ?></li>
        <li><?= $this->Html->link(__('New Im Sokuteidata Head'), ['controller' => 'ImSokuteidataHeads', 'action' => 'add']) ?></li>
    </ul>
</nav>
<div class="imSokuteidataResults index large-9 medium-8 columns content">
    <h3><?= __('Im Sokuteidata Results') ?></h3>
    <table cellpadding="0" cellspacing="0">
        <thead>
            <tr>
                <th scope="col"><?= $this->Paginator->sort('id') ?></th>
                <th scope="col"><?= $this->Paginator->sort('im_sokuteidata_head_id') ?></th>
                <th scope="col"><?= $this->Paginator->sort('inspec_datetime') ?></th>
                <th scope="col"><?= $this->Paginator->sort('serial') ?></th>
                <th scope="col"><?= $this->Paginator->sort('size_num') ?></th>
                <th scope="col"><?= $this->Paginator->sort('result') ?></th>
                <th scope="col"><?= $this->Paginator->sort('status') ?></th>
                <th scope="col" class="actions"><?= __('Actions') ?></th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($imSokuteidataResults as $imSokuteidataResult): ?>
            <tr>
                <td><?= h($imSokuteidataResult->id) ?></td>
                <td><?= $imSokuteidataResult->has('im_sokuteidata_head') ? $this->Html->link($imSokuteidataResult->im_sokuteidata_head->id, ['controller' => 'ImSokuteidataHeads', 'action' => 'view', $imSokuteidataResult->im_sokuteidata_head->id]) : '' ?></td>
                <td><?= h($imSokuteidataResult->inspec_datetime) ?></td>
                <td><?= h($imSokuteidataResult->serial) ?></td>
                <td><?= $this->Number->format($imSokuteidataResult->size_num) ?></td>
                <td><?= $this->Number->format($imSokuteidataResult->result) ?></td>
                <td><?= h($imSokuteidataResult->status) ?></td>
                <td class="actions">
                    <?= $this->Html->link(__('View'), ['action' => 'view', $imSokuteidataResult->id]) ?>
                    <?= $this->Html->link(__('Edit'), ['action' => 'edit', $imSokuteidataResult->id]) ?>
                    <?= $this->Form->postLink(__('Delete'), ['action' => 'delete', $imSokuteidataResult->id], ['confirm' => __('Are you sure you want to delete # {0}?', $imSokuteidataResult->id)]) ?>
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
