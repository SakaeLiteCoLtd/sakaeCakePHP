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
        <?= $this->Form->create($Users, ['url' => ['action' => 'shiiresyuuseido']]) ?>

<?php if($delete_flag != 1): ?>

 <br><br><br>
      <table align="left" border="2" bordercolor="#E6FFFF" cellpadding="0" cellspacing="0">
        <tr style="border-bottom: solid;border-width: 1px">
          <td width='250'  bgcolor="#FFFFCC"><div align="center"><strong style="font-size: 11pt; color:blue">発注日付</strong></div></td>
          <td width='200'  bgcolor="#FFFFCC"><strong style="font-size: 9pt; color:blue">発注NO(無ければ任意の英数字)</strong></td>
          <td width='300'  bgcolor="#FFFFCC"><strong style="font-size: 11pt; color:blue">仕入業者</strong></td>
        </tr>
        <tr style="border-bottom: solid;border-width: 1px">
          <td bgcolor="#FFFFCC"><div align="center"><?= h($date_order) ?></div></td>
          <td bgcolor="#FFFFCC"><?= h($num_order) ?></td>
          <td bgcolor="#FFFFCC"><?= h($ProductSupplierhyouji) ?></td>
        </tr>
      </table>
      <br><br><br><br>
      <br><br>

      <table align="left" border="2" bordercolor="#E6FFFF" cellpadding="0" cellspacing="0">
        <tr style="border-bottom: solid;border-width: 1px">
          <td width='300'  bgcolor="#FFFFCC"><strong style="font-size: 10pt; color:blue">品番、または品名、発注名</strong></td>
          <td width='150'  bgcolor="#FFFFCC"><strong style="font-size: 10pt; color:blue">価格（円）</strong></td>
          <td width='150'  bgcolor="#FFFFCC"><strong style="font-size: 10pt; color:blue">数量</strong></td>
          <td width='200'  bgcolor="#FFFFCC"><strong style="font-size: 10pt; color:blue">納入日</strong></td>
          <td width='150'  bgcolor="#FFFFCC"><strong style="font-size: 10pt; color:blue">完納済みはチェック</strong></td>
        </tr>
        <tr style="border-bottom: solid;border-width: 1px">
          <td bgcolor="#FFFFCC"><?= h($order_name) ?></td>
          <td bgcolor="#FFFFCC"><?= h($price) ?></td>
          <td bgcolor="#FFFFCC"><?= h($amount) ?></td>
          <td bgcolor="#FFFFCC"><?= h($date_deliver) ?></td>
          <td bgcolor="#FFFFCC" style="padding: 0.2rem"><?= $this->Form->control('check', array('type'=>'checkbox', 'label'=>false, 'required'=>false)) ?></td>
        </tr>
      </table>
      <br><br><br><br><br><br>
      <legend align="left"><strong style="font-size: 11pt; color:black"><?= __("※検収後登録なら完納済にチェック") ?></strong></legend>
      <br><br>
      <table align="left" border="2" bordercolor="#E6FFFF" cellpadding="0" cellspacing="0">
      <tr bgcolor="#E6FFFF" >
        <td style="border-style: none;"><div align="center"><?= $this->Form->submit('戻る', ['onclick' => 'history.back()', 'type' => 'button']); ?></div></td>
        <td align="right" rowspan="2" width="50" bgcolor="#E6FFFF" style="border: none"><div align="right"><?= $this->Form->submit(__('更新'), array('name' => 'kakunin')); ?></div></td>
      </tr>
      </table>
      <?= $this->Form->control('Staffid', array('type'=>'hidden', 'value'=>$Staffid, 'label'=>false)) ?>

<br><br><br><br><br><br>
    <?= $this->Form->end() ?>

<?php else: ?>

  <br><br>
    <legend align="center"><strong style="font-size: 11pt; color:red"><?= __("※以下のデータを削除します") ?></strong></legend>
    <br><br>

         <table align="left" border="2" bordercolor="#E6FFFF" cellpadding="0" cellspacing="0">
           <tr style="border-bottom: solid;border-width: 1px">
             <td width='250'  bgcolor="#FFFFCC"><div align="center"><strong style="font-size: 11pt; color:blue">発注日付</strong></div></td>
             <td width='200'  bgcolor="#FFFFCC"><strong style="font-size: 9pt; color:blue">発注NO(無ければ任意の英数字)</strong></td>
             <td width='300'  bgcolor="#FFFFCC"><strong style="font-size: 11pt; color:blue">仕入業者</strong></td>
           </tr>
           <tr style="border-bottom: solid;border-width: 1px">
             <td bgcolor="#FFFFCC"><div align="center"><?= h($date_order) ?></div></td>
             <td bgcolor="#FFFFCC"><?= h($num_order) ?></td>
             <td bgcolor="#FFFFCC"><?= h($ProductSupplierhyouji) ?></td>
           </tr>
         </table>
         <br><br><br><br>
         <br><br>

         <table align="left" border="2" bordercolor="#E6FFFF" cellpadding="0" cellspacing="0">
           <tr style="border-bottom: solid;border-width: 1px">
             <td width='300'  bgcolor="#FFFFCC"><strong style="font-size: 10pt; color:blue">品番、または品名、発注名</strong></td>
             <td width='150'  bgcolor="#FFFFCC"><strong style="font-size: 10pt; color:blue">価格（円）</strong></td>
             <td width='150'  bgcolor="#FFFFCC"><strong style="font-size: 10pt; color:blue">数量</strong></td>
             <td width='200'  bgcolor="#FFFFCC"><strong style="font-size: 10pt; color:blue">納入日</strong></td>
           </tr>
           <tr style="border-bottom: solid;border-width: 1px">
             <td bgcolor="#FFFFCC"><?= h($order_name) ?></td>
             <td bgcolor="#FFFFCC"><?= h($price) ?></td>
             <td bgcolor="#FFFFCC"><?= h($amount) ?></td>
             <td bgcolor="#FFFFCC"><?= h($date_deliver) ?></td>
           </tr>
         </table>
         <br><br><br><br><br><br>
         <table align="left" border="2" bordercolor="#E6FFFF" cellpadding="0" cellspacing="0">
         <tr bgcolor="#E6FFFF" >
           <td style="border-style: none;"><div align="center"><?= $this->Form->submit('戻る', ['onclick' => 'history.back()', 'type' => 'button']); ?></div></td>
           <td align="right" rowspan="2" width="50" bgcolor="#E6FFFF" style="border: none"><div align="right"><?= $this->Form->submit(__('削除'), array('name' => 'kakunin')); ?></div></td>
         </tr>
         </table>
         <?= $this->Form->control('Staffid', array('type'=>'hidden', 'value'=>$Staffid, 'label'=>false)) ?>
         <br><br><br><br><br><br>
             <?= $this->Form->end() ?>

<?php endif; ?>
