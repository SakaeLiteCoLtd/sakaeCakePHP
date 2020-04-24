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

<?=$this->Form->create($checkLots, ['url' => ['action' => 'fushiyoudo']]) ?>
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
<br><br>
<table style="margin-bottom:0px" width="750" border="0" align="center" cellpadding="0" cellspacing="0" bordercolor="#CCCCCC">
          <tr style="background-color: #E6FFFF">
            <td style="padding: 0.1rem 0.1rem;"><a href="qr/index.php"><?php echo $this->Html->image('Labelimg/label_touroku.gif',array('width'=>'105','height'=>'36','url'=>array('controller'=>'Labels','action'=>'fushiyoupreadd')));?></td>
            <td style="padding: 0.1rem 0.1rem;"><a href="qr/index.php"><?php echo $this->Html->image('Labelimg/label_ichiran.gif',array('width'=>'105','height'=>'36','url'=>array('controller'=>'Labels','action'=>'fushiyouichiranpre')));?></td>
          </tr>
</table>
<br><br><br>
<legend align="center"><strong style="font-size: 15pt; color:blue"><?= __('不使用ロット登録') ?></strong></legend>
<br><br>


<table align="center" border="2" bordercolor="#E6FFFF" cellpadding="0" cellspacing="0" style="border-bottom: solid;border-width: 1px">
  <tr>
    <td bgcolor="#FFFFCC" style="width: 200px"><strong style="font-size: 13pt; color:blue">品番</strong></td>
    <td bgcolor="#FFFFCC" style="width: 200px"><strong style="font-size: 13pt; color:blue">ロットNo．</strong></td>
	</tr>
    <?php
    for($i=0; $i<$maisuu; $i++){//１号機
      echo "<tr><td bgcolor='#FFFFCC' style='width: 200px'>\n";
      echo $product_code;
      echo "</td>\n";
      echo "<td bgcolor='#FFFFCC' style='width: 200px'>\n";
      echo ${"lot_num_".$i};
      echo "</td></tr>\n";
      echo "<input type='hidden' value=$product_code  name=product_code size='6'/>\n";
      echo "<input type='hidden' value=$maisuu  name=maisuu size='6'/>\n";
      echo "<input type='hidden' value=${"lot_num_".$i}  name=lot_num_$i size='6'/>\n";
    }
    ?>

</table>

<br>
<table align="center" border="2" bordercolor="#E6FFFF" cellpadding="0" cellspacing="0">
<tr>
  <td style="border-style: none;"><div align="center"><?= $this->Form->submit(__('登録'), array('name' => 'kakunin')); ?></div></td>
</tr>
</table>

<?=$this->Form->end() ?>
