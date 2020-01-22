<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\Staff[]|\Cake\Collection\CollectionInterface $staffs
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
 <hr size="5">
<table width="880" border="0" bordercolor="#E6FFFF" align="center" cellpadding="0" cellspacing="0" bgcolor="#E6FFFF">
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

              <p align="center"><?php echo $this->Html->image('ShinkiTourokuMenu/sinnkitouroku.gif',array('url'=>array('controller'=>'staffs','action'=>'form')));?></p>

<hr size="5">

<?=$this->Form->create($entity) ?>
<fieldset align="center">


<table border="2" bordercolor="#E6FFFF" align="center">
<tr>
  	<td bgcolor="#E6FFFF" style="width: 120px; border-bottom: solid;border-width: 1px">スタッフＩＤ</td>
		<td bgcolor="#E6FFFF" style="width: 40px; border-bottom: solid;border-width: 1px"><?= $this->Form->input("staff_code", array('type' => 'value', 'label'=>false)) ?></td>
		<td bgcolor="#E6FFFF" style="width: 30px; border-bottom: solid;border-width: 1px">姓</td>
		<td bgcolor="#E6FFFF" style="width: 40px; border-bottom: solid;border-width: 1px"><?= $this->Form->input("f_name", array('type' => 'value', 'label'=>false)); ?></td>
		<td bgcolor="#E6FFFF" style="width: 30px; border-bottom: solid;border-width: 1px">名</td>
		<td bgcolor="#E6FFFF" style="width: 40px; border-bottom: solid;border-width: 1px"><?= $this->Form->input("l_name", array('type' => 'value', 'label'=>false)); ?></td>
    <td bgcolor="#E6FFFF" class="noborder" style="width: 30px;border-style: none;"><div align="center"><?= $this->Form->submit(__('検索'), array('name' => 'index')); ?></div></td>
</tr>
</table>
</fieldset>
<?=$this->Form->end() ?>

<br>
<table align="center" border="2" bordercolor="#E6FFFF" cellpadding="0" cellspacing="0" style="border-bottom: solid;border-width: 1px">
      <tbody border="2" bordercolor="#E6FFFF" bgcolor="#FFFFCC">
      <tr>
        <td width="200" ><div align="center"><strong><font color="blue" size="2"><?= h('スタッフＩＤ') ?></font></strong></div></td>
        <td width="200" ><div align="center"><strong><font color="blue" size="3"><?= h('姓') ?></font></strong></div></td>
        <td width="200" ><div align="center"><strong><font color="blue" size="3"><?= h('名') ?></font></strong></div></td>
        <td width="200" ><div align="center"><strong><font color="blue" size="3"><?= h('性別') ?></font></strong></div></td>
        <td width="200" ><div align="center"><strong><font color="blue" size="3"><?= h('誕生日') ?></font></strong></div></td>
        <td width="200" ><div align="center"><strong><font color="blue" size="3"><?= h('入社日') ?></font></strong></div></td>
        <td width="200" ><div align="center"><strong><font color="blue" size="3"><?= h('退社日') ?></font></strong></div></td>
        <td width="100" ><div align="center"><strong><font color="blue" size="3"><?= h('') ?></font></strong></div></td>
      </tr>

      <?php foreach ($staffs as $staff): ?>
      <tr>
          <td><?= h($staff->staff_code) ?></td>
          <td><?= h($staff->f_name) ?></td>
          <td><?= h($staff->l_name) ?></td>
      <?php
        if($staff->sex == null){
        $sex = '';
        } elseif($staff->sex == 1) {
        $sex = '女';
        } else {
        $sex = '男';
        }
      ?>
          <td><?= h($sex) ?></td>
          <td><?= h($staff->birth) ?></td>
          <td><?= h($staff->date_start) ?></td>
          <td><?= h($staff->date_finish) ?></td>
          <td class="actions">
              <?= $this->Html->link(__('編集'), ['action' => 'edit', $staff->id]) ?>
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
