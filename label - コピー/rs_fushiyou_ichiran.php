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
require_once("Date_yobidashi.class.php");
$date_yobidashi =new Date_yobidashi();

$select_syear = $_POST['syear'];
$select_smonth = $_POST['smonth'];
$select_sday = $_POST['sday'];

$s_mk = mktime(0, 0, 0, $select_smonth, $select_sday, $select_syear);

$date = date("Y-m-d",$s_mk);

$s_date_hakkou = $select_syear."-".$select_smonth."-".$select_sday;

$select_fyear = $_POST['fyear'];
$select_fmonth = $_POST['fmonth'];
$select_fday = $_POST['fday'];

$f_mk = mktime(0, 0, 0, $select_fmonth, $select_fday, $select_fyear);

$f_date_hakkou = $select_fyear."-".$select_fmonth."-".$fselect_day;

$num_among_days = ($f_mk - $s_mk) / 86400;

$ichiran =array();
for($i=0;$i<=$num_among_days;$i++){

	$date1 = date("Y-m-d", $s_mk);
	$next_mk = $s_mk + 86400;
	$date2 = date("Y-m-d", $next_mk);

	$db->query("set names sjis");
	$rs_making_lot = $db->query("select id from check_lots where  ".
		" datetime_hakkou >= '".$date1." 8:00' and datetime_hakkou <= '".$date2." 8:00'");
	$rows_making_lot=$rs_making_lot->numRows();

	if($i==1){
	$mess ="select id from check_lots where  ".
		" datetime_hakkou >= '".$date1." 8:00' and datetime_hakkou <= '".$date2." 8:00'";
	}

	$db->query("set names sjis");
	$rs_fushiyou_lot = $db->query("select id from check_lots where flag_used = 1 ".
		" and datetime_hakkou >= '".$date1." 8:00' and datetime_hakkou <= '".$date2." 8:00'");
	$rows_fushiyou_lot=$rs_fushiyou_lot->numRows();

	$db->query("set names sjis");
	$rs_kinshi_lot = $db->query("select id from check_lots where flag_used = 2 ".
		" and datetime_hakkou >= '".$date1." 8:00' and datetime_hakkou <= '".$date2." 8:00'");
	$rows_kinshi_lot=$rs_kinshi_lot->numRows();

	$db->query("set names sjis");
	$rs_zaiko_lot = $db->query("select id from check_lots where flag_deliver is NULL and flag_used = 0 and lot_num not like 'IN_%'".
		" and datetime_hakkou >= '".$date1." 8:00' and datetime_hakkou <= '".$date2." 8:00'");
	$rows_zaiko_lot=$rs_zaiko_lot->numRows();

	if($rows_making_lot > 0){

		$ichiran[] = array("date"=>$date1,"num_making_lot"=>$rows_making_lot,"num_fushiyou"=>$rows_fushiyou_lot,
					"num_kinshi_lot"=>$rows_kinshi_lot,"num_zaiko"=>$rows_zaiko_lot);

	}

	$s_mk = $next_mk;

}
	$date_yobidashi->select_date($s_date_hakkou,0);
	$syear=$date_yobidashi->get_year();
	$sele_syear=$date_yobidashi->get_selected_year();
	$smonth=$date_yobidashi->get_month();
	$sele_smonth=$date_yobidashi->get_selected_month();
	$sday=$date_yobidashi->get_day();
	$sele_sday=$date_yobidashi->get_selected_day();

	$date_yobidashi->select_date($f_date_hakkou,0);
	$fyear=$date_yobidashi->get_year();
	$sele_fyear=$date_yobidashi->get_selected_year();
	$fmonth=$date_yobidashi->get_month();
	$sele_fmonth=$date_yobidashi->get_selected_month();
	$fday=$date_yobidashi->get_day();
	$sele_fday=$date_yobidashi->get_selected_day();

	$smarty->assign("syear",$syear);
	$smarty->assign("selected_syear",$_POST['syear']);
	$smarty->assign("smonth",$smonth);
	$smarty->assign("selected_smonth",$_POST['smonth']);
	$smarty->assign("sday",$sday);
	$smarty->assign("selected_sday",$_POST['sday']);

	$smarty->assign("fyear",$fyear);
	$smarty->assign("selected_fyear",$_POST['fyear']);
	$smarty->assign("fmonth",$fmonth);
	$smarty->assign("selected_fmonth",$_POST['fmonth']);
	$smarty->assign("fday",$fday);
	$smarty->assign("selected_fday",$_POST['fday']);
	$smarty->assign("header",$html_yobidashi->header());

	$smarty->assign("value",$updater);

	$smarty->assign("ichiran",$ichiran);
	$smarty->assign("mess","");
	//$smarty->assign("pre_tag","<!--");
	//$smarty->assign("last_tag","--!>");
	$smarty->assign("semi_header",$html_semiheader->semi_header());
	$smarty->assign("header",$html_yobidashi->header());
	$smarty->display("rs_fushiyou_ichiran.tpl");
	unset($smarty);
	unset($db);
	exit;


?>