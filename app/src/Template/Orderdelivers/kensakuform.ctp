<?php
 use App\myClass\EDImenus\htmlEDImenu;//myClassフォルダに配置したクラスを使用
 $htmlEDImenu = new htmlEDImenu();
 $htmlEDIs = $htmlEDImenu->EDImenus();
 ?>
 <hr size="5" style="margin: 0.5rem">
 <table style="margin-bottom:0px" width="750" border="0" align="center" cellpadding="0" cellspacing="0" bordercolor="#CCCCCC">
 <?php
    echo $htmlEDIs;
 ?>
</table>
<hr size="5" style="margin: 0.5rem">
<br>
<table style="margin-bottom:0px" width="750" border="0" align="center" cellpadding="0" cellspacing="0" bordercolor="#CCCCCC">
            <tr style="background-color: #E6FFFF">
              <td style="padding: 0.1rem 0.1rem;"><a href="qr/index.php"><?php echo $this->Html->image('Labelimg/orderdeliver.gif',array('width'=>'85','height'=>'36','url'=>array('controller'=>'Orderdelivers','action'=>'kensakuform')));?></td>
            </tr>
</table>

    <?= $this->Form->create($OrderEdis, ['url' => ['action' => 'kensakuselect']]) ?>
    <fieldset>

      <br>

      <table align="center" border="2" bordercolor="#E6FFFF" cellpadding="0" cellspacing="0">
        <tbody border="2" bordercolor="#E6FFFF" bgcolor="#FFFFCC" style="border-bottom: solid;border-width: 1px">
          <tr style="border-bottom: 0px;border-width: 0px">
            <td width="250" height="40" colspan="20" nowrap="nowrap"><div align="center"><strong style="font-size: 15pt; color:blue">品番</strong></div></td>
            <td width="500" colspan="40" nowrap="nowrap"><div align="center"><strong style="font-size: 15pt; color:blue">納期絞込</strong></div></td>
            <td width="250" height="40" colspan="20" nowrap="nowrap"><div align="center"><strong style="font-size: 13pt; color:blue">注文No.</strong></div></td>
          </tr>


      <?php
            $dateYMD = date('Y-m-d');
            $dateYMD1 = strtotime($dateYMD);
            $dayye = date('Y-m-d', strtotime('-1 day', $dateYMD1));
            $dayyey = date('Y', strtotime('-1 day', $dateYMD1));
            $dayyem = date('n', strtotime('-1 day', $dateYMD1));
            $dayyed = date('j', strtotime('-1 day', $dateYMD1));
            $dayyetoy = date('Y');
            $dayyetom = date('n');
            $dayyetod = date('j');

            echo "<tr style='border-bottom: 0px;border-width: 0px'>\n";
            echo "<td rowspan='2'  height='6' colspan='20'>\n";
            echo "<input type='text' name=product_code size='6'/>\n";
            echo "</td>\n";
            echo "<td width='50' colspan='3' style='border-bottom: 0px'><div align='center'><strong style='font-size: 15pt; color:blue'>\n";
            echo "開始";
            echo "</strong></div></td>\n";

        ?>
        <td width="80" colspan="12" style="border-right-style: none;border-bottom: 0px;border-width: 1px"><div align="center"><?= $this->Form->input("date_sta_year", array('type' => 'select', "options"=>$arrYears, 'value' => $dayyey, 'label'=>false)); ?></div></td>
        <td width="80" colspan="12" style="border-right-style: none;border-left-style: none;border-bottom: 0px;border-width: 1px"><div align="center"><?= $this->Form->input("date_sta_month", array('type' => 'select', "options"=>$arrMonths, 'value' => $dayyem, 'monthNames' => false, 'label'=>false)); ?></div></td>
        <td width="80" colspan="13" style="border-left-style: none;border-bottom: 0px;border-width: 1px"><div align="center"><?= $this->Form->input("date_sta_date", array('type' => 'select', "options"=>$arrDays, 'value' => $dayyed, 'label'=>false)); ?></div></td>
        <?php

            echo "<td rowspan='2' height='6' colspan='20'>\n";
            echo "<input type='text' name=num_order size='6'/>\n";
            echo "</td>\n";
            echo "</tr>\n";
            echo "<tr style='border-bottom: 0px;border-width: 0px'>\n";
            echo "<td colspan='3'><div align='center'><strong style='font-size: 15pt; color:blue'>\n";
            echo "終了";
            echo "</strong></div></td>\n";

      ?>
      <td width="80" colspan="12" style="border-right-style: none;border-width: 1px"><div align="center"><?= $this->Form->input("date_fin_year", array('type' => 'select', "options"=>$arrYears, 'value' => $dayyetoy, 'label'=>false)); ?></div></td>
      <td width="80" colspan="12" style="border-right-style: none;border-left-style: none;border-width: 1px"><div align="center"><?= $this->Form->input("date_fin_month", array('type' => 'select', "options"=>$arrMonths, 'value' => $dayyetom, 'monthNames' => false, 'label'=>false)); ?></div></td>
      <td width="80" colspan="13" style="border-left-style: none;border-width: 1px"><div align="center"><?= $this->Form->input("date_fin_date", array('type' => 'select', "options"=>$arrDays, 'value' => $dayyetod, 'label'=>false)); ?></div></td>
      <?php

            echo "</tr>\n";

       ?>
      <br>
        <tr bgcolor="#E6FFFF" >
          <td width="100" colspan="30" nowrap="nowrap" bgcolor="#E6FFFF" style="border: none"><div align="center"><strong style="font-size: 15pt; color:blue"></strong></div></td>
          <td width="100" colspan="30" nowrap="nowrap" bgcolor="#E6FFFF" style="border: none"><div align="center"><strong style="font-size: 15pt; color:blue"></strong></div></td>
          <td align="right" rowspan="2"  colspan="20" width="250" bgcolor="#E6FFFF" style="border: none"><div align="right"><?= $this->Form->submit(__('検索'), array('name' => 'kensaku')); ?></div></td>
        </tr>
      </table>
      </fieldset>

      <?=$this->Form->end() ?>
