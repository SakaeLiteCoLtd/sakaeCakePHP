<?php
require_once("MySmarty.class.php");
$smarty=new MySmarty();
require_once("Date_yobidashi.class.php");
$date_yobidashi =new Date_yobidashi();
require_once("../HTML_yobidashi.class.php");
$html_yobidashi = new HTML_yobidashi();
$smarty->assign("header",$html_yobidashi->header());
require_once("semiHTML.class.php");
$html_semiheader = new HTML_semiheader();
$smarty->assign("semi_header",$html_semiheader->semi_header());

$db=$smarty->getDb();
$today = date("Y-m-d");
require_once("Select.class.php");
$html_select = new Select();
require_once("Date_yobidashi.class.php");
$date_yobidashi =new Date_yobidashi();

$today = date("Y-m-d");
require_once("Check.class.php");
$Check = new Check();

$product_id = $_POST['product_id'];
$lot_num = $_POST['lot_num'];
$num_seq = $_POST['num_seq'];

list($date_seikei,$num_box)=preg_split("/-/", $lot_num);
$arr_num_box = array();

if(substr($num_box,0,2) == "00"){

	$num_box=substr($num_box,2,1);

}elseif(substr($num_box,0,1) == "0"){

	$num_box=substr($num_box,1,2);

//}elseif(preg_match("/^[1-9]/",$num_box)){


}else{

	$num_box = $num_box;

}

//////////////////////
//既存ロットチェック//
//////////////////////

//配列の初期化
$check_arr_lot = array();
$check_arr_not_lot = array();

$arr_product_id = array();
$arr_lot_num = array();
$arr_not_product_id = array();
$arr_not_lot_num = array();

//既存ロットチェックのため、クラスへ投げる

$Check->check_lots_tourokusumi($num_seq,$product_id,$date_seikei,$num_box);
$arr_product_id = $Check->get_arr_product_id();
$arr_lot_num = $Check->get_arr_lot_num();
$arr_not_product_id = $Check->get_arr_not_product_id();
$arr_not_lot_num = $Check->get_arr_not_lot_num();

for($i=0;$i<count($arr_product_id);$i++){

	$check_arr_lot[] = array("product_id"=>$arr_product_id[$i]['product_id'],"lot_num"=>$arr_lot_num[$i]['lot_num']);

}

for($h=0;$h<count($arr_fushiyou_product_id);$h++){

	$check_arr_not_lot[] = array("product_id"=>$arr_not_product_id[$h]['product_id'],"lot_num"=>$arr_not_lot_num[$h]['lot_num']);

}

if($h <> 0){

	$mess="以下のロットは元々存在しません。";

}

		$smarty->assign("mess",$mess);

		$smarty->assign("check_arr_lot",$check_arr_lot);
		$smarty->assign("check_arr_not_lot",$check_arr_not_lot);
		$smarty->display("kakunin_lot_fushiyou.tpl");
		unset($check_arr_lot);
		unset($check_arr_fushiyou_lot);
		unset($smarty);
		unset($db);
		exit;


?>