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
             <td style="padding: 0.1rem 0.1rem;"><a href="qr/index.php"><?php echo $this->Html->image('Labelimg/label_touroku.gif',array('width'=>'85','height'=>'30','url'=>array('controller'=>'Labels','action'=>'fushiyoupreadd')));?></td>
             <td style="padding: 0.1rem 0.1rem;"><a href="qr/index.php"><?php echo $this->Html->image('Labelimg/label_ichiran.gif',array('width'=>'85','height'=>'30','url'=>array('controller'=>'Labels','action'=>'fushiyouichiranpre')));?></td>
           </tr>
 </table>


 <br><br><br><br><br>

<?=$this->Form->end() ?>
