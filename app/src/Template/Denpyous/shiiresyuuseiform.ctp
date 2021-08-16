<?php
/**
 * AuthHelper: Authの変数にアクセスできる
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\Customer $customer
 */
use App\myClass\Shinkimenus\htmlShinkimenu;//myClassフォルダに配置したクラスを使用
?>
        <?php
            $username = $this->request->Session()->read('Auth.User.username');

            $htmlShinkimenu = new htmlShinkimenu();
            $htmlShinkis = $htmlShinkimenu->Shinkimenus();
            $htmldenpyomenus = $htmlShinkimenu->denpyomenus();
        ?>
        <hr size="5" style="margin: 0.5rem">
        <table style="margin-bottom:0px" width="1100" border="0" align="center" cellpadding="0" cellspacing="0" bordercolor="#CCCCCC">
          <?php
               echo $htmldenpyomenus;
          ?>
        </table>
        <hr size="5" style="margin: 0.5rem">
        <table style="margin-bottom:0px" width=85% border="0" align="center" cellpadding="0" cellspacing="0">
          <tr>
            <td style="padding: 0.1rem 0.1rem; text-align: center"><a href="qr/index.php"><?php echo $this->Html->image('Labelimg/subTouroku.gif',array('width'=>'85','height'=>'36','url'=>array('action'=>'shiirepreadd')));?></td>
            <td style="padding: 0.1rem 0.1rem; text-align: center"><a href="qr/index.php"><?php echo $this->Html->image('Labelimg/label_ichiran.gif',array('width'=>'85','height'=>'36','url'=>array('action'=>'shiireitiranform')));?></td>
          </tr>
        </table>
        <?= $this->Flash->render() ?>
        <?= $this->Form->create($Users, ['url' => ['action' => 'shiiresyuuseiconfirm']]) ?>
 <br><br><br>
      <table align="left" border="2" bordercolor="#E6FFFF" cellpadding="0" cellspacing="0">
        <tr style="border-bottom: solid;border-width: 1px">
          <td width='250'  bgcolor="#FFFFCC"><div align="center"><strong style="font-size: 11pt; color:blue">発注日付</strong></div></td>
          <td width='200'  bgcolor="#FFFFCC"><strong style="font-size: 9pt; color:blue">発注NO(無ければ任意の英数字)</strong></td>
          <td width='300'  bgcolor="#FFFFCC"><strong style="font-size: 11pt; color:blue">仕入業者</strong></td>
        </tr>
        <tr style="border-bottom: solid;border-width: 1px">
          <td bgcolor="#FFFFCC"><div align="center"><?= $this->Form->input("date_order", array('type' => 'date', 'monthNames' => false, 'value'=>$date_order, 'label'=>false)); ?></div></td>
          <td bgcolor="#FFFFCC"><?= $this->Form->input('num_order', ["type"=>"text", 'label'=>false, 'value'=>$num_order, 'required'=>true]); ?></td>
          <td bgcolor="#FFFFCC"><?= $this->Form->input('ProductSupplierId', ["type"=>"select", "empty"=>"選択してください", "options"=>$arrProductSupplier, 'value'=>$product_supplier_id, 'label'=>false, 'required'=>true]); ?></td>
        </tr>
      </table>
      <br><br><br><br>
      <br><br>

      <table align="left" border="2" bordercolor="#E6FFFF" cellpadding="0" cellspacing="0">
        <tr style="border-bottom: solid;border-width: 1px">
          <td width='220'  bgcolor="#FFFFCC"><strong style="font-size: 10pt; color:blue">品番、または品名、発注名</strong></td>
          <td width='200'  bgcolor="#FFFFCC"><strong style="font-size: 10pt; color:blue">仕入項目</strong></td>
          <td width='60'  bgcolor="#FFFFCC"><strong style="font-size: 10pt; color:blue">価格（円）</strong></td>
          <td width='60'  bgcolor="#FFFFCC"><strong style="font-size: 10pt; color:blue">数量</strong></td>
          <td width='300'  bgcolor="#FFFFCC"><strong style="font-size: 10pt; color:blue">納入日</strong></td>
          <td width='30'  bgcolor="#FFFFCC"><strong style="font-size: 10pt; color:blue">削除</strong></td>
        </tr>

        <tr style="border-bottom: solid;border-width: 1px">
          <td bgcolor="#FFFFCC"><?= $this->Form->input('order_name', ["type"=>"text", 'label'=>false, 'value'=>$order_name, 'required'=>true]); ?></td>
          <td bgcolor="#FFFFCC"><?= $this->Form->input('order_name_element', ["type"=>"select", "empty"=>"選択してください", "options"=>$arrElement, 'value'=>$order_element, 'label'=>false, 'required'=>true]); ?></td>
          <td bgcolor="#FFFFCC"><?= $this->Form->input('price', ["type"=>"text", 'label'=>false, 'value'=>$price, 'required'=>true]); ?></td>
          <td bgcolor="#FFFFCC"><?= $this->Form->input('amount', ["type"=>"text", 'label'=>false, 'value'=>$amount, 'required'=>true]); ?></td>
          <td bgcolor="#FFFFCC"><div align="center"><?= $this->Form->input("date_deliver", array('type' => 'date', 'monthNames' => false, 'value'=>$date_deliver, 'label'=>false)); ?></div></td>
          <td bgcolor="#FFFFCC" style="padding: 0.2rem"><?= $this->Form->control('check', array('type'=>'checkbox', 'label'=>false)) ?></td>
        </tr>

      </table>
      <br><br><br>
      <table align="left" border="2" bordercolor="#E6FFFF" cellpadding="0" cellspacing="0">
      <tr bgcolor="#E6FFFF" >
        <td width="30" colspan="50" nowrap="nowrap" bgcolor="#E6FFFF" style="border: none"><div align="center"><strong style="font-size: 15pt; color:blue"></strong></div></td>
        <td align="right" rowspan="2" width="50" bgcolor="#E6FFFF" style="border: none"><div align="right"><?= $this->Form->submit(__('登録確認'), array('name' => 'kakunin')); ?></div></td>
      </tr>
      </table>
      <?= $this->Form->control('Staffid', array('type'=>'hidden', 'value'=>$Staffid, 'label'=>false)) ?>

      <br><br><br>

<br><br><br><br><br><br>
    <?= $this->Form->end() ?>
