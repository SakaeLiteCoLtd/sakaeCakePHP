<?php
/**
 * AuthHelper: Authの変数にアクセスできる
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\Deliver $priceMaterial
 */
 use Cake\ORM\TableRegistry;//独立したテーブルを扱う
 $this->LabelElementPlaces = TableRegistry::get('labelElementPlaces');

?>
<?= $this->Form->create($labelTypeProducts, ['url' => ['action' => 'index']]) ?>

<?php
  $username = $this->request->Session()->read('Auth.User.username');
  $session = $this->request->getSession();
  $product_code = $session->read('labellayouts.product_code');
  $place = $session->read('labellayouts.place_code');
  $unit = $session->read('labellayouts.unit');
  $type = $session->read('labellayouts.type');

  $LabelElementPlace = $this->LabelElementPlaces->find()->where(['place_code' => $place])->toArray();//'id' => $created_staffとなるデータをStaffsテーブルから配列で取得
  $LabelPlace = $LabelElementPlace[0]->place1." ".$LabelElementPlace[0]->place2;//配列の0番目（0番目しかない）のf_nameとl_nameをつなげたものに$CreatedStaffと名前を付ける

?>
<hr size="5">
              <p align="center"><?php echo $this->Html->image('ShinkiTourokuMenu/touroku.gif',array('width'=>'157','height'=>'50'));?></p>
<hr size="5">



<legend align="center"><font color="red"><?= __('＊下記のように登録されました。') ?></font></legend>
    <table align="center" border="2" bordercolor="#E6FFFF" cellpadding="0" cellspacing="0" style="border-bottom: solid;border-width: 1px">
        <tbody border="2" bordercolor="#E6FFFF" bgcolor="#FFFFCC">
            <th scope="row"><?= __('品番') ?></th>
            <td><?= h($product_code) ?></td>
        </tr>
        <tbody border="2" bordercolor="#E6FFFF" bgcolor="#FFFFCC">
            <th scope="row"><?= __('納入先') ?></th>
            <td><?= h($LabelPlace) ?></td>
        </tr>
        <tbody border="2" bordercolor="#E6FFFF" bgcolor="#FFFFCC">
            <th scope="row"><?= __('梱包単位') ?></th>
            <td><?= h($unit) ?></td>
        </tr>
        <tbody border="2" bordercolor="#E6FFFF" bgcolor="#FFFFCC">
            <th scope="row"><?= __('ラベルタイプ') ?></th>
            <td><?= h($type) ?></td>
        </tr>
        <tbody border="2" bordercolor="#E6FFFF" bgcolor="#FFEFD5">
            <th scope="row"><?= __('登録日時') ?></th>
            <td><?= h($labelTypeProducts->created_at) ?></td>
        </tr>
        <tbody border="2" bordercolor="#E6FFFF" bgcolor="#FFEFD5">
            <th scope="row"><?= __('登録者') ?></th>
            <td><?= h($CreatedStaff) ?></td>
    </table>
<br>
<br>
        <p align="center"><?= $this->Form->button(__('top'), array('name' => 'top')) ?></p>
        <?= $this->Form->end() ?>
