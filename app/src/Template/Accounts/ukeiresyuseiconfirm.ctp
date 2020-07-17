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
     <td style="padding: 0.1rem 0.1rem; text-align: center"><?php echo $this->Html->image('Labelimg/accountYusyouzaiUkeireKensaku.gif');?></td>
   </tr>
 </table>
<br><br>

  <?= $this->Form->create($user, ['url' => ['action' => 'ukeiresyuseido']]) ?>
  <legend align="center"><font color="red"><?= __($mes) ?></font></legend>
<br>

  <table align="center" border="2" bordercolor="#E6FFFF" cellpadding="0" cellspacing="0">
    <tbody border="2" bordercolor="#E6FFFF" bgcolor="#FFFFCC" style="border-bottom: solid;border-width: 1px">
      <tr style="border-bottom: 0px;border-width: 0px">
        <td width="170" nowrap="nowrap"><div align="center"><strong style="font-size: 13pt; color:blue">品番</strong></div></td>
        <td width="170" height="30" nowrap="nowrap"><div align="center"><strong style="font-size: 13pt; color:blue">品名</strong></div></td>
        <td width="170" height="30" nowrap="nowrap"><div align="center"><strong style="font-size: 13pt; color:blue">単価</strong></div></td>
        <td width="170" height="30" nowrap="nowrap"><div align="center"><strong style="font-size: 13pt; color:blue">日付</strong></div></td>
        <td width="170" height="30" nowrap="nowrap"><div align="center"><strong style="font-size: 13pt; color:blue">数量</strong></div></td>
      </tr>
      <tr style="border-bottom: 0px;border-width: 0px">
        <td bgcolor="#FFFFCC" style="padding: 0.2rem"><?= h($this->request->getData('product_code')) ?></td>
        <td bgcolor="#FFFFCC" style="padding: 0.2rem"><?= h($this->request->getData('product_name')) ?></td>
        <td bgcolor="#FFFFCC" style="padding: 0.2rem"><?= h($this->request->getData('tanka')) ?></td>
        <td style="border-bottom: solid;border-width: 1px"><div align="center"><?= h($dateYMD) ?></div></td>
        <td bgcolor="#FFFFCC" style="padding: 0.2rem"><?= h($this->request->getData('amount')) ?></td>
      </tr>

  <table align="left" border="2" bordercolor="#E6FFFF" cellpadding="0" cellspacing="0">
    <br>
  <tr bgcolor="#E6FFFF" >
    <td align="left" rowspan="2" width="30" bgcolor="#E6FFFF" style="border: none"><div align="center"><?= $this->Form->submit(__($button), array('name' => 'do')); ?></div></td>
  </tr>
  </table>

  <?= $this->Form->control('product_code', array('type'=>'hidden', 'value'=>$this->request->getData('product_code'), 'label'=>false)) ?>
  <?= $this->Form->control('product_name', array('type'=>'hidden', 'value'=>$this->request->getData('product_name'), 'label'=>false)) ?>
  <?= $this->Form->control('date', array('type'=>'hidden', 'value'=>$dateYMD, 'label'=>false)) ?>
  <?= $this->Form->control('tanka', array('type'=>'hidden', 'value'=>$this->request->getData('tanka'), 'label'=>false)) ?>
  <?= $this->Form->control('amount', array('type'=>'hidden', 'value'=>$this->request->getData('amount'), 'label'=>false)) ?>
  <?= $this->Form->control('delete_flag', array('type'=>'hidden', 'value'=>$this->request->getData('check'), 'label'=>false)) ?>
  <?= $this->Form->control('Id', array('type'=>'hidden', 'value'=>$this->request->getData('Id'), 'label'=>false)) ?>

  <br><br>
