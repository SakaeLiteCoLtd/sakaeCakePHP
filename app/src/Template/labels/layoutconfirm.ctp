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

            if($this->request->getData('unit') == 0){
          	$unit = '印字なし';
          	} else {
          	$unit = 'セット';
          	}

        ?>
        <?php
         use App\myClass\Labelmenus\htmlLabelmenu;//myClassフォルダに配置したクラスを使用
         $htmlLabelmenu = new htmlLabelmenu();
         $htmlLabels = $htmlLabelmenu->Labelmenus();
         ?>
         <hr size="5" style="margin: 0.5rem">
         <table style="margin-bottom:0px" width="750" border="0" align="center" cellpadding="0" cellspacing="0" bordercolor="#CCCCCC">
         <?php
            echo $htmlLabels;
         ?>
         </table>
         <hr size="5" style="margin: 0.5rem">
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
            <td><?= h($unit) ?></td>
        </tr>
        <tbody border="2" bordercolor="#E6FFFF" bgcolor="#FFFFCC">
            <th scope="row" style="border-bottom: 0px"><?= __('ラベルタイプ') ?></th>
            <td><?= h($this->request->getData('type')) ?></td>
        </tr>
    </table>
<br><br>
<table align="center" border="2" bordercolor="#E6FFFF" cellpadding="0" cellspacing="0">
<tr>
  <td style="border-style: none;"><div align="center"><?= $this->Form->submit('戻る', ['onclick' => 'history.back()', 'type' => 'button']); ?></div></td>
  <td style="border-style: none;"><div align="center"><?= $this->Form->submit('追加', array('name' => 'touroku')); ?></div></td>
</tr>
</table>
        <?= $this->Form->end() ?>
