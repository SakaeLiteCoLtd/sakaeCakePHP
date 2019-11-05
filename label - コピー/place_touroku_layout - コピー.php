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
$type_label = $_POST['type_label'];

$html_select->select_label_place($type_label);
$html_select->select_label_unit($type_label);
$row_product=$html_select->get_row_product();
$row_place=$html_select->get_row_place();

if($row_product==2){

	$html_product2 = "<tr>".
		"<td width='100' bgcolor='#FFFFCC'><div align='center' class='style1'><strong><font color='#0000FF'>•i”Ô2</font></strong></div></td>".
		"<td bgcolor='#FFFFCC'><div align='center'><input type='text' name='product2' value='' size='30'/></div></td>".
		"</tr>";
	$smarty->assign("html_product2",$html_product2);
}


$smarty->assign("place",$html_select->get_select_label_place());
$smarty->assign("unit",$html_select->get_select_label_unit());

	$mess = "";
	$smarty->assign("product",$product);
	$smarty->assign("type_label",$type_label);
	$smarty->assign("mess",$mess);
	$smarty->assign("semi_header",$html_semiheader->semi_header());
	$smarty->assign("header",$html_yobidashi->header());
	$smarty->display("place_touroku_layout.tpl");
	unset($smarty);
	unset($db);
	exit;


?>