<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\Deliver $product
 */
 use App\myClass\Shinkimenus\htmlShinkimenu;//myClassフォルダに配置したクラスを使用

 $htmlShinkimenu = new htmlShinkimenu();
 $htmlShinkis = $htmlShinkimenu->Shinkimenus();
 ?>
<?= $this->Form->create($product, ['url' => ['action' => 'preadd']]) ?>
        <?php
            $username = $this->request->Session()->read('Auth.User.username');

            $session = $this->request->getSession();

            $session->write('productdata.product_code', $_POST['product_code']);
            $session->write('productdata.product_name', $_POST['product_name']);
            $session->write('productdata.customer_id', $customer_id);
            $session->write('productdata.place_deliver_id', $_POST['place_deliver_id']);
            $session->write('productdata.material_kind', $_POST['material_kind']);
    //        $session->write('productdata.material_id', $_POST['material_id']);
            $session->write('productdata.m_grade', $_POST['m_grade']);
            $session->write('productdata.col_num', $_POST['col_num']);
            $session->write('productdata.color', $_POST['color']);
            $session->write('productdata.weight', $_POST['weight']);
            $session->write('productdata.torisu', $_POST['torisu']);
    //        $session->write('productdata.cycle', $_POST['cycle']);
            $session->write('productdata.primary_p', 1);
            $session->write('productdata.gaityu', 0);
            $session->write('productdata.status', 0);
            $session->write('productdata.delete_flag', 0);
            $session->write('productdata.created_staff', $_POST['created_staff']);

            $session->write('customerdata.customer_code', $Customer_code);

            if(!empty($_POST['price'])){
              $price = $_POST['price'];
            }else{
              $price = 0;
            }

            $session->write('pricedata.product_code', $_POST['product_code']);
            $session->write('pricedata.price', $price);
            $session->write('pricedata.date_koushin', date('Y-m-d'));
            $session->write('pricedata.tourokubi', date('Y-m-d H:i:s'));
            $session->write('pricedata.delete_flag', 0);
            $session->write('pricedata.created_staff', $_POST['created_staff']);
            $session->write('pricedata.created_at', date('Y-m-d H:i:s'));

            $session->write('konpoudata.product_code', $_POST['product_code']);
            $session->write('konpoudata.irisu', $_POST['irisu']);
            $session->write('konpoudata.id_box', $_POST['id_box']);
            $session->write('konpoudata.delete_flag', 0);
            $session->write('konpoudata.created_staff', $_POST['created_staff']);
            $session->write('konpoudata.created_at', date('Y-m-d H:i:s'));

            $session->write('katakouzoudata.product_code', $_POST['product_code']);
            $session->write('katakouzoudata.kataban', $_POST['kataban']);
            $session->write('katakouzoudata.status', 0);
            $session->write('katakouzoudata.torisu', $_POST['torisu']);
            $session->write('katakouzoudata.set_tori', $_POST['set_tori']);
            $session->write('katakouzoudata.delete_flag', 0);
            $session->write('katakouzoudata.created_staff', $_POST['created_staff']);
            $session->write('katakouzoudata.created_at', date('Y-m-d H:i:s'));

            $session->write('zensudata.product_code', $_POST['product_code']);
            $session->write('zensudata.shot_cycle', $_POST['shot_cycle']);
            $session->write('zensudata.kijyun', $_POST['kijyun']);
            $session->write('zensudata.kariunyou', 1);
            $session->write('zensudata.status', 0);
            $session->write('zensudata.staff_code', $_POST['created_staff']);
            $session->write('zensudata.datetime_touroku', date('Y-m-d H:i:s'));
            $session->write('zensudata.delete_flag', 0);
            $session->write('zensudata.created_at', date('Y-m-d H:i:s'));
            $session->write('zensudata.created_staff', $_POST['created_staff']);
/*
            $data = $session->read();
            echo "<pre>";
      	    print_r($data);
      	    echo "</pre>";
*/
        ?>
        <hr size="5" style="margin: 0.5rem">
        <table style="margin-bottom:0px" width="750" border="0" align="center" cellpadding="0" cellspacing="0" bordercolor="#CCCCCC">
        <?php
           echo $htmlShinkis;
        ?>
        </table>
        <hr size="5" style="margin: 0.5rem">
        <br>

    <?php
    if($_POST['set_tori'] == 0){
      $set = "NO";
    }else{
      $set = "YES";
    }
    $mes = "※SET取のときは、1SETの合計重量を単重として考えてください！";
/*
    if($_POST['kariunyou'] == 0){
      $kariunyou = "運用";
    }else{
      $kariunyou = "仮運用";
    }
*/
    ?>

    <table align="center" border="2" bordercolor="#E6FFFF" cellpadding="0" cellspacing="0" style="border-bottom: solid;border-width: 1px">
      <tr>
        <td width="280" bgcolor="#FFFFCC" style="font-size: 8pt;padding: 0.2rem"><strong style="font-size: 11pt; color:blue">品番</strong></td>
        <td width="282" bgcolor="#FFFFCC" style="font-size: 8pt;padding: 0.2rem"><strong style="font-size: 11pt; color:blue">品名</strong></td>
    	</tr>
      <tr>
        <td bgcolor="#FFFFCC" style="padding: 0.2rem"><?= h($this->request->getData('product_code')) ?></td>
        <td bgcolor="#FFFFCC" style="padding: 0.2rem"><?= h($this->request->getData('product_name')) ?></td>
    	</tr>
    </table>
    <table align="center" border="2" bordercolor="#E6FFFF" cellpadding="0" cellspacing="0" style="border-bottom: solid;border-width: 1px">
      <tr>
        <td width="280" bgcolor="#FFFFCC"  colspan="2" style="font-size: 12pt;padding: 0.2rem"><strong style="font-size: 11pt; color:blue">グレード　　　　　　色番号</strong></td>
        <td width="282" bgcolor="#FFFFCC" style="font-size: 12pt;padding: 0.2rem"><strong style="font-size: 11pt; color:blue">色調</strong></td>
    	</tr>
      <tr>
        <td  width="140" bgcolor="#FFFFCC" style="padding: 0.2rem"><?= h($this->request->getData('m_grade')) ?></td>
        <td width="140"  bgcolor="#FFFFCC" style="padding: 0.2rem"><?= h($this->request->getData('col_num')) ?></td>
        <td  width="280" bgcolor="#FFFFCC" style="padding: 0.2rem"><?= h($this->request->getData('color')) ?></td>
    	</tr>
    </table>
    <table align="center" border="2" bordercolor="#E6FFFF" cellpadding="0" cellspacing="0" style="border-bottom: solid;border-width: 1px">
      <tr>
        <td width="280" bgcolor="#FFFFCC" style="font-size: 12pt;padding: 0.2rem"><strong style="font-size: 11pt; color:blue">原料の種類</strong></td>
        <td width="280" colspan="2" bgcolor="#FFFFCC" style="font-size: 12pt;padding: 0.2rem"><strong style="font-size: 11pt; color:blue">単価（円/kg）</strong></td>
    	</tr>
      <tr>
        <td width="280"  bgcolor="#FFFFCC" style="padding: 0.2rem"><?= h($this->request->getData('material_kind')) ?></td>
        <td width="140" bgcolor="#FFFFCC" style="text-align: right;border-right-style: none;padding: 0.2rem"><?= h($this->request->getData('price')) ?></td>
        <td width="140" bgcolor="#FFFFCC" style="text-align: left;border-left-style: none;padding: 0.2rem"><strong style="font-size: 11pt; color:blue">円/kg</strong></td>
    	</tr>
    </table>
    <table align="center" border="2" bordercolor="#E6FFFF" cellpadding="0" cellspacing="0" style="border-bottom: solid;border-width: 1px">
      <tr>
        <td width="280" colspan="2" bgcolor="#FFFFCC" style="font-size: 12pt;padding: 0.2rem"><strong style="font-size: 11pt; color:blue">単重</strong></td>
        <td width="280" bgcolor="#FFFFCC" style="font-size: 12pt;padding: 0.2rem"><strong style="font-size: 11pt; color:blue">金型No.</strong></td>
    	</tr>
      <tr>
        <td  width="140" bgcolor="#FFFFCC" style="text-align: right;border-right-style: none;padding: 0.2rem"><?= h($this->request->getData('weight')) ?></td>
        <td width="140" bgcolor="#FFFFCC" style="text-align: left;border-left-style: none;padding: 0.2rem"><strong style="font-size: 13pt; color:blue">g</strong></td>
        <td width="280"  bgcolor="#FFFFCC" style="padding: 0.2rem"><?= h($this->request->getData('kataban')) ?></td>
    	</tr>
    </table>
    <table align="center" border="2" bordercolor="#E6FFFF" cellpadding="0" cellspacing="0" style="border-bottom: solid;border-width: 1px">
      <tr>
        <td width="280" colspan="3" bgcolor="#FFFFCC" style="font-size: 8pt;padding: 0.2rem"><strong style="font-size: 11pt; color:blue">SET取り</strong></td>
        <td width="280" colspan="2" bgcolor="#FFFFCC" style="font-size: 12pt;padding: 0.2rem"><strong style="font-size: 11pt; color:blue">金型取数</strong></td>
    	</tr>
      <tr>
        <td bgcolor="#FFFFCC" style="border-right-style: none;padding: 0.2rem"><strong style="font-size: 13pt; color:blue"></strong></td>
        <td bgcolor="#FFFFCC" style="border-right-style: none;border-left-style: none;padding: 0.2rem"><?= h($set) ?></td>
        <td bgcolor="#FFFFCC" style="border-left-style: none;padding: 0.2rem"><strong style="font-size: 13pt; color:blue"></strong></td>
        <td  width="140" bgcolor="#FFFFCC" style="text-align: right;border-right-style: none;padding: 0.2rem"><?= h($this->request->getData('torisu')) ?></td>
        <td width="140" bgcolor="#FFFFCC" style="text-align: left;border-left-style: none;padding: 0.2rem"><strong style="font-size: 13pt; color:blue">ヶ取</strong></td>
    	</tr>
    </table>
    <table align="center" border="2" bordercolor="#E6FFFF" cellpadding="0" cellspacing="0" style="border-bottom: solid;border-width: 1px">
      <tr>
        <td width="250" colspan="2" bgcolor="#FFFFCC" style="font-size: 12pt;padding: 0.2rem"><strong style="font-size: 11pt; color:blue">入数</strong></td>
        <td width="280" bgcolor="#FFFFCC" style="font-size: 12pt;padding: 0.2rem"><strong style="font-size: 11pt; color:blue">箱No.</strong></td>
    	</tr>
      <tr>
        <td  width="140" bgcolor="#FFFFCC" style="text-align: right;border-right-style: none;padding: 0.2rem"><?= h($this->request->getData('irisu')) ?></td>
        <td width="140" bgcolor="#FFFFCC" style="text-align: left;border-left-style: none;padding: 0.2rem"><strong style="font-size: 13pt; color:blue">ヶ</strong></td>
        <td width="280"  bgcolor="#FFFFCC" style="padding: 0.2rem"><?= h($BoxKonpous) ?></td>
    	</tr>
    </table>
    <?php
/*
    <table align="center" border="2" bordercolor="#E6FFFF" cellpadding="0" cellspacing="0" style="border-bottom: solid;border-width: 1px">
      <tr>
        <td width="560" bgcolor="#FFFFCC" style="font-size: 12pt;padding: 0.2rem"><strong style="font-size: 11pt; color:blue">顧客</strong></td>
    	</tr>
      <tr>
        <td bgcolor="#FFFFCC" style="padding: 0.2rem"><?= h($Customer) ?></td>
    	</tr>
    </table>
*/
    ?>
    <table align="center" border="2" bordercolor="#E6FFFF" cellpadding="0" cellspacing="0" style="border-bottom: solid;border-width: 1px">
      <tr>
        <td width="280" bgcolor="#FFFFCC" style="font-size: 12pt;padding: 0.2rem"><strong style="font-size: 11pt; color:blue">ショットサイクル</strong></td>
        <td width="280" colspan="2" bgcolor="#FFFFCC" style="font-size: 12pt;padding: 0.2rem"><strong style="font-size: 11pt; color:blue">外観検査基準時間</strong></td>
    	</tr>
      <tr>
        <td width="280" bgcolor="#FFFFCC" style="padding: 0.2rem"><?= h($this->request->getData('shot_cycle')) ?></td>
        <td  width="140" bgcolor="#FFFFCC" style="text-align: right;border-right-style: none;padding: 0.2rem"><?= h($this->request->getData('kijyun')) ?></td>
        <td width="140" bgcolor="#FFFFCC" style="text-align: left;border-left-style: none;padding: 0.2rem"><strong style="font-size: 13pt; color:blue">分</strong></td>
    	</tr>
    </table>

    <table align="center" border="2" bordercolor="#E6FFFF" cellpadding="0" cellspacing="0" style="border-bottom: solid;border-width: 1px">
      <tr>
        <td width="560" bgcolor="#FFFFCC" style="font-size: 12pt;padding: 0.2rem"><strong style="font-size: 11pt; color:blue">出荷先</strong></td>
    	</tr>
      <tr>
        <td bgcolor="#FFFFCC" style="padding: 0.2rem"><?= h($PlaceDeliver) ?></td>
    	</tr>
    </table>


<br><br>
<table align="center" border="2" bordercolor="#E6FFFF" cellpadding="0" cellspacing="0">
<tr>
  <td style="border-style: none;"><div align="center"><?= $this->Form->submit('戻る', ['onclick' => 'history.back()', 'type' => 'button']); ?></div></td>
  <td style="border-style: none;"><div align="center"><?= $this->Form->submit('追加', array('name' => 'kakunin')); ?></div></td>
</tr>
</table>
<br>
<?= $this->Form->end() ?>
