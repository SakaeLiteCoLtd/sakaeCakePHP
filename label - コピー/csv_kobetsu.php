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

//kari_kadou_seikeiテーブルをDELETE
$db->query("set names sjis");
$delete_label= "DELETE FROM label_csv";
$db->query($delete_label);

$today = date("Y-m-d");
require_once("Check.class.php");
$Check = new Check();



if($_POST['csv_seikei_t'] <> ""){

	$product_id=$_POST['product_id'];
	$number_sheet=$_POST['number_sheet'];
	$date_seikei = $_POST['date_seikei'];

}else{
	
	$product_id = array();
	$product_id[]=$_POST['product_id'];
	$number_sheet=1;

	$date = $_POST['date'];
	$date_yobidashi->label_lot_seikei_date($date);
	$lot_date = $date_yobidashi->get_lot_seikei_date();


}

$num_box=$_POST['num_box'];

for($i=0;$i<count($num_box);$i++){

	if($num_box[$i] == "" or (!preg_match("/^[0-9]+$/", $num_box[$i])) ){

		$mess="空欄、または、数字ではない文字があります。";
		$smarty->assign("mess",$mess);
		$smarty->assign("pre_tag","<!--");
		$smarty->assign("last_tag","--!>");
		$smarty->display("error_input.tpl");
		unset($smarty);
		unset($db);
		exit;

	}

}
//////////////////////
//既存ロットチェック//
//////////////////////

//配列の初期化
$check_arr_lot = array();
$arr_product_id = array();
$arr_lot_num = array();

//既存ロットチェックのため、クラスへ投げる
for($i=0;$i<count($product_id);$i++){

	if($_POST['csv_seikei_t'] <> ""){

		$date_yobidashi->label_lot_seikei_date($date_seikei[$i]);
		$lot_date = $date_yobidashi->get_lot_seikei_date();

	}

	$Check->check_lots_tourokusumi($number_sheet[$i],$product_id[$i],$lot_date,$num_box[$i]);
	$arr_product_id = $Check->get_arr_product_id();
	$arr_lot_num = $Check->get_arr_lot_num();

	if($Check->get_hantei() == 1){//既存ロットがあれば、以下実行

		for($h=0;$h<count($arr_product_id);$h++){

			$check_arr_lot[] = array("product_id"=>$arr_product_id[$h]['product_id'],"lot_num"=>$arr_lot_num[$h]['lot_num']);

		}
			//配列の初期化
			$arr_product_id = array();
			$arr_lot_num = array();

	}

}

if(count($check_arr_lot) > 0){//既存ロットがあらば、エスケープしてエラー画面へ

	$smarty->assign("check_arr_lot",$check_arr_lot);
	$smarty->display("error_input.tpl");
	unset($smarty);
	unset($db);
	exit;

}



if($_POST['csv_seikei_t'] <> ""){

	for($i=0;$i<count($product_id);$i++){

		$product_set = array();
		$product_set[] = $product_id[$i];

			//セット取り一括印刷があるかどうか
			$Check->check_setikkatsu($product_id[$i]);
			if($Check->get_rows() > 0){

				$product_set[] = $Check->get_product_id2();

			}

			for($s=0;$s<count($product_set);$s++){

				$date_yobidashi->label_lot_seikei_date($date_seikei[$i]);
				$lot_date = $date_yobidashi->get_lot_seikei_date();

					$db->query("set names sjis");
					$rs=$db->query("select product_id,type_id,place_id,unit_id from label_type_product where product_id like '%".$product_set[$s]."%'");
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

						//梱包入り数を得る
						$db->query("set names sjis");
						$rs_konpou=$db->query("select irisu from konpou where product_id = '".$product1."'");
						while($row_konpou=$rs_konpou->fetchRow(MDB2_FETCHMODE_ASSOC)){

							$irisu1 = $row_konpou['irisu'];

						}

						$line_code1 = "";
						if($cs_id = '10001'){ //草津工場行きなら
							//line_codeを得る
							$db->query("set names sjis");
							$rs_line=$db->query("select line_code from line_codes where product_id = '".$product1."'");
							while($row_line=$rs_line->fetchRow(MDB2_FETCHMODE_ASSOC)){

								$line_code1 = $row_line['line_code'];

							}

						}

						$irisu2 = "";

						if($product2 <> "" and ($row['unit_id']=="D" or $row['unit_id']=="F")){

							$db->query("set names sjis");
							$rs_konpou2=$db->query("select irisu from konpou where product_id = '".$product2."'");
							while($row_konpou2=$rs_konpou2->fetchRow(MDB2_FETCHMODE_ASSOC)){

								$irisu2 = $row_konpou2['irisu'];

							}

						}

						//if($cs_id == "10003"){$lot_date = "IN.".$lot_date;}//ウワワクキャップだけは、IN.ロット

						$db->query("set names sjis");
						$insertstr = "INSERT INTO label_csv (number_sheet,hanbetsu,date,start_lot,place1,place2,product1,product2,name_pro1,name_pro2,irisu1,irisu2,unit1,unit2,line_code) ".
							" values ".
							" (".$number_sheet[$i].",'".$hanbetsu."','".$lot_date."','".$num_box[$i]."','".$place1."','".$place2."'".
							",'".$product1."','".$product2."','".$name_pro1."','".$name_pro2."'".
							",'".$irisu1."','".$irisu2."','".$unit1."','','".$line_code1."')";
						$db->query($insertstr);

						$Check->check_insideout($product1);//テーブルlabel_insideoutチェッククラスに投げる



						if(preg_match("/^[2]/",$cs_id) or ($Check->get_rows() <> 0)){//DNPは、箱の内側にもロットNO必要なため2枚ふつ作成。または、テーブルlabel_insideoutにデータが有る場合

							if(preg_match("/^[2]/",$cs_id) and ($Check->get_rows() == 0)){


								$db->query("set names sjis");
								$insertstr2 = "INSERT INTO label_csv (number_sheet,hanbetsu,date,start_lot,place1,place2,product1,product2,name_pro1,name_pro2,irisu1,irisu2,unit1,unit2,line_code) ".
										" values ".
										 " (".$number_sheet[$i].",'".$hanbetsu."','IN.".$lot_date."','".$num_box[$i]."','".$place1."','".$place2."'".
										",'".$product1."','".$product2."','".$name_pro1."','".$name_pro2."'".
										",'".$irisu1."','".$irisu2."','".$unit1."','','')";
								$db->query($insertstr2);

							}else{//テーブルlabel_insideoutにデータが有る場合は、以下のスクリプトを優先実行

									if($num_box[$i]-1 <> 0){

										$inside_num_box = ($num_box[$i]-1) * $Check->get_num_inside() + 1;

									}else{

										$inside_num_box = 1;

									}

									if($irisu2 <> ""){

										$irisu2 = $irisu2 / $Check->get_num_inside();

									}

									$db->query("set names sjis");
									$insertstr2 = "INSERT INTO label_csv (number_sheet,hanbetsu,date,start_lot,place1,place2,product1,product2,name_pro1,name_pro2,irisu1,irisu2,unit1,unit2,line_code) ".
											" values ".
											 " (".$number_sheet[$i] * $Check->get_num_inside().",'".$hanbetsu."','IN.".$lot_date."','".$inside_num_box."','".$place1."','".$place2."'".
											",'".$product1."','".$product2."','".$name_pro1."','".$name_pro2."'".
											",'".$irisu1 / $Check->get_num_inside()."','".$irisu2."','".$unit1."','','')";
									$db->query($insertstr2);

							}

						}

					}

			}

	}

}else{

			$db->query("set names sjis");
			$rs=$db->query("select product_id,type_id,place_id,unit_id from label_type_product where product_id like '%".$product_id[0]."%'");
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

				$db->query("set names sjis");
				$rs_konpou=$db->query("select irisu from konpou where product_id = '".$product1."'");
				while($row_konpou=$rs_konpou->fetchRow(MDB2_FETCHMODE_ASSOC)){

					$irisu1 = $row_konpou['irisu'];

				}

				$line_code1 = "";
				if($cs_id = '10001'){ //草津工場行きなら
					//line_codeを得る
					$db->query("set names sjis");
					$rs_line=$db->query("select line_code from line_codes where product_id = '".$product1."'");
					while($row_line=$rs_line->fetchRow(MDB2_FETCHMODE_ASSOC)){

						$line_code1 = $row_line['line_code'];

					}

				}

				$irisu2 = "";

				if($product2 <> "" and ($row['unit_id']=="D" or $row['unit_id']=="F")){

					$db->query("set names sjis");
					$rs_konpou2=$db->query("select irisu from konpou where product_id = '".$product2."'");
					while($row_konpou2=$rs_konpou2->fetchRow(MDB2_FETCHMODE_ASSOC)){

						$irisu2 = $row_konpou2['irisu'];

					}

				}

				$db->query("set names sjis");
				$insertstr = "INSERT INTO label_csv (number_sheet,hanbetsu,date,start_lot,place1,place2,product1,product2,name_pro1,name_pro2,irisu1,irisu2,unit1,unit2,line_code) ".
					" values ".
					" (".$number_sheet.",'".$hanbetsu."','".$lot_date."','".$num_box."','".$place1."','".$place2."'".
					",'".$product1."','".$product2."','".$name_pro1."','".$name_pro2."'".
					",'".$irisu1."','".$irisu2."','".$unit1."','','".$line_code1."')";
				$db->query($insertstr);

				$Check->check_insideout($product1);//テーブルlabel_insideoutチェッククラスに投げる

				if(preg_match("/^[2]/",$cs_id) or ($Check->get_rows() <> 0)){//DNPは、箱の内側にもロットNO必要なため2枚ふつ作成。または、テーブルlabel_insideoutにデータが有る場合

					if(preg_match("/^[2]/",$cs_id) and ($Check->get_rows() == 0)){

						$db->query("set names sjis");
						$insertstr2 = "INSERT INTO label_csv (number_sheet,hanbetsu,date,start_lot,place1,place2,product1,product2,name_pro1,name_pro2,irisu1,irisu2,unit1,unit2,line_code) ".
								" values ".
								 " (".$number_sheet.",'".$hanbetsu."','IN.".$lot_date."','".$num_box."','".$place1."','".$place2."'".
								",'".$product1."','".$product2."','".$name_pro1."','".$name_pro2."'".
								",'".$irisu1."','".$irisu2."','".$unit1."','','')";

						$db->query($insertstr2);

					}else{//テーブルlabel_insideoutにデータが有る場合は、以下のスクリプトを優先実行

							if($num_box - 1 <> 0){

								$inside_num_box = ($num_box-1) * $Check->get_num_inside() + 1;

							}else{

								$inside_num_box = 1;

							}

							if($irisu2 <> ""){

								$irisu2 = $irisu2 / $Check->get_num_inside();

							}

							$db->query("set names sjis");
							$insertstr2 = "INSERT INTO label_csv (number_sheet,hanbetsu,date,start_lot,place1,place2,product1,product2,name_pro1,name_pro2,irisu1,irisu2,unit1,unit2,line_code) ".
									" values ".
									 " (".$number_sheet * $Check->get_num_inside().",'".$hanbetsu."','IN.".$lot_date."','".$inside_num_box."','".$place1."','".$place2."'".
									",'".$product1."','".$product2."','".$name_pro1."','".$name_pro2."'".
									",'".$irisu1 / $Check->get_num_inside()."','".$irisu2."','".$unit1."','','')";
							$db->query($insertstr2);

					}

				

				}

			}

}

	//ファイル削除
	unlink("C:/Users/Public/Downloads/label_csv/label_hakkou.csv");	

	$db->query("set names sjis");
	$sql_csv ="SELECT number_sheet,hanbetsu,date,start_lot,place1,place2,product1,product2,name_pro1,name_pro2,irisu1,irisu2,unit1,unit2,line_code FROM label_csv into outfile 'C:/Users/Public/Downloads/label_csv/label_hakkou.csv' fields terminated by ','  lines terminated by '\r\n'";
	$db->query($sql_csv);

	$mess="'C:/Users/Public/Downloads/label_csv'にCSVファイルが出力されました。";

		$smarty->assign("mess",$mess);

		$smarty->display("rs.tpl");
		unset($smarty);
		unset($db);
		exit;


?>