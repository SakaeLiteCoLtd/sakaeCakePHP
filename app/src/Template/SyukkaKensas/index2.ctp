<hr size="5">
<table style="margin-bottom:0px" width="750" border="0" align="center" cellpadding="0" cellspacing="0" bordercolor="#CCCCCC">
            <tr style="background-color: #E6FFFF">
              <td style="padding: 0.1rem 0.1rem;"><?php echo $this->Html->image('ShinkiTourokuMenu/kensahyou_touroku.gif',array('width'=>'105','height'=>'36','url'=>array('controller'=>'KensahyouSokuteidatas','action'=>'index1')));?></td>
              <td style="padding: 0.1rem 0.1rem;"><a href="qr/index.php"><?php echo $this->Html->image('ShinkiTourokuMenu/kensahyou_head.gif',array('width'=>'105','height'=>'36','url'=>array('controller'=>'kensahyouHeads','action'=>'index1')));?></td>
              <td style="padding: 0.1rem 0.1rem;"><a href="qr/index.php"><?php echo $this->Html->image('ShinkiTourokuMenu/im_taiou_touroku.gif',array('width'=>'105','height'=>'36','url'=>array('controller'=>'SyukkaKensas','action'=>'index1')));?></td>
              <td style="padding: 0.1rem 0.1rem;"><a href="qr/index.php"><?php echo $this->Html->image('ShinkiTourokuMenu/kensahyou_yobidashi.gif',array('width'=>'105','height'=>'36','url'=>array('controller'=>'KensahyouSokuteidatas','action'=>'index')));?></td>
              <td style="padding: 0.1rem 0.1rem;"><a href="qr/index.php"><?php echo $this->Html->image('ShinkiTourokuMenu/kensa_jyunbi_insatsu.gif',array('width'=>'105','height'=>'36','url'=>array('controller'=>'KensahyouSokuteidatas','action'=>'indexcsv')));?></td>
              <td style="padding: 0.1rem 0.1rem;"><a href="qr/index.php"><?php echo $this->Html->image('ShinkiTourokuMenu/analyze_dist.gif',array('width'=>'105','height'=>'36','url'=>array('controller'=>'user','action'=>'index')));?></td>
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
<br>

<div align="center"><font color="red" size="4">＊下記の製品が未検査です</font></div>
<br>
<table align="center" border="2" bordercolor="#E6FFFF" cellpadding="0" cellspacing="0" style="border-bottom: solid;border-width: 1px">
      <tbody border="2" bordercolor="#E6FFFF" bgcolor="#FFFFCC">
      <tr>
          <td width="200" ><div align="center"><strong><font color="blue" size="3"><?= h('品番') ?></font></strong></div></td>
          <td width="300" ><div align="center"><strong><font color="blue" size="3"><?= h('品名') ?></font></strong></div></td>
          <td width="200" ><div align="center"><strong><font color="blue" size="3"><?= h('製造年月日') ?></font></strong></div></td>
      </tr>

      <?php
    //  echo $this->Url->build("/MLD-MD-20032_jigu");

    if($countname!=1){
      for($i=1; $i<=$countname; $i++){
        echo '<tr><td><div align="center">';
        echo (${"product_code".$i}) ;
        echo '</div></td>';
        echo '<td><div align="center">';
        echo (${"product_name".$i}) ;
        echo '</div></td>';
        echo '<td><div align="center"><font color="blue">';
  //      echo (${"inspec_date".$i}) ;
        echo $this->Html->link(${"inspec_date".$i}, ['action'=>'preform', 'name' => ${"inspec_date".$i}, 'value1' => ${"product_code".$i}, 'value2' => ${"product_name".$i}, 'value3' => ${"KadouSeikeiid".$i}]) ;
        echo '</div></font></td></tr>';
      }
    }
      ?>

</table>
<br>
<br>

<div align="center"><font color="blue" size="4">＊以下は、現在成形中の製品です。（成形品が違う場合は仮日報登録を修正してください。）</font></div>
<br>
<table align="center" border="2" bordercolor="#E6FFFF" cellpadding="0" cellspacing="0" style="border-bottom: solid;border-width: 1px">
      <tbody border="2" bordercolor="#E6FFFF" bgcolor="#FFFFCC">
      <tr>
          <td width="200" ><div align="center"><strong><font color="blue" size="3"><?= h('品番') ?></font></strong></div></td>
          <td width="300" ><div align="center"><strong><font color="blue" size="3"><?= h('品名') ?></font></strong></div></td>
          <td width="200" ><div align="center"><strong><font color="blue" size="3"><?= h('製造年月日') ?></font></strong></div></td>
      </tr>

      <?php
    //  echo $this->Url->build("/MLD-MD-20032_jigu");
    if($countnameb!=1){
      for($i=1; $i<=$countnameb; $i++){
        echo '<tr><td><div align="center">';
        echo (${"product_codeb".$i}) ;
        echo '</div></td>';
        echo '<td><div align="center">';
        echo (${"product_nameb".$i}) ;
        echo '</div></td>';
        echo '<td><div align="center"><font color="blue">';
    //    echo (${"inspec_dateb".$i}) ;
        echo $this->Html->link(${"inspec_dateb".$i}, ['action'=>'preform', 'name' => ${"inspec_dateb".$i}, 'value1' => ${"product_codeb".$i}, 'value2' => ${"product_nameb".$i}, 'value3' => ${"KadouSeikeiid".$i}]) ;
        echo '</div></font></td></tr>';
      }
    }
      ?>

</table>

<br>
<br>
</fieldset>
<?= $this->Form->end() ?>
