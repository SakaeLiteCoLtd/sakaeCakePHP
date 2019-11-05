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

$button = "<input type='submit' name='button' id='button' value='“o˜^' />";

	$smarty->assign("unit",$unit);
	$smarty->assign("button",$button);
	$smarty->assign("semi_header",$html_semiheader->semi_header());
	$smarty->assign("header",$html_yobidashi->header());
	$smarty->display("kakunin_touroku_unit.tpl");
	unset($smarty);
	unset($db);
	exit;


?>