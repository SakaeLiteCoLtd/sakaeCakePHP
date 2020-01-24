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
<table align="center" border="2" bordercolor="#E6FFFF" cellpadding="0" cellspacing="0">
<tr>
  <td style="border-style: none;"><div align="center"><?= $this->Form->submit('戻る', ['onclick' => 'history.back()', 'type' => 'button']); ?></div></td>
  <td style="border-style: none;"><div align="center"><?= $this->Form->submit('追加', array('name' => 'touroku')); ?></div></td>
</tr>
</table>
<br>
        <?= $this->Form->end() ?>
