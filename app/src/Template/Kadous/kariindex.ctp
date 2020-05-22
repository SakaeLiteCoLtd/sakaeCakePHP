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
          echo $this->Form->create($KariKadouSeikeis, ['url' => ['action' => 'kariform']]);
?>
<?php
 use App\myClass\Kadous\htmlKadoumenu;//myClassフォルダに配置したクラスを使用
 $htmlKadoumenu = new htmlKadoumenu();
 $htmlKadoumenus = $htmlKadoumenu->Kadoumenus();
 ?>
 <hr size="5" style="margin: 0.5rem">
 <table style="margin-bottom:0px" width="750" border="0" align="center" cellpadding="0" cellspacing="0" bordercolor="#CCCCCC">
 <?php
    echo $htmlKadoumenus;
 ?>
 </table>
 <hr size="5" style="margin: 0.5rem">
<br>
<table align="center" border="2" bordercolor="#E6FFFF" cellpadding="0" cellspacing="0">
  <tbody border="2" bordercolor="#E6FFFF" bgcolor="#FFFFCC">
    <tr>
      <td width="350" colspan="20" nowrap="nowrap"><div align="center"><strong style="font-size: 15pt; color:blue">仮日報呼出</strong></div></td>
      <td rowspan="2" width="150"  style="border-bottom: solid;border-width: 1px"><div align="center"><?= $this->Form->submit(__('日程絞込'), array('name' => 'top')); ?></div></td>
    </tr>
      <td width="250" colspan="20" style="border-bottom: solid;border-width: 1px"><div align="center"><?= $this->Form->input("manu_date", array('type' => 'date', 'monthNames' => false, 'label'=>false)); ?></div></td>
</table>
<br><br><br>
