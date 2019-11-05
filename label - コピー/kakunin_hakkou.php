<?php
require_once("MySmarty.class.php");
$smarty=new MySmarty();
require_once("Date_yobidashi.class.php");
$date_yobidashi =new Date_yobidashi();
require_once("semiHTML.class.php");
$html_semiheader = new HTML_semiheader();
$smarty->assign("semi_header",$html_semiheader->semi_header());
$db=$smarty->getDb();
$today = date("Y-m-d");
$yesterday= date("Y-m-d", time() - 86400);
require_once("../HTML_yobidashi.class.php");
$html_yobidashi = new HTML_yobidashi();
$smarty->assign("header",$html_yobidashi->header());

require_once("GetArray.class.php");
$GetArray =new GetArray();

$date = $_POST['year']."-".$_POST['month']."-".$_POST['day'];
$mkndt = mktime(0, 0, 0, $_POST['month'], $_POST['day'], $_POST['year']) + 86400;
$next_date = date("Y-m-d", $mkndt);
$yesterday= date("Y-m-d", time() - 86400);

//追加ボタン、削除ボタンからの返り値を取得
//変数の初期化
$num_ch = "";
$button_ch = "";
for($d=1;$d<=9;$d++){//$dはどの成形機の追加、または、削除ボタンが押されたのかを示す変数

	if($_POST['ch'.$d.'_addition'] <> ""){

		$num_ch = $d;
		$button_ch = $d;
		break;

	}

	if($_POST['ch'.$d.'_deletion'] <> ""){

		$num_ch = $d;
		$button_ch = -1 * $d;
		break;

	}

	

}


if($num_ch <> "" ){//追加ボタン、削除ボタンが押された場合のスクリプト

	for($c=1;$c<=9;$c++){

			$get_target = 0;
			
			$target_p = $_POST['target_p'.$c.''];
			$product_id=$_POST['ch'.$c.'_product_id'];
			$product_id=$_POST['ch'.$c.'_product_id'];
			$syear=$_POST['ch'.$c.'_syear'];
			$smonth=$_POST['ch'.$c.'_smonth'];
			$sday=$_POST['ch'.$c.'_sday'];
			$shour=$_POST['ch'.$c.'_shour'];
			$sminute=$_POST['ch'.$c.'_sminute'];
			$fyear=$_POST['ch'.$c.'_fyear'];
			$fmonth=$_POST['ch'.$c.'_fmonth'];
			$fday=$_POST['ch'.$c.'_fday'];
			$fhour=$_POST['ch'.$c.'_fhour'];
			$fminute=$_POST['ch'.$c.'_fminute'];
			$number_sheet=$_POST['ch'.$c.'_number_sheet'];
			$num_box=$_POST['ch'.$c.'_num_box'];

			$kousu=count($product_id) ;


			
			//チェックボックスをチェックした要素を探す
			for($h=0;$h<$kousu;$h++){

				if($target_p[$h] <> ""){

					$get_target = 1;
					$target_product = $target_p[$h];

				}

			}




		if($c == $d){//成形機の号数と$dが一致したときだけ実行

			if($button_ch < 0){//削除ボタンを押したとき

				if($get_target == 0){

					$kousu = $kousu -1;

				}

				if($kousu == -1){

						$err_mess="これ以上削除できません。。";
						$smarty->assign("err_mess",$err_mess);
						$smarty->display("error_input.tpl");
						unset($smarty);
						unset($db);
						exit;

				}

			}else{//追加ボタンを押したとき

					if($kousu <> 0){//工程が１つでも存在するとき
						$kousu = $kousu +1;
						$count = count($product_id);

						$syear[] = $syear[$count-1];
						$smonth[] = $smonth[$count-1];
						$sday[] = $sday[$count-1];
						$shour[] = "08";
						$sminute [] = "00";

						
						$fyear[] = $fyear[$count-1];
						$fmonth[] = $fmonth[$count-1];
						$fday[] = $fday[$count-1];
						$fhour[] = "08";
						$fminute [] = "00";

						$product_id[] = "";
						$number_sheet[] = "";
						$num_box[] = "";

					}elseif($kousu == 0){//工程が全くゼロのときに、追加ボタンを押したとき

						$kousu = $kousu +1;

						$syear[] = $_POST['year'];
						$smonth[] = $_POST['month'];
						$sday[] = $_POST['day'];
						$shour[] = "08";
						$sminute [] = "00";

						$year1=mb_substr("$next_date",0,10);
						$time1=mb_substr("$next_date",11,8);
						list($y1,$m1,$d1)=explode("-", $year1);
						list($y1,$m1,$d1)=explode("-", $year1);
						
						$fyear[] = $y1;
						$fmonth[] = $m1;
						$fday[] = $d1;
						$fhour[] = "08";
						$fminute [] = "00";

						$product_id[] = "";
						$number_sheet[] = "";
						$num_box[] = "";

					}

			}


		}


		if($get_target == 0){//チェックボタンが全て空白なら


			for($i=1;$i<=$kousu;$i++){

			//成形開始時間
				$date1=$syear[$i-1]."-".$smonth[$i-1]."-".$sday[$i-1];
				$time1 = $shour[$i-1].":".$sminute[$i-1];

				$date_yobidashi->select_date($date1,0);
				$date_yobidashi->select_time($time1);

				$starting_year = $date_yobidashi->get_year();
				$selected_starting_year = $date_yobidashi->get_selected_year();
				$starting_month = $date_yobidashi->get_month();
				$selected_starting_month = $date_yobidashi->get_selected_month();
				$starting_day = $date_yobidashi->get_day();
				$selected_starting_day = $date_yobidashi->get_selected_day();
				$starting_hour = $date_yobidashi->get_select_hour();
				$selected_starting_hour = $date_yobidashi->get_selected_hour();
				$starting_minute = $date_yobidashi->get_select_minute();
				$selected_starting_minute = $date_yobidashi->get_selected_minute();

				//成形終了時間
				$date2=$fyear[$i-1]."-".$fmonth[$i-1]."-".$fday[$i-1];
				$time2 = $fhour[$i-1].":".$fminute[$i-1];

				$date_yobidashi->select_date($date2,0);
				$date_yobidashi->select_time($time2);

				$finishing_year = $date_yobidashi->get_year();
				$selected_finishing_year = $date_yobidashi->get_selected_year();
				$finishing_month = $date_yobidashi->get_month();
				$selected_finishing_month = $date_yobidashi->get_selected_month();
				$finishing_day = $date_yobidashi->get_day();
				$selected_finishing_day = $date_yobidashi->get_selected_day();
				$finishing_hour = $date_yobidashi->get_select_hour();
				$selected_finishing_hour = $date_yobidashi->get_selected_hour();
				$finishing_minute = $date_yobidashi->get_select_minute();
				$selected_finishing_minute = $date_yobidashi->get_selected_minute();

				$checked = "";
				$radio = "<input type='checkbox' name='target_p".$c."[]' value='".$product_id[$i-1]."' ".$checked.">";
	
				if($c==1){$ch1[]=array("radio"=>$radio,"product_id"=>$product_id[$i-1],
				"starting_year"=>$starting_year,"selected_starting_year"=>$selected_starting_year,
				"starting_month"=>$starting_month,"selected_starting_month"=>$selected_starting_month,
				"starting_day"=>$starting_day,"selected_starting_day"=>$selected_starting_day,
				"starting_hour"=>$starting_hour,"selected_starting_hour"=>$selected_starting_hour,
				"starting_minute"=>$starting_minute,"selected_starting_minute"=>$selected_starting_minute,
				"finishing_year"=>$finishing_year,"selected_finishing_year"=>$selected_finishing_year,
				"finishing_month"=>$finishing_month,"selected_finishing_month"=>$selected_finishing_month,
				"finishing_day"=>$finishing_day,"selected_finishing_day"=>$selected_finishing_day,
				"finishing_hour"=>$finishing_hour,"selected_finishing_hour"=>$selected_finishing_hour,
				"finishing_minute"=>$finishing_minute,"selected_finishing_minute"=>$selected_finishing_minute,
				"number_sheet"=>$number_sheet[$i-1],"num_box"=>$num_box[$i-1]);}
				elseif($c==2){$ch2[]=array("radio"=>$radio,"product_id"=>$product_id[$i-1],
				"starting_year"=>$starting_year,"selected_starting_year"=>$selected_starting_year,
				"starting_month"=>$starting_month,"selected_starting_month"=>$selected_starting_month,
				"starting_day"=>$starting_day,"selected_starting_day"=>$selected_starting_day,
				"starting_hour"=>$starting_hour,"selected_starting_hour"=>$selected_starting_hour,
				"starting_minute"=>$starting_minute,"selected_starting_minute"=>$selected_starting_minute,
				"finishing_year"=>$finishing_year,"selected_finishing_year"=>$selected_finishing_year,
				"finishing_month"=>$finishing_month,"selected_finishing_month"=>$selected_finishing_month,
				"finishing_day"=>$finishing_day,"selected_finishing_day"=>$selected_finishing_day,
				"finishing_hour"=>$finishing_hour,"selected_finishing_hour"=>$selected_finishing_hour,
				"finishing_minute"=>$finishing_minute,"selected_finishing_minute"=>$selected_finishing_minute,
				"number_sheet"=>$number_sheet[$i-1],"num_box"=>$num_box[$i-1]);}
				elseif($c==3){$ch3[]=array("radio"=>$radio,"product_id"=>$product_id[$i-1],
				"starting_year"=>$starting_year,"selected_starting_year"=>$selected_starting_year,
				"starting_month"=>$starting_month,"selected_starting_month"=>$selected_starting_month,
				"starting_day"=>$starting_day,"selected_starting_day"=>$selected_starting_day,
				"starting_hour"=>$starting_hour,"selected_starting_hour"=>$selected_starting_hour,
				"starting_minute"=>$starting_minute,"selected_starting_minute"=>$selected_starting_minute,
				"finishing_year"=>$finishing_year,"selected_finishing_year"=>$selected_finishing_year,
				"finishing_month"=>$finishing_month,"selected_finishing_month"=>$selected_finishing_month,
				"finishing_day"=>$finishing_day,"selected_finishing_day"=>$selected_finishing_day,
				"finishing_hour"=>$finishing_hour,"selected_finishing_hour"=>$selected_finishing_hour,
				"finishing_minute"=>$finishing_minute,"selected_finishing_minute"=>$selected_finishing_minute,
				"number_sheet"=>$number_sheet[$i-1],"num_box"=>$num_box[$i-1]);}
				elseif($c==4){$ch4[]=array("radio"=>$radio,"product_id"=>$product_id[$i-1],
				"starting_year"=>$starting_year,"selected_starting_year"=>$selected_starting_year,
				"starting_month"=>$starting_month,"selected_starting_month"=>$selected_starting_month,
				"starting_day"=>$starting_day,"selected_starting_day"=>$selected_starting_day,
				"starting_hour"=>$starting_hour,"selected_starting_hour"=>$selected_starting_hour,
				"starting_minute"=>$starting_minute,"selected_starting_minute"=>$selected_starting_minute,
				"finishing_year"=>$finishing_year,"selected_finishing_year"=>$selected_finishing_year,
				"finishing_month"=>$finishing_month,"selected_finishing_month"=>$selected_finishing_month,
				"finishing_day"=>$finishing_day,"selected_finishing_day"=>$selected_finishing_day,
				"finishing_hour"=>$finishing_hour,"selected_finishing_hour"=>$selected_finishing_hour,
				"finishing_minute"=>$finishing_minute,"selected_finishing_minute"=>$selected_finishing_minute,
				"number_sheet"=>$number_sheet[$i-1],"num_box"=>$num_box[$i-1]);}
				elseif($c==5){$ch5[]=array("radio"=>$radio,"product_id"=>$product_id[$i-1],
				"starting_year"=>$starting_year,"selected_starting_year"=>$selected_starting_year,
				"starting_month"=>$starting_month,"selected_starting_month"=>$selected_starting_month,
				"starting_day"=>$starting_day,"selected_starting_day"=>$selected_starting_day,
				"starting_hour"=>$starting_hour,"selected_starting_hour"=>$selected_starting_hour,
				"starting_minute"=>$starting_minute,"selected_starting_minute"=>$selected_starting_minute,
				"finishing_year"=>$finishing_year,"selected_finishing_year"=>$selected_finishing_year,
				"finishing_month"=>$finishing_month,"selected_finishing_month"=>$selected_finishing_month,
				"finishing_day"=>$finishing_day,"selected_finishing_day"=>$selected_finishing_day,
				"finishing_hour"=>$finishing_hour,"selected_finishing_hour"=>$selected_finishing_hour,
				"finishing_minute"=>$finishing_minute,"selected_finishing_minute"=>$selected_finishing_minute,
				"number_sheet"=>$number_sheet[$i-1],"num_box"=>$num_box[$i-1]);}
				elseif($c==6){$ch6[]=array("radio"=>$radio,"product_id"=>$product_id[$i-1],
				"starting_year"=>$starting_year,"selected_starting_year"=>$selected_starting_year,
				"starting_month"=>$starting_month,"selected_starting_month"=>$selected_starting_month,
				"starting_day"=>$starting_day,"selected_starting_day"=>$selected_starting_day,
				"starting_hour"=>$starting_hour,"selected_starting_hour"=>$selected_starting_hour,
				"starting_minute"=>$starting_minute,"selected_starting_minute"=>$selected_starting_minute,
				"finishing_year"=>$finishing_year,"selected_finishing_year"=>$selected_finishing_year,
				"finishing_month"=>$finishing_month,"selected_finishing_month"=>$selected_finishing_month,
				"finishing_day"=>$finishing_day,"selected_finishing_day"=>$selected_finishing_day,
				"finishing_hour"=>$finishing_hour,"selected_finishing_hour"=>$selected_finishing_hour,
				"finishing_minute"=>$finishing_minute,"selected_finishing_minute"=>$selected_finishing_minute,
				"number_sheet"=>$number_sheet[$i-1],"num_box"=>$num_box[$i-1]);}
				elseif($c==7){$ch7[]=array("radio"=>$radio,"product_id"=>$product_id[$i-1],
				"starting_year"=>$starting_year,"selected_starting_year"=>$selected_starting_year,
				"starting_month"=>$starting_month,"selected_starting_month"=>$selected_starting_month,
				"starting_day"=>$starting_day,"selected_starting_day"=>$selected_starting_day,
				"starting_hour"=>$starting_hour,"selected_starting_hour"=>$selected_starting_hour,
				"starting_minute"=>$starting_minute,"selected_starting_minute"=>$selected_starting_minute,
				"finishing_year"=>$finishing_year,"selected_finishing_year"=>$selected_finishing_year,
				"finishing_month"=>$finishing_month,"selected_finishing_month"=>$selected_finishing_month,
				"finishing_day"=>$finishing_day,"selected_finishing_day"=>$selected_finishing_day,
				"finishing_hour"=>$finishing_hour,"selected_finishing_hour"=>$selected_finishing_hour,
				"finishing_minute"=>$finishing_minute,"selected_finishing_minute"=>$selected_finishing_minute,
				"number_sheet"=>$number_sheet[$i-1],"num_box"=>$num_box[$i-1]);}
				elseif($c==8){$ch8[]=array("radio"=>$radio,"product_id"=>$product_id[$i-1],
				"starting_year"=>$starting_year,"selected_starting_year"=>$selected_starting_year,
				"starting_month"=>$starting_month,"selected_starting_month"=>$selected_starting_month,
				"starting_day"=>$starting_day,"selected_starting_day"=>$selected_starting_day,
				"starting_hour"=>$starting_hour,"selected_starting_hour"=>$selected_starting_hour,
				"starting_minute"=>$starting_minute,"selected_starting_minute"=>$selected_starting_minute,
				"finishing_year"=>$finishing_year,"selected_finishing_year"=>$selected_finishing_year,
				"finishing_month"=>$finishing_month,"selected_finishing_month"=>$selected_finishing_month,
				"finishing_day"=>$finishing_day,"selected_finishing_day"=>$selected_finishing_day,
				"finishing_hour"=>$finishing_hour,"selected_finishing_hour"=>$selected_finishing_hour,
				"finishing_minute"=>$finishing_minute,"selected_finishing_minute"=>$selected_finishing_minute,
				"number_sheet"=>$number_sheet[$i-1],"num_box"=>$num_box[$i-1]);}
				else{$ch9[]=array("radio"=>$radio,"product_id"=>$product_id[$i-1],
				"starting_year"=>$starting_year,"selected_starting_year"=>$selected_starting_year,
				"starting_month"=>$starting_month,"selected_starting_month"=>$selected_starting_month,
				"starting_day"=>$starting_day,"selected_starting_day"=>$selected_starting_day,
				"starting_hour"=>$starting_hour,"selected_starting_hour"=>$selected_starting_hour,
				"starting_minute"=>$starting_minute,"selected_starting_minute"=>$selected_starting_minute,
				"finishing_year"=>$finishing_year,"selected_finishing_year"=>$selected_finishing_year,
				"finishing_month"=>$finishing_month,"selected_finishing_month"=>$selected_finishing_month,
				"finishing_day"=>$finishing_day,"selected_finishing_day"=>$selected_finishing_day,
				"finishing_hour"=>$finishing_hour,"selected_finishing_hour"=>$selected_finishing_hour,
				"finishing_minute"=>$finishing_minute,"selected_finishing_minute"=>$selected_finishing_minute,
				"number_sheet"=>$number_sheet[$i-1],"num_box"=>$num_box[$i-1]);}

			}

		}else{//チェックボタンにチェックが入っているなら


			for($j=0;$j<$kousu;$j++){

				if($product_id[$j] <> $target_product){

					//成形開始時間
					$date1=$syear[$j]."-".$smonth[$j]."-".$sday[$j];
					$time1 = $shour[$j].":".$sminute[$j];

					$date_yobidashi->select_date($date1,0);
					$date_yobidashi->select_time($time1);

					$starting_year = $date_yobidashi->get_year();
					$selected_starting_year = $date_yobidashi->get_selected_year();
					$starting_month = $date_yobidashi->get_month();
					$selected_starting_month = $date_yobidashi->get_selected_month();
					$starting_day = $date_yobidashi->get_day();
					$selected_starting_day = $date_yobidashi->get_selected_day();
					$starting_hour = $date_yobidashi->get_select_hour();
					$selected_starting_hour = $date_yobidashi->get_selected_hour();
					$starting_minute = $date_yobidashi->get_select_minute();
					$selected_starting_minute = $date_yobidashi->get_selected_minute();

					//成形終了時間
					$date2=$fyear[$j]."-".$fmonth[$j]."-".$fday[$j];
					$time2 = $fhour[$j].":".$fminute[$j];

					$date_yobidashi->select_date($date2,0);
					$date_yobidashi->select_time($time2);

					$finishing_year = $date_yobidashi->get_year();
					$selected_finishing_year = $date_yobidashi->get_selected_year();
					$finishing_month = $date_yobidashi->get_month();
					$selected_finishing_month = $date_yobidashi->get_selected_month();
					$finishing_day = $date_yobidashi->get_day();
					$selected_finishing_day = $date_yobidashi->get_selected_day();
					$finishing_hour = $date_yobidashi->get_select_hour();
					$selected_finishing_hour = $date_yobidashi->get_selected_hour();
					$finishing_minute = $date_yobidashi->get_select_minute();
					$selected_finishing_minute = $date_yobidashi->get_selected_minute();

					$checked = "";
					$radio = "<input type='checkbox' name='target_p".$c."[]' value='".$product_id[$j]."' ".$checked.">";

						if($c==1){$ch1[]=array("radio"=>$radio,"product_id"=>$product_id[$j],
						"starting_year"=>$starting_year,"selected_starting_year"=>$selected_starting_year,
						"starting_month"=>$starting_month,"selected_starting_month"=>$selected_starting_month,
						"starting_day"=>$starting_day,"selected_starting_day"=>$selected_starting_day,
						"starting_hour"=>$starting_hour,"selected_starting_hour"=>$selected_starting_hour,
						"starting_minute"=>$starting_minute,"selected_starting_minute"=>$selected_starting_minute,
						"finishing_year"=>$finishing_year,"selected_finishing_year"=>$selected_finishing_year,
						"finishing_month"=>$finishing_month,"selected_finishing_month"=>$selected_finishing_month,
						"finishing_day"=>$finishing_day,"selected_finishing_day"=>$selected_finishing_day,
						"finishing_hour"=>$finishing_hour,"selected_finishing_hour"=>$selected_finishing_hour,
						"finishing_minute"=>$finishing_minute,"selected_finishing_minute"=>$selected_finishing_minute,
						"number_sheet"=>$number_sheet[$j],"num_box"=>$num_box[$j]);}
						elseif($c==2){$ch2[]=array("radio"=>$radio,"product_id"=>$product_id[$j],
						"starting_year"=>$starting_year,"selected_starting_year"=>$selected_starting_year,
						"starting_month"=>$starting_month,"selected_starting_month"=>$selected_starting_month,
						"starting_day"=>$starting_day,"selected_starting_day"=>$selected_starting_day,
						"starting_hour"=>$starting_hour,"selected_starting_hour"=>$selected_starting_hour,
						"starting_minute"=>$starting_minute,"selected_starting_minute"=>$selected_starting_minute,
						"finishing_year"=>$finishing_year,"selected_finishing_year"=>$selected_finishing_year,
						"finishing_month"=>$finishing_month,"selected_finishing_month"=>$selected_finishing_month,
						"finishing_day"=>$finishing_day,"selected_finishing_day"=>$selected_finishing_day,
						"finishing_hour"=>$finishing_hour,"selected_finishing_hour"=>$selected_finishing_hour,
						"finishing_minute"=>$finishing_minute,"selected_finishing_minute"=>$selected_finishing_minute,
						"number_sheet"=>$number_sheet[$j],"num_box"=>$num_box[$j]);}
						elseif($c==3){$ch3[]=array("radio"=>$radio,"product_id"=>$product_id[$j],
						"starting_year"=>$starting_year,"selected_starting_year"=>$selected_starting_year,
						"starting_month"=>$starting_month,"selected_starting_month"=>$selected_starting_month,
						"starting_day"=>$starting_day,"selected_starting_day"=>$selected_starting_day,
						"starting_hour"=>$starting_hour,"selected_starting_hour"=>$selected_starting_hour,
						"starting_minute"=>$starting_minute,"selected_starting_minute"=>$selected_starting_minute,
						"finishing_year"=>$finishing_year,"selected_finishing_year"=>$selected_finishing_year,
						"finishing_month"=>$finishing_month,"selected_finishing_month"=>$selected_finishing_month,
						"finishing_day"=>$finishing_day,"selected_finishing_day"=>$selected_finishing_day,
						"finishing_hour"=>$finishing_hour,"selected_finishing_hour"=>$selected_finishing_hour,
						"finishing_minute"=>$finishing_minute,"selected_finishing_minute"=>$selected_finishing_minute,
						"number_sheet"=>$number_sheet[$j],"num_box"=>$num_box[$j]);}
						elseif($c==4){$ch4[]=array("radio"=>$radio,"product_id"=>$product_id[$j],
						"starting_year"=>$starting_year,"selected_starting_year"=>$selected_starting_year,
						"starting_month"=>$starting_month,"selected_starting_month"=>$selected_starting_month,
						"starting_day"=>$starting_day,"selected_starting_day"=>$selected_starting_day,
						"starting_hour"=>$starting_hour,"selected_starting_hour"=>$selected_starting_hour,
						"starting_minute"=>$starting_minute,"selected_starting_minute"=>$selected_starting_minute,
						"finishing_year"=>$finishing_year,"selected_finishing_year"=>$selected_finishing_year,
						"finishing_month"=>$finishing_month,"selected_finishing_month"=>$selected_finishing_month,
						"finishing_day"=>$finishing_day,"selected_finishing_day"=>$selected_finishing_day,
						"finishing_hour"=>$finishing_hour,"selected_finishing_hour"=>$selected_finishing_hour,
						"finishing_minute"=>$finishing_minute,"selected_finishing_minute"=>$selected_finishing_minute,
						"number_sheet"=>$number_sheet[$j],"num_box"=>$num_box[$j]);}
						elseif($c==5){$ch5[]=array("radio"=>$radio,"product_id"=>$product_id[$j],
						"starting_year"=>$starting_year,"selected_starting_year"=>$selected_starting_year,
						"starting_month"=>$starting_month,"selected_starting_month"=>$selected_starting_month,
						"starting_day"=>$starting_day,"selected_starting_day"=>$selected_starting_day,
						"starting_hour"=>$starting_hour,"selected_starting_hour"=>$selected_starting_hour,
						"starting_minute"=>$starting_minute,"selected_starting_minute"=>$selected_starting_minute,
						"finishing_year"=>$finishing_year,"selected_finishing_year"=>$selected_finishing_year,
						"finishing_month"=>$finishing_month,"selected_finishing_month"=>$selected_finishing_month,
						"finishing_day"=>$finishing_day,"selected_finishing_day"=>$selected_finishing_day,
						"finishing_hour"=>$finishing_hour,"selected_finishing_hour"=>$selected_finishing_hour,
						"finishing_minute"=>$finishing_minute,"selected_finishing_minute"=>$selected_finishing_minute,
						"number_sheet"=>$number_sheet[$j],"num_box"=>$num_box[$j]);}
						elseif($c==6){$ch6[]=array("radio"=>$radio,"product_id"=>$product_id[$j],
						"starting_year"=>$starting_year,"selected_starting_year"=>$selected_starting_year,
						"starting_month"=>$starting_month,"selected_starting_month"=>$selected_starting_month,
						"starting_day"=>$starting_day,"selected_starting_day"=>$selected_starting_day,
						"starting_hour"=>$starting_hour,"selected_starting_hour"=>$selected_starting_hour,
						"starting_minute"=>$starting_minute,"selected_starting_minute"=>$selected_starting_minute,
						"finishing_year"=>$finishing_year,"selected_finishing_year"=>$selected_finishing_year,
						"finishing_month"=>$finishing_month,"selected_finishing_month"=>$selected_finishing_month,
						"finishing_day"=>$finishing_day,"selected_finishing_day"=>$selected_finishing_day,
						"finishing_hour"=>$finishing_hour,"selected_finishing_hour"=>$selected_finishing_hour,
						"finishing_minute"=>$finishing_minute,"selected_finishing_minute"=>$selected_finishing_minute,
						"number_sheet"=>$number_sheet[$j],"num_box"=>$num_box[$j]);}
						elseif($c==7){$ch7[]=array("radio"=>$radio,"product_id"=>$product_id[$j],
						"starting_year"=>$starting_year,"selected_starting_year"=>$selected_starting_year,
						"starting_month"=>$starting_month,"selected_starting_month"=>$selected_starting_month,
						"starting_day"=>$starting_day,"selected_starting_day"=>$selected_starting_day,
						"starting_hour"=>$starting_hour,"selected_starting_hour"=>$selected_starting_hour,
						"starting_minute"=>$starting_minute,"selected_starting_minute"=>$selected_starting_minute,
						"finishing_year"=>$finishing_year,"selected_finishing_year"=>$selected_finishing_year,
						"finishing_month"=>$finishing_month,"selected_finishing_month"=>$selected_finishing_month,
						"finishing_day"=>$finishing_day,"selected_finishing_day"=>$selected_finishing_day,
						"finishing_hour"=>$finishing_hour,"selected_finishing_hour"=>$selected_finishing_hour,
						"finishing_minute"=>$finishing_minute,"selected_finishing_minute"=>$selected_finishing_minute,
						"number_sheet"=>$number_sheet[$j],"num_box"=>$num_box[$j]);}
						elseif($c==8){$ch8[]=array("radio"=>$radio,"product_id"=>$product_id[$j],
						"starting_year"=>$starting_year,"selected_starting_year"=>$selected_starting_year,
						"starting_month"=>$starting_month,"selected_starting_month"=>$selected_starting_month,
						"starting_day"=>$starting_day,"selected_starting_day"=>$selected_starting_day,
						"starting_hour"=>$starting_hour,"selected_starting_hour"=>$selected_starting_hour,
						"starting_minute"=>$starting_minute,"selected_starting_minute"=>$selected_starting_minute,
						"finishing_year"=>$finishing_year,"selected_finishing_year"=>$selected_finishing_year,
						"finishing_month"=>$finishing_month,"selected_finishing_month"=>$selected_finishing_month,
						"finishing_day"=>$finishing_day,"selected_finishing_day"=>$selected_finishing_day,
						"finishing_hour"=>$finishing_hour,"selected_finishing_hour"=>$selected_finishing_hour,
						"finishing_minute"=>$finishing_minute,"selected_finishing_minute"=>$selected_finishing_minute,
						"number_sheet"=>$number_sheet[$j],"num_box"=>$num_box[$j]);}
						else{$ch9[]=array("radio"=>$radio,"product_id"=>$product_id[$j],
						"starting_year"=>$starting_year,"selected_starting_year"=>$selected_starting_year,
						"starting_month"=>$starting_month,"selected_starting_month"=>$selected_starting_month,
						"starting_day"=>$starting_day,"selected_starting_day"=>$selected_starting_day,
						"starting_hour"=>$starting_hour,"selected_starting_hour"=>$selected_starting_hour,
						"starting_minute"=>$starting_minute,"selected_starting_minute"=>$selected_starting_minute,
						"finishing_year"=>$finishing_year,"selected_finishing_year"=>$selected_finishing_year,
						"finishing_month"=>$finishing_month,"selected_finishing_month"=>$selected_finishing_month,
						"finishing_day"=>$finishing_day,"selected_finishing_day"=>$selected_finishing_day,
						"finishing_hour"=>$finishing_hour,"selected_finishing_hour"=>$selected_finishing_hour,
						"finishing_minute"=>$finishing_minute,"selected_finishing_minute"=>$selected_finishing_minute,
						"number_sheet"=>$number_sheet[$j],"num_box"=>$num_box[$j]);}
					}

				}

		}

	}

		$smarty->assign("value",$target_product);

		$smarty->assign("ch1",$ch1);
		$smarty->assign("ch2",$ch2);
		$smarty->assign("ch3",$ch3);
		$smarty->assign("ch4",$ch4);
		$smarty->assign("ch5",$ch5);
		$smarty->assign("ch6",$ch6);
		$smarty->assign("ch7",$ch7);
		$smarty->assign("ch8",$ch8);
		$smarty->assign("ch9",$ch9);
		$smarty->assign("year",$_POST['year']);
		$smarty->assign("month",$_POST['month']);
		$smarty->assign("day",$_POST['day']);
		$smarty->display("form_hakkou.tpl");
		unset($smarty);
		unset($db);
		exit;
}elseif($_POST['all_delete'] <> "" ){//チェックした工程全て削除ボタンを押したとき

	for($c=1;$c<=9;$c++){


			$get_target = 0;
			
			$target_p = $_POST['target_p'.$c.''];
			$product_id=$_POST['ch'.$c.'_product_id'];
			$product_id=$_POST['ch'.$c.'_product_id'];
			$syear=$_POST['ch'.$c.'_syear'];
			$smonth=$_POST['ch'.$c.'_smonth'];
			$sday=$_POST['ch'.$c.'_sday'];
			$shour=$_POST['ch'.$c.'_shour'];
			$sminute=$_POST['ch'.$c.'_sminute'];
			$fyear=$_POST['ch'.$c.'_fyear'];
			$fmonth=$_POST['ch'.$c.'_fmonth'];
			$fday=$_POST['ch'.$c.'_fday'];
			$fhour=$_POST['ch'.$c.'_fhour'];
			$fminute=$_POST['ch'.$c.'_fminute'];
			$number_sheet=$_POST['ch'.$c.'_number_sheet'];
			$num_box=$_POST['ch'.$c.'_num_box'];

			$kousu=count($product_id) ;

			//チェックボックスをチェックした要素を探す
			for($h=0;$h<$kousu;$h++){

				if($target_p[$h] <> ""){

					//$get_target = 1;
					$target_product = $target_p[$h];

				}

			}

			for($j=0;$j<$kousu;$j++){

				if($product_id[$j] <> $target_product){

					//成形開始時間
					$date1=$syear[$j]."-".$smonth[$j]."-".$sday[$j];
					$time1 = $shour[$j].":".$sminute[$j];

					$date_yobidashi->select_date($date1);
					$date_yobidashi->select_time($time1);

					$starting_year = $date_yobidashi->get_year();
					$selected_starting_year = $date_yobidashi->get_selected_year();
					$starting_month = $date_yobidashi->get_month();
					$selected_starting_month = $date_yobidashi->get_selected_month();
					$starting_day = $date_yobidashi->get_day();
					$selected_starting_day = $date_yobidashi->get_selected_day();
					$starting_hour = $date_yobidashi->get_select_hour();
					$selected_starting_hour = $date_yobidashi->get_selected_hour();
					$starting_minute = $date_yobidashi->get_select_minute();
					$selected_starting_minute = $date_yobidashi->get_selected_minute();

					//成形終了時間
					$date2=$fyear[$j]."-".$fmonth[$j]."-".$fday[$j];
					$time2 = $fhour[$j].":".$fminute[$j];

					$date_yobidashi->select_date($date2);
					$date_yobidashi->select_time($time2);

					$finishing_year = $date_yobidashi->get_year();
					$selected_finishing_year = $date_yobidashi->get_selected_year();
					$finishing_month = $date_yobidashi->get_month();
					$selected_finishing_month = $date_yobidashi->get_selected_month();
					$finishing_day = $date_yobidashi->get_day();
					$selected_finishing_day = $date_yobidashi->get_selected_day();
					$finishing_hour = $date_yobidashi->get_select_hour();
					$selected_finishing_hour = $date_yobidashi->get_selected_hour();
					$finishing_minute = $date_yobidashi->get_select_minute();
					$selected_finishing_minute = $date_yobidashi->get_selected_minute();

					$checked = "";
					$radio = "<input type='checkbox' name='target_p".$c."[]' value='".$product_id[$j]."' ".$checked.">";

						if($c==1){$ch1[]=array("radio"=>$radio,"product_id"=>$product_id[$j],
						"starting_year"=>$starting_year,"selected_starting_year"=>$selected_starting_year,
						"starting_month"=>$starting_month,"selected_starting_month"=>$selected_starting_month,
						"starting_day"=>$starting_day,"selected_starting_day"=>$selected_starting_day,
						"starting_hour"=>$starting_hour,"selected_starting_hour"=>$selected_starting_hour,
						"starting_minute"=>$starting_minute,"selected_starting_minute"=>$selected_starting_minute,
						"finishing_year"=>$finishing_year,"selected_finishing_year"=>$selected_finishing_year,
						"finishing_month"=>$finishing_month,"selected_finishing_month"=>$selected_finishing_month,
						"finishing_day"=>$finishing_day,"selected_finishing_day"=>$selected_finishing_day,
						"finishing_hour"=>$finishing_hour,"selected_finishing_hour"=>$selected_finishing_hour,
						"finishing_minute"=>$finishing_minute,"selected_finishing_minute"=>$selected_finishing_minute,
						"number_sheet"=>$number_sheet[$j],"num_box"=>$num_box[$j]);}
						elseif($c==2){$ch2[]=array("radio"=>$radio,"product_id"=>$product_id[$j],
						"starting_year"=>$starting_year,"selected_starting_year"=>$selected_starting_year,
						"starting_month"=>$starting_month,"selected_starting_month"=>$selected_starting_month,
						"starting_day"=>$starting_day,"selected_starting_day"=>$selected_starting_day,
						"starting_hour"=>$starting_hour,"selected_starting_hour"=>$selected_starting_hour,
						"starting_minute"=>$starting_minute,"selected_starting_minute"=>$selected_starting_minute,
						"finishing_year"=>$finishing_year,"selected_finishing_year"=>$selected_finishing_year,
						"finishing_month"=>$finishing_month,"selected_finishing_month"=>$selected_finishing_month,
						"finishing_day"=>$finishing_day,"selected_finishing_day"=>$selected_finishing_day,
						"finishing_hour"=>$finishing_hour,"selected_finishing_hour"=>$selected_finishing_hour,
						"finishing_minute"=>$finishing_minute,"selected_finishing_minute"=>$selected_finishing_minute,
						"number_sheet"=>$number_sheet[$j],"num_box"=>$num_box[$j]);}
						elseif($c==3){$ch3[]=array("radio"=>$radio,"product_id"=>$product_id[$j],
						"starting_year"=>$starting_year,"selected_starting_year"=>$selected_starting_year,
						"starting_month"=>$starting_month,"selected_starting_month"=>$selected_starting_month,
						"starting_day"=>$starting_day,"selected_starting_day"=>$selected_starting_day,
						"starting_hour"=>$starting_hour,"selected_starting_hour"=>$selected_starting_hour,
						"starting_minute"=>$starting_minute,"selected_starting_minute"=>$selected_starting_minute,
						"finishing_year"=>$finishing_year,"selected_finishing_year"=>$selected_finishing_year,
						"finishing_month"=>$finishing_month,"selected_finishing_month"=>$selected_finishing_month,
						"finishing_day"=>$finishing_day,"selected_finishing_day"=>$selected_finishing_day,
						"finishing_hour"=>$finishing_hour,"selected_finishing_hour"=>$selected_finishing_hour,
						"finishing_minute"=>$finishing_minute,"selected_finishing_minute"=>$selected_finishing_minute,
						"number_sheet"=>$number_sheet[$j],"num_box"=>$num_box[$j]);}
						elseif($c==4){$ch4[]=array("radio"=>$radio,"product_id"=>$product_id[$j],
						"starting_year"=>$starting_year,"selected_starting_year"=>$selected_starting_year,
						"starting_month"=>$starting_month,"selected_starting_month"=>$selected_starting_month,
						"starting_day"=>$starting_day,"selected_starting_day"=>$selected_starting_day,
						"starting_hour"=>$starting_hour,"selected_starting_hour"=>$selected_starting_hour,
						"starting_minute"=>$starting_minute,"selected_starting_minute"=>$selected_starting_minute,
						"finishing_year"=>$finishing_year,"selected_finishing_year"=>$selected_finishing_year,
						"finishing_month"=>$finishing_month,"selected_finishing_month"=>$selected_finishing_month,
						"finishing_day"=>$finishing_day,"selected_finishing_day"=>$selected_finishing_day,
						"finishing_hour"=>$finishing_hour,"selected_finishing_hour"=>$selected_finishing_hour,
						"finishing_minute"=>$finishing_minute,"selected_finishing_minute"=>$selected_finishing_minute,
						"number_sheet"=>$number_sheet[$j],"num_box"=>$num_box[$j]);}
						elseif($c==5){$ch5[]=array("radio"=>$radio,"product_id"=>$product_id[$j],
						"starting_year"=>$starting_year,"selected_starting_year"=>$selected_starting_year,
						"starting_month"=>$starting_month,"selected_starting_month"=>$selected_starting_month,
						"starting_day"=>$starting_day,"selected_starting_day"=>$selected_starting_day,
						"starting_hour"=>$starting_hour,"selected_starting_hour"=>$selected_starting_hour,
						"starting_minute"=>$starting_minute,"selected_starting_minute"=>$selected_starting_minute,
						"finishing_year"=>$finishing_year,"selected_finishing_year"=>$selected_finishing_year,
						"finishing_month"=>$finishing_month,"selected_finishing_month"=>$selected_finishing_month,
						"finishing_day"=>$finishing_day,"selected_finishing_day"=>$selected_finishing_day,
						"finishing_hour"=>$finishing_hour,"selected_finishing_hour"=>$selected_finishing_hour,
						"finishing_minute"=>$finishing_minute,"selected_finishing_minute"=>$selected_finishing_minute,
						"number_sheet"=>$number_sheet[$j],"num_box"=>$num_box[$j]);}
						elseif($c==6){$ch6[]=array("radio"=>$radio,"product_id"=>$product_id[$j],
						"starting_year"=>$starting_year,"selected_starting_year"=>$selected_starting_year,
						"starting_month"=>$starting_month,"selected_starting_month"=>$selected_starting_month,
						"starting_day"=>$starting_day,"selected_starting_day"=>$selected_starting_day,
						"starting_hour"=>$starting_hour,"selected_starting_hour"=>$selected_starting_hour,
						"starting_minute"=>$starting_minute,"selected_starting_minute"=>$selected_starting_minute,
						"finishing_year"=>$finishing_year,"selected_finishing_year"=>$selected_finishing_year,
						"finishing_month"=>$finishing_month,"selected_finishing_month"=>$selected_finishing_month,
						"finishing_day"=>$finishing_day,"selected_finishing_day"=>$selected_finishing_day,
						"finishing_hour"=>$finishing_hour,"selected_finishing_hour"=>$selected_finishing_hour,
						"finishing_minute"=>$finishing_minute,"selected_finishing_minute"=>$selected_finishing_minute,
						"number_sheet"=>$number_sheet[$j],"num_box"=>$num_box[$j]);}
						elseif($c==7){$ch7[]=array("radio"=>$radio,"product_id"=>$product_id[$j],
						"starting_year"=>$starting_year,"selected_starting_year"=>$selected_starting_year,
						"starting_month"=>$starting_month,"selected_starting_month"=>$selected_starting_month,
						"starting_day"=>$starting_day,"selected_starting_day"=>$selected_starting_day,
						"starting_hour"=>$starting_hour,"selected_starting_hour"=>$selected_starting_hour,
						"starting_minute"=>$starting_minute,"selected_starting_minute"=>$selected_starting_minute,
						"finishing_year"=>$finishing_year,"selected_finishing_year"=>$selected_finishing_year,
						"finishing_month"=>$finishing_month,"selected_finishing_month"=>$selected_finishing_month,
						"finishing_day"=>$finishing_day,"selected_finishing_day"=>$selected_finishing_day,
						"finishing_hour"=>$finishing_hour,"selected_finishing_hour"=>$selected_finishing_hour,
						"finishing_minute"=>$finishing_minute,"selected_finishing_minute"=>$selected_finishing_minute,
						"number_sheet"=>$number_sheet[$j],"num_box"=>$num_box[$j]);}
						elseif($c==8){$ch8[]=array("radio"=>$radio,"product_id"=>$product_id[$j],
						"starting_year"=>$starting_year,"selected_starting_year"=>$selected_starting_year,
						"starting_month"=>$starting_month,"selected_starting_month"=>$selected_starting_month,
						"starting_day"=>$starting_day,"selected_starting_day"=>$selected_starting_day,
						"starting_hour"=>$starting_hour,"selected_starting_hour"=>$selected_starting_hour,
						"starting_minute"=>$starting_minute,"selected_starting_minute"=>$selected_starting_minute,
						"finishing_year"=>$finishing_year,"selected_finishing_year"=>$selected_finishing_year,
						"finishing_month"=>$finishing_month,"selected_finishing_month"=>$selected_finishing_month,
						"finishing_day"=>$finishing_day,"selected_finishing_day"=>$selected_finishing_day,
						"finishing_hour"=>$finishing_hour,"selected_finishing_hour"=>$selected_finishing_hour,
						"finishing_minute"=>$finishing_minute,"selected_finishing_minute"=>$selected_finishing_minute,
						"number_sheet"=>$number_sheet[$j],"num_box"=>$num_box[$j]);}
						else{$ch9[]=array("radio"=>$radio,"product_id"=>$product_id[$j],
						"starting_year"=>$starting_year,"selected_starting_year"=>$selected_starting_year,
						"starting_month"=>$starting_month,"selected_starting_month"=>$selected_starting_month,
						"starting_day"=>$starting_day,"selected_starting_day"=>$selected_starting_day,
						"starting_hour"=>$starting_hour,"selected_starting_hour"=>$selected_starting_hour,
						"starting_minute"=>$starting_minute,"selected_starting_minute"=>$selected_starting_minute,
						"finishing_year"=>$finishing_year,"selected_finishing_year"=>$selected_finishing_year,
						"finishing_month"=>$finishing_month,"selected_finishing_month"=>$selected_finishing_month,
						"finishing_day"=>$finishing_day,"selected_finishing_day"=>$selected_finishing_day,
						"finishing_hour"=>$finishing_hour,"selected_finishing_hour"=>$selected_finishing_hour,
						"finishing_minute"=>$finishing_minute,"selected_finishing_minute"=>$selected_finishing_minute,
						"number_sheet"=>$number_sheet[$j],"num_box"=>$num_box[$j]);}
				}

			}

	}

		$smarty->assign("value",$value);

		$smarty->assign("ch1",$ch1);
		$smarty->assign("ch2",$ch2);
		$smarty->assign("ch3",$ch3);
		$smarty->assign("ch4",$ch4);
		$smarty->assign("ch5",$ch5);
		$smarty->assign("ch6",$ch6);
		$smarty->assign("ch7",$ch7);
		$smarty->assign("ch8",$ch8);
		$smarty->assign("ch9",$ch9);
		$smarty->assign("year",$_POST['year']);
		$smarty->assign("month",$_POST['month']);
		$smarty->assign("day",$_POST['day']);
		$smarty->display("form_hakkou.tpl");
		unset($smarty);
		unset($db);
		exit;

}elseif($_POST['touroku'] <> "" ){//登録確認画面へ

	for($c=1;$c<=9;$c++){

		$product_id=$_POST['ch'.$c.'_product_id'];
		$syear=$_POST['ch'.$c.'_syear'];
		$smonth=$_POST['ch'.$c.'_smonth'];
		$sday=$_POST['ch'.$c.'_sday'];
		$shour=$_POST['ch'.$c.'_shour'];
		$sminute=$_POST['ch'.$c.'_sminute'];
		$fyear=$_POST['ch'.$c.'_fyear'];
		$fmonth=$_POST['ch'.$c.'_fmonth'];
		$fday=$_POST['ch'.$c.'_fday'];
		$fhour=$_POST['ch'.$c.'_fhour'];
		$fminute=$_POST['ch'.$c.'_fminute'];
		$number_sheet=$_POST['ch'.$c.'_number_sheet'];
		$num_box=$_POST['ch'.$c.'_num_box'];

		$count_pro=count($_POST['ch'.$c.'_product_id']);

		for($i=0;$i<$count_pro;$i++){

				$db->query("set names sjis");
				$rs=$db->query("select product_id from product where product_id = '".$product_id[$i]."'");
				$product_rows=$rs->numRows();

				if($product_rows==0){

					$err_mess=$c."chの品番は登録されていません。<br>製品登録からはじめてください。";
					$smarty->assign("err_mess",$err_mess);
					$smarty->display("error_input.tpl");
					unset($smarty);
					unset($db);
					exit;

				}else{

					$s_daytime=$syear[$i]."-".$smonth[$i]."-".$sday[$i]." ".$shour[$i].":".$sminute[$i];
					$f_daytime=$fyear[$i]."-".$fmonth[$i]."-".$fday[$i]." ".$fhour[$i].":".$fminute[$i];

					if($c==1){$ch1[]=array("product_id"=>$product_id[$i],"starting_tm"=>$s_daytime,"finishing_tm"=>$f_daytime,"number_sheet"=>$number_sheet[$i],"num_box"=>$num_box[$i]);}

					elseif($c==2){$ch2[]=array("product_id"=>$product_id[$i],"starting_tm"=>$s_daytime,"finishing_tm"=>$f_daytime,"number_sheet"=>$number_sheet[$i],"num_box"=>$num_box[$i]);}

					elseif($c==3){$ch3[]=array("product_id"=>$product_id[$i],"starting_tm"=>$s_daytime,"finishing_tm"=>$f_daytime,"number_sheet"=>$number_sheet[$i],"num_box"=>$num_box[$i]);}

					elseif($c==4){$ch4[]=array("product_id"=>$product_id[$i],"starting_tm"=>$s_daytime,"finishing_tm"=>$f_daytime,"number_sheet"=>$number_sheet[$i],"num_box"=>$num_box[$i]);}

					elseif($c==5){$ch5[]=array("product_id"=>$product_id[$i],"starting_tm"=>$s_daytime,"finishing_tm"=>$f_daytime,"number_sheet"=>$number_sheet[$i],"num_box"=>$num_box[$i]);}

					elseif($c==6){$ch6[]=array("product_id"=>$product_id[$i],"starting_tm"=>$s_daytime,"finishing_tm"=>$f_daytime,"number_sheet"=>$number_sheet[$i],"num_box"=>$num_box[$i]);}

					elseif($c==7){$ch7[]=array("product_id"=>$product_id[$i],"starting_tm"=>$s_daytime,"finishing_tm"=>$f_daytime,"number_sheet"=>$number_sheet[$i],"num_box"=>$num_box[$i]);}

					elseif($c==8){$ch8[]=array("product_id"=>$product_id[$i],"starting_tm"=>$s_daytime,"finishing_tm"=>$f_daytime,"number_sheet"=>$number_sheet[$i],"num_box"=>$num_box[$i]);}

					elseif($c==9){$ch9[]=array("product_id"=>$product_id[$i],"starting_tm"=>$s_daytime,"finishing_tm"=>$f_daytime,"number_sheet"=>$number_sheet[$i],"num_box"=>$num_box[$i]);}

				}

		}

	}

		
		$smarty->assign("ch1",$ch1);
		$smarty->assign("ch2",$ch2);
		$smarty->assign("ch3",$ch3);
		$smarty->assign("ch4",$ch4);
		$smarty->assign("ch5",$ch5);
		$smarty->assign("ch6",$ch6);
		$smarty->assign("ch7",$ch7);
		$smarty->assign("ch8",$ch8);
		$smarty->assign("ch9",$ch9);
		$smarty->assign("year",$_POST['year']);
		$smarty->assign("month",$_POST['month']);
		$smarty->assign("day",$_POST['day']);
		$smarty->assign("value","");

		$smarty->display("kakunin_hakkou.tpl");
		unset($smarty);
		unset($db);
		exit;

}else{//成形機別表示

$date = $_POST['year']."-".$_POST['month']."-".$_POST['day'];
$mkndt = mktime(0, 0, 0, $_POST['month'], $_POST['day'], $_POST['year']) + 86400;
$tomorrow = date("Y-m-d", $mkndt);

	for($s=1;$s<=9;$s++){

		if($_POST['seikeiki_'.$s.''] <> ""){

			$target_seikeiki = $s;
			break;
		}

	}

for($c=$target_seikeiki;$c<=$target_seikeiki;$c++){


	$checked = "";
	$radio = "<input type='checkbox' name='target_p".$c."[]' value='1' ".$checked.">";
	
	$db->query("set names sjis");
	$sql="SELECT datetime,seikeiki,product_id FROM schedule_koutei where datetime >= '".$date." 8:00' and datetime <= '".$tomorrow." 7:59' and seikeiki = '".$c."' order by datetime asc";
	$rs=$db->query($sql);
	$kousu = 0;
	$yobidashi_kari_nippou=array();
	while($row=$rs->fetchRow(MDB2_FETCHMODE_ASSOC)){

		$yobidashi_kari_nippou[]=array("datetime"=>$row['datetime'],"seikeiki"=>$row['seikeiki'],"product_id"=>$row['product_id']);
		
		$kousu++;
	}



	for($i=1;$i<=$kousu;$i++){

			//成形開始時間
			$datetime = $yobidashi_kari_nippou[$i-1]['datetime'];

			$date1=mb_substr("$datetime",0,10);
			$time1=mb_substr("$datetime",11,8);
			list($y1,$m1,$d1)=explode("-", $date1);
			list($h1,$min1,$sec1)=explode(":", $time1);
			
			$starting_time = $h1.":".$min1;
			


				$date_yobidashi->select_date($date1);
				$date_yobidashi->select_time($starting_time);

	
			$starting_year = $date_yobidashi->get_year();
			$selected_starting_year = $date_yobidashi->get_selected_year();
			$starting_month = $date_yobidashi->get_month();
			$selected_starting_month = $date_yobidashi->get_selected_month();
			$starting_day = $date_yobidashi->get_day();
			$selected_starting_day = $date_yobidashi->get_selected_day();
			$starting_hour = $date_yobidashi->get_select_hour();
			$selected_starting_hour = $date_yobidashi->get_selected_hour();
			$starting_minute = $date_yobidashi->get_select_minute();
			$selected_starting_minute = $date_yobidashi->get_selected_minute();

			//成形終了時間
				if($kousu == 1 or $i == $kousu){ //型替が1日に1回の時とその日の最後の型替製品の成形終了時間

					$next_date = $tomorrow;
					$finishing_time = "08:00";
					

				}elseif($i <> $kousu){ //型替が2面以上あるときの成形終了時間

					$next_datetime = $yobidashi_kari_nippou[$i]['datetime'];
					$date2=mb_substr("$next_datetime",0,10);
					$time2=mb_substr("$next_datetime",11,8);
					list($y2,$m2,$d2)=explode("-", $date2);
					list($h2,$min2,$sec2)=explode(":", $time2);

					$next_date = $date2;
					$finishing_time = $h2.":".$min2;

				}



				$date_yobidashi->select_date($next_date);
				$date_yobidashi->select_time($finishing_time);

		
				$finishing_year = $date_yobidashi->get_year();
				$selected_finishing_year = $date_yobidashi->get_selected_year();
				$finishing_month = $date_yobidashi->get_month();
				$selected_finishing_month = $date_yobidashi->get_selected_month();
				$finishing_day = $date_yobidashi->get_day();
				$selected_finishing_day = $date_yobidashi->get_selected_day();
				$finishing_hour = $date_yobidashi->get_select_hour();
				$selected_finishing_hour = $date_yobidashi->get_selected_hour();
				$finishing_minute = $date_yobidashi->get_select_minute();
				$selected_finishing_minute = $date_yobidashi->get_selected_minute();
			

			//product_id
				$product_id = $yobidashi_kari_nippou[$i-1]['product_id'];

			//成形時間（秒）を求める。
			$timestamp1= mktime($selected_starting_hour,$selected_starting_minute,0,$selected_starting_month,$selected_starting_day,$selected_starting_year);
			$timestamp2= mktime($selected_finishing_hour,$selected_finishing_minute,0,$selected_finishing_month,$selected_finishing_day,$selected_finishing_year);

			if($kousu==0){
				$stamp = $timestamp2-$timestamp1;
			}else{
				$stamp = ($timestamp2-$timestamp1) - 3600;//型替時間の1時間を引く
			}

			//$product_idから前回のショットサイクルを検索し、成形時間から発行枚数の当たりをつける
				$db->query("set names sjis");
				$sql_cycle="SELECT cycle_shot,starting_tm FROM kadou_seikei where pro_num = '".$product_id."' order by starting_tm desc limit 1";
				$rs_cycle=$db->query($sql_cycle);

				while($row_cycle=$rs_cycle->fetchRow(MDB2_FETCHMODE_ASSOC)){

					$cycle_shot=$row_cycle['cycle_shot'];
					
				}

				$rows_rs_cycle=$rs_cycle->numRows();
				if($rows_rs_cycle == 0){ $cycle_shot = 0;}

			//取り数を求める。
				$db->query("set names sjis");
				$sql_torisu="SELECT torisu FROM katakouzou where product_id = '".$product_id."' order by kataban desc limit 1";
				$rs_torisu=$db->query($sql_torisu);

				while($row_torisu=$rs_torisu->fetchRow(MDB2_FETCHMODE_ASSOC)){

					$torisu=$row_torisu['torisu'];
					
				}

				$rows_rs_torisu=$rs_torisu->numRows();
				if($rows_rs_torisu == 0){ $torisu = 0;}

			//梱包数を求める。
				$db->query("set names sjis");
				$sql_irisu="SELECT irisu FROM konpou where product_id = '".$product_id."'";
				$rs_irisu=$db->query($sql_irisu);

				while($row_irisu=$rs_irisu->fetchRow(MDB2_FETCHMODE_ASSOC)){

					$irisu=$row_irisu['irisu'];
					
				}

				$rows_rs_irisu=$rs_irisu->numRows();
				if($rows_rs_irisu == 0){ $irisu = 0;}

			//枚数の計算
				if($cycle_shot <> 0 or $torisu <> 0 or $irisu <> 0){

					$number_sheet = ceil(($stamp/$cycle_shot*$torisu)/$irisu);
					

				}else{

					$number_sheet = 0;

				}

			//箱NO.の代入
				$num_box = "1";

			//製品のラベル登録の確認、登録されてなかったら表示させない。

				$db->query("set names sjis");
				$sql_kakunin_product="SELECT product_id FROM label_type_product where product_id like '%".$product_id."%' ";
				$rs_kakunin=$db->query($sql_kakunin_product);

				while($row_kakunin=$rs_kakunin->fetchRow(MDB2_FETCHMODE_ASSOC)){

					$kakunin_product=$row_kakunin['product_id'];
					
				}
		if($kakunin_product <> "" and $kakunin_product <> "W002"){

			if($c==1){$ch1[]=array("radio"=>$radio,"product_id"=>$product_id,
				"starting_year"=>$starting_year,"selected_starting_year"=>$selected_starting_year,
				"starting_month"=>$starting_month,"selected_starting_month"=>$selected_starting_month,
				"starting_day"=>$starting_day,"selected_starting_day"=>$selected_starting_day,
				"starting_hour"=>$starting_hour,"selected_starting_hour"=>$selected_starting_hour,
				"starting_minute"=>$starting_minute,"selected_starting_minute"=>$selected_starting_minute,
				"finishing_year"=>$finishing_year,"selected_finishing_year"=>$selected_finishing_year,
				"finishing_month"=>$finishing_month,"selected_finishing_month"=>$selected_finishing_month,
				"finishing_day"=>$finishing_day,"selected_finishing_day"=>$selected_finishing_day,
				"finishing_hour"=>$finishing_hour,"selected_finishing_hour"=>$selected_finishing_hour,
				"finishing_minute"=>$finishing_minute,"selected_finishing_minute"=>$selected_finishing_minute,
				"number_sheet"=>$number_sheet,"num_box"=>$num_box);}
			elseif($c==2){$ch2[]=array("radio"=>$radio,"product_id"=>$product_id,
				"starting_year"=>$starting_year,"selected_starting_year"=>$selected_starting_year,
				"starting_month"=>$starting_month,"selected_starting_month"=>$selected_starting_month,
				"starting_day"=>$starting_day,"selected_starting_day"=>$selected_starting_day,
				"starting_hour"=>$starting_hour,"selected_starting_hour"=>$selected_starting_hour,
				"starting_minute"=>$starting_minute,"selected_starting_minute"=>$selected_starting_minute,
				"finishing_year"=>$finishing_year,"selected_finishing_year"=>$selected_finishing_year,
				"finishing_month"=>$finishing_month,"selected_finishing_month"=>$selected_finishing_month,
				"finishing_day"=>$finishing_day,"selected_finishing_day"=>$selected_finishing_day,
				"finishing_hour"=>$finishing_hour,"selected_finishing_hour"=>$selected_finishing_hour,
				"finishing_minute"=>$finishing_minute,"selected_finishing_minute"=>$selected_finishing_minute,
				"number_sheet"=>$number_sheet,"num_box"=>$num_box);}
			elseif($c==3){$ch3[]=array("radio"=>$radio,"product_id"=>$product_id,
				"starting_year"=>$starting_year,"selected_starting_year"=>$selected_starting_year,
				"starting_month"=>$starting_month,"selected_starting_month"=>$selected_starting_month,
				"starting_day"=>$starting_day,"selected_starting_day"=>$selected_starting_day,
				"starting_hour"=>$starting_hour,"selected_starting_hour"=>$selected_starting_hour,
				"starting_minute"=>$starting_minute,"selected_starting_minute"=>$selected_starting_minute,
				"finishing_year"=>$finishing_year,"selected_finishing_year"=>$selected_finishing_year,
				"finishing_month"=>$finishing_month,"selected_finishing_month"=>$selected_finishing_month,
				"finishing_day"=>$finishing_day,"selected_finishing_day"=>$selected_finishing_day,
				"finishing_hour"=>$finishing_hour,"selected_finishing_hour"=>$selected_finishing_hour,
				"finishing_minute"=>$finishing_minute,"selected_finishing_minute"=>$selected_finishing_minute,
				"number_sheet"=>$number_sheet,"num_box"=>$num_box);}
			elseif($c==4){$ch4[]=array("radio"=>$radio,"product_id"=>$product_id,
				"starting_year"=>$starting_year,"selected_starting_year"=>$selected_starting_year,
				"starting_month"=>$starting_month,"selected_starting_month"=>$selected_starting_month,
				"starting_day"=>$starting_day,"selected_starting_day"=>$selected_starting_day,
				"starting_hour"=>$starting_hour,"selected_starting_hour"=>$selected_starting_hour,
				"starting_minute"=>$starting_minute,"selected_starting_minute"=>$selected_starting_minute,
				"finishing_year"=>$finishing_year,"selected_finishing_year"=>$selected_finishing_year,
				"finishing_month"=>$finishing_month,"selected_finishing_month"=>$selected_finishing_month,
				"finishing_day"=>$finishing_day,"selected_finishing_day"=>$selected_finishing_day,
				"finishing_hour"=>$finishing_hour,"selected_finishing_hour"=>$selected_finishing_hour,
				"finishing_minute"=>$finishing_minute,"selected_finishing_minute"=>$selected_finishing_minute,
				"number_sheet"=>$number_sheet,"num_box"=>$num_box);}
			elseif($c==5){$ch5[]=array("radio"=>$radio,"product_id"=>$product_id,
				"starting_year"=>$starting_year,"selected_starting_year"=>$selected_starting_year,
				"starting_month"=>$starting_month,"selected_starting_month"=>$selected_starting_month,
				"starting_day"=>$starting_day,"selected_starting_day"=>$selected_starting_day,
				"starting_hour"=>$starting_hour,"selected_starting_hour"=>$selected_starting_hour,
				"starting_minute"=>$starting_minute,"selected_starting_minute"=>$selected_starting_minute,
				"finishing_year"=>$finishing_year,"selected_finishing_year"=>$selected_finishing_year,
				"finishing_month"=>$finishing_month,"selected_finishing_month"=>$selected_finishing_month,
				"finishing_day"=>$finishing_day,"selected_finishing_day"=>$selected_finishing_day,
				"finishing_hour"=>$finishing_hour,"selected_finishing_hour"=>$selected_finishing_hour,
				"finishing_minute"=>$finishing_minute,"selected_finishing_minute"=>$selected_finishing_minute,
				"number_sheet"=>$number_sheet,"num_box"=>$num_box);}
			elseif($c==6){$ch6[]=array("radio"=>$radio,"product_id"=>$product_id,
				"starting_year"=>$starting_year,"selected_starting_year"=>$selected_starting_year,
				"starting_month"=>$starting_month,"selected_starting_month"=>$selected_starting_month,
				"starting_day"=>$starting_day,"selected_starting_day"=>$selected_starting_day,
				"starting_hour"=>$starting_hour,"selected_starting_hour"=>$selected_starting_hour,
				"starting_minute"=>$starting_minute,"selected_starting_minute"=>$selected_starting_minute,
				"finishing_year"=>$finishing_year,"selected_finishing_year"=>$selected_finishing_year,
				"finishing_month"=>$finishing_month,"selected_finishing_month"=>$selected_finishing_month,
				"finishing_day"=>$finishing_day,"selected_finishing_day"=>$selected_finishing_day,
				"finishing_hour"=>$finishing_hour,"selected_finishing_hour"=>$selected_finishing_hour,
				"finishing_minute"=>$finishing_minute,"selected_finishing_minute"=>$selected_finishing_minute,
				"number_sheet"=>$number_sheet,"num_box"=>$num_box);}
			elseif($c==7){$ch7[]=array("radio"=>$radio,"product_id"=>$product_id,
				"starting_year"=>$starting_year,"selected_starting_year"=>$selected_starting_year,
				"starting_month"=>$starting_month,"selected_starting_month"=>$selected_starting_month,
				"starting_day"=>$starting_day,"selected_starting_day"=>$selected_starting_day,
				"starting_hour"=>$starting_hour,"selected_starting_hour"=>$selected_starting_hour,
				"starting_minute"=>$starting_minute,"selected_starting_minute"=>$selected_starting_minute,
				"finishing_year"=>$finishing_year,"selected_finishing_year"=>$selected_finishing_year,
				"finishing_month"=>$finishing_month,"selected_finishing_month"=>$selected_finishing_month,
				"finishing_day"=>$finishing_day,"selected_finishing_day"=>$selected_finishing_day,
				"finishing_hour"=>$finishing_hour,"selected_finishing_hour"=>$selected_finishing_hour,
				"finishing_minute"=>$finishing_minute,"selected_finishing_minute"=>$selected_finishing_minute,
				"number_sheet"=>$number_sheet,"num_box"=>$num_box);}
			elseif($c==8){$ch8[]=array("radio"=>$radio,"product_id"=>$product_id,
				"starting_year"=>$starting_year,"selected_starting_year"=>$selected_starting_year,
				"starting_month"=>$starting_month,"selected_starting_month"=>$selected_starting_month,
				"starting_day"=>$starting_day,"selected_starting_day"=>$selected_starting_day,
				"starting_hour"=>$starting_hour,"selected_starting_hour"=>$selected_starting_hour,
				"starting_minute"=>$starting_minute,"selected_starting_minute"=>$selected_starting_minute,
				"finishing_year"=>$finishing_year,"selected_finishing_year"=>$selected_finishing_year,
				"finishing_month"=>$finishing_month,"selected_finishing_month"=>$selected_finishing_month,
				"finishing_day"=>$finishing_day,"selected_finishing_day"=>$selected_finishing_day,
				"finishing_hour"=>$finishing_hour,"selected_finishing_hour"=>$selected_finishing_hour,
				"finishing_minute"=>$finishing_minute,"selected_finishing_minute"=>$selected_finishing_minute,
				"number_sheet"=>$number_sheet,"num_box"=>$num_box);}
			else{$ch9[]=array("radio"=>$radio,"product_id"=>$product_id,
				"starting_year"=>$starting_year,"selected_starting_year"=>$selected_starting_year,
				"starting_month"=>$starting_month,"selected_starting_month"=>$selected_starting_month,
				"starting_day"=>$starting_day,"selected_starting_day"=>$selected_starting_day,
				"starting_hour"=>$starting_hour,"selected_starting_hour"=>$selected_starting_hour,
				"starting_minute"=>$starting_minute,"selected_starting_minute"=>$selected_starting_minute,
				"finishing_year"=>$finishing_year,"selected_finishing_year"=>$selected_finishing_year,
				"finishing_month"=>$finishing_month,"selected_finishing_month"=>$selected_finishing_month,
				"finishing_day"=>$finishing_day,"selected_finishing_day"=>$selected_finishing_day,
				"finishing_hour"=>$finishing_hour,"selected_finishing_hour"=>$selected_finishing_hour,
				"finishing_minute"=>$finishing_minute,"selected_finishing_minute"=>$selected_finishing_minute,
				"number_sheet"=>$number_sheet,"num_box"=>$num_box);}

		}

	}
}



	

	$smarty->assign("value",$value);

	$smarty->assign("ch1",$ch1);
	$smarty->assign("ch2",$ch2);
	$smarty->assign("ch3",$ch3);
	$smarty->assign("ch4",$ch4);
	$smarty->assign("ch5",$ch5);
	$smarty->assign("ch6",$ch6);
	$smarty->assign("ch7",$ch7);
	$smarty->assign("ch8",$ch8);
	$smarty->assign("ch9",$ch9);
	$smarty->assign("year",$_POST['year']);
	$smarty->assign("month",$_POST['month']);
	$smarty->assign("day",$_POST['day']);
	$smarty->display("form_hakkou.tpl");
	unset($smarty);
	unset($db);
	exit;

}

?>