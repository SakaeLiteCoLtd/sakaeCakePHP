<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\PriceMaterial $priceMaterial
 */
?>
        <?php
            $options = [
	            '0' => 'edit this data　',
	            '1' => 'delete this data' 
                    ];
        ?>


    <?= $this->Form->create($priceMaterial) ?>
    <fieldset>
        
 		<a align="center"><?= $this->Form->radio("delete_flag", $options); ?></a>

<table align="center" border="2" bordercolor="#E6FFFF" cellpadding="0" cellspacing="0" style="border-bottom: solid;border-width: 1px">
        <tbody border="2" bordercolor="#E6FFFF" bgcolor="#FFFFCC">
            <th scope="row"><?= __('material_id') ?></th>
		<td><?= $this->Form->input("material_id", ["type"=>"select","empty"=>"選択してください", "options"=>$arrMaterial, 'label'=>false]); ?></td>
	</tr>
        <tbody border="2" bordercolor="#E6FFFF" bgcolor="#FFFFCC">
            <th scope="row"><?= __('supplier_id') ?></th>
		<td><?= $this->Form->input("supplier_id", ["type"=>"select","empty"=>"選択してください", "options"=>$arrSupplier, 'label'=>false]); ?></td>
	</tr>
        <tbody border="2" bordercolor="#E6FFFF" bgcolor="#FFFFCC">
            <th scope="row"><?= __('lot_low') ?></th>
		<td><?= $this->Form->input("lot_low", array('type' => 'value', 'label'=>false)); ?></td>
	</tr>
        <tbody border="2" bordercolor="#E6FFFF" bgcolor="#FFFFCC">
            <th scope="row"><?= __('lot_upper') ?></th>
		<td><?= $this->Form->input("lot_upper", array('type' => 'value', 'label'=>false)); ?></td>
	</tr>
        <tbody border="2" bordercolor="#E6FFFF" bgcolor="#FFFFCC">
            <th scope="row"><?= __('price') ?></th>
		<td><?= $this->Form->input("price", array('type' => 'value', 'label'=>false)); ?></td>
	</tr>
        <tbody border="2" bordercolor="#E6FFFF" bgcolor="#FFFFCC">
            <th scope="row"><?= __('start') ?></th>
		<td><?= $this->Form->input("start", array('type' => 'date', 'label'=>false)); ?></td>
	</tr>
        <tbody border="2" bordercolor="#E6FFFF" bgcolor="#FFFFCC">
            <th scope="row"><?= __('finish') ?></th>
		<td><?= $this->Form->input("finish", array('type' => 'date', 'label'=>false)); ?></td>
	</tr>
        <tbody border="2" bordercolor="#E6FFFF" bgcolor="#FFFFCC">
            <th scope="row"><?= __('status') ?></th>
		<td><?= $this->Form->input("status", array('type' => 'value', 'label'=>false)); ?></td>
	</tr>
</table>

        <?php
//            echo $this->Form->hidden('delete_flag');
//            echo $this->Form->hidden('created_at') ;
            echo $this->Form->hidden('created_staff' ,['value'=>$priceMaterial->created_staff ]) ;
//            echo $this->Form->hidden('updated_at', ['empty' => true]);
            echo $this->Form->hidden('updated_staff');
        ?>
    </fieldset>
    <center><?= $this->Form->button(__('OK'), array('name' => 'kakunin')) ?></center>
    <?= $this->Form->end() ?>
</div>
