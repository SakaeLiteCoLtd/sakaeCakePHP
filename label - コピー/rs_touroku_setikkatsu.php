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

$product_id1 = $_POST['product_id1'];
$product_id2 = $_POST['product_id2'];

$Check->check_product($product_id1);
$product1_rows = $Check->get_rows();

if($product1_rows == 0 ){

	$smarty->assign("mess","•i”Ô1‚Í–¢“o˜^‚Å‚·B");

	$smarty->assign("pre_tag","<!--");
	$smarty->assign("last_tag","--!>");
	$smarty->display("error_input.tpl");
	unset($smarty);
	unset($db);
	exit;

}

$Check->check_product($product_id2);
$product2_rows = $Check->get_rows();

if($product2_rows == 0 ){

	$smarty->assign("mess","•i”Ô2‚Í–¢“o˜^‚Å‚·B");

	$smarty->assign("pre_tag","<!--");
	$smarty->assign("last_tag","--!>");
	$smarty->display("error_input.tpl");
	unset($smarty);
	unset($db);
	exit;

}

$Check->check_setikkatsu($product_id1,$product_id2);
$set_rows = $Check->get_rows();

if($set_rows > 0 ){

	$smarty->assign("mess","Šù‚É“o˜^Ï‚Å‚·B");

	$smarty->assign("pre_tag","<!--");
	$smarty->assign("last_tag","--!>");
	$smarty->display("error_input.tpl");
	unset($smarty);
	unset($db);
	exit;

}


	$db->query("set names sjis");
	$insertr = "INSERT INTO label_setikkatsu (product_id1,product_id2,tourokubi) values ('".$product_id1."','".$product_id2."','".$today."')";
	$db->query($insertr);

	$db->query("set names sjis");
	$rs=$db->query("select product_id1,product_id2 from label_setikkatsu where product_id1 = '".$product_id1."'");

	$label = array();
	while($row=$rs->fetchRow(MDB2_FETCHMODE_ASSOC)){

		$rs_product_id1 = $row['product_id1'];
		$rs_product_id2 = $row['product_id2'];

	}

	


	$smarty->assign("value",$insertr);

	$mess = "ˆÈã‚Ì‚æ‚¤‚É“o˜^‚³‚ê‚Ü‚µ‚½B";
	$smarty->assign("rs_product_id1",$rs_product_id1);
	$smarty->assign("rs_product_id2",$rs_product_id2);
	$smarty->assign("mess",$mess);
	$smarty->assign("semi_header",$html_semiheader->semi_header());
	$smarty->assign("header",$html_yobidashi->header());
	$smarty->display("rs_touroku_setikkatsu.tpl");
	unset($smarty);
	unset($db);
	exit;


?>