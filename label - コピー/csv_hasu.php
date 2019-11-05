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
require_once("Label.class.php");
$classLabel =new Label();
require_once("Check.class.php");
$Check = new Check();

//label_csvテーブルをDELETE
$db->query("set names sjis");
$delete_label= "DELETE FROM label_csv";
$db->query($delete_label);

require_once("Date_yobidashi.class.php");
$date_yobidashi =new Date_yobidashi();

$today= date("Y-m-d", time() + 86400);

	$date_yobidashi->select_date($today);
	$syear=$date_yobidashi->get_year();
	$sele_syear=$date_yobidashi->get_selected_year();
	$smonth=$date_yobidashi->get_month();
	$sele_smonth=$date_yobidashi->get_selected_month();
	$sday=$date_yobidashi->get_day();
	$sele_sday=$date_yobidashi->get_selected_day();

	$smarty->assign("syear",$syear);
	$smarty->assign("selected_syear",$sele_syear);
	$smarty->assign("smonth",$smonth);
	$smarty->assign("selected_smonth",$sele_smonth);
	$smarty->assign("sday",$sday);
	$smarty->assign("selected_sday",$sele_sday);

$date_making = date("Y-m-d", time());
$date_yobidashi->label_lot_seikei_date($date_making);
$lot_date=$date_yobidashi->get_lot_seikei_date();

$product_id = $_POST['product_id'];
$hasu = $_POST['hasu'];


for($i=0;$i<count($product_id);$i++){

	if(($hasu[$i] <> 0 and $hasu[$i] <> "ERROR") and $product_id[$i] <> "W002"){

		$db->query("set names sjis");

		$rs=$db->query("select product_id,type_id,place_id,unit_id from label_type_product where product_id = '".$product_id[$i]."'");
			
		while($row=$rs->fetchRow(MDB2_FETCHMODE_ASSOC)){
			
			if(preg_match("/_/",$row['product_id'])){

						list($product1,$product2)=explode("_", $row['product_id']);

			}else{

						$product1 = $row['product_id'];
						$product2 = "";

			}

			$db->query("set names sjis");
			$rs_product1=$db->query("select product_name,cs_id from product where product_id = '".$product1."'");
			while($row_product1=$rs_product1->fetchRow(MDB2_FETCHMODE_ASSOC)){

						$name_pro1 = $row_product1['product_name'];
						$cs_id = $row_product1['cs_id'];

			}

			if($product2 <> ""){

				$rs_product2=$db->query("select product_name from product where product_id = '".$product2."'");
				while($row_product2=$rs_product2->fetchRow(MDB2_FETCHMODE_ASSOC)){

							$name_pro2 = $row_product2['product_name'];

				}

			}else{

				$name_pro2 = "";

			}

			$hanbetsu = $row['type_id'];

			$html_select->label_place($row['place_id']);
			$place1 = $html_select->get_name_place1();
			$place2 = $html_select->get_name_place2();
			if($place2 == ""){ $place2 = "";}

			$html_select->label_unit($row['unit_id']);
			$unit1 = $html_select->get_label_unit();

			$irisu1 = $hasu[$i];

			//既存ロットチェックのため、クラスへ投げる
			$Check->check_lots_tourokusumi(1,$product1,$lot_date,"HS.");
			$arr_product_id = $Check->get_arr_product_id();
			$arr_lot_num = $Check->get_arr_lot_num();

			if($Check->get_hantei() == 1){//既存ロットがあれば、以下実行

				for($h=0;$h<count($arr_product_id);$h++){

					$check_arr_lot[] = array("product_id"=>$arr_product_id[$h]['product_id'],"lot_num"=>$arr_lot_num[$h]['lot_num']);

				}

			}

			//配列の初期化
			$arr_product_id = array();
			$arr_lot_num = array();

			$kari_values .= " (1,'".$hanbetsu."','HS.".$lot_date."','1','".$place1."','".$place2."'".
						",'".$product1."','".$product2."','".$name_pro1."','".$name_pro2."'".
						",'".$irisu1."','".$irisu2."','".$unit1."',''),";

		}

	}

}

	$db->query("set names sjis");
	$insertstr = "INSERT INTO label_csv (number_sheet,hanbetsu,date,start_lot,place1,place2,product1,product2,name_pro1,name_pro2,irisu1,irisu2,unit1,unit2) values ".
	$insertstr = substr($insertstr.$kari_values ,0, -1);
	$db->query($insertstr);

	//ファイル削除
	unlink("C:/Users/Public/Downloads/label_csv/label_hakkou.csv");	

	$db->query("set names sjis");
	$sql_csv ="SELECT number_sheet,hanbetsu,date,start_lot,place1,place2,product1,product2,name_pro1,name_pro2,irisu1,irisu2,unit1,unit2 "
		."FROM label_csv into outfile 'C:/Users/Public/Downloads/label_csv/label_hakkou.csv' fields terminated by ','  lines terminated by '\r\n'";


	$db->query($sql_csv);
	
	$mess="'C:/Users/Public/Downloads/label_csv'にlabel_hakkou.csvファイルが出力されました。";

	$smarty->assign("value","");

	$smarty->assign("arr_hasu_box",$arr_hasu_box);

	$smarty->assign("semi_header",$html_semiheader->semi_header());
	$smarty->assign("header",$html_yobidashi->header());


	$smarty->assign("mess",$mess);
	$smarty->display("rs.tpl");
	unset($smarty);
	unset($db);
	exit;


?>