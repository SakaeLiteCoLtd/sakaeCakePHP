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

$target_p = $_POST['target_p'];
$product_id1 = $_POST['product_id1'];
$product_id2 = $_POST['product_id2'];

//チェックボックスをチェックした要素を探す

$count = 0;
for($h=0;$h<count($product_id1);$h++){

	if($_POST['target_p'.$h.''] == 1){
		
		$count++;
		$target_product_id1 = $product_id1[$h];
		$target_product_id2 = $product_id2[$h];

	}

}

if($count == 0 or $count >1){

	$mess ="チェックボックスには、１つだけチェックしてください。";
	$smarty->assign("pre_tag","<!--");
	$smarty->assign("last_tag","--!>");
	$smarty->assign("mess",$mess);
	$smarty->display("error_input.tpl");
	unset($smarty);
	unset($db);
	exit;

}
	$smarty->assign("mess",$target_p[0]);

	$smarty->assign("product_id1",$target_product_id1);
	$smarty->assign("product_id2",$target_product_id2);
	//$smarty->assign("pre_tag","<!--");
	//$smarty->assign("last_tag","--!>");
	$smarty->assign("semi_header",$html_semiheader->semi_header());
	$smarty->assign("header",$html_yobidashi->header());
	$smarty->display("form_update_setikkatsu.tpl");
	unset($smarty);
	unset($db);
	exit;


?>