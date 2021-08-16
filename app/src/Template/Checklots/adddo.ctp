    <?= $this->Form->create($CheckLots, ['url' => ['action' => 'preadd']]) ?>
    <fieldset>

      <div align="center"><font color="black" size="3"><?= __($mes) ?></font></div>
      <br>

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
       <?php for($i=0; $i<=$nummax; $i++): ?>
         <tr style="border-bottom: solid;border-width: 1px">
           <td width="200" bgcolor="#FFFFCC" ><?= h($arraylot_nums[$i]) ?></td>
         </tr>
        <?php endfor;?>
   </tr>
 </table>

    </fieldset>
    <table align="center" border="2" bordercolor="#E6FFFF" cellpadding="0" cellspacing="0">
      <tr bgcolor="#E6FFFF" >
        <td align="center" rowspan="2" width="30" bgcolor="#E6FFFF" style="border: none"><div align="center"><?= $this->Form->submit(__('続けて登録'), array('name' => 'confirm', 'value'=>"1")); ?></div></td>
      </tr>
      </table>
<br>
