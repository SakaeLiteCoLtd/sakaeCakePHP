<h2 class="mb-3"><i class="fas fa-list"></i> ����ꗗ</h2>

<?php if ($questions->isEmpty()): ?>
    <div class="card mb-2">
        <div class="card-body">
            <h5 class="card-title text-center">�\���ł��鎿�₪����܂���B</h5>
        </div>
    </div>
<?php else: ?>
    <p><?= $this->Paginator->counter(['format' => '�S{{pages}}�y�[�W��{{page}}�y�[�W�ڂ�\�����Ă��܂�']) ?></p>
    <?php foreach ($questions as $question): ?>
        <div class="card mb-2">
            <div class="card-body">
                <h5 class="card-title">
                    <i class="fas fa-user-circle"></i> <?= h($question->user->nickname) ?>
                </h5>
                <p class="card-text"><?= nl2br(h($question->body)) ?></p>
                <p class="card-subtitle mb-2 text-muted">
                    <small><?= h($question->created) ?></small>
                    <small>
                        <i class="fas fa-comment-dots"></i> <?= $this->Number->format($question->answered_count) ?>
                    </small>
                </p>
                <?= $this->Html->link('�ڍׂ�', ['action' => 'view', $question->id], ['class' => 'card-link']) ?>
                <?php if ($this->request->getSession()->read('Auth.User.id') === $question->user_id): ?>
                    <?= $this->Form->postLink('�폜����', ['action' => 'delete', $question->id],
                        ['confirm' => '������폜���܂��B��낵���ł����H'], ['class' => 'card-link']) ?>
                <?php endif; ?>
            </div>
        </div>
    <?php endforeach; ?>

    <div class="paginator">
        <ul class="pagination">
            <?= $this->Paginator->first('<< �ŏ���') ?>
            <?= $this->Paginator->prev('< �O��') ?>
            <?= $this->Paginator->numbers() ?>
            <?= $this->Paginator->next('���� >') ?>
            <?= $this->Paginator->last('�Ō�� >>') ?>
        </ul>
    </div>

<?php endif; ?>