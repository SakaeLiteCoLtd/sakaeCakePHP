<?php
require_once("MySmarty.class.php");
$smarty=new MySmarty();
$db=$smarty->getDb();
require_once("../HTML_yobidashi.class.php");
$html_yobidashi = new HTML_yobidashi();
require_once("semiHTML.class.php");
$html_semiheader = new HTML_semiheader();
$today = date("Y-m-d");

	$mess = "1�s�����K�v�̂Ȃ��Ƃ��́A�[�i�ꏊ�P�̋󗓂݂̂ɋL������B";
	$smarty->assign("mess",$mess);
	$smarty->assign("semi_header",$html_semiheader->semi_header());
	$smarty->assign("header",$html_yobidashi->header());
	$smarty->display("form_touroku_place.tpl");
	unset($smarty);
	unset($db);
	exit;


?>