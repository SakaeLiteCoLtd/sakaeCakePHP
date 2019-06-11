<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\PriceProduct $priceProduct
 */
?>
<?= $this->Form->create($priceProduct, ['url' => ['action' => 'do']]) ?>
        <?php
            $username = $this->request->Session()->read('Auth.User.username');

            $startY = $_POST['start']['year'];
            $startM = $_POST['start']['month'];
            $startD = $_POST['start']['day'];
            $startYMD = array($startY,$startM,$startD);
            $start = implode("-",$startYMD);

            echo $this->Form->hidden('product_id' ,['value'=>$_POST['product_id'] ]) ;
            echo $this->Form->hidden('customer_id' ,['value'=>$_POST['customer_id'] ]) ;
            echo $this->Form->hidden('price' ,['value'=>$_POST['price'] ]) ;
            echo $this->Form->hidden('start' ,['value'=>$start ]) ;
            echo $this->Form->hidden('status' ,['value'=>$_POST['status'] ]) ;
            echo $this->Form->hidden('delete_flag' ,['value'=>$_POST['delete_flag'] ]) ;
            echo $this->Form->hidden('created_staff' ,['value'=>$_POST['created_staff'] ]) ;
            echo $this->Form->hidden('updated_staff' ,['value'=>null ]) ;
        ?>

              <p align="center"><?php echo $this->Html->image('ShinkiTourokuMenu/touroku.gif',array('width'=>'157','height'=>'50'));?></p>

<hr size="5">

    <table align="center" border="2" bordercolor="#E6FFFF" cellpadding="0" cellspacing="0" style="border-bottom: solid;border-width: 1px">
        <tbody border="2" bordercolor="#E6FFFF" bgcolor="#FFFFCC">
            <th scope="row"><?= __('product_id') ?></th>
            <td><?= h($this->request->getData('product_id')) ?></td>
        </tr>
        <tbody border="2" bordercolor="#E6FFFF" bgcolor="#FFFFCC">
            <th scope="row"><?= __('customer_id') ?></th>
            <td><?= h($this->request->getData('customer_id')) ?></td>
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
            <th scope="row"><?= __('status') ?></th>
            <td><?= h($this->request->getData('status')) ?></td>
        </tr>
    </table>
<br>
<br>
        <p align="center"><?= $this->Form->button('back', ['onclick' => 'history.back()', 'type' => 'button']) ?>
        <?= $this->Form->button(__('add'), array('name' => 'touroku')) ?></p>
        <?= $this->Form->end() ?>
