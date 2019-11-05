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

if($konpou_rows == 0 or $checker == 1){

	if($konpou_rows == 0){

		$smarty->assign("mess","«•ï‚Ì“ü‚è”‚ª“o˜^‚³‚ê‚Ä‚¢‚Ü‚¹‚ñB");

	}elseif($checker == 1){

		$smarty->assign("mess","‚»‚Ì’†g‘Ü”‚Å‚ÍAŠ„‚èØ‚ê‚Ü‚¹‚ñB");

	}
	$smarty->assign("pre_tag","<!--");
	$smarty->assign("last_tag","--!>");
	$smarty->display("error_input.tpl");
	unset($smarty);
	unset($db);
	exit;

}

$irisu = $Check->get_irisu();

	$db->query("set names sjis");
	$insertr = "INSERT INTO label_insideout (product_id,num_inside) values ('".$product_id."',".$num_inside.")";
	$db->query($insertr);

	$db->query("set names sjis");
	$rs=$db->query("select product_id,num_inside from label_insideout where product_id = '".$product_id."'");

	$label = array();
	while($row=$rs->fetchRow(MDB2_FETCHMODE_ASSOC)){

		$rs_product_id = $row['product_id'];
		$rs_num_inside = $row['num_inside'];

	}

	


	$smarty->assign("value",$insertr);

	$mess = "ˆÈã‚Ì‚æ‚¤‚É“o˜^‚³‚ê‚Ü‚µ‚½B";
	$smarty->assign("product_id",$rs_product_id);
	$smarty->assign("num_inside",$rs_num_inside);
	$smarty->assign("mess",$mess);
	$smarty->assign("semi_header",$html_semiheader->semi_header());
	$smarty->assign("header",$html_yobidashi->header());
	$smarty->display("rs_touroku_insideout.tpl");
	unset($smarty);
	unset($db);
	exit;


?>