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
$yesterday= date("Y-m-d", time() - 86400);
require_once("Select.class.php");
$html_select = new Select();
require_once("Check.class.php");
$Check = new Check();

$date = $_POST['year']."-".$_POST['month']."-".$_POST['day'];
$date_yobidashi->label_lot_seikei_date($date);
$lot_date = $date_yobidashi->get_lot_seikei_date();

$mkndt = mktime(0, 0, 0, $_POST['month'], $_POST['day'], $_POST['year']) + 86400;
$next_date = date("Y-m-d", $mkndt);
$yesterday= date("Y-m-d", time() - 86400);

//label_csvテーブルをDELETE
$db->query("set names sjis");
$delete_label= "DELETE FROM label_csv";
$db->query($delete_label);



$check_arr_lot = array();
$kari_values = "";

$arr_product_id = array();
$arr_lot_num = array();

$count = 0;
for($j=1;$j<=9;$j++){

$count++;
	$product_id=$_POST['ch'.$j.'_product_id'];
	$number_sheet=$_POST['ch'.$j.'_number_sheet'];
	$num_box=$_POST['ch'.$j.'_num_box'];
	$count_pro=count($product_id);

	for($i=0;$i<$count_pro;$i++){
		
		$product_set = array();
		$product_set[] = $product_id[$i];

			//セット取り一括印刷があるかどうか
			$Check->check_setikkatsu($product_id[$i]);
			if($Check->get_rows() > 0){

				$product_set[] = $Check->get_product_id2();

			}

			for($s=0;$s<count($product_set);$s++){

				//ラベルタイプの違いを得る
				$db->query("set names sjis");
				$rs=$db->query("select product_id,type_id,place_id,unit_id from label_type_product where product_id like '%".$product_set[$s]."%'");
				while($row=$rs->fetchRow(MDB2_FETCHMODE_ASSOC)){
					if(preg_match("/_/",$row['product_id'])){

						list($product1,$product2)=explode("_", $row['product_id']);

					}else{

						$product1 = $row['product_id'];
						$product2 = "";

					}

					//製品名、顧客IDを得る
					$db->query("set names sjis");
					$rs_product1=$db->query("select product_name,cs_id from product where product_id = '".$product1."'");
					while($row_product1=$rs_product1->fetchRow(MDB2_FETCHMODE_ASSOC)){

						$name_pro1 = $row_product1['product_name'];
						$cs_id = $row_product1['cs_id'];

					}

					//製品２があれば、製品２の品名を得る
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

					if($product2 <> ""  and ($row['unit_id']=="D" or $row['unit_id']=="F")){
						//梱包入り数を得る
						$db->query("set names sjis");
						$rs_konpou2=$db->query("select irisu from konpou where product_id = '".$product2."'");
						while($row_konpou2=$rs_konpou2->fetchRow(MDB2_FETCHMODE_ASSOC)){

							$irisu2 = $row_konpou2['irisu'];

						}

					}

					
					//既存ロットチェックのため、クラスへ投げる
					$Check->check_lots_tourokusumi($number_sheet[$i],$product1,$lot_date,$num_box[$i]);
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

					//if($cs_id == "10003"){$lot_date = "IN.".$lot_date;}

					$kari_values .= " (".$number_sheet[$i].",'".$hanbetsu."','".$lot_date."','".$num_box[$i]."','".$place1."','".$place2."'".
							",'".$product1."','".$product2."','".$name_pro1."','".$name_pro2."'".
							",'".$irisu1."','".$irisu2."','".$unit1."','','".$line_code1."'),";

					$Check->check_insideout($product1);//テーブルlabel_insideoutチェッククラスに投げる

					if(preg_match("/^[2]/",$cs_id) or ($Check->get_rows() <> 0)){//DNPは、箱の内側にもロットNO必要なため2枚ふつ作成。または、テーブルlabel_insideoutにデータが有る場合

						if(preg_match("/^[2]/",$cs_id) and ($Check->get_rows() == 0)){

							$kari_values .= " (".$number_sheet[$i].",'".$hanbetsu."','IN.".$lot_date."','".$num_box[$i]."','".$place1."','".$place2."'".
									",'".$product1."','".$product2."','".$name_pro1."','".$name_pro2."'".
									",'".$irisu1."','".$irisu2."','".$unit1."','',''),";

						}else{//テーブルlabel_insideoutにデータが有る場合は、以下のスクリプトを優先実行

								if($num_box[$i]-1 <> 0){

									$inside_num_box = ($num_box[$i]-1) * $Check->get_num_inside() + 1;

								}else{

									$inside_num_box = 1;

								}

								if($irisu2 <> ""){

									$irisu2 = $irisu2 / $Check->get_num_inside();

								}

								$kari_values .= " (".$number_sheet[$i] * $Check->get_num_inside().",'".$hanbetsu."','IN.".$lot_date."','".$inside_num_box."','".$place1."','".$place2."'".
										",'".$product1."','".$product2."','".$name_pro1."','".$name_pro2."'".
										",'".$irisu1 / $Check->get_num_inside()."','".$irisu2."','".$unit1."','',''),";

						}

					}

				}

			}

	}

}
				
	if(count($check_arr_lot) > 0){//既存ロットがあらば、エスケープしてエラー画面へ

		$smarty->assign("check_arr_lot",$check_arr_lot);
		$smarty->display("error_input.tpl");
		unset($smarty);
		unset($db);
		exit;

	}


	$db->query("set names sjis");
	$insertstr = "INSERT INTO label_csv (number_sheet,hanbetsu,date,start_lot,place1,place2,product1,product2,name_pro1,name_pro2,irisu1,irisu2,unit1,unit2,line_code) values ".
	$insertstr = substr($insertstr.$kari_values ,0, -1);
	$db->query($insertstr);

	//ファイル削除
	unlink("C:/Users/Public/Downloads/label_csv/label_hakkou.csv");	

	$db->query("set names sjis");
	$sql_csv ="SELECT number_sheet,hanbetsu,date,start_lot,place1,place2,product1,product2,name_pro1,name_pro2,irisu1,irisu2,unit1,unit2,line_code "
		."FROM label_csv into outfile 'C:/Users/Public/Downloads/label_csv/label_hakkou.csv' fields terminated by ','  lines terminated by '\r\n'";


	$db->query($sql_csv);
	
	$mess="'C:/Users/Public/Downloads/label_csv'にlabel_hakkou.csvファイルが出力されました。";

		

		$smarty->assign("mess",$mess);

		$smarty->display("rs.tpl");
		unset($smarty);
		unset($db);
		exit;


?>