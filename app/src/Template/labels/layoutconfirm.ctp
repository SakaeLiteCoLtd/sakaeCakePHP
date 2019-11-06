<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\Deliver $priceMaterial
 */
 use Cake\ORM\TableRegistry;//独立したテーブルを扱う
 $this->LabelElementPlaces = TableRegistry::get('labelElementPlaces');

?>
<?= $this->Form->create($labelTypeProducts, ['url' => ['action' => 'layoutpreadd']]) ?>

        <?php
            $username = $this->request->Session()->read('Auth.User.username');

            $session = $this->request->getSession();
            $session->write('labellayouts.product_code', $_POST['product_code']);
            $session->write('labellayouts.place_code', $_POST['place']);
            $session->write('labellayouts.unit', $_POST['unit']);
            $session->write('labellayouts.type', $_POST['type']);
            $session->write('labellayouts.delete_flag', 0);

            $LabelElementPlace = $this->LabelElementPlaces->find()->where(['place_code' => $_POST['place']])->toArray();//'id' => $created_staffとなるデータをStaffsテーブルから配列で取得
            $LabelPlace = $LabelElementPlace[0]->place1." ".$LabelElementPlace[0]->place2;//配列の0番目（0番目しかない）のf_nameとl_nameをつなげたものに$CreatedStaffと名前を付ける
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
<legend align="center"><strong style="font-size: 15pt; color:blue"><?= __('ラベル納品場所登録') ?></strong></legend>
<br><br>

    <table align="center" border="2" bordercolor="#E6FFFF" cellpadding="0" cellspacing="0" style="border-bottom: solid;border-width: 1px">
        <tbody border="2" bordercolor="#E6FFFF" bgcolor="#FFFFCC">
            <th scope="row" style="border-bottom: 0px"><?= __('品番') ?></th>
            <td><?= h($this->request->getData('product_code')) ?></td>
        </tr>
        <tbody border="2" bordercolor="#E6FFFF" bgcolor="#FFFFCC">
            <th scope="row" style="border-bottom: 0px"><?= __('納入先') ?></th>
            <td><?= h($LabelPlace) ?></td>
        </tr>
        <tbody border="2" bordercolor="#E6FFFF" bgcolor="#FFFFCC">
            <th scope="row" style="border-bottom: 0px"><?= __('梱包単位') ?></th>
            <td><?= h($this->request->getData('unit')) ?></td>
        </tr>
        <tbody border="2" bordercolor="#E6FFFF" bgcolor="#FFFFCC">
            <th scope="row" style="border-bottom: 0px"><?= __('ラベルタイプ') ?></th>
            <td><?= h($this->request->getData('type')) ?></td>
        </tr>
    </table>
<br>
<br>
        <p align="center"><?= $this->Form->button('back', ['onclick' => 'history.back()', 'type' => 'button']) ?>
        <?= $this->Form->button(__('add'), array('name' => 'touroku')) ?></p>
        <?= $this->Form->end() ?>
