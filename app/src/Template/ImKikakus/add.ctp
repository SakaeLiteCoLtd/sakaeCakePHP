<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\ImKikakus $imKikakus
 */
?>
<nav class="large-3 medium-4 columns" id="actions-sidebar">
    <ul class="side-nav">
        <li class="heading"><?= __('Actions') ?></li>
        <li><?= $this->Html->link(__('List Im Kikakus'), ['action' => 'index']) ?></li>
        <li><?= $this->Html->link(__('List Im Sokuteidata Heads'), ['controller' => 'ImSokuteidataHeads', 'action' => 'index']) ?></li>
        <li><?= $this->Html->link(__('New Im Sokuteidata Head'), ['controller' => 'ImSokuteidataHeads', 'action' => 'add']) ?></li>
    </ul>
</nav>
<div class="imKikakus form large-9 medium-8 columns content">
    <?= $this->Form->create($imKikakus) ?>
    <fieldset>
        <legend><?= __('Add Im Kikakus') ?></legend>
        <?php
            echo $this->Form->control('im_sokuteidata_head_id', ['options' => $imSokuteidataHeads]);
            echo $this->Form->control('size_num');
            echo $this->Form->control('size');
            echo $this->Form->control('upper');
            echo $this->Form->control('lower');
        ?>
    </fieldset>
    <?= $this->Form->button(__('Submit')) ?>
    <?= $this->Form->end() ?>
</div>
