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
$today = date("Y-m-d");
$today= date("Y-m-d", time() );
$yesterday = date("Y-m-d", time() -86400);

//成形開始時間
$starting_time = "09:00";
			
$date_yobidashi->select_date($yesterday,1);

$starting_year = $date_yobidashi->get_year();
$starting_month = $date_yobidashi->get_month();
$starting_day = $date_yobidashi->get_day();

//成形終了時間


$date_yobidashi->select_date($yesterday,1);
$finishing_year = $date_yobidashi->get_year();
$finishing_month = $date_yobidashi->get_month();
$finishing_day = $date_yobidashi->get_day();

$data[]=array(  
		"starting_year"=>$starting_year,"selected_starting_year"=>$selected_starting_year,
		"starting_month"=>$starting_month,"selected_starting_month"=>$selected_starting_month,
		"starting_day"=>$starting_day,"selected_starting_day"=>$selected_starting_day,
		"starting_hour"=>$starting_hour,"selected_starting_hour"=>$selected_starting_hour,
		"starting_minute"=>$starting_minute,"selected_starting_minute"=>$selected_starting_minute,
		"finishing_year"=>$finishing_year,"selected_finishing_year"=>$selected_finishing_year,
		"finishing_month"=>$finishing_month,"selected_finishing_month"=>$selected_finishing_month,
		"finishing_day"=>$finishing_day,"selected_finishing_day"=>$selected_finishing_day,
		"finishing_hour"=>$finishing_hour,"selected_finishing_hour"=>$selected_finishing_hour,
		"finishing_minute"=>$finishing_minute,"selected_finishing_minute"=>$selected_finishing_minute
		);

	$smarty->assign("data",$data);
	$smarty->assign("header",$html_yobidashi->header());
	$smarty->display("form_kensaku_lot.tpl");
	unset($smarty);
	unset($db);
	exit;


?>