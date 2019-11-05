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
$tomorrow= date("Y-m-d", time() + 86400);

require_once("SelectSql.class.php");
$SelectSql = new SelectSql();
//ロット表示のためにターゲット製品を確定させる。
$target_product="";
for($i=0;$i<count($_POST['sum_order_amount']);$i++){

	if($_POST['target_'.$_POST['product_id'][$i].''] <> ""){

		$target_product = $_POST['product_id'][$i];
		break;

	}

}

if($_POST['kakunin'] <> ""){

	$date = $_POST['year']."-".$_POST['month']."-".$_POST['day'];

	$date_yobidashi->select_date($date,0);

	$starting_year = $date_yobidashi->get_year();
	$selected_starting_year = $date_yobidashi->get_selected_year();
	$starting_month = $date_yobidashi->get_month();
	$selected_starting_month = $date_yobidashi->get_selected_month();
	$starting_day = $date_yobidashi->get_day();
	$selected_starting_day =$date_yobidashi->get_selected_day();

	$db->query("set names sjis");
	$sql = "select a.place_deliver_id,b.name from order_edi as a ".
			" inner join customers_handy as b on a.place_deliver_id= b.place_deliver_id ".
			" where a.date_deliver = '".$date."' and a.delete_flg = 0 group by place_deliver_id,name";

	$rs = $db->query($sql);
	$buttons = array();
	while($row=$rs->fetchRow(MDB2_FETCHMODE_ASSOC)){

		$button = "<label><input type='submit' name='button' id='button' value='".$row['name']."' /></label>";
		$buttons[] = array("button"=>$button);

	}

	$smarty->assign("buttons",$buttons);
	$smarty->assign("value","");

	$smarty->assign("starting_year",$starting_year);
	$smarty->assign("selected_starting_year",$selected_starting_year);
	$smarty->assign("starting_month",$starting_month);
	$smarty->assign("selected_starting_month",$selected_starting_month);
	$smarty->assign("starting_day",$starting_day);
	$smarty->assign("selected_starting_day",$selected_starting_day);

	$smarty->assign("header",$html_yobidashi->header());
	$smarty->display("index_jyoukyou.tpl");
	unset($smarty);
	unset($db);
	exit;

}elseif($_POST['button'] <> ""){

	$date = $_POST['year']."-".$_POST['month']."-".$_POST['day'];

	$db->query("set names sjis");
	$rs = $db->query("select place_deliver_id from customers_handy where name = '".$_POST['button']."'");
	while($row=$rs->fetchRow(MDB2_FETCHMODE_ASSOC)){

		$place_deliver_id = $row['place_deliver_id'];

	}

	$db->query("set names sjis");
	$sql = "select a.product_id,b.product_name,a.place_deliver_id,a.place_line,a.amount from order_edi as a ".
			" inner join product as b on a.product_id= b.product_id ".
			" where a.date_deliver = '".$date."' and place_deliver_id = '".$place_deliver_id."' and a.delete_flg = 0 GROUP BY product_id";

	$rs = $db->query($sql);
	$data = array();
	$sum_order_amount = 0;
	$sum_lot_amount = 0;
	while($row=$rs->fetchRow(MDB2_FETCHMODE_ASSOC)){


		$db->query("set names sjis");
		$sql_order_sum = "select sum(amount) from order_edi ".
				" where product_id = '".$row['product_id']."' and date_deliver = '".$date."' and place_deliver_id = '".$place_deliver_id."' and delete_flg = 0 ";
		$sum_order_amount = $db->queryOne($sql_order_sum);

		$db->query("set names sjis");
		$sql_lot_sum = "select sum(amount) from check_lots  ".
				" where product_id = '".$row['product_id']."' and date_deliver = '".$date."' and place_deliver_id = '".$place_deliver_id."' and delete_flg is NULL";
		$sum_lot_amount = $db->queryOne($sql_lot_sum);

		$button_lot = "<label><input type='submit' name='target_".$row['product_id']."' id='button' value='ロット' /></label>";

		$data[] = array("product_id"=>$row['product_id'],
				"product_name"=>$row['product_name'],
				"sum_order_amount"=>$sum_order_amount,
				"sum_lot_amount"=>$sum_lot_amount,
				"button_lot"=>$button_lot);

	}

	$date_yobidashi->select_date($date,0);

	$starting_year = $date_yobidashi->get_year();
	$selected_starting_year = $date_yobidashi->get_selected_year();
	$starting_month = $date_yobidashi->get_month();
	$selected_starting_month = $date_yobidashi->get_selected_month();
	$starting_day = $date_yobidashi->get_day();
	$selected_starting_day =$date_yobidashi->get_selected_day();

	$smarty->assign("place_deliver_id",$place_deliver_id);

	$smarty->assign("starting_year",$starting_year);
	$smarty->assign("selected_starting_year",$selected_starting_year);
	$smarty->assign("starting_month",$starting_month);
	$smarty->assign("selected_starting_month",$selected_starting_month);
	$smarty->assign("starting_day",$starting_day);
	$smarty->assign("selected_starting_day",$selected_starting_day);

	$smarty->assign("data",$data);

	$smarty->assign("header",$html_yobidashi->header());
	$smarty->display("rs_jyoukyou.tpl");
	unset($smarty);
	unset($db);
	exit;

}elseif($target_product <> ""){

	$date_deliver = $_POST['year']."-".$_POST['month']."-".$_POST['day'];

	$place_deliver_id = $_POST['place_deliver_id'];
	$product_name = $_POST['product_name'][$i];
	$sum_order_amount = $_POST['sum_order_amount'][$i];
	$sum_lot_amount = $_POST['sum_lot_amount'][$i];

	$SelectSql->select_name_deliver($place_deliver_id);
	$name_deliver = $SelectSql->get_name();

	$SelectSql->select_lots($target_product,$date_deliver,$place_deliver_id);
	$rows = $SelectSql->get_rows();
	$data = $SelectSql->get_data();

	$arr_hasu_lots = array();
	for($j=0;$j<$SelectSql->get_rows();$j++){

		if(preg_match("/^[HS_]/",$data[$j]['lot_num'])==1){

			$SelectSql->select_moto_lots($target_product,$data[$j]['lot_num']);
			$arr_moto_lots = $SelectSql->get_arr_moto_lots();
			for($h=0;$h<count($arr_moto_lots);$h++){

				$arr_hasu_lots[]= array("hasu_lot_num"=>$data[$j]['lot_num'],
						"moto_lot_num"=>$arr_moto_lots[$h]['lot_num'],
						"moto_lot_amount"=>$arr_moto_lots[$h]['moto_lot_amount']);

			}

			$pre_table ="<table width='500' border='0' align='left' bgcolor='#666666'>".
					"<tr>".
					"<td bgcolor='#FFFFCC'><div align='center'><font color='#0000FF'><strong>端数ロットNo.</strong></font></div></td>".
					"<td bgcolor='#FFFFCC'><div align='center'><font color='#0000FF'><strong>元ロットNo.</strong></font></div></td>".
					"<td bgcolor='#FFFFCC'><div align='center'><font color='#0000FF'><strong>元ロット数量</strong></font></div></td>".
					"</tr>";
			$last_table = "</table>";

		}

	}

	//$smarty->assign("value",$SelectSql->get_rows());


	$smarty->assign("date_deliver",$date_deliver);
	$smarty->assign("name_deliver",$name_deliver);

	$smarty->assign("product_id",$target_product);
	$smarty->assign("product_name",$product_name);
	$smarty->assign("sum_order_amount",$sum_order_amount);
	$smarty->assign("rows",$rows);
	$smarty->assign("arr_hasu_lots",$arr_hasu_lots);

	$smarty->assign("pre_table",$pre_table);
	$smarty->assign("last_table",$last_table);
	$smarty->assign("data",$data);

	$smarty->assign("header",$html_yobidashi->header());
	$smarty->display("rs_jyoukyou_lot.tpl");
	unset($smarty);
	unset($db);
	exit;

}else{

	$date_yobidashi->select_date($tomorrow,0);

	$starting_year = $date_yobidashi->get_year();
	$selected_starting_year = $date_yobidashi->get_selected_year();
	$starting_month = $date_yobidashi->get_month();
	$selected_starting_month = $date_yobidashi->get_selected_month();
	$starting_day = $date_yobidashi->get_day();
	$selected_starting_day =$date_yobidashi->get_selected_day();

	$smarty->assign("starting_year",$starting_year);
	$smarty->assign("selected_starting_year",$selected_starting_year);
	$smarty->assign("starting_month",$starting_month);
	$smarty->assign("selected_starting_month",$selected_starting_month);
	$smarty->assign("starting_day",$starting_day);
	$smarty->assign("selected_starting_day",$selected_starting_day);

	$smarty->assign("header",$html_yobidashi->header());
	$smarty->display("index_jyoukyou.tpl");
	unset($smarty);
	unset($db);
	exit;

}
?>