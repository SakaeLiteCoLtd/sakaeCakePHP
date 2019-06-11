<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\SupplierSection $supplierSection
 */
?>
        <?php
            $options = [
	            '0' => 'edit this data　',
	            '1' => 'delete this data' 
                    ];
        ?>

    <?= $this->Form->create($supplierSection) ?>
    <fieldset>
        
 		<a align="center"><?= $this->Form->radio("delete_flag", $options); ?></a>

<table align="center" border="2" bordercolor="#E6FFFF" cellpadding="0" cellspacing="0" style="border-bottom: solid;border-width: 1px">
        <tbody border="2" bordercolor="#E6FFFF" bgcolor="#FFFFCC">
            <th scope="row"><?= __('name') ?></th>
		<td><?= $this->Form->input("name", array('type' => 'value', 'label'=>false)); ?></td>
	</tr>
        <tbody border="2" bordercolor="#E6FFFF" bgcolor="#FFFFCC">
            <th scope="row"><?= __('account_code') ?></th>
		<td><?= $this->Form->input("account_code", array('type' => 'value', 'label'=>false)); ?></td>
	</tr>
</table>
        
        <?php
//            echo $this->Form->hidden('delete_flag');
//            echo $this->Form->hidden('created_at') ;
            echo $this->Form->hidden('created_staff' ,['value'=>$supplierSection->created_staff ]) ;
//            echo $this->Form->hidden('updated_at', ['empty' => true]);
            echo $this->Form->hidden('updated_staff');
        ?>
    </fieldset>
    <center><?= $this->Form->button(__('OK'), array('name' => 'kakunin')) ?></center>
    <?= $this->Form->end() ?>
</div>

