<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\Material[]|\Cake\Collection\CollectionInterface $materials
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

    <?= $this->Html->css('base1.css') ?>
    <?= $this->Html->css('cake.css') ?>

    <?= $this->fetch('meta') ?>
    <?= $this->fetch('css') ?>
    <?= $this->fetch('script') ?>
</head>
<body>
<table width="1500" border="0" bordercolor="#E6FFFF" align="center" cellpadding="0" cellspacing="0" bgcolor="#E6FFFF">
  <tr>
          <tr>
              <br>
              <p align="center"><?php echo $this->Html->image('ShinkiTourokuMenu/touroku_genryou.gif',array('width'=>'125','height'=>'46'));?></p>
          </tr>
  </tr>
</table>
</body>
</html>

<hr size="5">

              <p align="center"><?php echo $this->Html->image('ShinkiTourokuMenu/menu_csv.gif',array('url'=>array('controller'=>'materials','action'=>'confirmcsv')));?></p>

<hr size="5">

              <p align="center"><?php echo $this->Html->image('ShinkiTourokuMenu/sinnkitouroku.gif',array('url'=>array('controller'=>'materials','action'=>'form')));?></p>

<hr size="5">


<?=$this->Form->create($entity) ?>
<fieldset align="center">

<table border="2" bordercolor="#E6FFFF" align="center">
        <tr>
		<td bgcolor="#E6FFFF" style="width: 60px;border-bottom: solid;border-width: 1px">grade</td>
		<td bgcolor="#E6FFFF" style="width: 200px;border-bottom: solid;border-width: 1px"><?= $this->Form->input("grade", array('type' => 'value', 'label'=>false)) ?></td>
		<td bgcolor="#E6FFFF" style="width: 60px;border-bottom: solid;border-width: 1px">color</td>
		<td bgcolor="#E6FFFF" style="width: 200px;border-bottom: solid;border-width: 1px"><?= $this->Form->input("color", array('type' => 'value', 'label'=>false)); ?></td>
                <td bgcolor="#E6FFFF" class="noborder" style="border-style: none;color: #E6FFFF" ><?=$this->Form->button("search") ?></td>
	</tr>
</table>

</fieldset>
<?=$this->Form->end() ?>

    <table align="center" border="2" bordercolor="#E6FFFF" cellpadding="0" cellspacing="0" style="border-bottom: solid;border-width: 1px">
        <thead>
            <tr  border="2" bordercolor="#E6FFFF" bgcolor="#FFDEAD">
                <th scope="col"><?= $this->Paginator->sort('grade') ?></th>
                <th scope="col"><?= $this->Paginator->sort('color') ?></th>
                <th scope="col"><?= $this->Paginator->sort('material_type_id') ?></th>
                <th scope="col"><?= $this->Paginator->sort('tani') ?></th>
                <th scope="col"><?= $this->Paginator->sort('multiple_sup') ?></th>
                <th scope="col"><?= $this->Paginator->sort('status') ?></th>
                <th scope="col" class="actions"><?= __('') ?></th>
            </tr>
        </thead>
        <tbody border="2" bordercolor="#E6FFFF" bgcolor="#FFEFD5">
            <?php foreach ($materials as $material): ?>
            <tr>
                <td><?= h($material->grade) ?></td>
                <td><?= h($material->color) ?></td>
                <td><?= h($material->material_type_id) ?></td>
                <td><?= h($material->tani) ?></td>
                <td><?= h($material->multiple_sup) ?></td>
                <td><?= h($material->status) ?></td>
                <td class="actions">
                    <?= $this->Html->link(__('edit'), ['action' => 'edit', $material->id]) ?>
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
