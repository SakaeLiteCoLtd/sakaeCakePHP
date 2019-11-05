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


$product_id = $_POST['product_id'];
$date = $_POST['year']."-".$_POST['month']."-".$_POST['day'];
$num_box = $_POST['num_box'];

$data[]=array( "product_id"=>$product_id,"date"=>$date,"num_box"=>$num_box);

	$smarty->assign("data",$data);
	$smarty->assign("header",$html_yobidashi->header());
	$smarty->display("kakunin_kobetsu_hakkou.tpl");
	unset($smarty);
	unset($db);
	exit;


?>