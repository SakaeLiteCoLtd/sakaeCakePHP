<?php
require_once("MySmarty.class.php");
$smarty=new MySmarty();
$db=$smarty->getDb();
require_once("../HTML_yobidashi.class.php");
$html_yobidashi = new HTML_yobidashi();
require_once("semiHTML.class.php");
$html_semiheader = new HTML_semiheader();
require_once("../qr/Select.class.php");
$html_select = new Select();
$today = date("Y-m-d");
require_once("../qr/Check.class.php");
$Check = new Check();
require_once("../qr/Date_yobidashi.class.php");
$date_yobidashi =new Date_yobidashi();
require_once("../qr/QrCode.class.php");
$QrCode =new QrCode();
require_once("../qr/InsertSql.class.php");
$InsertSql =new InsertSql();
require_once("../qr/SelectSql.class.php");
$SelectSql =new SelectSql();


$emp_id = $_POST['emp_id'];
$f_name = $_POST['f_name'];
$l_name = $_POST['l_name'];

$date_tanaoroshi = $year."-".$month."-".$day;

$product_id1="";
$lot_num="";
$checker="";
	//QrCodeをカンマで分割し、各要素を取得する
	if($_POST['qrLot'] <> ""){

		$QrCode->getQr($_POST['qrLot']);
		$product_id1 = $QrCode->get_product_id1();
		$product_id2 = $QrCode->get_product_id2();
		$amount1 = $QrCode->get_amount1();
		$amount2 = $QrCode->get_amount2();
		$lot_num = $QrCode->get_lot_num();
		$date_hakkou = $QrCode->get_date_hakkou();

		$InsertSql->updateSyukkateishiLot($product_id1,$product_id2,$lot_num,$emp_id);
		$data=$InsertSql->get_data();

	}

		$smarty->assign("emp_id",$emp_id);
		$smarty->assign("f_name",$f_name);
		$smarty->assign("l_name",$l_name);
		$smarty->assign("value",$InsertSql->get_mess());
		$smarty->assign("data",$data);
		//$smarty->assign("pre_tag","<!--");
		//$smarty->assign("last_tag","--!>");
		$smarty->assign("semi_header",$html_semiheader->semi_header());
		$smarty->assign("header",$html_yobidashi->header());
		$smarty->display("form_lot_syukkateishi.tpl");
		unset($smarty);
		unset($db);
		exit;


?>