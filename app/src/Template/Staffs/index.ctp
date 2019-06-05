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

    <?= $this->Html->css('base2.css') ?>
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
              <p align="center"><?php echo $this->Html->image('ShinkiTourokuMenu/shinki_staff.gif',array('width'=>'125','height'=>'46'));?></p>
          </tr>
  </tr>
</table>
</body>
</html>

<hr size="5">

              <p align="center"><?php echo $this->Html->image('ShinkiTourokuMenu/menu_csv.gif',array('url'=>array('controller'=>'staffs','action'=>'confirmcsv')));?></p>

<hr size="5">

              <p align="center"><?php echo $this->Html->image('ShinkiTourokuMenu/sinnkitouroku.gif',array('url'=>array('controller'=>'staffs','action'=>'form')));?></p>

<hr size="5">

<?=$this->Form->create($entity) ?>
<fieldset align="center">

<table border="2" bordercolor="#E6FFFF" align="center">
		<td bgcolor="#E6FFFF" style="width: 100px;border-bottom: solid;border-width: 1px">staff_code</td>
		<td bgcolor="#E6FFFF" style="border-bottom: solid;border-width: 1px"><?= $this->Form->input("staff_code", array('type' => 'value', 'label'=>false)) ?></td>
		<td  bgcolor="#E6FFFF" style="border-bottom: solid;border-width: 1px">f_name</td>
		<td bgcolor="#E6FFFF" style="border-bottom: solid;border-width: 1px"><?= $this->Form->input("f_name", array('type' => 'value', 'label'=>false)); ?></td>
		<td  bgcolor="#E6FFFF" style="border-bottom: solid;border-width: 1px">l_name</td>
		<td bgcolor="#E6FFFF" style="border-bottom: solid;border-width: 1px"><?= $this->Form->input("l_name", array('type' => 'value', 'label'=>false)); ?></td>
        <td bgcolor="#E6FFFF" class="noborder" style="border-style: none;color: #E6FFFF"><?=$this->Form->button("search") ?></td>
</table>
</fieldset>
<?=$this->Form->end() ?>

    <table align="center" border="2" bordercolor="#E6FFFF" cellpadding="0" cellspacing="0" style="border-bottom: solid;border-width: 1px">
        <thead>
            <tr border="2" bordercolor="#E6FFFF" bgcolor="#FFDEAD">
                <th scope="col"><?= $this->Paginator->sort('staff_code') ?></th>
                <th scope="col" style="background-color: #FFDEAD"><?= $this->Paginator->sort('f_name') ?></th>
                <th scope="col" style="background-color: #FFDEAD"><?= $this->Paginator->sort('l_name') ?></th>
                <th scope="col" style="background-color: #FFDEAD"><?= $this->Paginator->sort('sex') ?></th>
                <th scope="col" style="background-color: #FFDEAD"><?= $this->Paginator->sort('birth') ?></th>
                <th scope="col" style="background-color: #FFDEAD"><?= $this->Paginator->sort('date_start') ?></th>
                <th scope="col" style="background-color: #FFDEAD"><?= $this->Paginator->sort('date_finish') ?></th>
                <th scope="col" style="background-color: #FFDEAD" class="actions"><?= __('') ?></th>
            </tr>
        </thead>
        <tbody border="2" bordercolor="#E6FFFF" bgcolor="#FFEFD5">
            <?php foreach ($staffs as $staff): ?>
            <tr>
                <td><?= h($staff->staff_code) ?></td>
                <td><?= h($staff->f_name) ?></td>
                <td><?= h($staff->l_name) ?></td>
            <?php
            	if($staff->sex == null){
            	$sex = '';
            	} elseif($staff->sex == 1) {
            	$sex = 'F';
            	} else {
            	$sex = 'M';
            	}
            ?>
                <td><?= h($sex) ?></td>
                <td><?= h($staff->birth) ?></td>
                <td><?= h($staff->date_start) ?></td>
                <td><?= h($staff->date_finish) ?></td>
                <td class="actions">
                    <?= $this->Html->link(__('edit'), ['action' => 'edit', $staff->id]) ?>
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
