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


//¬Œ`ŠJŽnŽžŠÔ
$starting_time = "09:00";
			
$date_yobidashi->select_date($today,0);
$date_yobidashi->select_time($starting_time);

	
$starting_year = $date_yobidashi->get_year();
$selected_starting_year = $date_yobidashi->get_selected_year();
$starting_month = $date_yobidashi->get_month();
$selected_starting_month = $date_yobidashi->get_selected_month();
$starting_day = $date_yobidashi->get_day();
$selected_starting_day =$date_yobidashi->get_selected_day();
$starting_hour = $date_yobidashi->get_select_hour();
$selected_starting_hour = $date_yobidashi->get_selected_hour();
$starting_minute = $date_yobidashi->get_select_minute();
$selected_starting_minute = $date_yobidashi->get_selected_minute();

$data[]=array( 
		"starting_year"=>$starting_year,"selected_starting_year"=>$selected_starting_year,
		"starting_month"=>$starting_month,"selected_starting_month"=>$selected_starting_month,
		"starting_day"=>$starting_day,"selected_starting_day"=>$selected_starting_day,
		"starting_hour"=>$starting_hour,"selected_starting_hour"=>$selected_starting_hour,
		"starting_minute"=>$starting_minute,"selected_starting_minute"=>$selected_starting_minute,
		);

	$smarty->assign("data",$data);
	$smarty->assign("header",$html_yobidashi->header());
	$smarty->display("form_kobetsu_hakkou.tpl");
	unset($smarty);
	unset($db);
	exit;


?>