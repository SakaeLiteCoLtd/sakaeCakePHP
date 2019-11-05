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
require_once("SelectSql.class.php");
$SelectSql = new SelectSql();

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

$arr_table =array();
for($i=0;$i<=$num_among_days;$i++){

	$target_date = date("Y-m-d", $s_mk);
	$button_kannou = "";
	$button_minou = "";
	$SelectSql->select_datebetsu_deliver($target_date);
	$arr_deliver = $SelectSql->get_data();

	for($j=0;$j<count($arr_deliver);$j++){

		$Check->check_deliver_flag($target_date,$arr_deliver[$j]['place_deliver_id']);
		$hantei = $Check->get_hantei();
		$arr_mikan = $Check->get_arr_mikan();
		$arr_kannou = $Check->get_arr_kannou();
		if($hantei > 0){//ñ¢î[Ç™Ç†ÇÈÇ»ÇÁ

			$button_minou .= "<strong><a href='rs_check_kannou.php?target=".$target_date."_".$arr_deliver[$j]['place_deliver_id']."'>".$arr_deliver[$j]['name']."</a></strong>Å@Å@";

		}else{

			$button_kannou .= "<strong><a href='rs_check_kannou.php?target=".$target_date."_".$arr_deliver[$j]['place_deliver_id']."'>".$arr_deliver[$j]['name']."</a></strong>Å@Å@";

		}

	}

	$arr_table[] = array("row"=>"<tr>\n".
			"<td bgcolor='#FFFFCC'><div align='center'><strong>".$target_date."</strong><input type='hidden' name='target_date[]' value='".$target_date."' /></div></td>\n".
			"<td bgcolor='#FFFFCC'><div align='center'><font size = '-2'>".$button_kannou."</font></div></td>\n".
			"<td bgcolor='#FFFFCC'><div align='center'><font size = '-2'>".$button_minou."</font></div></td>\n".
			"</tr>\n");

	$s_mk = $s_mk + 86400;

}

	$pre_table ="<table width='800' border='0' align='left' bgcolor='#666666'>\n".
			"<tr>\n".
			"<td width='150' bgcolor='#FFFFCC'><div align='center'><font color='#0000FF'><strong>ì˙ït</strong></font></div></td>\n".
			"<td width='350' bgcolor='#FFFFCC'><div align='center'><font color='#0000FF'><strong>äÆî[</strong></font></div></td>\n".
			"<td width='350' bgcolor='#FFFFCC'><div align='center'><font color='#0000FF'><strong>ñ¢î[</strong></font></div></td>\n".
			"</tr>\n";
	$last_table = "</table>\n";

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

	$smarty->assign("pre_table",$pre_table);
	$smarty->assign("last_table",$last_table);
	$smarty->assign("arr_table",$arr_table);
	$smarty->assign("mess","");
	//$smarty->assign("pre_tag","<!--");
	//$smarty->assign("last_tag","--!>");
	$smarty->assign("semi_header",$html_semiheader->semi_header());
	$smarty->assign("header",$html_yobidashi->header());
	$smarty->display("index_check_kannou.tpl");
	unset($smarty);
	unset($db);
	exit;


?>