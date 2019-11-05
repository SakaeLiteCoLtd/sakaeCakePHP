<?php
require_once("MySmarty.class.php");
$smarty=new MySmarty();
$db=$smarty->getDb();
require_once("../HTML_yobidashi.class.php");
$html_yobidashi = new HTML_yobidashi();
require_once("semiHTML.class.php");
$html_semiheader = new HTML_semiheader();
require_once("Select.class.php");
$html_select = new Select();
$today = date("Y-m-d");
require_once("Check.class.php");
$Check = new Check();

$product_id = $_POST['product_id'];

	$db->query("set names sjis");
	$updater = "DELETE label_label_nashi  where product_id = '".$product_id."'";
	$rs=$db->query($updater);

	$mess = $product_id ."‚ÍAíœ‚µ‚Ü‚µ‚½B";

	$smarty->assign("mess",$mess);
	$smarty->assign("pre_tag","<!--");
	$smarty->assign("last_tag","--!>");
	$smarty->assign("semi_header",$html_semiheader->semi_header());
	$smarty->assign("header",$html_yobidashi->header());
	$smarty->display("rs_label_nashi_ichiran.tpl");
	unset($smarty);
	unset($db);
	exit;


?>