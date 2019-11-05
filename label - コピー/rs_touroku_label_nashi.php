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

$Check->check_product($product_id);
$product_rows = $Check->get_rows();

if($product_rows == 0 ){

	$smarty->assign("mess","•i”Ô‚Í–¢“o˜^‚Å‚·B");

	$smarty->assign("pre_tag","<!--");
	$smarty->assign("last_tag","--!>");
	$smarty->display("error_input.tpl");
	unset($smarty);
	unset($db);
	exit;

}


$Check->check_label_nashi($product_id);
$rows = $Check->get_rows();

if($rows > 0 ){

	$smarty->assign("mess","Šù‚É“o˜^Ï‚Å‚·B");

	$smarty->assign("pre_tag","<!--");
	$smarty->assign("last_tag","--!>");
	$smarty->display("error_input.tpl");
	unset($smarty);
	unset($db);
	exit;

}


	$db->query("set names sjis");
	$insertr = "INSERT INTO label_nashi (product_id,tourokubi) values ('".$product_id."','".$today."')";
	$db->query($insertr);

	$db->query("set names sjis");
	$rs=$db->query("select product_id from label_nashi where product_id = '".$product_id."'");

	$label = array();
	while($row=$rs->fetchRow(MDB2_FETCHMODE_ASSOC)){

		$rs_product_id = $row['product_id'];

	}

	


	$smarty->assign("value",$insertr);

	$mess = "ˆÈã‚Ì‚æ‚¤‚É“o˜^‚³‚ê‚Ü‚µ‚½B";
	$smarty->assign("rs_product_id",$rs_product_id);
	$smarty->assign("mess",$mess);
	$smarty->assign("semi_header",$html_semiheader->semi_header());
	$smarty->assign("header",$html_yobidashi->header());
	$smarty->display("rs_touroku_label_nashi.tpl");
	unset($smarty);
	unset($db);
	exit;


?>