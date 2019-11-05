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
$num_inside = $_POST['num_inside'];

$Check->check_box_insideout($product_id,$num_inside);
$konpou_rows = $Check->get_konpou_rows();
$checker = $Check->get_checker();


	$db->query("set names sjis");
	$updater = "UPDATE label_insideout set num_inside = ".$num_inside." where product_id = '".$product_id."'";
	$rs=$db->query($updater);

	$db->query("set names sjis");
	$sql = "select a.product_id,b.product_name,a.num_inside from label_insideout as a ".
		"inner join product as b on a.product_id=b.product_id  ".
		" where a.product_id = '".$product_id."'";
	$rs=$db->query($sql);

	$raido = "";
	$ichiran =array();
	while($row=$rs->fetchRow(MDB2_FETCHMODE_ASSOC)){

		$ichiran[] = array("radio"=>$radio,"product_id"=>$row['product_id'],"product_name"=>$row['product_name'],"num_inside"=>$row['num_inside']);

	}

	$mess = "ˆÈã‚Ì‚æ‚¤‚É•ÏX‚¢‚½‚µ‚Ü‚µ‚½B";

	$smarty->assign("ichiran",$ichiran);
	$smarty->assign("mess",$mess);
	$smarty->assign("pre_tag","<!--");
	$smarty->assign("last_tag","--!>");
	$smarty->assign("semi_header",$html_semiheader->semi_header());
	$smarty->assign("header",$html_yobidashi->header());
	$smarty->display("rs_insideout_ichiran.tpl");
	unset($smarty);
	unset($db);
	exit;


?>