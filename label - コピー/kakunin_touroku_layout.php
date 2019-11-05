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

$product = $_POST['product'];
$product2 = $_POST['product2'];
$place_id = $_POST['place_id'];
$unit_id = $_POST['unit_id'];
$type_label = $_POST['type_label'];

$html_select->label_place($place_id);
$html_select->label_unit($unit_id);


if($product2<>""){

	$html_product2 = "<tr>".
		"<td width='100' bgcolor='#FFFFCC'><div align='center' class='style1'><strong><font color='#0000FF'>•i”Ô2</font></strong></div></td>".
		"<td bgcolor='#FFFFCC'><div align='center'><strong>".$product2."</strong><input type='hidden' name='product2' value='".$product2."' /></div></td>".
		"</tr>";
	$smarty->assign("html_product2",$html_product2);
}

	$button = "<input type='submit' name='button' id='button' value='“o˜^‚·‚é' />";
	$smarty->assign("button",$button);
	$smarty->assign("name_place",$html_select->get_name_place());
	$smarty->assign("unit",$html_select->get_unit());

	$mess = "";
	$smarty->assign("product",$product);
	$smarty->assign("place_id",$place_id);
	$smarty->assign("unit_id",$unit_id);
	$smarty->assign("type_label",$type_label);
	$smarty->assign("mess",$mess);
	$smarty->assign("semi_header",$html_semiheader->semi_header());
	$smarty->assign("header",$html_yobidashi->header());
	$smarty->display("kakunin_touroku_layout.tpl");
	unset($smarty);
	unset($db);
	exit;


?>