<?php
/**
 * AuthHelper: Authの変数にアクセスできる
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\Material $material
 */
?>
<?= $this->Form->create($material, ['url' => ['action' => 'index']]) ?>

<?php
  $username = $this->request->Session()->read('Auth.User.username');
  $session = $this->request->getSession();
  $grade = $session->read('materialdata.grade');
  $color = $session->read('materialdata.color');
  $tani = $session->read('materialdata.tani');
  $multiple_sup = $session->read('materialdata.multiple_sup');
  $status = $session->read('materialdata.status');
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

<legend align="center"><font color="red"><?= __($mes) ?></font></legend>
<table align="center" border="2" bordercolor="#E6FFFF" cellpadding="0" cellspacing="0" style="border-bottom: solid;border-width: 1px">
        <tbody border="2" bordercolor="#E6FFFF" bgcolor="#FFFFCC">
          <td><div align="center"><strong style="font-size: 12pt; color:blue">グレード</strong></div></td>
          <td style="border-left-style: none;"><div align="center"><strong style="font-size: 12pt; color:blue">色番号</strong></div></td>
        <tbody border="2" bordercolor="#E6FFFF" bgcolor="#FFFFCC">
          <td><?= h($grade) ?></td>
      		<td style="border-left-style: none;"><?= h($color) ?></td>
        <tbody border="2" bordercolor="#E6FFFF" bgcolor="#FFFFCC">
          <td><div align="center"><strong style="font-size: 12pt; color:blue">material_type_id</strong></div></td>
          <td style="border-left-style: none;"><div align="center"><strong style="font-size: 12pt; color:blue">tani</strong></div></td>
        <tbody border="2" bordercolor="#E6FFFF" bgcolor="#FFFFCC">
          <td><?= h($MaterialType) ?></td>
		      <td style="border-left-style: none;"><?= h($tani) ?></td>
        <tbody border="2" bordercolor="#E6FFFF" bgcolor="#FFFFCC">
          <td><div align="center"><strong style="font-size: 12pt; color:blue">multiple_sup</strong></div></td>
          <td style="border-left-style: none;"><div align="center"><strong style="font-size: 12pt; color:blue">Status</strong></div></td>
        <tbody border="2" bordercolor="#E6FFFF" bgcolor="#FFFFCC">
          <td><?= h($multiple_sup) ?></td>
		      <td style="border-left-style: none;"><?= h($status) ?></td>
          <tbody border="2" bordercolor="#E6FFFF" bgcolor="#FFFFCC">
            <td><div align="center"><strong style="font-size: 12pt; color:blue">登録日時</strong></div></td>
            <td style="border-left-style: none;"><div align="center"><strong style="font-size: 12pt; color:blue">登録者</strong></div></td>
          <tbody border="2" bordercolor="#E6FFFF" bgcolor="#FFFFCC">
            <td><?= h($material->created_at) ?></td>
  		      <td style="border-left-style: none;"><?= h($CreatedStaff) ?></td>
	</p>
</table>

<br>
<br>
        <?= $this->Form->end() ?>
