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
          echo $this->Form->create($orderEdis, ['url' => ['action' => 'syukkajoukyousyousai']]);
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
       <td width="200" nowrap="nowrap"><div align="center"><strong style="font-size: 13pt; color:blue">納入日</strong></div></td>
       <td width="200" nowrap="nowrap"><div align="center"><strong style="font-size: 13pt; color:blue">納入場所</strong></div></td>
     </tr>
     <tr style="border-bottom: 0px;border-width: 0px">
       <td><strong style="font-size: 13pt"><?= h($inputdate) ?></strong></td>
       <td><strong style="font-size: 13pt"><?= h($place_deliver) ?></strong></td>
      </tr>
 <table align="center" border="2" bordercolor="#E6FFFF" cellpadding="0" cellspacing="0">

   <br><br>

   <table align="center" border="2" bordercolor="#E6FFFF" cellpadding="0" cellspacing="0">
     <tbody border="2" bordercolor="#E6FFFF" bgcolor="#FFFFCC" style="border-bottom: solid;border-width: 1px">
           <thead>
               <tr border="2" bordercolor="#E6FFFF" bgcolor="#FFFFCC">
                 <td width="200" height="30" colspan="20" nowrap="nowrap"><div align="center"><strong style="font-size: 12pt; color:blue">品番</strong></div></td>
                 <td width="200" height="30" colspan="20" nowrap="nowrap"><div align="center"><strong style="font-size: 12pt; color:blue">品名</strong></div></td>
                 <td width="200" height="30" colspan="20" nowrap="nowrap"><div align="center"><strong style="font-size: 12pt; color:blue">出荷予定数量</strong></div></td>
                 <td width="200" height="30" colspan="20" nowrap="nowrap"><div align="center"><strong style="font-size: 12pt; color:blue">チェック済数量</strong></div></td>
                 <td width="100" height="30" colspan="20" nowrap="nowrap"><div align="center"><strong style="font-size: 12pt; color:blue">ロット</strong></div></td>
               </tr>
           </thead>
           <tbody border="2" bordercolor="#E6FFFF" bgcolor="#FFFFCC">
               <?php for($i=0; $i<count($arrPro); $i++): ?>
               <tr style="border-bottom: solid;border-width: 1px">
                   <td colspan="20" nowrap="nowrap"><?= h(${"product_code".$i}) ?></td>
                   <td colspan="20" nowrap="nowrap"><?= h(${"product_name".$i}) ?></td>
                   <td colspan="20" nowrap="nowrap"><?= h(${"total_amount".$i}) ?></td>
                   <td colspan="20" nowrap="nowrap"><?= h(${"check_amount".$i}) ?></td>
                   <td colspan="20" nowrap="nowrap"><div><?= $this->Form->submit(__("ロット"), array('name' => ${"product_code".$i}."_".${"total_amount".$i})); ?></div></td>
               </tr>
           <?php endfor;?>
           </tbody>
       </table>

       <?= $this->Form->control('inputdate', array('type'=>'hidden', 'value'=>$inputdate, 'label'=>false)) ?>
       <?= $this->Form->control('place_deliver', array('type'=>'hidden', 'value'=>$place_deliver, 'label'=>false)) ?>

<br><br><br>
