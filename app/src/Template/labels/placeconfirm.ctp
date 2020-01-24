<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\Deliver $priceMaterial
 */
?>
<?= $this->Form->create($labelElementPlaces, ['url' => ['action' => 'placepreadd']]) ?>
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

        <?php
            $username = $this->request->Session()->read('Auth.User.username');

            $session = $this->request->getSession();
            $session->write('labelplaces.place_code', $place_code);
            $session->write('labelplaces.place1', $_POST['place1']);
            $session->write('labelplaces.place2', $_POST['place2']);
            $session->write('labelplaces.genjyou', 0);
            $session->write('labelplaces.delete_flag', 0);

            $session = $this->request->getSession();
            $data = $session->read();
        ?>

<br>
<legend align="center"><strong style="font-size: 15pt; color:blue"><?= __('ラベル納品場所登録') ?></strong></legend>
<br><br>

    <table align="center" border="2" bordercolor="#E6FFFF" cellpadding="0" cellspacing="0" style="border-bottom: solid;border-width: 1px">
        <tbody border="2" bordercolor="#E6FFFF" bgcolor="#FFFFCC">
            <th scope="row" style="border-bottom: 0px"><?= __('納品場所１') ?></th>
            <td><?= h($this->request->getData('place1')) ?></td>
        </tr>
        <tbody border="2" bordercolor="#E6FFFF" bgcolor="#FFFFCC">
            <th scope="row" style="border-bottom: 0px"><?= __('納品場所２') ?></th>
            <td><?= h($this->request->getData('place2')) ?></td>
        </tr>
    </table>
<br>
<br>
<table align="center" border="2" bordercolor="#E6FFFF" cellpadding="0" cellspacing="0">
<tr>
  <td style="border-style: none;"><div align="center"><?= $this->Form->submit('戻る', ['onclick' => 'history.back()', 'type' => 'button']); ?></div></td>
  <td style="border-style: none;"><div align="center"><?= $this->Form->submit('追加', array('name' => 'touroku')); ?></div></td>
</tr>
</table>
        <?= $this->Form->end() ?>
