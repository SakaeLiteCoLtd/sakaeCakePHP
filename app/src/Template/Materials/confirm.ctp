<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\Material $material
 */
?>
<?= $this->Form->create($material, ['url' => ['action' => 'preadd']]) ?>
        <?php
            $username = $this->request->Session()->read('Auth.User.username');
/*
            echo $this->Form->hidden('grade' ,['value'=>$_POST['grade'] ]) ;
            echo $this->Form->hidden('color' ,['value'=>$_POST['color'] ]) ;
            echo $this->Form->hidden('material_type_id' ,['value'=>$_POST['material_type_id'] ]) ;
            echo $this->Form->hidden('tani' ,['value'=>$_POST['tani'] ]) ;
            echo $this->Form->hidden('multiple_sup' ,['value'=>$_POST['multiple_sup'] ]) ;
            echo $this->Form->hidden('status' ,['value'=>$_POST['status'] ]) ;
            echo $this->Form->hidden('delete_flag' ,['value'=>$_POST['delete_flag'] ]) ;
            echo $this->Form->hidden('created_staff' ,['value'=>$_POST['created_staff'] ]) ;
            echo $this->Form->hidden('updated_staff' ,['value'=>null ]) ;
            */
            $session = $this->request->getSession();
            $session->write('materialdata.grade', $_POST['grade']);
            $session->write('materialdata.color', $_POST['color']);
            $session->write('materialdata.material_type_id', $_POST['material_type_id']);
            $session->write('materialdata.tani', $_POST['tani']);
            $session->write('materialdata.multiple_sup', $_POST['multiple_sup']);
            $session->write('materialdata.status', $_POST['status']);
            $session->write('materialdata.delete_flag', $_POST['delete_flag']);
            $session->write('materialdata.created_staff', $_POST['created_staff']);
            $session->write('materialdata.updated_staff', null);

        ?>
<hr size="5">

              <p align="center"><?php echo $this->Html->image('ShinkiTourokuMenu/touroku.gif',array('width'=>'157','height'=>'50'));?></p>

<hr size="5">

    <table align="center" border="2" bordercolor="#E6FFFF" cellpadding="0" cellspacing="0" style="border-bottom: solid;border-width: 1px">
        <tbody border="2" bordercolor="#E6FFFF" bgcolor="#FFFFCC">
            <th scope="row"><?= __('grade') ?></th>
            <td><?= h($this->request->getData('grade')) ?></td>
        </tr>
        <tbody border="2" bordercolor="#E6FFFF" bgcolor="#FFFFCC">
            <th scope="row"><?= __('color') ?></th>
            <td><?= h($this->request->getData('color')) ?></td>
        </tr>
        <tbody border="2" bordercolor="#E6FFFF" bgcolor="#FFFFCC">
            <th scope="row"><?= __('material_type_id') ?></th>
            <td><?= h($MaterialType) ?></td>
        </tr>
        <tbody border="2" bordercolor="#E6FFFF" bgcolor="#FFFFCC">
            <th scope="row"><?= __('tani') ?></th>
            <td><?= h($this->request->getData('tani')) ?></td>
        </tr>
        <tbody border="2" bordercolor="#E6FFFF" bgcolor="#FFFFCC">
            <th scope="row"><?= __('multiple_sup') ?></th>
            <td><?= h($this->request->getData('multiple_sup')) ?></td>
        </tr>
        <tbody border="2" bordercolor="#E6FFFF" bgcolor="#FFFFCC">
            <th scope="row"><?= __('Status') ?></th>
            <td><?= h($this->request->getData('status')) ?></td>
    </table>
<br>
<br>
        <p align="center"><?= $this->Form->button('back', ['onclick' => 'history.back()', 'type' => 'button']) ?>
        <?= $this->Form->button(__('add'), array('name' => 'touroku')) ?></p>
        <?= $this->Form->end() ?>
