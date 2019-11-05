<?php
require_once("MySmarty.class.php");
$smarty=new MySmarty();
$db=$smarty->getDb();
require_once("../HTML_yobidashi.class.php");
$html_yobidashi = new HTML_yobidashi();
require_once("semiHTML.class.php");
$html_semiheader = new HTML_semiheader();
$smarty->assign("semi_header",$html_semiheader->semi_header());
require_once("../qr/QrCode.class.php");
$QrCode =new QrCode();


$QrCode->getEmpQr($_POST['emp_id']);
$emp_id = $QrCode->get_emp_id();
$kind = $QrCode->get_kind();
$emp_rows = $QrCode->get_rows();
if($emp_rows == 0){

	$mess = "社員証ではない、QRコードが読み込まれました。";

	$smarty->assign("mess",$mess);
	$smarty->display("error_input.tpl");
	unset($smarty);
	unset($db);
	exit;

}

	$smarty->assign("emp_id",$QrCode->get_emp_id());
	$smarty->assign("f_name",$QrCode->get_f_name());
	$smarty->assign("l_name",$QrCode->get_l_name());
	$smarty->assign("header",$html_yobidashi->header());
	$smarty->display("form_lot_syukkateishi.tpl");
	unset($smarty);
	unset($db);
	exit;


?>