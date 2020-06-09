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

<?=$this->Form->create($checkLots, ['url' => ['action' => 'genzaijoukyouichiran']]) ?>
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
      <td width="700" colspan="40" nowrap="nowrap"><div align="center"><strong style="font-size: 15pt; color:blue">完納未納日程絞込み</strong></div></td>
    </tr>


<?php
      $dateYMD = date('Y-m-d');
      $dateYMD1 = strtotime($dateYMD);
      $dayye = date('Y-m-d', strtotime('-1 day', $dateYMD1));


    //  echo "<td width='350' colspan='37' style='border-bottom: 0px'><div align='center'>\n";
    //  echo "<input type='date' value=$dayye name=date_sta empty=Please select size='6'/>\n";
    //  echo "</div></td>\n";

    ?>
    <td width="300" colspan="20" style="border-right-style: none;border-bottom: solid;border-width: 1px"><div align="center"><?= $this->Form->input("date_sta", array('type' => 'date', 'value' => $dayye, 'monthNames' => false, 'label'=>false)); ?></div></td>
    <td width="100"  bgcolor="#FFFFCC" style="border-left-style: none;border-right-style: none;border-bottom: solid;border-width: 1px"><strong style="font-size: 13pt; color:blue">～</strong></td>
    <?php

    //  echo "<td colspan='37'><div align='center'>\n";
    //  echo "<input type='date' value=$dateYMD name=date_fin size='6'/>\n";
    //  echo "</div></td>\n";

    ?>
    <td width="300" colspan="20" style="border-left-style: none;border-bottom: solid;border-width: 1px"><div align="center"><?= $this->Form->input("date_fin", array('type' => 'date', 'value' => $dateYMD, 'monthNames' => false, 'label'=>false)); ?></div></td>
    <?php

 ?>
<br>
</table>
<br><br>
<table>
  <tr bgcolor="#E6FFFF" >
    <div align="center"><?= $this->Form->submit(__('日程絞込'), array('name' => 'kensaku')); ?></div>
  </tr>
</table>
<br>
<br>

</fieldset>

<?=$this->Form->end() ?>
