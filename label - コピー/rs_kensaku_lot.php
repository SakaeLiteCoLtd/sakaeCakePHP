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

$product_id = $_POST['product_id'];
$lot_num = $_POST['lot_num'];

$syear = $_POST['syear'];
$smonth = $_POST['smonth'];
$sday = $_POST['sday'];

$s_date = $syear."-".$smonth."-".$sday;


$fyear = $_POST['fyear'];
$fmonth = $_POST['fmonth'];
$fday = $_POST['fday'];

$f_mk = mktime(0, 0, 0, $fmonth, $fday, $fyear);

$f_date = date("Y-m-d",$f_mk + 86400);


if($product_id == "" and $lot_num == "" and ($syear==0 or $smonth==0 
	or $sday==0 or $fyear==0 or $fmonth==0 or $fday == 0)){

	$err_mess = "空欄です。<br>ブラウザの戻るから戻ってください。";
				
	$smarty->assign("mess",$err_mess);
	$smarty->assign("pre_tag","<!--");
	$smarty->assign("last_tag","--!>");
	$smarty->display("error_input.tpl");
	unset($smarty);
	unset($db);
	exit;


}

$wherestr = "";

if($product_id <> ""){

	$wherestr = " where a.product_id = '".$product_id."' ";
}

if($wherestr <> "" ){

	$wherestr = $wherestr." and a.lot_num like '%".$lot_num."%' ";

}else{

	$wherestr = " where a.lot_num like '%".$lot_num."%' ";

}

if($wherestr <> "" and $syear<>0 and $smonth<>0 and $sday<>0 and $fyear<>0 and $fmonth<>0 and $fday <> 0){

	$wherestr = $wherestr." and a.datetime_hakkou >= '".$s_date." 8:00' and a.datetime_hakkou <= '".$f_date." 7:59' ";

}elseif($wherestr == "" and $syear<>0 and $smonth<>0 and $sday<>0 and $fyear<>0 and $fmonth<>0 and $fday <> 0){

	$wherestr = " where a.datetime_hakkou >= '".$s_date." 8:00' and a.datetime_hakkou <= '".$f_date." 23:59'";

}

$db->query("set names sjis");
$sql = "select a.product_id,b.product_name,a.lot_num,a.amount,c.name,a.flag_used,a.flag_deliver,a.date_deliver ".
	" from check_lots as a inner join product as b on a.product_id= b.product_id ".
	" inner join name_lot_flag_used as c on a.flag_used = c.id ".$wherestr." order by product_id";
$rs=$db->query($sql);
$ichiran = array();

while($row=$rs->fetchRow(MDB2_FETCHMODE_ASSOC)){

	if(is_null($row['flag_deliver']) and $row['flag_used'] == 0){

		$name_flag = "出荷待ち";

	}elseif($row['flag_used'] == 0){

		$name_flag = $row['date_deliver']."納品済";

	}else{

		$name_flag = $row['name'];

	}

	$ichiran[] = array("product_id"=>$row['product_id'],"product_name"=>$row['product_name'],
			"lot_num"=>$row['lot_num'],"amount"=>$row['amount'],"name_flag_used"=>$name_flag);
}


	$date_yobidashi->select_date($s_date,1);
	$syear=$date_yobidashi->get_year();
	$sele_syear=$date_yobidashi->get_selected_year();
	$smonth=$date_yobidashi->get_month();
	$sele_smonth=$date_yobidashi->get_selected_month();
	$sday=$date_yobidashi->get_day();
	$sele_sday=$date_yobidashi->get_selected_day();

	$date_yobidashi->select_date($f_date,1);
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

	$smarty->assign("value",$sql);

	$smarty->assign("ichiran",$ichiran);
	$smarty->assign("mess","");
	//$smarty->assign("pre_tag","<!--");
	//$smarty->assign("last_tag","--!>");

	$smarty->assign("semi_header",$html_semiheader->semi_header());
	$smarty->assign("header",$html_yobidashi->header());
	$smarty->display("rs_kensaku_lot.tpl");
	unset($smarty);
	unset($db);
	exit;

?>