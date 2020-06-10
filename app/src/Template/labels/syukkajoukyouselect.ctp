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
          echo $this->Form->create($orderEdis, ['url' => ['action' => 'syukkajoukyouichiran']]);
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
 <?php
   $htmlLabelLabelsubmenu = new htmlLabelmenu();
   $htmlLabelgenzaijoukyoumenus = $htmlLabelLabelsubmenu->Labelgenzaijoukyoumenus();
 ?>
   <table style="margin-bottom:0px" width="750" border="0" align="center" cellpadding="0" cellspacing="0" bordercolor="#CCCCCC">
   <?php
      echo $htmlLabelgenzaijoukyoumenus;
   ?>
   </table>

 <br><br>

 <table align="center" border="2" bordercolor="#E6FFFF" cellpadding="0" cellspacing="0">
   <tbody border="2" bordercolor="#E6FFFF" bgcolor="#FFFFCC" style="border-bottom: solid;border-width: 1px">
     <tr style="border-bottom: 0px;border-width: 0px">
       <td width="200" colspan="40" nowrap="nowrap"><div align="center"><strong style="font-size: 13pt; color:blue">納入日</strong></div></td>
     </tr>
     <tr style="border-bottom: 0px;border-width: 0px">
       <td><strong style="font-size: 13pt"><?= h($inputdate) ?></strong></td>
      </tr>
 <table align="center" border="2" bordercolor="#E6FFFF" cellpadding="0" cellspacing="0">

   <br><br>

     <?php for($i=0; $i<count($arrPlace); $i++): ?>
       <table align="center" border="2" bordercolor="#E6FFFF" cellpadding="0" cellspacing="0">
       <tr bgcolor="#E6FFFF" >
         <td align="left" rowspan="2" width="30" bgcolor="#E6FFFF" style="border: none"><div align="left"><?= $this->Form->submit(__($arrPlace[$i]), array('name' => $arrPlacecode[$i], 'value'=>$arrPlacecode[$i])); ?></div></td>
       </tr>
     </table>
   <?php endfor;?>

   <?= $this->Form->control('inputdate', array('type'=>'hidden', 'value'=>$inputdate, 'label'=>false)) ?>

<br><br><br>
