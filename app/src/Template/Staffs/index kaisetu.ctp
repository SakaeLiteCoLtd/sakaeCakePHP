<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\Staff[]|\Cake\Collection\CollectionInterface $staffs
 */
?>
<!DOCTYPE html>
<html>
<head>
    <?= $this->Html->charset() ?>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>
        <?= $cakeDescription ?>:
        <?= $this->fetch('title') ?>
    </title>
    <?= $this->Html->meta('icon') ?>

    <?= $this->Html->css('base.css') ?>
    <?= $this->Html->css('cake.css') ?>

    <?= $this->fetch('meta') ?>
    <?= $this->fetch('css') ?>
    <?= $this->fetch('script') ?>
</head>
<body bgcolor="#E6FFFF">
<table width="1500" border="0" bordercolor="#E6FFFF" align="center" cellpadding="0" cellspacing="0" bgcolor="#E6FFFF">
  <tr>
    <td>
        <table width="1500" border="0" align="center" cellpadding="0" cellspacing="0" bordercolor="#CCCCCC" margin="0" padding="0">
          <tr>
            <td bgcolor="#E6FFFF">
              <p align="center"><?php echo $this->Html->image('ShinkiTourokuMenu/shinki_staff.gif',array('width'=>'157','height'=>'22'));?></p>
              <table style="margin-bottom:0px" width="180" border="0" align="center" cellpadding="0" cellspacing="0">
              </table>
            </td>
          </tr>
        </table>
    </td> 
  </tr>
</table>
</body>
</html>

<hr size="5">

              <p align="center"><?php echo $this->Html->image('ShinkiTourokuMenu/sinnkitouroku.gif',array('width'=>'157','height'=>'22','url'=>array('controller'=>'staffs','action'=>'form')));?></p>

<hr size="5">

<?=$this->Form->create($entity) ?>//entityという名前の空の入力欄を作る(controller)
<fieldset align="center">

<table border="2" bordercolor="#E6FFFF" align="center" style="width: 800px">
        <tr>
		<td bgcolor="#E6FFFF">スタッフID</td>
		<td><?= $this->Form->input("スタッフID", array('type' => 'value', 'label'=>false)) ?></td>
		<td bgcolor="#E6FFFF">氏名</td>
		<td><?= $this->Form->input("氏名", array('type' => 'value', 'label'=>false)); ?></td>
                <td bgcolor="#E6FFFF" class="noborder"><?=$this->Form->button("検索") ?></td>//ボタンを押したらpostでデータが送られる
	</tr>
</table>
</fieldset>
<?=$this->Form->end() ?>

    <table align="center" border="2" bordercolor="#E6FFFF" cellpadding="0" cellspacing="0">
        <thead>
            <tr  border="2" bordercolor="#E6FFFF" bgcolor="#FFDEAD">
                <th scope="col"><?= $this->Paginator->sort('スタッフID') ?></th>
                <th scope="col"><?= $this->Paginator->sort('姓') ?></th>
                <th scope="col"><?= $this->Paginator->sort('名') ?></th>
                <th scope="col"><?= $this->Paginator->sort('性別') ?></th>
                <th scope="col"><?= $this->Paginator->sort('誕生日') ?></th>
                <th scope="col"><?= $this->Paginator->sort('入社日') ?></th>
                <th scope="col"><?= $this->Paginator->sort('退社日') ?></th>
                <th scope="col" class="actions"><?= __('') ?></th>
            </tr>
        </thead>
        <tbody border="2" bordercolor="#E6FFFF" bgcolor="#FFEFD5">
            <?php foreach ($staffs as $staff): ?>//配列$staffsを表示する
            <tr>
                <td><?= h($staff->staff_code) ?></td>
                <td><?= h($staff->f_name) ?></td>
                <td><?= h($staff->l_name) ?></td>
                <td><?= h($staff->sex) ?></td>
                <td><?= h($staff->birth) ?></td>
                <td><?= h($staff->date_start) ?></td>
                <td><?= h($staff->date_finish) ?></td>
                <td class="actions">
                    <?= $this->Html->link(__('編集'), ['action' => 'edit', $staff->id]) ?>//☆これはポスト？
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
