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
?>

<?=$this->Form->create($checkLots, ['url' => ['action' => 'kensakuview']]) ?>
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
   $htmlLabelLabelsubmenu = new htmlLabelmenu();
   $htmlLabelgenzaijoukyoumenus = $htmlLabelLabelsubmenu->Labelgenzaijoukyoumenus();
 ?>
 <br>
   <table style="margin-bottom:0px" width="750" border="0" align="center" cellpadding="0" cellspacing="0" bordercolor="#CCCCCC">
   <?php
      echo $htmlLabelgenzaijoukyoumenus;
   ?>
   </table>

 <br><br>

<table align="center" border="2" bordercolor="#E6FFFF" cellpadding="0" cellspacing="0">
  <tbody border="2" bordercolor="#E6FFFF" bgcolor="#FFFFCC" style="border-bottom: solid;border-width: 1px">
    <tr style="border-bottom: 0px;border-width: 0px">
      <td width="150" height="40" nowrap="nowrap"><div align="center"><strong style="font-size: 15pt; color:blue">日付</strong></div></td>
      <td width="400" height="40" nowrap="nowrap"><div align="center"><strong style="font-size: 13pt; color:blue">完納</strong></div></td>
      <td width="400" nowrap="nowrap"><div align="center"><strong style="font-size: 15pt; color:blue">未納</strong></div></td>
    </tr>

    <?php for($i=0; $i<=$dif_days; $i++): ?>
    <tr style="border-bottom: solid;border-width: 1px">
        <td><?= h(${"date".$i}) ?></td>
        <td><?= h(${"arrPlaceDelivers_kannou_hyouji".$i}) ?></td>
        <td><?= h(${"arrPlaceDelivers_minou_hyouji".$i}) ?></td>
    </tr>
  <?php endfor;?>

</table>
</fieldset>
<br><br>

<?=$this->Form->end() ?>
