<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\Staff[]|\Cake\Collection\CollectionInterface $staffs
 */
 use Cake\ORM\TableRegistry;//独立したテーブルを扱う
 $this->Products = TableRegistry::get('products');//productsテーブルを使う
 $this->NameLotFlagUseds = TableRegistry::get('nameLotFlagUseds');
?>
<?php
  $username = $this->request->Session()->read('Auth.User.username');

  header('Expires:-1');
  header('Cache-Control:');
  header('Pragma:');

  $num1 = 0;
  $num = 0;
  $count1 = 1;
  $count2 = 0;
  $count = 1;
  $kadouritutotal1 = 0;
  $kadouritutotal = 0;
?>

<?php
 use App\myClass\Kadous\htmlKadoumenu;//myClassフォルダに配置したクラスを使用
 $htmlKadoumenu = new htmlKadoumenu();
 $htmlKadoumenus = $htmlKadoumenu->Kadoumenus();
 ?>
 <hr size="5" style="margin: 0.5rem">
 <table style="margin-bottom:0px" width="750" border="0" align="center" cellpadding="0" cellspacing="0" bordercolor="#CCCCCC">
 <?php
    echo $htmlKadoumenus;
 ?>
 </table>
 <hr size="5" style="margin: 0.5rem">
<?=$this->Form->create($kadouSeikeis, ['url' => ['action' => 'kensakusyousai']]) ?>



<?php if($check_product != 1): ?>

  <?php if($itiniticheck > 0): ?>

    <?php

    for($i=0; $i<$countkadouSeikei; $i++){

      if($i >= $num1 && isset($arrGroupcount[$count1])){

        $numcell1 = $arrGroupcount[$count1];
        $num1 = $num1 + $arrGroupcount[$count1];

        $total_loss_time = round((1 - $KadouSeikeis[$num1-1]["kadouritsu"]) * 86400 / 60 , 1);

        $count1 = $count1 + 1;
        $total_loss1 = 0;

        $kadouritutotal1 = $kadouritutotal1 + $KadouSeikeis[$num1-1]["kadouritsu"] * 100;

      }else{
        $numcell1 = 1;
      }

    }

    ?>

  <br>
  <table align="center" border="2" bordercolor="#E6FFFF" cellpadding="0" cellspacing="0">
    <tbody border="2" bordercolor="#E6FFFF" bgcolor="#FFFFCC">
      <tr border="2" bordercolor="#E6FFFF" bgcolor="#FFFFCC">
        <td width="250" height="30" style="border-bottom: solid;border-width: 1px" colspan="20" nowrap="nowrap"><font color=#FF66FF><strong style="font-size: 12pt"><?= h($date_hyouji." 全体稼働率") ?></strong></font></td>
        <td width="150" style="border-bottom: solid;border-width: 1px" colspan="20" nowrap="nowrap"><font color="red"><strong style="font-size: 12pt"><?= h(round($kadouritutotal1 / 9 , 1)) ?></strong></font><font color="blue"><?= h(" ％") ?></font></td>
      </tr>
    </tbody>
    </table>

  <?php else: ?>

    <?php

    for($i=0; $i<$countkadouSeikei; $i++){

      if($i >= $num1 && isset($arrGroupcount[$count1])){

        $numcell1 = $arrGroupcount[$count1];
        $num1 = $num1 + $arrGroupcount[$count1];

        $total_loss_time = round((1 - $KadouSeikeis[$num1-1]["kadouritsu"]) * 86400 / 60 , 1);

        $count1 = $count1 + 1;
        $count2 = $count2 + 1;
        $total_loss1 = 0;

        $kadouritutotal1 = $kadouritutotal1 + $KadouSeikeis[$num1-1]["kadouritsu"] * 100;

      }else{
        $numcell1 = 1;
      }

    }

    if($count2 > 0){
      $zentaikadouritu = round($kadouritutotal1 / $count2 , 1);
    }else{
      $zentaikadouritu = "";
    }

    ?>

    <br>
    <table align="center" border="2" bordercolor="#E6FFFF" cellpadding="0" cellspacing="0">
      <tbody border="2" bordercolor="#E6FFFF" bgcolor="#FFFFCC">
        <tr border="2" bordercolor="#E6FFFF" bgcolor="#FFFFCC">
          <td width="200" height="30" style="border-bottom: solid;border-width: 1px" colspan="20" nowrap="nowrap"><font color=#FF66FF><strong style="font-size: 12pt"><?= h("絞込データ全体稼働率") ?></strong></font></td>
          <td width="150" style="border-bottom: solid;border-width: 1px" colspan="20" nowrap="nowrap"><font color="red"><strong style="font-size: 12pt"><?= h($zentaikadouritu) ?></strong></font><font color="blue"><?= h(" ％") ?></font></td>
        </tr>
      </tbody>
      </table>

  <?php endif; ?>


<br><br>
<table align="center" border="2" bordercolor="#E6FFFF" cellpadding="0" cellspacing="0">
  <tbody border="2" bordercolor="#E6FFFF" bgcolor="#FFFFCC" style="border-bottom: solid;border-width: 1px">
        <thead>
          <tr border="2" bordercolor="#E6FFFF" bgcolor="#FFFFCC">
            <td width="150" height="30" colspan="20" nowrap="nowrap"><div align="center"><strong style="font-size: 10pt; color:#FF66FF">品番</strong></div></td>
            <td height="30" colspan="20" nowrap="nowrap"><div align="center"><strong style="font-size: 9pt; color:#FF66FF">成形機</strong></div></td>
            <td height="30" colspan="20" nowrap="nowrap"><div align="center"><strong style="font-size: 10pt; color:#FF66FF">開始時刻</strong></div></td>
            <td height="30" colspan="20" nowrap="nowrap"><div align="center"><strong style="font-size: 10pt; color:#FF66FF">終了時刻</strong></div></td>
            <td width="80" height="30" colspan="20" nowrap="nowrap"><div align="center"><strong style="font-size: 9pt; color:#FF66FF">ショットサイクル</strong></div></td>
            <td width="80" height="30" colspan="20" nowrap="nowrap"><div align="center"><strong style="font-size: 8pt; color:#FF66FF">プログラムショットサイクル</strong></div></td>
            <td height="30" colspan="20" nowrap="nowrap"><div align="center"><strong style="font-size: 8pt; color:#FF66FF">日報ショット数</strong></div></td>
            <td height="30" colspan="20" nowrap="nowrap"><div align="center"><strong style="font-size: 8pt; color:#FF66FF">PRGショット数</strong></div></td>
            <td width="80" height="30" colspan="20" nowrap="nowrap"><div align="center"><strong style="font-size: 9pt; color:#FF66FF">個別達成率</strong></div></td>
            <td width="80" height="30" colspan="20" nowrap="nowrap"><div align="center"><strong style="font-size: 9pt; color:#FF66FF">個別非生産時間</strong></div></td>
            <td height="30" colspan="20" nowrap="nowrap"><div align="center"><strong style="font-size: 10pt; color:#FF66FF">成形機稼動率</strong></div></td>
            <td height="30" colspan="20" nowrap="nowrap"><div align="center"><strong style="font-size: 10pt; color:#FF66FF">非生産時間</strong></div></td>
            <td height="30" colspan="20" nowrap="nowrap"><div align="center"><strong style="font-size: 10pt; color:#FF66FF">型替え時間</strong></div></td>
            <td width="60" height="30" colspan="20" nowrap="nowrap"><div align="center"><strong style="font-size: 9pt; color:#FF66FF"></strong></div></td>
          </tr>
        </thead>
        <tbody border="2" bordercolor="#E6FFFF" bgcolor="#FFFFCC">
          <?php for($i=0; $i<$countkadouSeikei; $i++): ?>
          <tr style="border-bottom: solid;border-width: 1px">
            <td colspan="20" nowrap="nowrap"><font color="blue"><?= h($KadouSeikeis[$i]["product_code"]) ?></font></td>
            <td colspan="20" nowrap="nowrap"><font color="blue"><?= h($KadouSeikeis[$i]["seikeiki"]." 号機") ?></font></td>
            <td colspan="20" nowrap="nowrap"><font color="blue"><?= h($KadouSeikeis[$i]["program_starting_tm"]) ?></font></td>
            <td colspan="20" nowrap="nowrap"><font color="blue"><?= h($KadouSeikeis[$i]["program_finishing_tm"]) ?></font></td>
            <td colspan="20" nowrap="nowrap"><font color="blue"><?= h($KadouSeikeis[$i]["cycle_shot"]) ?></font></td>
            <td colspan="20" nowrap="nowrap"><font color="blue"><?= h($KadouSeikeis[$i]["shot_cycle"]) ?></font></td>
            <td colspan="20" nowrap="nowrap"><font color="blue"><?= h($KadouSeikeis[$i]["amount_shot"]) ?></font></td>
            <td colspan="20" nowrap="nowrap"><font color="blue"><?= h($KadouSeikeis[$i]["amount_programming"]) ?></font></td>
            <td colspan="20" nowrap="nowrap"><font color="red"><?= h($KadouSeikeis[$i]["accomp_rate_program"] * 100) ?></font><font color="blue"><?= h(" ％") ?></font></td>
            <td colspan="20" nowrap="nowrap"><font color="red"><?= h($KadouSeikeis[$i]["kobetu_loss_time"]) ?></font><font color="blue"><?= h(" 分") ?></font></td>

            <?php
              if($i >= $num && isset($arrGroupcount[$count])){
                $numcell = $arrGroupcount[$count];
                $num = $num + $arrGroupcount[$count];

                $total_loss_time = round((1 - $KadouSeikeis[$num-1]["kadouritsu"]) * 86400 / 60 , 1);
/*
                $total_loss = 0;
                for($n=$i; $n<=$num-1; $n++){
                  $total_loss = $total_loss + $KadouSeikeis[$n]["total_loss_time"];
                }
*/
                echo "<td colspan='20' nowrap='nowrap' rowspan=$numcell><div align='center'><font color='red'>";
                echo $KadouSeikeis[$num-1]["kadouritsu"] * 100;
                echo "<font color='blue'>";
                echo " ％";
                echo "</font>";
                echo "</font></div></td>";
                echo "<td colspan='20' nowrap='nowrap' rowspan=$numcell><div align='center'><font color='red'>";
                echo $total_loss_time;
        //        echo $KadouSeikeis[$num-1]["total_loss_time"];
                echo "<font color='blue'>";
                echo " 分";
                echo "</font>";
                echo "</font></div></td>";

                $count = $count + 1;
                $total_loss = 0;

                $kadouritutotal = $kadouritutotal + $KadouSeikeis[$num-1]["kadouritsu"] * 100;

              }
            ?>

            <td colspan="20" nowrap="nowrap"><font color="red"><?= h($KadouSeikeis[$i]["katagae_time"]) ?></font><font color="blue"><?= h(" 分") ?></font></td>

            <?php
            echo "<td colspan='20' nowrap='nowrap'><div align='center'>";
            echo $this->Form->submit("詳細" , ['action'=>'kensakusyousai', 'name' => $i."_".$KadouSeikeis[$i]["id"]."_".strval($KadouSeikeis[$i]["accomp_rate_program"] * 1000).
            "_".strval($KadouSeikeis[$i]["kobetu_loss_time"] * 1000)."_".strval($KadouSeikeis[$i]["katagae_time"] * 1000)]) ;
            echo "</div></td>";
            ?>
          </tr>
        <?php endfor;?>

        <?php if($countarrNon_data_KadouSeikeis > 0): ?>

          <?php for($i=0; $i<$countarrNon_data_KadouSeikeis; $i++): ?>
          <tr style="border-bottom: solid;border-width: 1px">
            <td colspan="20" nowrap="nowrap"><font color="blue"><?= h($arrNon_data_KadouSeikeis[$i]["product_code"]) ?></font></td>
            <td colspan="20" nowrap="nowrap"><font color="blue"><?= h($arrNon_data_KadouSeikeis[$i]["seikeiki"]." 号機") ?></font></td>
            <td colspan="20" nowrap="nowrap"><font color="blue"><?= h($arrNon_data_KadouSeikeis[$i]["starting_tm"]) ?></font></td>
            <td colspan="20" nowrap="nowrap"><font color="blue"><?= h($arrNon_data_KadouSeikeis[$i]["finishing_tm"]) ?></font></td>
            <td colspan="20" nowrap="nowrap"><font color="blue"><?= h($arrNon_data_KadouSeikeis[$i]["cycle_shot"]) ?></font></td>
            <td colspan="20" nowrap="nowrap"><font color="blue"><?= h("-") ?></font></td>
            <td colspan="20" nowrap="nowrap"><font color="blue"><?= h($arrNon_data_KadouSeikeis[$i]["amount_shot"]) ?></font></td>
            <td colspan="20" nowrap="nowrap"><font color="blue"><?= h("-") ?></font></td>
            <td colspan="20" nowrap="nowrap"><font color="red"><?= h($arrNon_data_KadouSeikeis[$i]["accomp_rate"]*100) ?></font><font color="blue"><?= h(" ％") ?></font></td>
            <td colspan="20" nowrap="nowrap"><font color="red"><font color="blue"><?= h("-") ?></font></td>

            <?php
            
            $numcell = 1;

                echo "<td colspan='20' nowrap='nowrap' rowspan=$numcell><div align='center'><font color='red'>";
                echo "データがありません";
                echo "</font></div></td>";
                echo "<td colspan='20' nowrap='nowrap' rowspan=$numcell><div align='center'><font color='red'>";
                echo "データがありません";
                echo "</font></div></td>";
            ?>

            <td colspan="20" nowrap="nowrap"><font color="red"><?= h("データがありません") ?></font></td>

            <?php
            echo "<td colspan='20' nowrap='nowrap'><div align='center'>";
            echo $this->Form->submit("詳細" , ['action'=>'kensakusyousai', 'name' => $i."_".$arrNon_data_KadouSeikeis[$i]["id"]."_-_-_-"]) ;
            echo "</div></td>";
            ?>
          </tr>
        <?php endfor;?>

    <?php else: ?>
    <?php endif; ?>

        </tbody>
    </table>
<br><br>

<?php else: ?>

  <br><br>
  <table align="center" border="2" bordercolor="#E6FFFF" cellpadding="0" cellspacing="0">
    <tbody border="2" bordercolor="#E6FFFF" bgcolor="#FFFFCC" style="border-bottom: solid;border-width: 1px">
          <thead>
            <tr border="2" bordercolor="#E6FFFF" bgcolor="#FFFFCC">
              <td width="150" height="30" colspan="20" nowrap="nowrap"><div align="center"><strong style="font-size: 10pt; color:#FF66FF">品番</strong></div></td>
              <td width="80" height="30" colspan="20" nowrap="nowrap"><div align="center"><strong style="font-size: 9pt; color:#FF66FF">成形機</strong></div></td>
              <td width="200" height="30" colspan="20" nowrap="nowrap"><div align="center"><strong style="font-size: 10pt; color:#FF66FF">開始時刻</strong></div></td>
              <td width="200" height="30" colspan="20" nowrap="nowrap"><div align="center"><strong style="font-size: 10pt; color:#FF66FF">終了時刻</strong></div></td>
              <td width="80" height="30" colspan="20" nowrap="nowrap"><div align="center"><strong style="font-size: 9pt; color:#FF66FF">ショットサイクル</strong></div></td>
              <td width="100" height="30" colspan="20" nowrap="nowrap"><div align="center"><strong style="font-size: 8pt; color:#FF66FF">日報ショット数</strong></div></td>
              <td width="80" height="30" colspan="20" nowrap="nowrap"><div align="center"><strong style="font-size: 9pt; color:#FF66FF">達成率</strong></div></td>
              <td width="100" height="30" colspan="20" nowrap="nowrap"><div align="center"><strong style="font-size: 10pt; color:#FF66FF">開始ロット</strong></div></td>
              <td width="100" height="30" colspan="20" nowrap="nowrap"><div align="center"><strong style="font-size: 10pt; color:#FF66FF">最終ロット</strong></div></td>
              <td width="60" height="30" colspan="20" nowrap="nowrap"><div align="center"><strong style="font-size: 9pt; color:#FF66FF"></strong></div></td>
            </tr>
          </thead>
          <tbody border="2" bordercolor="#E6FFFF" bgcolor="#FFFFCC">
            <?php for($i=0; $i<count($KadouSeikeis); $i++): ?>
            <tr style="border-bottom: solid;border-width: 1px">
              <td colspan="20" nowrap="nowrap"><font color="blue"><?= h($KadouSeikeis[$i]["product_code"]) ?></font></td>
              <td colspan="20" nowrap="nowrap"><font color="blue"><?= h($KadouSeikeis[$i]["seikeiki"]." 号機") ?></font></td>
              <td colspan="20" nowrap="nowrap"><font color="blue"><?= h($KadouSeikeis[$i]["starting_tm"]) ?></font></td>
              <td colspan="20" nowrap="nowrap"><font color="blue"><?= h($KadouSeikeis[$i]["finishing_tm"]) ?></font></td>
              <td colspan="20" nowrap="nowrap"><font color="blue"><?= h($KadouSeikeis[$i]["cycle_shot"]) ?></font></td>
              <td colspan="20" nowrap="nowrap"><font color="blue"><?= h($KadouSeikeis[$i]["amount_shot"]) ?></font></td>
              <td colspan="20" nowrap="nowrap"><font color="red"><?= h($KadouSeikeis[$i]["accomp_rate"]*100) ?></font><font color="blue"><?= h(" ％") ?></font></td>
              <td colspan="20" nowrap="nowrap"><font color="blue"><?= h($KadouSeikeis[$i]["first_lot_num"]) ?></font></td>
              <td colspan="20" nowrap="nowrap"><font color="blue"><?= h($KadouSeikeis[$i]["last_lot_num"]) ?></font></td>
              <?php
              echo "<td colspan='20' nowrap='nowrap'><div align='center'>";
              echo $this->Form->submit("詳細" , ['action'=>'kensakusyousai', 'name' => $i."_".$KadouSeikeis[$i]["id"]."_-_-_-"]) ;
              echo "</div></td>";
              ?>
            </tr>
          <?php endfor;?>
          </tbody>
      </table>
  <br><br>


<?php endif; ?>
