<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\Staff[]|\Cake\Collection\CollectionInterface $staffs
 */
use Cake\ORM\TableRegistry;//独立したテーブルを扱う

$this->Products = TableRegistry::get('products');//productsテーブルを使う
?>
        <?php
          $username = $this->request->Session()->read('Auth.User.username');

          header('Expires:-1');
          header('Cache-Control:');
          header('Pragma:');
          echo $this->Form->create($StockProducts, ['url' => ['action' => 'preadd']]);
?>
<?php
 use App\myClass\EDImenus\htmlEDImenu;//myClassフォルダに配置したクラスを使用
 $htmlEDImenu = new htmlEDImenu();
 $htmlEDIs = $htmlEDImenu->EDImenus();
 ?>
 <hr size="5" style="margin: 0.5rem">
 <table style="margin-bottom:0px" width="750" border="0" align="center" cellpadding="0" cellspacing="0" bordercolor="#CCCCCC">
 <?php
    echo $htmlEDIs;
 ?>
 </table>
 <hr size="5" style="margin: 0.5rem">
 <br>

 <br>
<table style="margin-bottom:0px" width="750" border="0" align="center" cellpadding="0" cellspacing="0" bordercolor="#CCCCCC">
            <tr style="background-color: #E6FFFF">
              <td style="padding: 0.1rem 0.1rem;"><a href="qr/index.php"><?php echo $this->Html->image('Labelimg/button_pana.gif',array('width'=>'85','height'=>'36','url'=>array('action'=>'yobidashipana')));?></td>
              <td style="padding: 0.1rem 0.1rem;"><a href="qr/index.php"><?php echo $this->Html->image('Labelimg/button_dnp.gif',array('width'=>'85','height'=>'36','url'=>array('action'=>'yobidashidnp')));?></td>
              <td style="padding: 0.1rem 0.1rem;"><a href="qr/index.php"><?php echo $this->Html->image('Labelimg/button_others.gif',array('width'=>'85','height'=>'36','url'=>array('action'=>'yobidashiothers')));?></td>
            </tr>
</table>

<br><br>
 <legend align="center"><font color="red"><?= __("入力内容確認") ?></font></legend>
<br>
<table align="center" border="2" bordercolor="#E6FFFF" cellpadding="0" cellspacing="0">
  <tbody border="2" bordercolor="#E6FFFF" bgcolor="#FFFFCC" style="border-bottom: solid;border-width: 1px">
        <thead>
            <tr border="2" bordercolor="#E6FFFF" bgcolor="#FFFFCC">
              <td width="50" height="20" colspan="20" nowrap="nowrap"><div align="center"><strong style="font-size: 10pt; color:blue">NO.</strong></div></td>
              <td width="150" height="20" colspan="20" nowrap="nowrap"><div align="center"><strong style="font-size: 10pt; color:blue">品番</strong></div></td>
              <td width="100" height="20" colspan="20" nowrap="nowrap"><div align="center"><strong style="font-size: 10pt; color:blue">品名</strong></div></td>
              <td width="100" height="20" colspan="20" nowrap="nowrap"><div align="center"><strong style="font-size: 10pt; color:blue">在庫数</strong></div></td>
              <td width="100" height="20" colspan="20" nowrap="nowrap"><div align="center"><strong style="font-size: 10pt; color:blue">棚卸日</strong></div></td>
            </tr>
        </thead>
        <tbody border="2" bordercolor="#E6FFFF" bgcolor="#FFFFCC">
          <?php for($i=0; $i<count($tourokustock); $i++): ?>

            <?php
              $product_code = $tourokustock[$i]['product_code'];
              $Product = $this->Products->find()->where(['product_code' => $product_code])->toArray();
              if(isset($Product[0])){
                $product_name = $Product[0]->product_name;
              }else{
                $product_name = "";
              }
            ?>

          <tr style="border-bottom: solid;border-width: 1px">
            <td colspan="20" nowrap="nowrap"><?= h($i+1) ?></td>
            <td colspan="20" nowrap="nowrap"><?= h($tourokustock[$i]["product_code"]) ?></td>
            <td colspan="20" nowrap="nowrap"><?= h($product_name) ?></td>
            <td colspan="20" nowrap="nowrap"><?= h($tourokustock[$i]["amount"]) ?></td>
            <td colspan="20" nowrap="nowrap"><?= h($tourokustock[$i]["date_stock"]) ?></td>
          </tr>
        <?php endfor;?>
        </tbody>
    </table>
<br>
<table align="center" border="2" bordercolor="#E6FFFF" cellpadding="0" cellspacing="0">
<tr>
  <td style="border-style: none;"><div align="center"><?= $this->Form->submit('戻る', ['onclick' => 'history.back()', 'type' => 'button']); ?></div></td>
  <td style="border-style: none;"><div align="center"><?= $this->Form->submit(__('登録'), array('name' => 'kakunin')); ?></div></td>
</tr>
</table>
<br>
