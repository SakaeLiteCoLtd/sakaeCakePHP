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
require_once("../qr/SelectSql.class.php");
$SelectSql =new SelectSql();

	$QrCode->getEmpQr($_POST['emp_id']);
	$emp_id = $QrCode->get_emp_id();

	$SelectSql->select_employee($emp_id);
	$full_name = $SelectSql->get_full_name();

	$smarty->assign("emp_id",$emp_id);
	$smarty->assign("full_name",$emp_id."F".$full_name);
	$smarty->assign("header",$html_yobidashi->header());
	$smarty->display("qr_touroku_hasu.tpl");
	unset($smarty);
	unset($db);
	exit;


?>