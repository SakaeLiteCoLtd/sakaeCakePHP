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
       <td width="400" nowrap="nowrap"><div align="center"><strong style="font-size: 13pt; color:blue">納入日</strong></div></td>
       <td width="400" nowrap="nowrap"><div align="center"><strong style="font-size: 13pt; color:blue">納入場所</strong></div></td>
     </tr>
     <tr style="border-bottom: 0px;border-width: 0px">
       <td><strong style="font-size: 13pt"><?= h($inputdate) ?></strong></td>
       <td><strong style="font-size: 13pt"><?= h($place_deliver) ?></strong></td>
      </tr>
 <table align="center" border="2" bordercolor="#E6FFFF" cellpadding="0" cellspacing="0">

   <br><br>

   <?php
      if(isset($arrPlace[0])){
        $num = count($arrPlace);
      }else{
        $num = 0;
      }
   ?>

   <table align="center" border="2" bordercolor="#E6FFFF" cellpadding="0" cellspacing="0">
     <tbody border="2" bordercolor="#E6FFFF" bgcolor="#FFFFCC" style="border-bottom: solid;border-width: 1px">
       <tr style="border-bottom: 0px;border-width: 0px">
         <td width="200" nowrap="nowrap"><div align="center"><strong style="font-size: 13pt; color:blue">品番</strong></div></td>
         <td width="200" nowrap="nowrap"><div align="center"><strong style="font-size: 13pt; color:blue">品名</strong></div></td>
         <td width="200" nowrap="nowrap"><div align="center"><strong style="font-size: 13pt; color:blue">数量</strong></div></td>
         <td width="200" nowrap="nowrap"><div align="center"><strong style="font-size: 13pt; color:blue">ロット数</strong></div></td>
       </tr>
       <tr style="border-bottom: 0px;border-width: 0px">
         <td><strong style="font-size: 13pt"><?= h($product_code) ?></strong></td>
         <td><strong style="font-size: 13pt"><?= h($product_name) ?></strong></td>
         <td><strong style="font-size: 13pt"><?= h($total_amount) ?></strong></td>
         <td><strong style="font-size: 13pt"><?= h($num) ?></strong></td>
        </tr>
   <table align="center" border="2" bordercolor="#E6FFFF" cellpadding="0" cellspacing="0">

     <br><br>

     <table align="center" border="2" bordercolor="#E6FFFF" cellpadding="0" cellspacing="0">
       <tbody border="2" bordercolor="#E6FFFF" bgcolor="#FFFFCC">
                 <tr border="2" bordercolor="#E6FFFF" bgcolor="#FFFFCC">
                   <td width="200" height="30" colspan="20" nowrap="nowrap" style="border-bottom: solid;border-width: 1px"><div align="center"><strong style="font-size: 12pt; color:blue">納入ロット</strong></div></td>
                 </tr>
         </table>

         <br>

   <table align="center" border="2" bordercolor="#E6FFFF" cellpadding="0" cellspacing="0">
     <tbody border="2" bordercolor="#E6FFFF" bgcolor="#FFFFCC" style="border-bottom: solid;border-width: 1px">
           <thead>
               <tr border="2" bordercolor="#E6FFFF" bgcolor="#FFFFCC">
                 <td width="200" height="30" colspan="20" nowrap="nowrap"><div align="center"><strong style="font-size: 12pt; color:blue">ロットNo.</strong></div></td>
                 <td width="200" height="30" colspan="20" nowrap="nowrap"><div align="center"><strong style="font-size: 12pt; color:blue">数量</strong></div></td>
               </tr>
           </thead>
           <tbody border="2" bordercolor="#E6FFFF" bgcolor="#FFFFCC">
               <?php for($i=0; $i<$num; $i++): ?>
               <tr style="border-bottom: solid;border-width: 1px">
                   <td colspan="20" nowrap="nowrap"><?= h($arrPlace[$i]['lot_num']) ?></td>
                   <td colspan="20" nowrap="nowrap"><?= h($arrPlace[$i]['amount']) ?></td>
               </tr>
             <?php endfor;?>
           </tbody>
       </table>


<br><br><br>
