<hr size="5">
<table style="margin-bottom:0px" width="750" border="0" align="center" cellpadding="0" cellspacing="0" bordercolor="#CCCCCC">
            <tr style="background-color: #E6FFFF">
              <td style="padding: 0.1rem 0.1rem;"><?php echo $this->Html->image('ShinkiTourokuMenu/kensahyou_touroku.gif',array('width'=>'105','height'=>'36','url'=>array('controller'=>'KensahyouSokuteidatas','action'=>'index1')));?></td>
              <td style="padding: 0.1rem 0.1rem;"><a href="qr/index.php"><?php echo $this->Html->image('ShinkiTourokuMenu/kensahyou_head.gif',array('width'=>'105','height'=>'36','url'=>array('controller'=>'kensahyouHeads','action'=>'index1')));?></td>
              <td style="padding: 0.1rem 0.1rem;"><a href="qr/index.php"><?php echo $this->Html->image('ShinkiTourokuMenu/im_taiou_touroku.gif',array('width'=>'105','height'=>'36','url'=>array('controller'=>'SyukkaKensas','action'=>'index')));?></td>
              <td style="padding: 0.1rem 0.1rem;"><a href="qr/index.php"><?php echo $this->Html->image('ShinkiTourokuMenu/kensahyou_yobidashi.gif',array('width'=>'105','height'=>'36','url'=>array('controller'=>'KensahyouSokuteidatas','action'=>'index')));?></td>
              <td style="padding: 0.1rem 0.1rem;"><a href="qr/index.php"><?php echo $this->Html->image('ShinkiTourokuMenu/kensa_jyunbi_insatsu.gif',array('width'=>'105','height'=>'36','url'=>array('controller'=>'KensahyouSokuteidatas','action'=>'indexcsv')));?></td>
              <td style="padding: 0.1rem 0.1rem;"><a href="qr/index.php"><?php echo $this->Html->image('ShinkiTourokuMenu/analyze_dist.gif',array('width'=>'105','height'=>'36','url'=>array('controller'=>'user','action'=>'index')));?></td>
              <td style="padding: 0.1rem 0.1rem;"><a href="qr/index.php"><?php echo $this->Html->image('ShinkiTourokuMenu/kensa_jyunbi_insatsu.gif',array('width'=>'105','height'=>'36','url'=>array('controller'=>'user','action'=>'index')));?></td>
            </tr>
</table>
<hr size="5">

<?= $this->Form->create($imKikakus, ['url' => ['action' => 'torikomi']]) ?>
<fieldset>

<table width="600" border="1" align="center" bordercolor="#000000" bgcolor="#FFDEAD">
    <tbody border="2" bordercolor="#E6FFFF" bgcolor="#FFFFCC">
    <tr>
      <td width="450" nowrap="nowrap" style="border-bottom: solid;border-width: 1px"><div align="center"><strong><font color="blue" size="4">ＩＭデータ取り込み</font></strong></div></td>
      <td nowrap="nowrap" style="border-bottom: solid;border-width: 1px"><?= $this->Form->submit(__('ＩＭデータ取り込み'), array('name' => 'top')) ?></td>
    </tr>
</table>
<br>
<table width="600" border="1" align="center" bordercolor="#000000" bgcolor="#FFDEAD">
  <tr  border="2" bordercolor="#E6FFFF" bgcolor="#FFFFCC">
      <td width="200" nowrap="nowrap" style="border-bottom: solid;border-width: 1px"><div align="center"><font color="blue"><?= h('品番') ?></font></div></td>
      <td width="200" nowrap="nowrap" style="border-bottom: solid;border-width: 1px"><div align="center"><font color="blue"><?= h('品名') ?></font></div></td>
      <td width="200" nowrap="nowrap" style="border-bottom: solid;border-width: 1px"><div align="center"><font color="blue"><?= h('製造年月日') ?></font></div></td>
  </tr>

  </table>
  <br>

  <table align="center" border="2" bordercolor="#E6FFFF" cellpadding="0" cellspacing="0" style="border-bottom: solid;border-width: 1px">
      <tbody border="2" bordercolor="#E6FFFF" bgcolor="#FFFFCC">
      <tr>
          <th width="200" ><div align="center"><font color="blue"><?= h('品番') ?></font></div></th>
          <th width="200" ><div align="center"><font color="blue"><?= h('品名') ?></font></div></th>
          <th width="200" ><div align="center"><font color="blue"><?= h('製造年月日') ?></font></div></th>
      </tr>
      <tr>
          <td><div align="center"><?= h('品番') ?></div></td>
          <td><div align="center"><?= h('品番') ?></div></td>
          <td><div align="center"><?= h('品番') ?></div></td>
      </tr>
      <tr>
          <td><div align="center"><?= h('品番') ?></div></td>
          <td><div align="center"><?= h('品番') ?></div></td>
          <td><div align="center"><?= h('品番') ?></div></td>
      </tr>
      <tr>
          <td><div align="center"><?= h('品番') ?></div></td>
          <td><div align="center"><?= h('品番') ?></div></td>
          <td><div align="center"><?= h('品番') ?></div></td>
      </tr>

  </table>


<br>
<br>
</fieldset>
<?= $this->Form->end() ?>