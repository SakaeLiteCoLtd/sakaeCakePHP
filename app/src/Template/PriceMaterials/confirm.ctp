<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\Deliver $priceMaterial
 */
 use App\myClass\Shinkimenus\htmlShinkimenu;//myClassフォルダに配置したクラスを使用

 $htmlShinkimenu = new htmlShinkimenu();
 $htmlShinkis = $htmlShinkimenu->Shinkimenus();
 ?>
<?= $this->Form->create($priceMaterial, ['url' => ['action' => 'preadd']]) ?>
        <?php
            $username = $this->request->Session()->read('Auth.User.username');

            $startY = $_POST['start']['year'];
            $startM = $_POST['start']['month'];
            $startD = $_POST['start']['day'];
            $startYMD = array($startY,$startM,$startD);
            $start = implode("-",$startYMD);

            if($priceMaterial->finish == null){
            $finish = '';
            }else {
            $finishY = $_POST['finish']['year'];
            $finishM = $_POST['finish']['month'];
            $finishD = $_POST['finish']['day'];
            $finishYMD = array($finishY,$finishM,$finishD);
            $finish = implode("-",$finishYMD);
            }
/*
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
*/
            $session = $this->request->getSession();
            $session->write('priceMaterialdata.material_id', $_POST['material_id']);
            $session->write('priceMaterialdata.supplier_id', $_POST['supplier_id']);
            $session->write('priceMaterialdata.lot_low', $_POST['lot_low']);
            $session->write('priceMaterialdata.lot_upper', $_POST['lot_upper']);
            $session->write('priceMaterialdata.price', $_POST['price']);
            $session->write('priceMaterialdata.start', $start);
            $session->write('priceMaterialdata.finish', $finish);
            $session->write('priceMaterialdata.status', $_POST['status']);
            $session->write('priceMaterialdata.delete_flag', $_POST['delete_flag']);
            $session->write('priceMaterialdata.created_staff', $_POST['created_staff']);
            $session->write('priceMaterialdata.updated_staff', null);
        ?>
        <hr size="5">
        <table style="margin-bottom:0px" width="750" border="0" align="center" cellpadding="0" cellspacing="0" bordercolor="#CCCCCC">
        <?php
           echo $htmlShinkis;
        ?>
        </table>
        <hr size="5">

              <p align="center"><?php echo $this->Html->image('ShinkiTourokuMenu/touroku.gif',array('width'=>'157','height'=>'50'));?></p>

<hr size="5">

    <table align="center" border="2" bordercolor="#E6FFFF" cellpadding="0" cellspacing="0" style="border-bottom: solid;border-width: 1px">
        <tbody border="2" bordercolor="#E6FFFF" bgcolor="#FFFFCC">
            <th scope="row"><?= __('material_id') ?></th>
            <td><?= h($materialgrade2) ?></td>
        </tr>
        <tbody border="2" bordercolor="#E6FFFF" bgcolor="#FFFFCC">
            <th scope="row"><?= __('supplier_id') ?></th>
            <td><?= h($Supplier) ?></td>
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
<table align="center" border="2" bordercolor="#E6FFFF" cellpadding="0" cellspacing="0">
<tr>
  <td style="border-style: none;"><div align="center"><?= $this->Form->submit('戻る', ['onclick' => 'history.back()', 'type' => 'button']); ?></div></td>
  <td style="border-style: none;"><div align="center"><?= $this->Form->submit('追加', array('name' => 'kakunin')); ?></div></td>
</tr>
</table>
<br>
<?= $this->Form->end() ?>
