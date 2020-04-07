<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\Staff[]|\Cake\Collection\CollectionInterface $staffs
 */
use Cake\ORM\TableRegistry;//独立したテーブルを扱う

//$this->KariKadouSeikeis = TableRegistry::get('kariKadouSeikeis');
$this->Products = TableRegistry::get('products');//productsテーブルを使う
?>
        <?php
          $username = $this->request->Session()->read('Auth.User.username');

          header('Expires:-1');
          header('Cache-Control:');
          header('Pragma:');
          echo $this->Form->create($scheduleKouteis, ['url' => ['action' => 'form']]);
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
<table style="margin-bottom:0px" width="750" border="0" align="center" cellpadding="0" cellspacing="0" bordercolor="#CCCCCC">
            <tr style="background-color: #E6FFFF">
              <td style="padding: 0.1rem 0.1rem; text-align: center"><a href="qr/index.php"><?php echo $this->Html->image('ShinkiTourokuMenu/kensahyou_yobidashi.gif',array('width'=>'105','height'=>'36','url'=>array('controller'=>'KensahyouSokuteidatas','action'=>'yobidasi1')));?></td>
              <td style="padding: 0.1rem 0.1rem; text-align: center"><a href="qr/index.php"><?php echo $this->Html->image('ShinkiTourokuMenu/kensa_jyunbi_insatsu.gif',array('width'=>'105','height'=>'36','url'=>array('controller'=>'KensahyouSokuteidatas','action'=>'yobidasi2')));?></td>
              <td style="padding: 0.1rem 0.1rem; text-align: center"><a href="qr/index.php"><?php echo $this->Html->image('ShinkiTourokuMenu/analyze_dist.gif',array('width'=>'105','height'=>'36','url'=>array('controller'=>'KensahyouSokuteidatas','action'=>'yobidasi3')));?></td>
            </tr>
</table>
<br><br>
<table align="center" border="2" bordercolor="#E6FFFF" cellpadding="0" cellspacing="0">
  <tbody border="2" bordercolor="#E6FFFF" bgcolor="#FFFFCC">
    <tr>
      <td width="350" colspan="20" nowrap="nowrap"><div align="center"><strong style="font-size: 13pt; color:blue">納入日指定</strong></div></td>
      <td rowspan="2" width="150"  style="border-bottom: solid;border-width: 1px"><div align="center"><?= $this->Form->submit(__('呼出'), array('name' => 'top')); ?></div></td>
    </tr>
      <td width="250" colspan="20" style="border-bottom: solid;border-width: 1px"><div align="center"><?= $this->Form->input("manu_date", array('type' => 'date', 'monthNames' => false, 'label'=>false)); ?></div></td>
</table>
<br><br>
