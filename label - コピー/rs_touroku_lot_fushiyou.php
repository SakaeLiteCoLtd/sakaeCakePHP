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
$lot_num = $_POST['lot_num'];

$check_arr_lot = array();
for($i=0;$i<count($product_id);$i++){

	$db->query("set names sjis");
	$updater = "UPDATE check_lots set flag_used = 1 where product_id ='".$product_id[$i]."' and lot_num = '".$lot_num[$i]."'";
	$db->query($updater);


	$db->query("set names sjis");
	$sql = "select product_id,lot_num from check_lots where product_id = '".$product_id[$i]."' ".
			"and lot_num = '".$lot_num[$i]."' and flag_used = 1";

	$rs=$db->query($sql);


	while($row=$rs->fetchRow(MDB2_FETCHMODE_ASSOC)){

		$check_arr_lot[] = array("product_id"=>$row['product_id'],"lot_num"=>$row['lot_num']);

	}

}

unset($_POST['product_id']);
unset($_POST['lot_num']);

	$smarty->assign("value",$updater);

	$mess = "ˆÈã‚Ì‚æ‚¤‚É“o˜^‚³‚ê‚Ü‚µ‚½B";
	$smarty->assign("check_arr_lot",$check_arr_lot);
	$smarty->assign("mess",$mess);
	$smarty->assign("pre_tag","<!--");
	$smarty->assign("last_tag","--!>");
	$smarty->assign("semi_header",$html_semiheader->semi_header());
	$smarty->assign("header",$html_yobidashi->header());
	$smarty->display("kakunin_lot_fushiyou.tpl");
	unset($smarty);
	unset($db);
	exit;


?>