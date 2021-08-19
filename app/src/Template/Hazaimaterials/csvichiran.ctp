<?php

if(!isset($_SESSION)){
  session_start();
  header('Expires:-1');
  header('Cache-Control:');
  header('Pragma:');
}

 use App\myClass\Genryoumenu\htmlGenryoumenu;//myClassフォルダに配置したクラスを使用
 $htmlGenryoumenu = new htmlGenryoumenu();
 $htmlGenryou = $htmlGenryoumenu->Genryoumenus();
 ?>
 <hr size="5" style="margin: 0.5rem">
 <table style="margin-bottom:0px" width="750" border="0" align="center" cellpadding="0" cellspacing="0" bordercolor="#CCCCCC">
 <?php
    echo $htmlGenryou;
 ?>
 </table>
 <hr size="5" style="margin: 0.5rem">
<table style="margin-bottom:0px" width="1000" border="0" align="center" cellpadding="0" cellspacing="0" bordercolor="#CCCCCC">
  <tr style="background-color: #E6FFFF">
      <td style="padding: 0.1rem 0.1rem;"><a href="qr/index.php"><?php echo $this->Html->image('Labelimg/hazaicsv.gif',array('width'=>'105','url'=>array('action'=>'csvpreadd')));?></td>
  </tr>
</table>
<hr size="5" style="margin: 0.5rem">
<br>

<?=$this->Form->create($stockEndMaterials, ['url' => ['action' => 'csvichiran']]) ?>
<br>
<?php if ($chesk_flag == 1): ?>
<table align="right" border="2" bordercolor="#E6FFFF" cellpadding="0" cellspacing="0">
<tr>
  <td style="border-style: none;"><div align="center"><?= $this->Form->submit('全てのチェックを外す', array('name' => 'alldel')); ?></div></td>
  <td style="border-style: none;"><div align="center">　　　</div></td>
</tr>
</table>
<br><br><br>
<?php else : ?>
<?php endif; ?>

<?= $this->Form->control('username', array('type'=>'hidden', 'value'=>$username, 'label'=>false)) ?>

<?php if ($checkstrlen > 0): ?>

<br>
<legend align="center"><font color="red"><?= __("※端材名が21字以上のものはCSV出力できません。代替名を登録してください。") ?></font></legend>
<br>

<?php else : ?>

<?php endif; ?>

<table align="center" border="2" bordercolor="#E6FFFF" cellpadding="0" cellspacing="0">
  <tbody border="2" bordercolor="#E6FFFF" bgcolor="#FFFFCC" style="border-bottom: solid;border-width: 1px">
        <thead>
            <tr border="2" bordercolor="#E6FFFF" bgcolor="#FFFFCC">
              <td width="200" height="30" colspan="20" nowrap="nowrap"><div align="center"><strong style="font-size: 12pt; color:blue">端材</strong></div></td>
              <td width="150" height="30" colspan="20" nowrap="nowrap"><div align="center"><strong style="font-size: 12pt; color:blue">ロットNo.</strong></div></td>
              <td width="150" height="30" colspan="20" nowrap="nowrap"><div align="center"><strong style="font-size: 12pt; color:blue">端材ステイタス</strong></div></td>
              <td width="100" height="30" colspan="20" nowrap="nowrap"><div align="center"><strong style="font-size: 12pt; color:blue">数量</strong></div></td>
              <td width="100" height="30" colspan="20" nowrap="nowrap"><div align="center"><strong style="font-size: 12pt; color:blue">登録日</strong></div></td>
              <td width="100" height="30" colspan="20" nowrap="nowrap"><div align="center"><strong style="font-size: 12pt; color:blue">登録者</strong></div></td>
              <td width="30" height="30" colspan="10" nowrap="nowrap"><div align="center"><strong style="font-size: 12pt; color:blue"></strong></div></td>
            </tr>
        </thead>
        <tbody border="2" bordercolor="#E6FFFF" bgcolor="#FFFFCC">
          <?php for($i=0; $i<count($arrStockEndMaterials); $i++): ?>
            <tr style="border-bottom: solid;border-width: 1px">
              <td colspan="20" nowrap="nowrap"><?= h($arrStockEndMaterials[$i]["hazai"]) ?></td>
              <td colspan="20" nowrap="nowrap"><?= h($arrStockEndMaterials[$i]["lot_num"]) ?></td>
              <td colspan="20" nowrap="nowrap"><?= h($arrStockEndMaterials[$i]["status_material"]) ?></td>
              <td colspan="20" nowrap="nowrap"><?= h($arrStockEndMaterials[$i]["amount"]) ?></td>
              <td colspan="20" nowrap="nowrap"><?= h($arrStockEndMaterials[$i]["created_at"]) ?></td>
              <td colspan="20" nowrap="nowrap"><?= h($arrStockEndMaterials[$i]["staff_name"]) ?></td>

              <?php if ($arrStockEndMaterials[$i]["hazainamecheck"] == 0): ?>

                <?php if ($chesk_flag == 1): ?>
                  <?php
                  echo "<td colspan='10' nowrap='nowrap'>\n";
                  echo "<input type='checkbox' name=check".$i." checked='checked' size='6'/>\n";
                  echo "</td>\n";
                  ?>
                <?php else : ?>
                  <?php
                  echo "<td colspan='10' nowrap='nowrap'>\n";
                  echo "<input type='checkbox' name=check".$i." size='6'/>\n";
                  echo "</td>\n";
                  ?>
                <?php endif; ?>

              <?php else : ?>

                <?php
                echo "<td colspan='10' nowrap='nowrap'>\n";
                echo "\n";
                echo "</td>\n";
                ?>

              <?php endif; ?>

            </tr>

            <?php
            echo "<input type='hidden' name='nummax' value=$i size='6'/>\n";
             ?>

           <?php endfor;?>

        </tbody>
    </table>

<br>
<table align="right" border="2" bordercolor="#E6FFFF" cellpadding="0" cellspacing="0">
<tr>
<td style="border-style: none;"><div align="center"><?= $this->Form->submit('csv発行確認', array('name' => 'kakuninn')); ?></div></td>
<td style="border-style: none;"><div align="center">　　　</div></td>
</tr>
</table>
<br><br><br><br><br><br><br>
<?=$this->Form->end() ?>
</form>
