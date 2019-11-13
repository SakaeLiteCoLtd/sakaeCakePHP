<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\Staff[]|\Cake\Collection\CollectionInterface $staffs
 */
?>
        <?php
          $username = $this->request->Session()->read('Auth.User.username');

          header('Expires:-1');
          header('Cache-Control:');
          header('Pragma:');
          echo $this->Form->create($checkLots, ['url' => ['action' => 'torikomipreadd']]);
?>
<br>
<table style="margin-bottom:0px" width="750" border="0" align="center" cellpadding="0" cellspacing="0" bordercolor="#CCCCCC">
            <tr style="background-color: #E6FFFF">
              <td style="padding: 0.1rem 0.1rem; text-align: center"><a href="qr/index.php"><?php echo $this->Html->image('ShinkiTourokuMenu/kensahyou_yobidashi.gif',array('width'=>'105','height'=>'36','url'=>array('controller'=>'KensahyouSokuteidatas','action'=>'yobidasi1')));?></td>
              <td style="padding: 0.1rem 0.1rem; text-align: center"><a href="qr/index.php"><?php echo $this->Html->image('ShinkiTourokuMenu/kensa_jyunbi_insatsu.gif',array('width'=>'105','height'=>'36','url'=>array('controller'=>'KensahyouSokuteidatas','action'=>'yobidasi2')));?></td>
              <td style="padding: 0.1rem 0.1rem; text-align: center"><a href="qr/index.php"><?php echo $this->Html->image('ShinkiTourokuMenu/analyze_dist.gif',array('width'=>'105','height'=>'36','url'=>array('controller'=>'KensahyouSokuteidatas','action'=>'yobidasi3')));?></td>
            </tr>
</table>
<br>
<br>
<table align="center" border="2" bordercolor="#E6FFFF" cellpadding="0" cellspacing="0">
  <tbody border="2" bordercolor="#E6FFFF" bgcolor="#FFFFCC">
    <tr>
      <td width="200" colspan="20" style="border-bottom: solid;border-width: 1px"><div align="center"><strong>読み込みファイル</strong></div></td>
      <td width="300" colspan="20" style="border-bottom: solid;border-width: 1px"><div align="center"><?= $this->Form->input('file', array('type' => 'file', 'label'=>false)); ?></div></td>
    </tr>
</table>
<br>

<p align="center"><?= $this->Form->button(__('確認'), array('name' => 'do')) ?></p>
