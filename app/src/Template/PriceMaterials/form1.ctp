<?php
/**
 * AuthHelper: Authの変数にアクセスできる
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\Deliver $priceMaterial
 */
?>
        <?php
            $username = $this->request->Session()->read('Auth.User.username');
        ?>

              <p align="center"><?php echo $this->Html->image('ShinkiTourokuMenu/touroku.gif',array('width'=>'157','height'=>'50'));?></p>

<hr size="5">

    <?= $this->Form->create($priceMaterial, ['url' => ['action' => 'form2']]) ?>
    <fieldset>
<table align="center" border="2" bordercolor="#E6FFFF" cellpadding="0" cellspacing="0" style="border-bottom: solid;border-width: 1px">
        <tbody border="2" bordercolor="#E6FFFF" bgcolor="#FFFFCC">
            <th scope="row"><?= __('material_id') ?></th>
		<td><?= $this->Form->input("material_id", ["type"=>"select","empty"=>"Please select", "options"=>$arrMaterial, 'label'=>false]); ?></td>
	</tr>
</table>

        <?php
            echo $this->Form->hidden('supplier_id');
            echo $this->Form->hidden('lot_low');
            echo $this->Form->hidden('lot_upper');
            echo $this->Form->hidden('price');
            echo $this->Form->hidden('start');
            echo $this->Form->hidden('finish');
            echo $this->Form->hidden('status');
            echo $this->Form->hidden('delete_flag');
            echo $this->Form->hidden('created_staff', ['empty' => true]);
            echo $this->Form->hidden('updated_staff');
        ?>
    </fieldset>
    <center><?= $this->Form->button(__('select'), array('name' => 'kakunin')) ?></center>
    <?= $this->Form->end() ?>
<br>
