<?php
require_once("MySmarty.class.php");
$smarty=new MySmarty();
$db=$smarty->getDb();
require_once("../HTML_yobidashi.class.php");
$html_yobidashi = new HTML_yobidashi();
require_once("semiHTML.class.php");
$html_semiheader = new HTML_semiheader();
$today = date("Y-m-d");

$unit = $_POST['unit'];


	$db->query("set names sjis");
	$insertr_unit = "INSERT INTO label_element_unit (unit,genjyou) values ('".$unit."','0')";
	$db->query($insertr_unit);



		$db->query("set names sjis");
		$kakunin_unit=$db->query("select * from label_element_unit  where unit = '".$unit."'");

		while($row=$kakunin_unit->fetchRow(MDB2_FETCHMODE_ASSOC)){

			$result_unit=$row['unit'];


		}

	$mess = "ˆÈã‚Ì‚æ‚¤‚É“o˜^‚³‚ê‚Ü‚µ‚½B";

	$smarty->assign("unit",$result_unit);
	$smarty->assign("mess",$mess);
	$smarty->assign("semi_header",$html_semiheader->semi_header());
	$smarty->assign("header",$html_yobidashi->header());
	$smarty->display("kakunin_touroku_unit.tpl");
	unset($smarty);
	unset($db);
	exit;


?>