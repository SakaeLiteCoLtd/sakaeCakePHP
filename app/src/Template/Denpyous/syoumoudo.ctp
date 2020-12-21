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
        <table style="margin-bottom:0px" width="1000" border="0" align="center" cellpadding="0" cellspacing="0" bordercolor="#CCCCCC">
          <?php
               echo $htmldenpyomenus;
          ?>
        </table>
        <hr size="5" style="margin: 0.5rem">
        <table style="margin-bottom:0px" width=85% border="0" align="center" cellpadding="0" cellspacing="0">
          <tr>
            <td style="padding: 0.1rem 0.1rem; text-align: center"><a href="qr/index.php"><?php echo $this->Html->image('Labelimg/subTouroku.gif',array('width'=>'85','height'=>'36','url'=>array('action'=>'syoumoupreadd')));?></td>
            <td style="padding: 0.1rem 0.1rem; text-align: center"><a href="qr/index.php"><?php echo $this->Html->image('Labelimg/label_ichiran.gif',array('width'=>'85','height'=>'36','url'=>array('action'=>'menukatagae')));?></td>
          </tr>
        </table>
        <?= $this->Flash->render() ?>
    <?= $this->Form->create($Users, ['url' => ['action' => 'syoumoumenu']]) ?>
    <br><br><br>
    <table align="left" border="2" bordercolor="#E6FFFF" cellpadding="0" cellspacing="0" style="border-bottom: solid;border-width: 1px">
      <tr>
        <td  width="150" bgcolor="#FFFFCC" style="font-size: 12pt;"><strong style="font-size: 11pt; color:blue">登録社員名</strong></td>
        <td  width="150" bgcolor="#FFFFCC" style="font-size: 12pt;"><strong style="font-size: 10pt"><?= __($Staff) ?></strong></td>
      </tr>
    </table>
    <br><br>
    <br><br>
    <table align="left" border="2" bordercolor="#E6FFFF" cellpadding="0" cellspacing="0">
      <tbody border="2" bordercolor="#E6FFFF" bgcolor="#FFFFCC">
        <tr>
          <td width="250" colspan="20" nowrap="nowrap"><div align="center"><strong style="font-size: 11pt; color:blue">発注日付</strong></div></td>
        </tr>
          <td width="250" colspan="20" style="border-bottom: solid;border-width: 1px"><div align="center"><?= h($date_order) ?></div></td>
    </table>
    <br><br><br><br>
    <br><br><br><br>
    <table align="left" border="2" bordercolor="#E6FFFF" cellpadding="0" cellspacing="0">
      <tr style="border-bottom: solid;border-width: 1px">
        <td width='200'  bgcolor="#FFFFCC"><strong style="font-size: 11pt; color:blue">発注部署</strong></td>
        <td width='200'  bgcolor="#FFFFCC"><strong style="font-size: 9pt; color:blue">発注NO(無ければ任意の英数字)</strong></td>
        <td width='300'  bgcolor="#FFFFCC"><strong style="font-size: 9pt; color:blue">仕入業者</strong></td>
      </tr>

      <tr style="border-bottom: solid;border-width: 1px">
        <td bgcolor="#FFFFCC"><?= h($fromorderhyouji) ?></td>
        <td bgcolor="#FFFFCC"><?= h($num_order) ?></td>
        <td bgcolor="#FFFFCC"><?= h($syoumousupplierhyouji) ?></td>
      </tr>

    </table>
    <br><br><br><br>
    <br><br><br><br>

    <table align="left" border="2" bordercolor="#E6FFFF" cellpadding="0" cellspacing="0" style="border-bottom: solid;border-width: 1px">
      <tr>
        <td  width="150" bgcolor="#FFFFCC" style="font-size: 12pt;"><strong style="font-size: 11pt; color:blue">合計金額</strong></td>
        <td  width="150" bgcolor="#FFFFCC" style="font-size: 12pt;"><strong style="font-size: 12pt"><?= h("￥ ".$totalprice) ?></strong></td>
      </tr>
    </table>

<br><br><br><br><br><br>

<table align="left" border="2" bordercolor="#E6FFFF" cellpadding="0" cellspacing="0">
  <tr style="border-bottom: solid;border-width: 1px">
    <td width='10'  bgcolor="#FFFFCC"><strong style="font-size: 13pt; color:blue"></strong></td>
    <td width='100'  bgcolor="#FFFFCC"><strong style="font-size: 9pt; color:blue">仕入項目</strong></td>
    <td width='120'  bgcolor="#FFFFCC"><strong style="font-size: 9pt; color:blue">品番、機械番号etc</strong></td>
    <td width='120'  bgcolor="#FFFFCC"><strong style="font-size: 9pt; color:blue">品名、または発注名</strong></td>
    <td width='100'  bgcolor="#FFFFCC"><strong style="font-size: 9pt; color:blue">単価（円）</strong></td>
    <td width='100'  bgcolor="#FFFFCC"><strong style="font-size: 9pt; color:blue">数量</strong></td>
    <td width='100'  bgcolor="#FFFFCC"><strong style="font-size: 9pt; color:blue">納入日</strong></td>
    <td width='100'  bgcolor="#FFFFCC"><strong style="font-size: 9pt; color:blue">完納</strong></td>
  </tr>

  <?php for($i=0; $i<=$tuika; $i++): ?>
  <tr style="border-bottom: solid;border-width: 1px">
    <td bgcolor="#FFFFCC"><?= __($i+1) ?></td>
    <td bgcolor="#FFFFCC"><?= h(${"elementhyouji".$i}) ?></td>
    <td bgcolor="#FFFFCC"><?= h(${"order_product_code".$i}) ?></td>
    <td bgcolor="#FFFFCC"><?= h(${"order_product_name".$i}) ?></td>
    <td bgcolor="#FFFFCC"><?= h(${"price".$i}) ?></td>
    <td bgcolor="#FFFFCC"><?= h(${"amount".$i}) ?></td>
    <td bgcolor="#FFFFCC"><?= h(${"date_deliver".$i}) ?></td>
    <td bgcolor="#FFFFCC"><?= h(${"kannouhyouji".$i}) ?></td>
  </tr>
  <?= $this->Form->control('num', array('type'=>'hidden', 'value'=>$i, 'label'=>false)) ?>
  <?php endfor;?>

</table>
<br><br><br><br><br><br>
<table align="center" border="2" bordercolor="#E6FFFF" cellpadding="0" cellspacing="0">
<tr bgcolor="#E6FFFF" >
  <td align="center" rowspan="2" width="50" bgcolor="#E6FFFF" style="border: none"><div align="center"><?= $this->Form->submit(__('TOP'), array('name' => 'kakunin')); ?></div></td>
</tr>
</table>

<br>

    <?= $this->Form->end() ?>
