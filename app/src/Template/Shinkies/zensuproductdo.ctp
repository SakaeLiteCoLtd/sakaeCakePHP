<?php
$this->layout = 'defaultshinki';
?>
<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\Deliver $product
 */
 use App\myClass\Shinkimenus\htmlShinkimenu;//myClassフォルダに配置したクラスを使用

 $htmlShinkimenu = new htmlShinkimenu();
 $htmlShinkis = $htmlShinkimenu->Shinkimenus();
?>
        <?php
          $username = $this->request->Session()->read('Auth.User.username');

          header('Expires:-1');
          header('Cache-Control:');
          header('Pragma:');
          echo $this->Form->create($user, ['url' => ['action' => 'menu']]);

?>

<hr size="5" style="margin: 0.5rem">
<table style="margin-bottom:0px" width="750" border="0" align="center" cellpadding="0" cellspacing="0" bordercolor="#CCCCCC">
<?php
   echo $htmlShinkis;
?>
</table>
<hr size="5" style="margin: 0.5rem">
<br>
<legend align="center"><strong style="font-size: 13pt; color:blue"><?= __("全数製品変更") ?></strong></legend>
<br>
<br>
<legend align="center"><strong style="font-size: 13pt; color:blue"><?= __($mess) ?></strong></legend>
<br>

<table align="center" border="2" bordercolor="#E6FFFF" cellpadding="0" cellspacing="0">
  <tbody border="2" bordercolor="#E6FFFF" bgcolor="#FFFFCC" style="border-bottom: solid;border-width: 1px">

    <?php
    echo "<tr style='border-bottom: 0px;border-width: 0px'>\n";
    ?>
    <td  width="300" bgcolor="#FFFFCC"><strong style="font-size: 13pt"><?= h("品番：".$this->request->getData('product_code')) ?></strong></td>
    <?php
    echo "</tr>\n";
    echo "<tr style='border-bottom: 0px;border-width: 0px'>\n";
    ?>
    <td  width="300" bgcolor="#FFFFCC"><strong style="font-size: 13pt; color:red"><?= h($mes) ?></strong></td>
    <?php
    echo "</tr>\n";
    ?>

<table align="center" border="2" bordercolor="#E6FFFF" cellpadding="0" cellspacing="0">
  <br>

<tr bgcolor="#E6FFFF" >
  <td align="center" rowspan="2" width="30" bgcolor="#E6FFFF" style="border: none"><div align="center"><?= $this->Form->submit(__('TOP'), array('name' => 'confirm', 'value'=>"1")); ?></div></td>
</tr>
</table>

<?= $this->Form->control('product_code', array('type'=>'hidden', 'value'=>$this->request->getData('product_code'), 'label'=>false)) ?>

<br><br><br>
