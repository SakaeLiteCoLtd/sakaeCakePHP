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
                    <td style="padding: 0.1rem 0.1rem;"><a href="qr/index.php"><?php echo $this->Html->image('ShinkiTourokuMenu/seihinntouroku.gif',array('width'=>'105','height'=>'36','url'=>array('controller'=>'products','action'=>'index')));?></td>
                    <td style="padding: 0.1rem 0.1rem;"><a href="qr/index.php"><?php echo $this->Html->image('ShinkiTourokuMenu/seihinnkakaku.gif',array('width'=>'105','height'=>'36','url'=>array('controller'=>'price-products','action'=>'index')));?></td>
                    <td style="padding: 0.1rem 0.1rem;"><a href="qr/index.php"><?php echo $this->Html->image('ShinkiTourokuMenu/kenngenntouroku.gif',array('width'=>'105','height'=>'36','url'=>array('controller'=>'roles','action'=>'index')));?></td>
                  </tr>
        </table>
<br>
<hr size="5">

<table style="margin-bottom:0px" width="750" border="0" align="center" cellpadding="0" cellspacing="0" bordercolor="#CCCCCC">
<tr style="background-color: #E6FFFF">
  <td style="padding: 0.1rem 0.1rem;"><a href="qr/index.php"><?php echo $this->Html->image('Labelimg/subTourokuMaterial.gif',array('width'=>'105','height'=>'36','url'=>array('controller'=>'materials','action'=>'form')));?></td>
  <td style="padding: 0.1rem 0.1rem;"><a href="qr/index.php"><?php echo $this->Html->image('Labelimg/subYobidashiMaterial.gif',array('width'=>'105','height'=>'36','url'=>array('controller'=>'materials','action'=>'index')));?></td>
  <td style="padding: 0.1rem 0.1rem;"><a href="qr/index.php"><?php echo $this->Html->image('Labelimg/subTourokuShiire.gif',array('width'=>'105','height'=>'36','url'=>array('controller'=>'suppliers','action'=>'form')));?></td>
</tr>
</table>

<hr size="5">

<table align="center" border="2" bordercolor="#E6FFFF" cellpadding="0" cellspacing="0" style="border-bottom: solid;border-width: 1px">
        <tbody border="2" bordercolor="#E6FFFF" bgcolor="#FFFFCC">
          <td><div align="center"><strong style="font-size: 12pt; color:blue">グレード</strong></div></td>
          <td style="border-left-style: none;"><div align="center"><strong style="font-size: 12pt; color:blue">色番号</strong></div></td>
        <tbody border="2" bordercolor="#E6FFFF" bgcolor="#FFFFCC">
          <td><?= h($this->request->getData('grade')) ?></td>
      		<td style="border-left-style: none;"><?= h($this->request->getData('color')) ?></td>
        <tbody border="2" bordercolor="#E6FFFF" bgcolor="#FFFFCC">
          <td><div align="center"><strong style="font-size: 12pt; color:blue">material_type_id</strong></div></td>
          <td style="border-left-style: none;"><div align="center"><strong style="font-size: 12pt; color:blue">tani</strong></div></td>
        <tbody border="2" bordercolor="#E6FFFF" bgcolor="#FFFFCC">
          <td><?= h($MaterialType) ?></td>
		      <td style="border-left-style: none;"><?= h($this->request->getData('tani')) ?></td>
        <tbody border="2" bordercolor="#E6FFFF" bgcolor="#FFFFCC">
          <td><div align="center"><strong style="font-size: 12pt; color:blue">multiple_sup</strong></div></td>
          <td style="border-left-style: none;"><div align="center"><strong style="font-size: 12pt; color:blue">Status</strong></div></td>
        <tbody border="2" bordercolor="#E6FFFF" bgcolor="#FFFFCC">
          <td><?= h($this->request->getData('multiple_sup')) ?></td>
		      <td style="border-left-style: none;"><?= h($this->request->getData('status')) ?></td>
	</p>
</table>

<br><br>

<table align="center" border="2" bordercolor="#E6FFFF" cellpadding="0" cellspacing="0">
<tr>
  <td style="border-style: none;"><div align="center"><?= $this->Form->submit('戻る', ['onclick' => 'history.back()', 'type' => 'button']); ?></div></td>
  <td style="border-style: none;"><div align="center"><?= $this->Form->submit('追加', array('name' => 'kakunin')); ?></div></td>
</tr>
</table>
<br>
        <?= $this->Form->end() ?>
