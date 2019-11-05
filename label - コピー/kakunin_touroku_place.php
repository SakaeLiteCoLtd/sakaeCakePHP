<?php
require_once("MySmarty.class.php");
$smarty=new MySmarty();
$db=$smarty->getDb();
require_once("../HTML_yobidashi.class.php");
$html_yobidashi = new HTML_yobidashi();
require_once("semiHTML.class.php");
$html_semiheader = new HTML_semiheader();
$today = date("Y-m-d");

$place1 = $_POST['place1'];
$place2 = $_POST['place2'];

$button = "<input type='submit' name='button' id='button' value='“o˜^' />";

	$smarty->assign("place1",$place1);
	$smarty->assign("place2",$place2);
	$smarty->assign("button",$button);
	$smarty->assign("semi_header",$html_semiheader->semi_header());
	$smarty->assign("header",$html_yobidashi->header());
	$smarty->display("kakunin_touroku_place.tpl");
	unset($smarty);
	unset($db);
	exit;


?>