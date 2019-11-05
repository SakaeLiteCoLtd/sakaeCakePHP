<?php
require_once("MySmarty.class.php");
$smarty=new MySmarty();
$db=$smarty->getDb();
require_once("../HTML_yobidashi.class.php");
$html_yobidashi = new HTML_yobidashi();
$smarty->assign("header",$html_yobidashi->header());
require_once("semiHTML.class.php");
$html_semiheader = new HTML_semiheader();
$smarty->assign("semi_header",$html_semiheader->semi_header());
require_once("Select.class.php");
$html_select = new Select();
$today = date("Y-m-d");
require_once("Label.class.php");
$classLabel =new Label();
require_once("Check.class.php");
$Check = new Check();

require_once("Date_yobidashi.class.php");
$date_yobidashi =new Date_yobidashi();

$product_id = $_POST['product_id'];
$taisyou_lot_num = $_POST['taisyou_lot_num'];

$Check->check_touroku_hasu_lot($product_id,$taisyou_lot_num);
$hantei = $Check->get_hantei();
$taisyou_check_lots_id = $Check->get_id();

if($hantei == 0){

	$err_mess = "ÇªÇÃÉçÉbÉgNo.ÇÕìoò^Ç≥ÇÍÇƒÇ¢Ç‹ÇπÇÒÅB";
		
	$smarty->assign("mess",$err_mess);
	$smarty->assign("pre_tag","<!--");
	$smarty->assign("last_tag","--!>");
	$smarty->display("error_input.tpl");
	unset($smarty);
	unset($db);
	exit;

}

$db->query("set names sjis");
$rs=$db->query("select id,amount from check_lots where product_id = '".$product_id."' and lot_num = '".$taisyou_lot_num."'");
			
while($row=$rs->fetchRow(MDB2_FETCHMODE_ASSOC)){

	$taisyou_amount = $row['amount'];
	$taisyou_id = $row['id'];

}

$td1 = "<td width='100' bgcolor='#FFFFCC' ><div align='center' class='style1'><strong><font color='#0000FF'>êîó </font></strong></div></td>";
$td2 = "<td bgcolor='#FFFFCC'><div align='center'><strong>".$taisyou_amount."</strong><input type='hidden' name='taisyou_amount' value='".$taisyou_amount."' /></div></td>";

$db->query("set names sjis");

if(preg_match("/^[HS_]/",$taisyou_lot_num) or preg_match("/^[HS.]/",$taisyou_lot_num)){

	$wherestr = " where hasu_lot_id = ".$taisyou_id;

}else{

	$wherestr = " where moto_lot_id = ".$taisyou_id;

}
$sql_moto_lots = "select hasu_lot_id,moto_lot_id,moto_lot_amount from moto_lots ".$wherestr;
$rs_moto_lots=$db->query($sql_moto_lots);

$arr_moto_lots = array();
while($row_moto_lots=$rs_moto_lots->fetchRow(MDB2_FETCHMODE_ASSOC)){

	$arr_moto_lots[] = array("hasu_lot_id"=>$row_moto_lots['hasu_lot_id'],"moto_lot_id"=>$row_moto_lots['moto_lot_id'],
		"moto_lot_amount"=>$row_moto_lots['moto_lot_amount']);

}

$arr_lot = array();

if(preg_match("/^[HS_]/",$taisyou_lot_num) or preg_match("/^[HS.]/",$taisyou_lot_num)){

	$num = 1;
	for($i=0;$i<count($arr_moto_lots);$i++){

		$db->query("set names sjis");
		$sql = "select lot_num from check_lots where id = ".$arr_moto_lots[$i]['moto_lot_id'];
		$rs = $db->query($sql);
		while($row=$rs->fetchRow(MDB2_FETCHMODE_ASSOC)){

			$arr_lot[] = array("num"=>$num,"lot_num"=>$row['lot_num'],"amount"=>$arr_moto_lots[$i]['moto_lot_amount']);

		}
		$num++;
	}

}else{


		$num = 1;
		$db->query("set names sjis");
		$sql = "select a.lot_num,b.moto_lot_amount from check_lots as a ".
			" inner join moto_lots as b on a.id=b.hasu_lot_id ".
			" where b.moto_lot_id = ".$taisyou_id;
		$rs = $db->query($sql);
		while($row=$rs->fetchRow(MDB2_FETCHMODE_ASSOC)){

			$arr_lot[] = array("num"=>$num,"lot_num"=>$row['lot_num'],"amount"=>$row['moto_lot_amount']);


	}


}

	$smarty->assign("mess",$mess);

	$smarty->assign("product_id",$product_id);
	$smarty->assign("taisyou_lot_num",$taisyou_lot_num);
	$smarty->assign("type","hidden");
	$smarty->assign("td1",$td1);
	$smarty->assign("td2",$td2);

	$smarty->assign("arr_lot",$arr_lot);
	$smarty->display("form_kensaku_hasu_lot.tpl");
	unset($smarty);
	unset($db);
	exit;


?>