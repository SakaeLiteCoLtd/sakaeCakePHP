<?php
require_once("MySmarty.class.php");
$smarty=new MySmarty();
$db=$smarty->getDb();
require_once("../HTML_yobidashi.class.php");
$html_yobidashi = new HTML_yobidashi();
require_once("semiHTML.class.php");
$html_semiheader = new HTML_semiheader();
$smarty->assign("semi_header",$html_semiheader->semi_header());

require_once("Date_yobidashi.class.php");
$date_yobidashi =new Date_yobidashi();

$today= date("Y-m-d", time() + 86400);


	$date_yobidashi->select_date($today,0);
	$syear=$date_yobidashi->get_year();
	$sele_syear=$date_yobidashi->get_selected_year();
	$smonth=$date_yobidashi->get_month();
	$sele_smonth=$date_yobidashi->get_selected_month();
	$sday=$date_yobidashi->get_day();
	$sele_sday=$date_yobidashi->get_selected_day();

	$smarty->assign("syear",$syear);
	$smarty->assign("selected_syear",$sele_syear);
	$smarty->assign("smonth",$smonth);
	$smarty->assign("selected_smonth",$sele_smonth);
	$smarty->assign("sday",$sday);
	$smarty->assign("selected_sday",$sele_sday);
	$smarty->assign("header",$html_yobidashi->header());
	$smarty->display("index_hasu_hakkou.tpl");
	unset($smarty);
	unset($db);
	exit;


?>