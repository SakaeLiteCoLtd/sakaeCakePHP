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
          echo $this->Form->create($accountUrikakePriceMaterials, ['url' => ['action' => 'gaityuseihindo']]);

?>
<hr size="5" style="margin: 0.5rem">
<table style="margin-bottom:0px" width="750" border="0" align="center" cellpadding="0" cellspacing="0" bordercolor="#CCCCCC">
<?php
   echo $htmlShinkis;
?>
</table>
 <hr size="5" style="margin: 0.5rem">
 <table style="margin-bottom:0px" width="750" border="0" align="center" cellpadding="0" cellspacing="0" bordercolor="#CCCCCC">
 <tr style="background-color: #E6FFFF">
   <td style="padding: 0.1rem 0.1rem;"><a href="qr/index.php"><?php echo $this->Html->image('Labelimg/sub_index_gaityuproduct.gif',array('width'=>'85','height'=>'36','url'=>array('controller'=>'shinkies','action'=>'gaityuseihinproduct')));?></td>
 </tr>
 </table>
 <hr size="5" style="margin: 0.5rem">
<br>
<fieldset>

<table align="center" border="2" bordercolor="#E6FFFF" cellpadding="0" cellspacing="0" style="border-bottom: solid;border-width: 1px">
  <tr>
    <td width="280" bgcolor="#FFFFCC" style="font-size: 8pt;padding: 0.2rem"><strong style="font-size: 11pt; color:blue">品番</strong></td>
    <td width="280" bgcolor="#FFFFCC" style="font-size: 8pt;padding: 0.2rem"><strong style="font-size: 11pt; color:blue">品名</strong></td>
	</tr>
  <tr>
    <td bgcolor="#FFFFCC"><?= h($product_code) ?></td>
    <td bgcolor="#FFFFCC"><?= h($product_name) ?></td>
	</tr>
</table>
<br><br>
<table align="center" border="2" bordercolor="#E6FFFF" cellpadding="0" cellspacing="0" style="border-bottom: solid;border-width: 1px">
  <tr>
    <td width="280" colspan="2" bgcolor="#FFFFCC" style="font-size: 12pt;padding: 0.2rem"><strong style="font-size: 11pt; color:blue">発注単位ユニット（ケ/unit）</strong></td>
    <td width="280" colspan="2" bgcolor="#FFFFCC" style="font-size: 12pt;padding: 0.2rem"><strong style="font-size: 11pt; color:blue">単価（円/kg）</strong></td>
	</tr>
  <tr>
    <td  width="140" bgcolor="#FFFFCC" style="text-align: right;border-right-style: none;padding: 0.2rem"><?= h($this->request->getData('unit')) ?></td>
    <td width="140" bgcolor="#FFFFCC" style="text-align: left;border-left-style: none;padding: 0.2rem"><strong style="font-size: 10pt; color:blue">ケ/unit</strong></td>
    <td width="140" bgcolor="#FFFFCC" style="text-align: right;border-right-style: none;padding: 0.2rem"><?= h($this->request->getData('price')) ?></td>
    <td width="140" bgcolor="#FFFFCC" style="text-align: left;border-left-style: none;padding: 0.2rem"><strong style="font-size: 10pt; color:blue">円/kg</strong></td>
	</tr>
</table>
<table align="center" border="2" bordercolor="#E6FFFF" cellpadding="0" cellspacing="0" style="border-bottom: solid;border-width: 1px">
  <tr>
    <td width="560" bgcolor="#FFFFCC" style="font-size: 12pt;padding: 0.2rem"><strong style="font-size: 11pt; color:blue">出荷先</strong></td>
	</tr>
  <tr>
    <td bgcolor="#FFFFCC" style="padding: 0.2rem"><?= h($product_supplier_name) ?></td>
	</tr>
</table>


    </fieldset>
    <table align="center" border="2" bordercolor="#E6FFFF" cellpadding="0" cellspacing="0">
    <tr>
      <td style="border-style: none;"><div align="center"><?= $this->Form->submit(__('登録'), array('name' => 'kakunin')); ?></div></td>
    </tr>
  </table>

  <?= $this->Form->control('product_code', array('type'=>'hidden', 'value'=>$product_code, 'label'=>false)) ?>
  <?= $this->Form->control('unit', array('type'=>'hidden', 'value'=>($this->request->getData('unit')), 'label'=>false)) ?>
  <?= $this->Form->control('price', array('type'=>'hidden', 'value'=>($this->request->getData('unit')), 'label'=>false)) ?>
  <?= $this->Form->control('product_supplier_id', array('type'=>'hidden', 'value'=>($this->request->getData('product_supplier_id')), 'label'=>false)) ?>

<br>
