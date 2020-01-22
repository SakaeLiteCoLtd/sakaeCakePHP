<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\Material[]|\Cake\Collection\CollectionInterface $materials
 */
 use App\myClass\Shinkimenus\htmlShinkimenu;//myClassフォルダに配置したクラスを使用

 $htmlShinkimenu = new htmlShinkimenu();
 $htmlShinkis = $htmlShinkimenu->Shinkimenus();
 ?>
 <hr size="5">
 <table style="margin-bottom:0px" width="750" border="0" align="center" cellpadding="0" cellspacing="0" bordercolor="#CCCCCC">
 <?php
    echo $htmlShinkis;
 ?>
 </table>

<body>
<hr size="5">
<table width="800" border="0" bordercolor="#E6FFFF" align="center" cellpadding="0" cellspacing="0" bgcolor="#E6FFFF">
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

              <p align="center"><?php echo $this->Html->image('ShinkiTourokuMenu/sinnkitouroku.gif',array('url'=>array('controller'=>'materials','action'=>'form')));?></p>

<hr size="5">


<?=$this->Form->create($entity) ?>
<fieldset align="center">

<table border="2" bordercolor="#E6FFFF" align="center">
  <tr>
		<td bgcolor="#E6FFFF" style="width: 100px;border-bottom: solid;border-width: 1px">グレード</td>
		<td bgcolor="#E6FFFF" style="width: 200px;border-bottom: solid;border-width: 1px"><?= $this->Form->input("grade", array('type' => 'value', 'label'=>false)) ?></td>
		<td bgcolor="#E6FFFF" style="width: 60px;border-bottom: solid;border-width: 1px">色</td>
		<td bgcolor="#E6FFFF" style="width: 200px;border-bottom: solid;border-width: 1px"><?= $this->Form->input("color", array('type' => 'value', 'label'=>false)); ?></td>
    <td bgcolor="#E6FFFF" class="noborder" style="border-style: none" ><?= $this->Form->submit(__('検索'), array('name' => 'index')); ?></td>
	</tr>
</table>

</fieldset>
<?=$this->Form->end() ?>

<br>
<table align="center" border="2" bordercolor="#E6FFFF" cellpadding="0" cellspacing="0" style="border-bottom: solid;border-width: 1px">
      <tbody border="2" bordercolor="#E6FFFF" bgcolor="#FFFFCC">
      <tr>
        <td width="100" ><div align="center"><strong><font color="blue" size="3"><?= h('グレード') ?></font></strong></div></td>
        <td width="100" ><div align="center"><strong><font color="blue" size="3"><?= h('色') ?></font></strong></div></td>
        <td width="100" ><div align="center"><strong><font color="blue" size="3"><?= h('原料タイプ') ?></font></strong></div></td>
        <td width="100" ><div align="center"><strong><font color="blue" size="3"><?= h('単位') ?></font></strong></div></td>
        <td width="100" ><div align="center"><strong><font color="blue" size="3"><?= h('multiple_sup') ?></font></strong></div></td>
        <td width="100" ><div align="center"><strong><font color="blue" size="3"><?= h('status') ?></font></strong></div></td>
        <td width="50" ><div align="center"><strong><font color="blue" size="3"><?= h('') ?></font></strong></div></td>
      </tr>

      <?php foreach ($materials as $material): ?>
      <tr>
          <td><?= h($material->grade) ?></td>
          <td><?= h($material->color) ?></td>
          <td><?= h($material->material_type_id) ?></td>
          <td><?= h($material->tani) ?></td>
          <td><?= h($material->multiple_sup) ?></td>
          <td><?= h($material->status) ?></td>
          <td class="actions">
              <?= $this->Html->link(__('編集'), ['action' => 'edit', $material->id]) ?>
          </td>
      </tr>
      <?php endforeach; ?>
</table>
<br>

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
