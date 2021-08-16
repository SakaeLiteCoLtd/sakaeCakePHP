    <?= $this->Form->create($CheckLots, ['url' => ['action' => 'addconfirm']]) ?>
    <fieldset>

      <?php
         $nowtime = date('Y-m-d H:i:s');
      ?>

      <div align="center"><font color="black" size="3"><?= __($mess) ?></font></div>
      <br>

 <table align="center" border="2" bordercolor="#E6FFFF" cellpadding="0" cellspacing="0" style="border-bottom: solid;border-width: 1px">
   <tr>
     <td width="200" bgcolor="#FFFFCC" style="font-size: 8pt;padding: 0.2rem"><strong style="font-size: 11pt; color:blue">品番</strong></td>
     <td width="200" bgcolor="#FFFFCC" style="font-size: 8pt;padding: 0.2rem"><strong style="font-size: 11pt; color:blue">数量</strong></td>
   </tr>
   <tr>
     <td bgcolor="#FFFFCC" style="padding: 0.2rem"><?= $this->Form->control('product_code', array('type'=>'text', 'label'=>false, 'autofocus'=>true, 'required'=>true)) ?></td>
     <td bgcolor="#FFFFCC" style="padding: 0.2rem"><?= $this->Form->control('amount', array('type'=>'text', 'label'=>false, 'required'=>true)) ?></td>
   </tr>
 </table>
<br>
      <table align="center" border="2" bordercolor="#E6FFFF" cellpadding="0" cellspacing="0" style="border-bottom: solid;border-width: 1px">
        <tr>
          <td width="200" bgcolor="#FFFFCC" style="font-size: 8pt;padding: 0.2rem"><strong style="font-size: 11pt; color:blue">１番目ロットナンバー</strong></td>
          <td width="200" bgcolor="#FFFFCC" style="font-size: 8pt;padding: 0.2rem"><strong style="font-size: 11pt; color:blue">枚数</strong></td>
      	</tr>
        <tr>
          <td bgcolor="#FFFFCC" style="padding: 0.2rem"><?= $this->Form->control('lot_num', array('type'=>'text', 'label'=>false, 'required'=>true)) ?></td>
          <td bgcolor="#FFFFCC" style="padding: 0.2rem"><?= $this->Form->control('maisu', array('type'=>'text', 'label'=>false, 'required'=>true)) ?></td>
      	</tr>
      </table>
      <br>
      <table align="center" border="2" bordercolor="#E6FFFF" cellpadding="0" cellspacing="0" style="border-bottom: solid;border-width: 1px">
        <tr>
          <td width="200" bgcolor="#FFFFCC" style="font-size: 8pt;padding: 0.2rem"><strong style="font-size: 11pt; color:blue">発行日時</strong></td>
      	</tr>
        <tr>
          <td bgcolor="#FFFFCC" style="padding: 0.2rem"><?= $this->Form->control('datetime_hakkou', array('type'=>'datetime-local', 'value'=>$nowtime, 'label'=>false, 'required'=>true)) ?></td>
      	</tr>
      </table>

    </fieldset>
    <table align="center" border="2" bordercolor="#E6FFFF" cellpadding="0" cellspacing="0">
    <tr>
      <td style="border-style: none;"><div align="center"><?= $this->Form->submit(__('確認'), array('name' => 'kakunin')); ?></div></td>
    </tr>
  </table>
<br>
<?= $this->Form->control('staff_id', array('type'=>'hidden', 'value'=>$staff_id, 'label'=>false)) ?>
