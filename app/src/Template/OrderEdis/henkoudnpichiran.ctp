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
 <?php
   $username = $this->request->Session()->read('Auth.User.username');
   use Cake\ORM\TableRegistry;//独立したテーブルを扱う
   $this->Products = TableRegistry::get('products');
   $this->PlaceDelivers = TableRegistry::get('placeDelivers');
   echo $this->Form->create($orderEdis, ['url' => ['action' => 'henkoudnpform']]);
   $i = 1 ;
?>
<?php
header('Expires:-1');
header('Cache-Control:');
header('Pragma:');

  $data = $this->request->getData();
  $Data=$this->request->query();

  if(isset($Data["s"]["Pro"])){
    $Pro=$Data["s"]["Pro"];
    echo $this->Form->hidden('Pro' ,['value'=>$Data["s"]["Pro"]]);
  }else{
    $Pro=$data["Pro"];
    echo $this->Form->hidden('Pro' ,['value'=>$data["Pro"]]);
  }

?>

 </table>
 <hr size="5" style="margin: 0.5rem">
 <br>
 <table style="margin-bottom:0px" width="750" border="0" align="center" cellpadding="0" cellspacing="0" bordercolor="#CCCCCC">
             <tr style="background-color: #E6FFFF">
               <td style="padding: 0.1rem 0.1rem;"><a href="qr/index.php"><?php echo $this->Html->image('Labelimg/edi_henkou_order.gif',array('width'=>'85','height'=>'36','url'=>array('controller'=>'OrderEdis','action'=>'henkousentakucustomer')));?></td>
             </tr>
 </table>
 <br><br>
 <table style="margin-bottom:0px" width="750" border="0" align="center" cellpadding="0" cellspacing="0" bordercolor="#CCCCCC">
             <tr style="background-color: #E6FFFF">
               <td style="padding: 0.1rem 0.1rem;"><a href="qr/index.php"><?php echo $this->Html->image('Labelimg/button_dnp.gif',array('width'=>'85','height'=>'33','url'=>array('controller'=>'OrderEdis','action'=>'henkoudnpselectproduct')));?></td>
             </tr>
 </table>
<br><br>

<?php if($Pro == "BON"): ?>

<table style="margin-bottom:0px" width="750" border="0" align="center" cellpadding="0" cellspacing="0" bordercolor="#CCCCCC">
            <tr style="background-color: #E6FFFF">
              <td style="padding: 0.1rem 0.1rem;"><a href="qr/index.php"><?php echo $this->Html->image('Labelimg/push_button_bon.gif',array('width'=>'85','height'=>'33','url'=>array('controller'=>'OrderEdis','action'=>'henkoudnpsearch','Pro'=>'BON')));?></td>
              <td style="padding: 0.1rem 0.1rem;"><a href="qr/index.php"><?php echo $this->Html->image('Labelimg/button_cas.gif',array('width'=>'85','height'=>'33','url'=>array('controller'=>'OrderEdis','action'=>'henkoudnpsearch','Pro'=>'CAS')));?></td>
              <td style="padding: 0.1rem 0.1rem;"><a href="qr/index.php"><?php echo $this->Html->image('Labelimg/button_mld.gif',array('width'=>'85','height'=>'33','url'=>array('controller'=>'OrderEdis','action'=>'henkoudnpsearch','Pro'=>'MLD')));?></td>
            </tr>
</table>

<?php elseif($Pro == "CAS"): ?>

  <table style="margin-bottom:0px" width="750" border="0" align="center" cellpadding="0" cellspacing="0" bordercolor="#CCCCCC">
              <tr style="background-color: #E6FFFF">
                <td style="padding: 0.1rem 0.1rem;"><a href="qr/index.php"><?php echo $this->Html->image('Labelimg/button_bon.gif',array('width'=>'85','height'=>'33','url'=>array('controller'=>'OrderEdis','action'=>'henkoudnpsearch','Pro'=>'BON')));?></td>
                <td style="padding: 0.1rem 0.1rem;"><a href="qr/index.php"><?php echo $this->Html->image('Labelimg/push_button_cas.gif',array('width'=>'85','height'=>'33','url'=>array('controller'=>'OrderEdis','action'=>'henkoudnpsearch','Pro'=>'CAS')));?></td>
                <td style="padding: 0.1rem 0.1rem;"><a href="qr/index.php"><?php echo $this->Html->image('Labelimg/button_mld.gif',array('width'=>'85','height'=>'33','url'=>array('controller'=>'OrderEdis','action'=>'henkoudnpsearch','Pro'=>'MLD')));?></td>
              </tr>
  </table>

<?php else: ?>

  <table style="margin-bottom:0px" width="750" border="0" align="center" cellpadding="0" cellspacing="0" bordercolor="#CCCCCC">
              <tr style="background-color: #E6FFFF">
                <td style="padding: 0.1rem 0.1rem;"><a href="qr/index.php"><?php echo $this->Html->image('Labelimg/button_bon.gif',array('width'=>'85','height'=>'33','url'=>array('controller'=>'OrderEdis','action'=>'henkoudnpsearch','Pro'=>'BON')));?></td>
                <td style="padding: 0.1rem 0.1rem;"><a href="qr/index.php"><?php echo $this->Html->image('Labelimg/button_cas.gif',array('width'=>'85','height'=>'33','url'=>array('controller'=>'OrderEdis','action'=>'henkoudnpsearch','Pro'=>'CAS')));?></td>
                <td style="padding: 0.1rem 0.1rem;"><a href="qr/index.php"><?php echo $this->Html->image('Labelimg/push_button_mld.gif',array('width'=>'85','height'=>'33','url'=>array('controller'=>'OrderEdis','action'=>'henkoudnpsearch','Pro'=>'MLD')));?></td>
              </tr>
  </table>

<?php endif; ?>

<br>
<hr size="5" style="margin: 0.5rem">
<table align="center" border="2" bordercolor="#E6FFFF" cellpadding="0" cellspacing="0">
  <tbody border="2" bordercolor="#E6FFFF" bgcolor="#FFFFCC" style="border-bottom: solid;border-width: 1px">
    <tr style="border-bottom: 0px;border-width: 0px">
      <td width="250" height="60" colspan="20" nowrap="nowrap"><div align="center"><strong style="font-size: 15pt; color:blue">品番</strong></div></td>
      <td width="500" colspan="40" nowrap="nowrap"><div align="center"><strong style="font-size: 15pt; color:blue">納期絞り込み</strong></div></td>
    </tr>

<?php
      $Data=$this->request->query('s');
      if(isset($Data)){
        $product_code = $Data['product_code'];
        $date_sta = $Data['date_sta'];
        $date_fin = $Data['date_fin'];
      }else{
        $dateYMD = date('Y-m-d');
        $product_code = $data['product_code'];
        $date_sta = $data['date_sta'];
        $date_fin = $data['date_fin'];
      }

      echo "<tr style='border-bottom: 0px;border-width: 0px'>\n";
      echo "<td rowspan='2'  height='6' colspan='20'>\n";
      echo "<input type='text' name=product_code size='6'/>\n";
      echo "</td>\n";
      echo "<td width='50' colspan='3' style='border-bottom: 0px'><div align='center'><strong style='font-size: 15pt; color:blue'>\n";
      echo "開始";
      echo "</strong></div></td>\n";
      echo "<td width='350' colspan='37' style='border-bottom: 0px'><div align='center'>\n";
      echo "<input type='date' value=$date_sta name=date_sta empty=Please select size='6'/>\n";
      echo "</div></td>\n";
      echo "</tr>\n";
      echo "<tr style='border-bottom: 0px;border-width: 0px'>\n";
      echo "<td colspan='3'><div align='center'><strong style='font-size: 15pt; color:blue'>\n";
      echo "終了";
      echo "</strong></div></td>\n";
      echo "<td colspan='37'><div align='center'>\n";
      echo "<input type='date' value=$date_fin name=date_fin size='6'/>\n";
      echo "</div></td>\n";
      echo "</tr>\n";
 ?>
<br>
<table align="center" border="2" bordercolor="#E6FFFF" cellpadding="0" cellspacing="0">
<tr>
<br>
<td style="border-style: none;"><div align="center"><?= $this->Form->submit('検索', array('name' => 'kensaku')); ?></div></td>
</tr>
</table>
<br><br><br><br>

<?php if(isset($data["subete"])): ?>
  <form method="post" action="henkou4pana" enctype="multipart/form-data">

  <table align="right" border="2" bordercolor="#E6FFFF" cellpadding="0" cellspacing="0">
  <tr>
  <td style="border-style: none;"><div align="center"><?= $this->Form->submit('全てチェック解除', array('name' => 'kaijo')); ?></div></td>
  </tr>
  </table>

  <table align="center" border="2" bordercolor="#E6FFFF" cellpadding="0" cellspacing="0">
    <tbody border="2" bordercolor="#E6FFFF" bgcolor="#FFFFCC" style="border-bottom: solid;border-width: 1px">
          <thead>
              <tr border="2" bordercolor="#E6FFFF" bgcolor="#FFFFCC">
                <td width="30" height="30" colspan="10" nowrap="nowrap"><div align="center"><strong style="font-size: 12pt; color:blue"></strong></div></td>
                <td width="150" height="30" colspan="20" nowrap="nowrap"><div align="center"><strong style="font-size: 12pt; color:blue">注文ＮＯ</strong></div></td>
                <td width="150" height="30" colspan="20" nowrap="nowrap"><div align="center"><strong style="font-size: 12pt; color:blue">品番</strong></div></td>
                <td width="200" height="30" colspan="20" nowrap="nowrap"><div align="center"><strong style="font-size: 12pt; color:blue">品名</strong></div></td>
                <td width="50" height="30" colspan="20" nowrap="nowrap"><div align="center"><strong style="font-size: 12pt; color:blue">納品数</strong></div></td>
                <td width="200" height="30" colspan="20" nowrap="nowrap"><div align="center"><strong style="font-size: 12pt; color:blue">納期</strong></div></td>
                <td width="50" height="30" colspan="20" nowrap="nowrap"><div align="center"><strong style="font-size: 12pt; color:blue">納品場所</strong></div></td>
              </tr>
          </thead>
          <tbody border="2" bordercolor="#E6FFFF" bgcolor="#FFFFCC">
              <?php foreach ($orderEdis as $orderEdis): ?>
                <?php
                $i = $i + 1 ;
                $this->set('i',$i);
                 ?>
              <tr style="border-bottom: solid;border-width: 1px">
                <?php
                echo "<td colspan='10' nowrap='nowrap'>\n";
                echo "<input type='checkbox' name=check".$i." checked='checked' size='6'/>\n";
                echo "<input type='hidden' name=".$i." value=$orderEdis->id size='6'/>\n";//チェックされたもののidをキープする
                echo "</td>\n";
                ?>
                <td width="150" colspan="20" nowrap="nowrap"><?= h($orderEdis->num_order) ?></td>
                <td width="150" colspan="20" nowrap="nowrap"><?= h($orderEdis->product_code) ?></td>
                  <?php
                    $product_code = $orderEdis->product_code;
                		$Product = $this->Products->find()->where(['product_code' => $product_code])->toArray();
                		$product_name = $Product[0]->product_name;
                  ?>
                <td width="200" colspan="20" nowrap="nowrap"><?= h($product_name) ?></td>
                <td width="100" colspan="20" nowrap="nowrap"><?= h($orderEdis->amount) ?></td>
              <?php
                    $dateYMD = date('Y-m-d');
                    $date_deliver = $orderEdis->date_deliver->format('Y-m-d');
                    echo "<td width='200' colspan='20'><div align='center'>\n";
                    echo "<input type='date' value=$date_deliver name=date_deliver empty=Please select size='6'/>\n";
                    echo "</div></td>\n";

                    $PlaceDeliver = $this->PlaceDelivers->find()->where(['id_from_order' => $orderEdis->place_deliver_code])->toArray();
                    $place = $PlaceDeliver[0]->name;
               ?>
                <td width="150" colspan="20" nowrap="nowrap"><?= h($place) ?></td>
              </tr>
              <?php endforeach; ?>

             <?php
              echo "<input type='hidden' name='nummax' value=$i size='6'/>\n";
              ?>

          </tbody>
      </table>
  <br>
  <table align="left" border="2" bordercolor="#E6FFFF" cellpadding="0" cellspacing="0">
  <tr>
  <td style="border-style: none;"><div align="center"><?= $this->Form->submit('日付変更', array('name' => 'nouki')); ?></div></td>
  <td style="border-style: none;"><div align="center"><?= $this->Form->submit('分納', array('name' => 'bunnnou')); ?></div></td>
  </tr>
  </table>
  <?=$this->Form->end() ?>
</form>

<?php else: ?>
  <form method="post" action="henkou4pana" enctype="multipart/form-data">

  <table align="right" border="2" bordercolor="#E6FFFF" cellpadding="0" cellspacing="0">
  <tr>
  <td style="border-style: none;"><div align="center"><?= $this->Form->submit('全て選択', array('name' => 'subete')); ?></div></td>
  </tr>
  </table>
  <table align="center" border="2" bordercolor="#E6FFFF" cellpadding="0" cellspacing="0">
    <tbody border="2" bordercolor="#E6FFFF" bgcolor="#FFFFCC" style="border-bottom: solid;border-width: 1px">
          <thead>
              <tr border="2" bordercolor="#E6FFFF" bgcolor="#FFFFCC">
                <td width="30" height="30" colspan="10" nowrap="nowrap"><div align="center"><strong style="font-size: 12pt; color:blue"></strong></div></td>
                <td width="150" height="30" colspan="20" nowrap="nowrap"><div align="center"><strong style="font-size: 12pt; color:blue">注文ＮＯ</strong></div></td>
                <td width="150" height="30" colspan="20" nowrap="nowrap"><div align="center"><strong style="font-size: 12pt; color:blue">品番</strong></div></td>
                <td width="200" height="30" colspan="20" nowrap="nowrap"><div align="center"><strong style="font-size: 12pt; color:blue">品名</strong></div></td>
                <td width="50" height="30" colspan="20" nowrap="nowrap"><div align="center"><strong style="font-size: 12pt; color:blue">納品数</strong></div></td>
                <td width="200" height="30" colspan="20" nowrap="nowrap"><div align="center"><strong style="font-size: 12pt; color:blue">納期</strong></div></td>
                <td width="50" height="30" colspan="20" nowrap="nowrap"><div align="center"><strong style="font-size: 12pt; color:blue">納品場所</strong></div></td>
              </tr>
          </thead>
          <tbody border="2" bordercolor="#E6FFFF" bgcolor="#FFFFCC">
              <?php foreach ($orderEdis as $orderEdis): ?>
                <?php
                $i = $i + 1 ;
                $this->set('i',$i);
                 ?>
              <tr style="border-bottom: solid;border-width: 1px">
                <?php
                echo "<td colspan='10' nowrap='nowrap'>\n";
                echo "<input type='checkbox' name=check".$i."  size='6'/>\n";
                echo "<input type='hidden' name=".$i." value=$orderEdis->id size='6'/>\n";//チェックされたもののidをキープする
                echo "</td>\n";
                ?>
                <td width="150" colspan="20" nowrap="nowrap"><?= h($orderEdis->num_order) ?></td>
                <td width="150" colspan="20" nowrap="nowrap"><?= h($orderEdis->product_code) ?></td>
                  <?php
                    $product_code = $orderEdis->product_code;
                		$Product = $this->Products->find()->where(['product_code' => $product_code])->toArray();
                		$product_name = $Product[0]->product_name;
                  ?>
                <td width="200" colspan="20" nowrap="nowrap"><?= h($product_name) ?></td>
                <td width="100" colspan="20" nowrap="nowrap"><?= h($orderEdis->amount) ?></td>
              <?php
                    $dateYMD = date('Y-m-d');
                    $date_deliver = $orderEdis->date_deliver->format('Y-m-d');
                    echo "<td width='200' colspan='20'><div align='center'>\n";
                    echo "<input type='date' value=$date_deliver name=date_deliver empty=Please select size='6'/>\n";
                    echo "</div></td>\n";

                    $PlaceDeliver = $this->PlaceDelivers->find()->where(['id_from_order' => $orderEdis->place_deliver_code])->toArray();
                    $place = $PlaceDeliver[0]->name;
               ?>
                <td width="150" colspan="20" nowrap="nowrap"><?= h($place) ?></td>
              </tr>
              <?php endforeach; ?>

             <?php
              echo "<input type='hidden' name='nummax' value=$i size='6'/>\n";
              ?>

          </tbody>
      </table>
  <br>
  <table align="left" border="2" bordercolor="#E6FFFF" cellpadding="0" cellspacing="0">
  <tr>
  <td style="border-style: none;"><div align="center"><?= $this->Form->submit('日付変更', array('name' => 'nouki')); ?></div></td>
  <td style="border-style: none;"><div align="center"><?= $this->Form->submit('分納', array('name' => 'bunnnou')); ?></div></td>
  <td style="border-style: none;"><legend align="center"><font color="red"><?= __("※分納は１行のみ選択してください。") ?></font></legend></td>
  </tr>
  </table>
  <?=$this->Form->end() ?>
</form>

<?php endif; ?>
