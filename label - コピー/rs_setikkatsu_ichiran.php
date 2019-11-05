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
	$sql = "select product_id1,product_id2 from label_setikkatsu  order by product_id1";
	$rs=$db->query($sql);

	$ichiran =array();
	$i = 0;
	while($row=$rs->fetchRow(MDB2_FETCHMODE_ASSOC)){

		$checked = "";
		$radio = "<input type='checkbox' name='target_p".$i."' value='1' ".$checked.">";
		$ichiran[] = array("radio"=>$radio,"product_id1"=>$row['product_id1'],"product_id2"=>$row['product_id2']);
		$i++;
	}

	$smarty->assign("value",$updater);

	$smarty->assign("ichiran",$ichiran);
	$smarty->assign("mess",$mess);
	//$smarty->assign("pre_tag","<!--");
	//$smarty->assign("last_tag","--!>");
	$smarty->assign("semi_header",$html_semiheader->semi_header());
	$smarty->assign("header",$html_yobidashi->header());
	$smarty->display("rs_setikkatsu_ichiran.tpl");
	unset($smarty);
	unset($db);
	exit;


?>