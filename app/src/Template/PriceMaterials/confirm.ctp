<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\Deliver $priceMaterial
 */
?>
<?= $this->Form->create($priceMaterial, ['url' => ['action' => 'do']]) ?>
        <?php
            $username = $this->request->Session()->read('Auth.User.username');

            $startY = $_POST['start']['year'];
            $startM = $_POST['start']['month'];
            $startD = $_POST['start']['day'];
            $startYMD = array($startY,$startM,$startD);
            $start = implode("-",$startYMD);

            $finishY = $_POST['finish']['year'];
            $finishM = $_POST['finish']['month'];
            $finishD = $_POST['finish']['day'];
            $finishYMD = array($finishY,$finishM,$finishD);
            $finish = implode("-",$finishYMD);

            echo $this->Form->hidden('material_id' ,['value'=>$_POST['material_id'] ]) ;
            echo $this->Form->hidden('supplier_id' ,['value'=>$_POST['supplier_id'] ]) ;
            echo $this->Form->hidden('lot_low' ,['value'=>$_POST['lot_low'] ]) ;
            echo $this->Form->hidden('lot_upper' ,['value'=>$_POST['lot_upper'] ]) ;
            echo $this->Form->hidden('price' ,['value'=>$_POST['price'] ]) ;
            echo $this->Form->hidden('start' ,['value'=>$start ]) ;
            echo $this->Form->hidden('finish' ,['value'=>$finish ]) ;
            echo $this->Form->hidden('status' ,['value'=>$_POST['status'] ]) ;
            echo $this->Form->hidden('delete_flag' ,['value'=>$_POST['delete_flag'] ]) ;
            echo $this->Form->hidden('created_staff' ,['value'=>$_POST['created_staff'] ]) ;
            echo $this->Form->hidden('updated_staff' ,['value'=>null ]) ;
        ?>

              <p align="center"><?php echo $this->Html->image('ShinkiTourokuMenu/touroku.gif',array('width'=>'157','height'=>'50'));?></p>

<hr size="5">

    <table align="center" border="2" bordercolor="#E6FFFF" cellpadding="0" cellspacing="0" style="border-bottom: solid;border-width: 1px">
        <tbody border="2" bordercolor="#E6FFFF" bgcolor="#FFFFCC">
            <th scope="row"><?= __('material_id') ?></th>
            <td><?= h($this->request->getData('material_id')) ?></td>
        </tr>
        <tbody border="2" bordercolor="#E6FFFF" bgcolor="#FFFFCC">
            <th scope="row"><?= __('supplier_id') ?></th>
            <td><?= h($this->request->getData('supplier_id')) ?></td>
        </tr>
        <tbody border="2" bordercolor="#E6FFFF" bgcolor="#FFFFCC">
            <th scope="row"><?= __('lot_low') ?></th>
            <td><?= h($this->request->getData('lot_low')) ?></td>
        </tr>
        <tbody border="2" bordercolor="#E6FFFF" bgcolor="#FFFFCC">
            <th scope="row"><?= __('lot_upper') ?></th>
            <td><?= h($this->request->getData('lot_upper')) ?></td>
        </tr>
        <tbody border="2" bordercolor="#E6FFFF" bgcolor="#FFFFCC">
            <th scope="row"><?= __('price') ?></th>
            <td><?= h($this->request->getData('price')) ?></td>
        </tr>
        <tbody border="2" bordercolor="#E6FFFF" bgcolor="#FFFFCC">
            <th scope="row"><?= __('start') ?></th>
            <td><?= h($start) ?></td>
        </tr>
        <tbody border="2" bordercolor="#E6FFFF" bgcolor="#FFFFCC">
            <th scope="row"><?= __('finish') ?></th>
            <td><?= h($finish) ?></td>
        </tr>
        <tbody border="2" bordercolor="#E6FFFF" bgcolor="#FFFFCC">
            <th scope="row"><?= __('status') ?></th>
            <td><?= h($this->request->getData('status')) ?></td>
        </tr>
    </table>
<br>
<br>
        <p align="center"><?= $this->Form->button('back', ['onclick' => 'history.back()', 'type' => 'button']) ?>
        <?= $this->Form->button(__('add'), array('name' => 'touroku')) ?></p>
        <?= $this->Form->end() ?>
