<?php
require_once("MySmarty.class.php");
$smarty=new MySmarty();
$db=$smarty->getDb();
require_once("../HTML_yobidashi.class.php");
$html_yobidashi = new HTML_yobidashi();
require_once("semiHTML.class.php");
$html_semiheader = new HTML_semiheader();
$smarty->assign("semi_header",$html_semiheader->semi_header());

	$label_kensaku = "<label><input type='submit' name='kensaku' id='button' value='ŒŸõ' /></label>";

	$smarty->assign("label_kensaku",$label_kensaku);
	$smarty->assign("type","text");
	$smarty->assign("arr_lot",$arr_lot);
	$smarty->assign("header",$html_yobidashi->header());
	$smarty->display("form_kensaku_hasu_lot.tpl");
	unset($smarty);
	unset($db);
	exit;


?>