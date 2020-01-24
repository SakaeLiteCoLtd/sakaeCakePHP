<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\Deliver $priceMaterial
 */
?>
<?= $this->Form->create($labelInsideouts, ['url' => ['action' => 'insideoutpreadd']]) ?>

        <?php
            $username = $this->request->Session()->read('Auth.User.username');

            $session = $this->request->getSession();
            $session->write('labelinsideouts.product_code', $_POST['product_code']);
            $session->write('labelinsideouts.num_inside', $_POST['num_inside']);
            $session->write('labelinsideouts.delete_flag', 0);
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
            <td colspan="3"><?= h($this->request->getData('product_code')) ?></td>
        </tr>
        <tbody border="2" bordercolor="#E6FFFF" bgcolor="#FFFFCC">
            <th scope="row" style="border-bottom: 0px"><?= __('袋数') ?></th>
            <td colspan="1.5" style="border-right-style: none"><?= h($this->request->getData('num_inside')) ?></td>
            <td colspan="1.5" style="border-left-style: none"><?= __('（袋）') ?></td>
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
