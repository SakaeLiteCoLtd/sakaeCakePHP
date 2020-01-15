<?php
/**
 * AuthHelper: Authの変数にアクセスできる
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\Deliver $product
 */
?>
        <?php
            $username = $this->request->Session()->read('Auth.User.username');
        ?>
        <hr size="5">
        <table style="margin-bottom:0px" width="750" border="0" align="center" cellpadding="0" cellspacing="0" bordercolor="#CCCCCC">
                  <tr style="background-color: #E6FFFF">
                    <td style="padding: 0.1rem 0.1rem;"><a href="qr/index.php"><?php echo $this->Html->image('ShinkiTourokuMenu/shinki_staff.gif',array('width'=>'105','height'=>'36','url'=>array('controller'=>'staffs','action'=>'index')));?></td>
                    <td style="padding: 0.1rem 0.1rem;"><a href="qr/index.php"><?php echo $this->Html->image('ShinkiTourokuMenu/shinki_user.gif',array('width'=>'105','height'=>'36','url'=>array('controller'=>'users','action'=>'index')));?></td>
                    <td style="padding: 0.1rem 0.1rem;"><a href="qr/index.php"><?php echo $this->Html->image('ShinkiTourokuMenu/TourokuCustomer.gif',array('width'=>'105','height'=>'36','url'=>array('controller'=>'customers','action'=>'index')));?></td>
                    <td style="padding: 0.1rem 0.1rem;"><a href="qr/index.php"><?php echo $this->Html->image('ShinkiTourokuMenu/teikyougif.gif',array('width'=>'105','height'=>'36','url'=>array('controller'=>'delivers','action'=>'index')));?></td>
                    <td style="padding: 0.1rem 0.1rem;"><a href="qr/index.php"><?php echo $this->Html->image('ShinkiTourokuMenu/kanikakyaku.gif',array('width'=>'105','height'=>'36','url'=>array('controller'=>'customers-handy','action'=>'index')));?></td>
                    <td style="padding: 0.1rem 0.1rem;"><a href="qr/index.php"><?php echo $this->Html->image('ShinkiTourokuMenu/touroku_supplier.gif',array('width'=>'105','height'=>'36','url'=>array('controller'=>'suppliers','action'=>'index')));?></td>
                    <td style="padding: 0.1rem 0.1rem;"><a href="qr/index.php"><?php echo $this->Html->image('ShinkiTourokuMenu/gaityuukubungif.gif',array('width'=>'105','height'=>'36','url'=>array('controller'=>'supplier-sections','action'=>'index')));?></td>
                  </tr>
                  <tr style="background-color: #E6FFFF">
                    <td style="padding: 0.1rem 0.1rem;"><a href="qr/index.php"><?php echo $this->Html->image('ShinkiTourokuMenu/genryoutaipu.gif',array('width'=>'105','height'=>'36','url'=>array('controller'=>'material-types','action'=>'index')));?></td>
                    <td style="padding: 0.1rem 0.1rem;"><a href="qr/index.php"><?php echo $this->Html->image('ShinkiTourokuMenu/touroku_genryou.gif',array('width'=>'105','height'=>'36','url'=>array('controller'=>'materials','action'=>'form')));?></td>
                    <td style="padding: 0.1rem 0.1rem;"><a href="qr/index.php"><?php echo $this->Html->image('ShinkiTourokuMenu/genryoukakaku.gif',array('width'=>'105','height'=>'36','url'=>array('controller'=>'price-materials','action'=>'index')));?></td>
                    <td style="padding: 0.1rem 0.1rem;"><a href="qr/index.php"><?php echo $this->Html->image('ShinkiTourokuMenu/seihinntouroku.gif',array('width'=>'105','height'=>'36','url'=>array('controller'=>'products','action'=>'form')));?></td>
                    <td style="padding: 0.1rem 0.1rem;"><a href="qr/index.php"><?php echo $this->Html->image('ShinkiTourokuMenu/seihinnkakaku.gif',array('width'=>'105','height'=>'36','url'=>array('controller'=>'price-products','action'=>'index')));?></td>
                    <td style="padding: 0.1rem 0.1rem;"><a href="qr/index.php"><?php echo $this->Html->image('ShinkiTourokuMenu/kenngenntouroku.gif',array('width'=>'105','height'=>'36','url'=>array('controller'=>'roles','action'=>'index')));?></td>
                  </tr>
        </table>
        <hr size="5">
        <br>

        <legend align="center"><strong style="font-size: 15pt; color:blue"><?= __("製品登録") ?></strong></legend>
    <?= $this->Form->create($product, ['url' => ['action' => 'confirm']]) ?>
    <fieldset>
<table align="center" border="2" bordercolor="#E6FFFF" cellpadding="0" cellspacing="0" style="border-bottom: solid;border-width: 1px">
        <tbody border="2" bordercolor="#E6FFFF" bgcolor="#FFFFCC">
            <th scope="row"><?= __('品番') ?></th>
		<td><?= $this->Form->input("product_code", array('type' => 'value', 'label'=>false)); ?></td>
	</tr>
        <tbody border="2" bordercolor="#E6FFFF" bgcolor="#FFFFCC">
            <th scope="row"><?= __('品名') ?></th>
		<td><?= $this->Form->input("product_name", array('type' => 'value', 'label'=>false)); ?></td>
	</tr>
        <tbody border="2" bordercolor="#E6FFFF" bgcolor="#FFFFCC">
            <th scope="row"><?= __('customer_id') ?></th>
		<td><?= $this->Form->input("customer_id", ["type"=>"select","empty"=>"Please select", "options"=>$arrCustomer, 'label'=>false]); ?></td>
	</tr>
        <tbody border="2" bordercolor="#E6FFFF" bgcolor="#FFFFCC">
            <th scope="row"><?= __('multiple_cs') ?></th>
		<td><?= $this->Form->input("multiple_cs", array('type' => 'value', 'label'=>false)); ?></td>
	</tr>
        <tbody border="2" bordercolor="#E6FFFF" bgcolor="#FFFFCC">
            <th scope="row"><?= __('material_id') ?></th>
		<td><?= $this->Form->input("material_id", ["type"=>"select","empty"=>"Please select", "options"=>$arrMaterial, 'label'=>false]); ?></td>
	</tr>
        <tbody border="2" bordercolor="#E6FFFF" bgcolor="#FFFFCC">
            <th scope="row"><?= __('weight') ?></th>
		<td><?= $this->Form->input("weight", array('type' => 'value', 'label'=>false)); ?></td>
	</tr>
        <tbody border="2" bordercolor="#E6FFFF" bgcolor="#FFFFCC">
            <th scope="row"><?= __('torisu') ?></th>
		<td><?= $this->Form->input("torisu", array('type' => 'value', 'label'=>false)); ?></td>
	</tr>
        <tbody border="2" bordercolor="#E6FFFF" bgcolor="#FFFFCC">
            <th scope="row"><?= __('cycle') ?></th>
		<td><?= $this->Form->input("cycle", array('type' => 'value', 'label'=>false)); ?></td>
	</tr>
        <tbody border="2" bordercolor="#E6FFFF" bgcolor="#FFFFCC">
            <th scope="row"><?= __('primary_p') ?></th>
		<td><?= $this->Form->input("primary_p", array('type' => 'value', 'label'=>false)); ?></td>
	</tr>
        <tbody border="2" bordercolor="#E6FFFF" bgcolor="#FFFFCC">
            <th scope="row"><?= __('gaityu') ?></th>
		<td><?= $this->Form->input("gaityu", array('type' => 'value', 'label'=>false)); ?></td>
	</tr>
        <tbody border="2" bordercolor="#E6FFFF" bgcolor="#FFFFCC">
            <th scope="row"><?= __('status') ?></th>
		<td><?= $this->Form->input("status", array('type' => 'value', 'label'=>false)); ?></td>
	</tr>
</table>

        <?php
            echo $this->Form->hidden('delete_flag');
            echo $this->Form->hidden('created_staff', ['empty' => true]);
            echo $this->Form->hidden('updated_staff');
        ?>
    </fieldset>
    <table align="center" border="2" bordercolor="#E6FFFF" cellpadding="0" cellspacing="0">
    <tr>
      <td style="border-style: none;"><div align="center"><?= $this->Form->submit(__('確認'), array('name' => 'kakunin')); ?></div></td>
    </tr>
  </table>
<br>
