<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\ImSokuteidataHead[]|\Cake\Collection\CollectionInterface $imSokuteidataHeads
 */
?>
<nav class="large-3 medium-4 columns" id="actions-sidebar">
    <ul class="side-nav">
        <li class="heading"><?= __('Actions') ?></li>
        <li><?= $this->Html->link(__('New Im Sokuteidata Head'), ['action' => 'add']) ?></li>
        <li><?= $this->Html->link(__('List Products'), ['controller' => 'Products', 'action' => 'index']) ?></li>
        <li><?= $this->Html->link(__('New Product'), ['controller' => 'Products', 'action' => 'add']) ?></li>
    </ul>
</nav>
<div class="imSokuteidataHeads index large-9 medium-8 columns content">
    <h3><?= __('Im Sokuteidata Heads') ?></h3>
    <table cellpadding="0" cellspacing="0">
        <thead>
            <tr>
                <th scope="col"><?= $this->Paginator->sort('id') ?></th>
                <th scope="col"><?= $this->Paginator->sort('product_id') ?></th>
                <th scope="col"><?= $this->Paginator->sort('kind_kensa') ?></th>
                <th scope="col"><?= $this->Paginator->sort('inspec_date') ?></th>
                <th scope="col"><?= $this->Paginator->sort('lot_num') ?></th>
                <th scope="col"><?= $this->Paginator->sort('torikomi') ?></th>
                <th scope="col"><?= $this->Paginator->sort('delete_flag') ?></th>
                <th scope="col"><?= $this->Paginator->sort('created_at') ?></th>
                <th scope="col"><?= $this->Paginator->sort('created_staff') ?></th>
                <th scope="col"><?= $this->Paginator->sort('updated_at') ?></th>
                <th scope="col"><?= $this->Paginator->sort('updated_staff') ?></th>
                <th scope="col" class="actions"><?= __('Actions') ?></th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($imSokuteidataHeads as $imSokuteidataHead): ?>
            <tr>
                <td><?= h($imSokuteidataHead->id) ?></td>
                <td><?= $imSokuteidataHead->has('product') ? $this->Html->link($imSokuteidataHead->product->id, ['controller' => 'Products', 'action' => 'view', $imSokuteidataHead->product->id]) : '' ?></td>
                <td><?= h($imSokuteidataHead->kind_kensa) ?></td>
                <td><?= h($imSokuteidataHead->inspec_date) ?></td>
                <td><?= h($imSokuteidataHead->lot_num) ?></td>
                <td><?= $this->Number->format($imSokuteidataHead->torikomi) ?></td>
                <td><?= $this->Number->format($imSokuteidataHead->delete_flag) ?></td>
                <td><?= h($imSokuteidataHead->created_at) ?></td>
                <td><?= h($imSokuteidataHead->created_staff) ?></td>
                <td><?= h($imSokuteidataHead->updated_at) ?></td>
                <td><?= h($imSokuteidataHead->updated_staff) ?></td>
                <td class="actions">
                    <?= $this->Html->link(__('View'), ['action' => 'view', $imSokuteidataHead->id]) ?>
                    <?= $this->Html->link(__('Edit'), ['action' => 'edit', $imSokuteidataHead->id]) ?>
                    <?= $this->Form->postLink(__('Delete'), ['action' => 'delete', $imSokuteidataHead->id], ['confirm' => __('Are you sure you want to delete # {0}?', $imSokuteidataHead->id)]) ?>
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
