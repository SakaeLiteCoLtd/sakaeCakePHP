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

$product_id = $_POST['product'];
$product2 = $_POST['product2'];
$place_id = $_POST['place_id'];
$unit_id = $_POST['unit_id'];
$type_label = $_POST['type_label'];

if($product2<>""){

	$product_id = $product_id."_".$product2;

}

	$db->query("set names sjis");
	$insertr = "INSERT INTO label_type_product (product_id,type_id,place_id,unit_id) values ('".$product_id."','".$type_label."',".$place_id.",".$unit_id.")";
	$db->query($insertr);

	$db->query("set names sjis");
	$rs=$db->query("select product_id,type_id,place_id,unit_id from label_type_product where product_id = '".$product_id."'");

	$label = array();
	while($row=$rs->fetchRow(MDB2_FETCHMODE_ASSOC)){

		if(preg_match("/_/",$row['product_id'])){

			list($rs_product,$rs_product2)=explode("_", $row['product_id']);

		}else{

			$rs_product = $row['product_id'];

		}

		$rs_type_id = $row['type_id'];
		$rs_place_id = $row['place_id'];
		$rs_unit_id = $row['unit_id'];

		$html_select->label_place($row['place_id']);
		$html_select->label_unit($row['unit_id']);

		if(preg_match("/_/",$row['product_id'])){

			$html_product2 = "<tr>".
				"<td width='100' bgcolor='#FFFFCC'><div align='center' class='style1'><strong><font color='#0000FF'>•i”Ô2</font></strong></div></td>".
				"<td bgcolor='#FFFFCC'><div align='center'><strong>".$rs_product2."</strong><input type='hidden' name='product2' value='".$rs_product2."' /></div></td>".
				"</tr>";
			$smarty->assign("html_product2",$html_product2);
		}

	}

	


	$smarty->assign("value",$insertr);

	$smarty->assign("name_place",$html_select->get_name_place());
	$smarty->assign("unit",$html_select->get_unit());

	$mess = "ˆÈã‚Ì‚æ‚¤‚É“o˜^‚³‚ê‚Ü‚µ‚½B";
	$smarty->assign("product",$rs_product);
	$smarty->assign("place_id",$rs_place_id);
	$smarty->assign("unit_id",$rs_unit_id);
	$smarty->assign("type_label",$rs_type_id);
	$smarty->assign("mess",$mess);
	$smarty->assign("semi_header",$html_semiheader->semi_header());
	$smarty->assign("header",$html_yobidashi->header());
	$smarty->display("kakunin_touroku_layout.tpl");
	unset($smarty);
	unset($db);
	exit;


?>