<?php
require_once("MySmarty.class.php");
$smarty=new MySmarty();
require_once("Date_yobidashi.class.php");
$date_yobidashi =new Date_yobidashi();
require_once("../HTML_yobidashi.class.php");
$html_yobidashi = new HTML_yobidashi();
$smarty->assign("header",$html_yobidashi->header());
require_once("semiHTML.class.php");
$html_semiheader = new HTML_semiheader();
$smarty->assign("semi_header",$html_semiheader->semi_header());

$db=$smarty->getDb();
$today = date("Y-m-d");
require_once("Select.class.php");
$html_select = new Select();
require_once("Date_yobidashi.class.php");
$date_yobidashi =new Date_yobidashi();
require_once("../qr/QrCode.class.php");
$QrCode =new QrCode();
$today = date("Y-m-d");
require_once("Check.class.php");
$Check = new Check();

$QrCode->getQr($_POST['qrLot']);
$fushiyou_product_id = $QrCode->get_product_id1();
$fushiyou_lot_num = $QrCode->get_lot_num();
$fushiyou_amount = $QrCode->get_amount1();

	$smarty->assign("fushiyou_product_id",$fushiyou_product_id);
	$smarty->assign("fushiyou_lot_num",$fushiyou_lot_num);
	$smarty->display("pre_touroku_lot_syukkateishi.tpl");
	unset($smarty);
	unset($db);
	exit;


?>