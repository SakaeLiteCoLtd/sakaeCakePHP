    <?= $this->Form->create($CheckLots, ['url' => ['action' => 'adddo']]) ?>
    <fieldset>

      <?php
         $nowtime = date('Y-m-d H:i:s');
      ?>

      <table align="center" border="2" bordercolor="#E6FFFF" cellpadding="0" cellspacing="0" style="border-bottom: solid;border-width: 1px">
        <tr>
          <td width="200" bgcolor="#FFFFCC" style="font-size: 8pt;padding: 0.2rem"><strong style="font-size: 11pt; color:blue">品番</strong></td>
          <td width="200" bgcolor="#FFFFCC" style="font-size: 8pt;padding: 0.2rem"><strong style="font-size: 11pt; color:blue">数量</strong></td>
          <td width="200" bgcolor="#FFFFCC" style="font-size: 8pt;padding: 0.2rem"><strong style="font-size: 11pt; color:blue">発行日時</strong></td>
      	</tr>
        <tr>
          <td bgcolor="#FFFFCC" style="padding: 0.2rem"><?= h($this->request->getData('product_code')) ?></td>
          <td bgcolor="#FFFFCC" style="padding: 0.2rem"><?= h($this->request->getData('amount')) ?></td>
          <td bgcolor="#FFFFCC" style="padding: 0.2rem"><?= h($this->request->getData('datetime_hakkou')) ?></td>
      	</tr>
      </table>
      <br>
      <table align="center" border="2" bordercolor="#E6FFFF" cellpadding="0" cellspacing="0" style="border-bottom: solid;border-width: 1px">
        <tr>
          <td width="250" bgcolor="#FFFFCC" style="font-size: 8pt;padding: 0.2rem"><strong style="font-size: 11pt; color:blue">ロットナンバー</strong></td>
        </tr>
        <tr>
            <?php for($i=0; $i<count($arraylot_nums); $i++): ?>
              <tr style="border-bottom: solid;border-width: 1px">
                <td width="200" bgcolor="#FFFFCC" ><?= h($arraylot_nums[$i]) ?></td>
              </tr>
              <?= $this->Form->control('lot_num'.$i, array('type'=>'hidden', 'value'=>$arraylot_nums[$i], 'label'=>false)) ?>
              <?= $this->Form->control('nummax', array('type'=>'hidden', 'value'=>$i, 'label'=>false)) ?>
             <?php endfor;?>
        </tr>
      </table>

      <?php if (count($arraylot_numtorikomizumis) > 0): ?>
        <br>
        <div align="center"><font color="red" size="3"><?= __("※以下のロットは既に登録されています。") ?></font></div>
        <br>
        <table align="center" border="2" bordercolor="#E6FFFF" cellpadding="0" cellspacing="0" style="border-bottom: solid;border-width: 1px">
          <tr>
            <td width="250" bgcolor="#FFFFCC" style="font-size: 8pt;padding: 0.2rem"><strong style="font-size: 11pt; color:blue">ロットナンバー</strong></td>
          </tr>
          <tr>
              <?php for($i=0; $i<count($arraylot_numtorikomizumis); $i++): ?>
                <tr style="border-bottom: solid;border-width: 1px">
                  <td width="200" bgcolor="#FFFFCC" ><?= h($arraylot_numtorikomizumis[$i]) ?></td>
                </tr>
               <?php endfor;?>
          </tr>
        </table>

      <?php else : ?>

      <?php endif; ?>

    </fieldset>

      <?php if (count($arraylot_nums) > 0): ?>

        <table align="center" border="2" bordercolor="#E6FFFF" cellpadding="0" cellspacing="0">
          <tr bgcolor="#E6FFFF" >
            <td style="border-style: none;"><div align="center"><?= $this->Form->submit('戻る', ['onclick' => 'history.back()', 'type' => 'button']); ?></div></td>
            <td align="center" rowspan="2" width="30" bgcolor="#E6FFFF" style="border: none"><div align="center"><?= $this->Form->submit(__('登録'), array('name' => 'confirm', 'value'=>"1")); ?></div></td>
          </tr>
          </table>

      <?php else : ?>

        <table align="center" border="2" bordercolor="#E6FFFF" cellpadding="0" cellspacing="0">
          <tr bgcolor="#E6FFFF" >
            <td style="border-style: none;"><div align="center"><?= $this->Form->submit('戻る', ['onclick' => 'history.back()', 'type' => 'button']); ?></div></td>
          </tr>
          </table>

      <?php endif; ?>

      <br>

      <?= $this->Form->control('product_code', array('type'=>'hidden', 'value'=>$this->request->getData('product_code'), 'label'=>false)) ?>
      <?= $this->Form->control('lot_num', array('type'=>'hidden', 'value'=>$this->request->getData('lot_num'), 'label'=>false)) ?>
      <?= $this->Form->control('amount', array('type'=>'hidden', 'value'=>$this->request->getData('amount'), 'label'=>false)) ?>
      <?= $this->Form->control('datetime_hakkou', array('type'=>'hidden', 'value'=>$this->request->getData('datetime_hakkou'), 'label'=>false)) ?>
      <?= $this->Form->control('staff_id', array('type'=>'hidden', 'value'=>$this->request->getData('staff_id'), 'label'=>false)) ?>
