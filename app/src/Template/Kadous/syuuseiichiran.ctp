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
<?=$this->Form->create($KadouSeikeis, ['url' => ['action' => 'syuuseiform']]) ?>
<br><br>
<table align="center" border="2" bordercolor="#E6FFFF" cellpadding="0" cellspacing="0">
  <tbody border="2" bordercolor="#E6FFFF" bgcolor="#FFFFCC" style="border-bottom: solid;border-width: 1px">
        <thead>
            <tr border="2" bordercolor="#E6FFFF" bgcolor="#FFFFCC">
              <td width="150" height="30" colspan="20" nowrap="nowrap"><div align="center"><strong style="font-size: 10pt; color:#FF66FF">品番</strong></div></td>
              <td width="100" height="30" colspan="20" nowrap="nowrap"><div align="center"><strong style="font-size: 10pt; color:#FF66FF">成型機</strong></div></td>
              <td width="200" height="30" colspan="20" nowrap="nowrap"><div align="center"><strong style="font-size: 10pt; color:#FF66FF">開始時刻</strong></div></td>
              <td width="200" height="30" colspan="20" nowrap="nowrap"><div align="center"><strong style="font-size: 10pt; color:#FF66FF">終了時刻</strong></div></td>
              <td width="180" height="30" colspan="20" nowrap="nowrap"><div align="center"><strong style="font-size: 10pt; color:#FF66FF">ショットサイクル	</strong></div></td>
              <td width="150" height="30" colspan="20" nowrap="nowrap"><div align="center"><strong style="font-size: 10pt; color:#FF66FF">ショット数	</strong></div></td>
              <td width="150" height="30" colspan="20" nowrap="nowrap"><div align="center"><strong style="font-size: 10pt; color:#FF66FF">達成率	</strong></div></td>
            </tr>
        </thead>
        <tbody border="2" bordercolor="#E6FFFF" bgcolor="#FFFFCC">
          <?php foreach ($KadouSeikeis as $KadouSeikeis): ?>
          <tr style="border-bottom: solid;border-width: 1px">
            <?php
            echo "<td colspan='20' nowrap='nowrap'><div align='center'><font color='blue'>";
            echo $this->Html->link($KadouSeikeis->product_code , ['action'=>'syuuseiform', 'name' => "select", 'id' => $KadouSeikeis->id, 'value1' => $KadouSeikeis->product_code, 'value2' => $KadouSeikeis->seikeiki, 'value3' => $KadouSeikeis->starting_tm->format('Y-m-d H:i:s')]) ;
            echo "</div></font></td>";
            ?>
            <td colspan="20" nowrap="nowrap"><font color="blue"><?= h($KadouSeikeis->seikeiki." 号機") ?></font></td>
            <td colspan="20" nowrap="nowrap"><font color="blue"><?= h($KadouSeikeis->starting_tm->format('Y-m-d H:i:s')) ?></font></td>
            <td colspan="20" nowrap="nowrap"><font color="blue"><?= h($KadouSeikeis->finishing_tm->format('Y-m-d H:i:s')) ?></font></td>
            <td colspan="20" nowrap="nowrap"><font color="blue"><?= h($KadouSeikeis->cycle_shot) ?></font></td>
            <td colspan="20" nowrap="nowrap"><font color="blue"><?= h($KadouSeikeis->amount_shot) ?></font></td>
            <td colspan="20" nowrap="nowrap"><font color="red"><?= h($KadouSeikeis->accomp_rate) ?></font><font color="blue"><?= h(" ％") ?></font></td>
          </tr>
          <?php endforeach; ?>
        </tbody>
    </table>
<br><br>
