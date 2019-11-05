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

	$db->query("set names sjis");
	$updater = "UPDATE label_setikkatsu set product_id2 = ".$product_id2." where product_id1 = '".$product_id1."'";
	$rs=$db->query($updater);

	$db->query("set names sjis");
	$sql = "select product_id1,product_id2 from label_setikkatsu ".
		" where product_id1 = '".$product_id1."'";
	$rs=$db->query($sql);

	$raido = "";
	$ichiran =array();
	while($row=$rs->fetchRow(MDB2_FETCHMODE_ASSOC)){

		$ichiran[] = array("radio"=>$radio,"product_id1"=>$row['product_id1'],"product_id2"=>$row['product_id2']);

	}

	$mess = "ˆÈã‚Ì‚æ‚¤‚É•ÏX‚¢‚½‚µ‚Ü‚µ‚½B";

	$smarty->assign("ichiran",$ichiran);
	$smarty->assign("mess",$mess);
	$smarty->assign("pre_tag","<!--");
	$smarty->assign("last_tag","--!>");
	$smarty->assign("semi_header",$html_semiheader->semi_header());
	$smarty->assign("header",$html_yobidashi->header());
	$smarty->display("rs_setikkatsu_ichiran.tpl");
	unset($smarty);
	unset($db);
	exit;


?>