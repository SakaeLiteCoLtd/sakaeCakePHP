<?php
$this->layout = 'defaultaccount';
?>

<?php
use App\myClass\Shinkimenus\htmlShinkimenu;//myClassフォルダに配置したクラスを使用
?>
<?php
    $htmlShinkimenu = new htmlShinkimenu();
    $htmlaccountmenus = $htmlShinkimenu->accountmenus();
    $htmlyusyouzaimenus = $htmlShinkimenu->yusyouzaimenus();
?>
<hr size="5" style="margin: 0.5rem">
<table style="margin-bottom:0px" width="750" border="0" align="center" cellpadding="0" cellspacing="0" bordercolor="#CCCCCC">
  <?php
       echo $htmlaccountmenus;
  ?>
</table>
<hr size="5" style="margin: 0.5rem">
<table style="margin-bottom:0px" width="750" border="0" align="center" cellpadding="0" cellspacing="0" bordercolor="#CCCCCC">
  <?php
       echo $htmlyusyouzaimenus;
  ?>
</table>
<hr size="5" style="margin: 0.5rem">
<br>
<table style="margin-bottom:0px" width="750" border="0" align="center" cellpadding="0" cellspacing="0" bordercolor="#CCCCCC">
   <tr style="background-color: #E6FFFF">
     <td style="padding: 0.1rem 0.1rem; text-align: center"><?php echo $this->Html->image('Labelimg/accountYusyouzaiMasterKensaku.gif');?></td>
   </tr>
 </table>
<br><br>

  <?= $this->Form->create($user, ['url' => ['action' => 'yusyouzaisyuseido']]) ?>

<table align="center" border="2" bordercolor="#E6FFFF" cellpadding="0" cellspacing="0" style="border-bottom: solid;border-width: 1px">
  <tr>
    <td width="280" bgcolor="#FFFFCC" style="font-size: 8pt;padding: 0.2rem"><strong style="font-size: 11pt; color:blue">品番</strong></td>
    <td width="282" bgcolor="#FFFFCC" style="font-size: 8pt;padding: 0.2rem"><strong style="font-size: 11pt; color:blue">品名</strong></td>
	</tr>
  <tr>
    <td bgcolor="#FFFFCC" style="padding: 0.2rem"><?= h($this->request->getData('product_code')) ?></td>
    <td bgcolor="#FFFFCC" style="padding: 0.2rem"><?= h($this->request->getData('product_name')) ?></td>
	</tr>
</table>
<table align="center" border="2" bordercolor="#E6FFFF" cellpadding="0" cellspacing="0" style="border-bottom: solid;border-width: 1px">
  <tr>
    <td width="562" bgcolor="#FFFFCC" style="font-size: 12pt;padding: 0.2rem"><strong style="font-size: 11pt; color:blue">顧客</strong></td>
	</tr>
  <tr>
    <td bgcolor="#FFFFCC" style="padding: 0.2rem"><?= h($customer_name) ?></td>
	</tr>
</table>
<table align="center" border="2" bordercolor="#E6FFFF" cellpadding="0" cellspacing="0" style="border-bottom: solid;border-width: 1px">
  <tr>
    <td width="280" colspan="2" bgcolor="#FFFFCC" style="font-size: 12pt;padding: 0.2rem"><strong style="font-size: 11pt; color:blue">価格（円/kg）</strong></td>
    <td width="282" bgcolor="#FFFFCC" style="font-size: 12pt;padding: 0.2rem"><strong style="font-size: 11pt; color:blue">種類</strong></td>
	</tr>
  <tr>
    <td width="140" bgcolor="#FFFFCC" style="text-align: right;border-right-style: none;padding: 0.2rem"><?= h($this->request->getData('price')) ?></td>
    <td width="140" bgcolor="#FFFFCC" style="text-align: left;border-left-style: none;padding: 0.2rem"><strong style="font-size: 11pt; color:blue">円/ヶ</strong></td>
    <td bgcolor="#FFFFCC" style="padding: 0.2rem"><?= h($Type) ?></td>
	</tr>
</table>

    </fieldset>
    <br>
    <table align="center" border="2" bordercolor="#E6FFFF" cellpadding="0" cellspacing="0">
    <tr>
      <td style="border-style: none;"><div align="center"><?= $this->Form->submit(__('登録'), array('name' => 'touroku')); ?></div></td>
    </tr>
  </table>
<br>

<?= $this->Form->control('product_code', array('type'=>'hidden', 'value'=>$this->request->getData('product_code'), 'label'=>false)) ?>
<?= $this->Form->control('product_name', array('type'=>'hidden', 'value'=>$this->request->getData('product_name'), 'label'=>false)) ?>
<?= $this->Form->control('customer_code', array('type'=>'hidden', 'value'=>$this->request->getData('customer'), 'label'=>false)) ?>
<?= $this->Form->control('price', array('type'=>'hidden', 'value'=>$this->request->getData('price'), 'label'=>false)) ?>
<?= $this->Form->control('flag_product_material', array('type'=>'hidden', 'value'=>$this->request->getData('flag_product_material'), 'label'=>false)) ?>
<?= $this->Form->control('customer', array('type'=>'hidden', 'value'=>$this->request->getData('customer'), 'label'=>false)) ?>
<?= $this->Form->control('Id', array('type'=>'hidden', 'value'=>$this->request->getData('Id'), 'label'=>false)) ?>
