<?php
$this->layout = 'defaultshinki';
?>
<?php
/**
 * AuthHelper: Authの変数にアクセスできる
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\Deliver $product
 */
 use App\myClass\Shinkimenus\htmlShinkimenu;//myClassフォルダに配置したクラスを使用

 $htmlShinkimenu = new htmlShinkimenu();
 $htmlShinkis = $htmlShinkimenu->Shinkimenus();
 ?>
<?= $this->Form->create($product, ['url' => ['action' => 'form']]) ?>

<?php
$username = $this->request->Session()->read('Auth.User.username');
$session = $this->request->getSession();
$product_code = $session->read('productdata.product_code');
$product_name = $session->read('productdata.product_name');
$multiple_cs = $session->read('productdata.multiple_cs');
$weight = $session->read('productdata.weight');
$torisu = $session->read('productdata.torisu');
$m_grade = $session->read('productdata.m_grade');
$col_num = $session->read('productdata.col_num');
$color = $session->read('productdata.color');
$material_kind = $session->read('productdata.material_kind');
$price = $session->read('pricedata.price');
$irisu = $session->read('konpoudata.irisu');
$kataban = $session->read('katakouzoudata.kataban');
$shot_cycle = $session->read('zensudata.shot_cycle');
$kijyun = $session->read('zensudata.kijyun');

if($session->read('katakouzoudata.set_tori') == 0){
  $set = "NO";
}else{
  $set = "YES";
}

?>
<hr size="5">
<table style="margin-bottom:0px" width="750" border="0" align="center" cellpadding="0" cellspacing="0" bordercolor="#CCCCCC">
<?php

   echo $htmlShinkis;

?>
</table>
<hr size="5">

<legend align="center"><font color="red"><?= __($mes) ?></font></legend>
<br>

<table align="center" border="2" bordercolor="#E6FFFF" cellpadding="0" cellspacing="0" style="border-bottom: solid;border-width: 1px">
  <tr>
    <td width="280" bgcolor="#FFFFCC" style="font-size: 8pt;padding: 0.2rem"><strong style="font-size: 11pt; color:blue">品番</strong></td>
    <td width="280" bgcolor="#FFFFCC" style="font-size: 8pt;padding: 0.2rem"><strong style="font-size: 11pt; color:blue">品名</strong></td>
  </tr>
  <tr>
    <td bgcolor="#FFFFCC" style="padding: 0.2rem"><?= h($product_code) ?></td>
    <td bgcolor="#FFFFCC" style="padding: 0.2rem"><?= h($product_name) ?></td>
  </tr>
</table>
<table align="center" border="2" bordercolor="#E6FFFF" cellpadding="0" cellspacing="0" style="border-bottom: solid;border-width: 1px">
  <tr>
    <td width="280" bgcolor="#FFFFCC"  colspan="2" style="font-size: 12pt;padding: 0.2rem"><strong style="font-size: 11pt; color:blue">グレード　　　　　　色番号</strong></td>
    <td width="280" bgcolor="#FFFFCC" style="font-size: 12pt;padding: 0.2rem"><strong style="font-size: 11pt; color:blue">色調</strong></td>
  </tr>
  <tr>
    <td  width="140" bgcolor="#FFFFCC" style="padding: 0.2rem"><?= h($m_grade) ?></td>
    <td width="140"  bgcolor="#FFFFCC" style="padding: 0.2rem"><?= h($col_num) ?></td>
    <td  width="280" bgcolor="#FFFFCC" style="padding: 0.2rem"><?= h($color) ?></td>
  </tr>
</table>
<table align="center" border="2" bordercolor="#E6FFFF" cellpadding="0" cellspacing="0" style="border-bottom: solid;border-width: 1px">
  <tr>
    <td width="280" bgcolor="#FFFFCC" style="font-size: 12pt;padding: 0.2rem"><strong style="font-size: 11pt; color:blue">原料の種類</strong></td>
    <td width="280" colspan="2" bgcolor="#FFFFCC" style="font-size: 12pt;padding: 0.2rem"><strong style="font-size: 11pt; color:blue">単価（円/個）</strong></td>
  </tr>
  <tr>
    <td width="280"  bgcolor="#FFFFCC" style="padding: 0.2rem"><?= h($material_kind) ?></td>
    <td width="140" bgcolor="#FFFFCC" style="text-align: right;border-right-style: none;padding: 0.2rem"><?= h($price) ?></td>
    <td width="140" bgcolor="#FFFFCC" style="text-align: left;border-left-style: none;padding: 0.2rem"><strong style="font-size: 11pt; color:blue">円/個</strong></td>
  </tr>
</table>
<table align="center" border="2" bordercolor="#E6FFFF" cellpadding="0" cellspacing="0" style="border-bottom: solid;border-width: 1px">
  <tr>
    <td width="280" colspan="2" bgcolor="#FFFFCC" style="font-size: 12pt;padding: 0.2rem"><strong style="font-size: 11pt; color:blue">単重</strong></td>
    <td width="280" bgcolor="#FFFFCC" style="font-size: 12pt;padding: 0.2rem"><strong style="font-size: 11pt; color:blue">金型No.</strong></td>
  </tr>
  <tr>
    <td  width="140" bgcolor="#FFFFCC" style="text-align: right;border-right-style: none;padding: 0.2rem"><?= h($weight) ?></td>
    <td width="140" bgcolor="#FFFFCC" style="text-align: left;border-left-style: none;padding: 0.2rem"><strong style="font-size: 13pt; color:blue">g</strong></td>
    <td width="280"  bgcolor="#FFFFCC" style="padding: 0.2rem"><?= h($kataban) ?></td>
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
    <td  width="140" bgcolor="#FFFFCC" style="text-align: right;border-right-style: none;padding: 0.2rem"><?= h($torisu) ?></td>
    <td width="140" bgcolor="#FFFFCC" style="text-align: left;border-left-style: none;padding: 0.2rem"><strong style="font-size: 13pt; color:blue">ヶ取</strong></td>
  </tr>
</table>
<table align="center" border="2" bordercolor="#E6FFFF" cellpadding="0" cellspacing="0" style="border-bottom: solid;border-width: 1px">
  <tr>
    <td width="250" colspan="2" bgcolor="#FFFFCC" style="font-size: 12pt;padding: 0.2rem"><strong style="font-size: 11pt; color:blue">入数</strong></td>
    <td width="280" bgcolor="#FFFFCC" style="font-size: 12pt;padding: 0.2rem"><strong style="font-size: 11pt; color:blue">箱No.</strong></td>
  </tr>
  <tr>
    <td  width="140" bgcolor="#FFFFCC" style="text-align: right;border-right-style: none;padding: 0.2rem"><?= h($irisu) ?></td>
    <td width="140" bgcolor="#FFFFCC" style="text-align: left;border-left-style: none;padding: 0.2rem"><strong style="font-size: 13pt; color:blue">ヶ</strong></td>
    <td width="280"  bgcolor="#FFFFCC" style="padding: 0.2rem"><?= h($BoxKonpous) ?></td>
  </tr>
</table>
<table align="center" border="2" bordercolor="#E6FFFF" cellpadding="0" cellspacing="0" style="border-bottom: solid;border-width: 1px">
  <tr>
    <td width="280" bgcolor="#FFFFCC" style="font-size: 12pt;padding: 0.2rem"><strong style="font-size: 11pt; color:blue">ショットサイクル</strong></td>
    <td width="280"  colspan="2"  bgcolor="#FFFFCC" style="font-size: 12pt;padding: 0.2rem"><strong style="font-size: 11pt; color:blue">外観検査基準時間</strong></td>
  </tr>
  <tr>
    <td width="280" bgcolor="#FFFFCC" style="padding: 0.2rem"><?= h($shot_cycle) ?></td>
    <td  width="140" bgcolor="#FFFFCC" style="text-align: right;border-right-style: none;padding: 0.2rem"><?= h($kijyun) ?></td>
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


    <br>
    <table align="center" border="2" bordercolor="#E6FFFF" cellpadding="0" cellspacing="0">
    <tr>
      <td style="border-style: none;"><div align="center"><?= $this->Form->submit(__('登録画面へ'), array('name' => 'top')); ?></div></td>
    </tr>
    </table>
    <br>
