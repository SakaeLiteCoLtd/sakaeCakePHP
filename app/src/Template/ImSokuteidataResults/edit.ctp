<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\ImSokuteidataResult $imSokuteidataResult
 */
?>
<nav class="large-3 medium-4 columns" id="actions-sidebar">
    <ul class="side-nav">
        <li class="heading"><?= __('Actions') ?></li>
        <li><?= $this->Form->postLink(
                __('Delete'),
                ['action' => 'delete', $imSokuteidataResult->id],
                ['confirm' => __('Are you sure you want to delete # {0}?', $imSokuteidataResult->id)]
            )
        ?></li>
        <li><?= $this->Html->link(__('List Im Sokuteidata Results'), ['action' => 'index']) ?></li>
        <li><?= $this->Html->link(__('List Im Sokuteidata Heads'), ['controller' => 'ImSokuteidataHeads', 'action' => 'index']) ?></li>
        <li><?= $this->Html->link(__('New Im Sokuteidata Head'), ['controller' => 'ImSokuteidataHeads', 'action' => 'add']) ?></li>
    </ul>
</nav>
<div class="imSokuteidataResults form large-9 medium-8 columns content">
    <?= $this->Form->create($imSokuteidataResult) ?>
    <fieldset>
        <legend><?= __('Edit Im Sokuteidata Result') ?></legend>
        <?php
            echo $this->Form->control('im_sokuteidata_head_id', ['options' => $imSokuteidataHeads]);
            echo $this->Form->control('inspec_datetime');
            echo $this->Form->control('serial');
            echo $this->Form->control('size_num');
            echo $this->Form->control('result');
            echo $this->Form->control('status');
        ?>
    </fieldset>
    <?= $this->Form->button(__('Submit')) ?>
    <?= $this->Form->end() ?>
</div>
