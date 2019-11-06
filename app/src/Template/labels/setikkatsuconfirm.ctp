<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\Deliver $priceMaterial
 */
?>
<?= $this->Form->create($labelSetikkatsues, ['url' => ['action' => 'setikkatsupreadd']]) ?>

        <?php
            $today = date("Y-m-d");

            $username = $this->request->Session()->read('Auth.User.username');

            $session = $this->request->getSession();
            $session->write('labelsetikkatsus.product_id1', $_POST['product_id1']);
            $session->write('labelsetikkatsus.product_id2', $_POST['product_id2']);
            $session->write('labelsetikkatsus.tourokubi', $today);
            $session->write('labelsetikkatsus.delete_flag', 0);
        ?>

<hr size="5">
<table style="margin-bottom:0px" width="750" border="0" align="center" cellpadding="0" cellspacing="0" bordercolor="#CCCCCC">
          <tr style="background-color: #E6FFFF">
            <td style="padding: 0.1rem 0.1rem;"><a href="qr/index.php"><?php echo $this->Html->image('Labelimg/label_hakkou.gif',array('width'=>'105','height'=>'36','url'=>array('controller'=>'Labels','action'=>'index')));?></td>
            <td style="padding: 0.1rem 0.1rem;"><a href="qr/index.php"><?php echo $this->Html->image('Labelimg/label_touroku_place.gif',array('width'=>'105','height'=>'36','url'=>array('controller'=>'Labels','action'=>'placeform')));?></td>
          </tr>
</table>
<hr size="5">
<table style="margin-bottom:0px" width="750" border="0" align="center" cellpadding="0" cellspacing="0" bordercolor="#CCCCCC">
          <tr style="background-color: #E6FFFF">
            <td style="padding: 0.1rem 0.1rem;"><a href="qr/index.php"><?php echo $this->Html->image('Labelimg/label_hakkou.gif',array('width'=>'105','height'=>'36','url'=>array('controller'=>'Labels','action'=>'index')));?></td>
            <td style="padding: 0.1rem 0.1rem;"><a href="qr/index.php"><?php echo $this->Html->image('Labelimg/label_touroku_place.gif',array('width'=>'105','height'=>'36','url'=>array('controller'=>'Labels','action'=>'placeform')));?></td>
          </tr>
</table>
<hr size="5">
<br>
<legend align="center"><strong style="font-size: 15pt; color:blue"><?= __('セット取り登録') ?></strong></legend>
<br><br>

    <table align="center" border="2" bordercolor="#E6FFFF" cellpadding="0" cellspacing="0" style="border-bottom: solid;border-width: 1px">
        <tbody border="2" bordercolor="#E6FFFF" bgcolor="#FFFFCC">
            <th scope="row" style="border-bottom: 0px"><?= __('品番１') ?></th>
            <td><?= h($this->request->getData('product_id1')) ?></td>
        </tr>
        <tbody border="2" bordercolor="#E6FFFF" bgcolor="#FFFFCC">
            <th scope="row" style="border-bottom: 0px"><?= __('品番２') ?></th>
            <td><?= h($this->request->getData('product_id2')) ?></td>
        </tr>
    </table>
<br>
<br>
        <p align="center"><?= $this->Form->button('back', ['onclick' => 'history.back()', 'type' => 'button']) ?>
        <?= $this->Form->button(__('add'), array('name' => 'touroku')) ?></p>
        <?= $this->Form->end() ?>