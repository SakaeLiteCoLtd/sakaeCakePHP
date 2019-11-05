<?php
require_once("MySmarty.class.php");
$smarty=new MySmarty();
$db=$smarty->getDb();
require_once("../HTML_yobidashi.class.php");
$html_yobidashi = new HTML_yobidashi();
require_once("semiHTML.class.php");
$html_semiheader = new HTML_semiheader();
$smarty->assign("semi_header",$html_semiheader->semi_header());


	$smarty->assign("header",$html_yobidashi->header());
	$smarty->display("index_touroku_hasu.tpl");
	unset($smarty);
	unset($db);
	exit;


?>