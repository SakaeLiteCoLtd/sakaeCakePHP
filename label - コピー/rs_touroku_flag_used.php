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

$id = $_POST['id'];
$name = $_POST['name'];

	$db->query("set names sjis");
	$insertr = "INSERT INTO name_lot_flag_used (id,name) values (".$id.",'".$name."')";
	$db->query($insertr);

	$db->query("set names sjis");
	$rs=$db->query("select id,name from name_lot_flag_used where id = '".$id."'");

	$label = array();
	while($row=$rs->fetchRow(MDB2_FETCHMODE_ASSOC)){

		$rs_id = $row['id'];
		$rs_name = $row['name'];

	}

	


	$smarty->assign("value",$insertr);

	$mess = "ˆÈã‚Ì‚æ‚¤‚É“o˜^‚³‚ê‚Ü‚µ‚½B";
	$smarty->assign("id",$rs_id);
	$smarty->assign("name",$rs_name);
	$smarty->assign("mess",$mess);
	$smarty->assign("semi_header",$html_semiheader->semi_header());
	$smarty->assign("header",$html_yobidashi->header());
	$smarty->display("rs_touroku_flag_used.tpl");
	unset($smarty);
	unset($db);
	exit;


?>