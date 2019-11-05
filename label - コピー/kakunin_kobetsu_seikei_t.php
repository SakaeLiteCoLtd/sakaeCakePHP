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



if($_POST['addition'] <> "" ){//追加ボタンが押された場合のスクリプト

	$product_id=$_POST['product_id'];
	$syear=$_POST['syear'];
	$smonth=$_POST['smonth'];
	$sday=$_POST['sday'];
	$shour=$_POST['shour'];
	$sminute=$_POST['sminute'];
	$fyear=$_POST['fyear'];
	$fmonth=$_POST['fmonth'];
	$fday=$_POST['fday'];
	$fhour=$_POST['fhour'];
	$fminute=$_POST['fminute'];

	$kousu=count($_POST['product_id']);

	for($i=0;$i<=$kousu;$i++){

		if(($product_id[$i]<>"" and $i<$kousu) or ($product_id[$i]=="" and $i==$kousu and $kousu==1) or ($product_id[$i-1]<>"" and $i==$kousu) or ($product_id[$i]=="" and $i == $kousu-1 and $product_id[$i-1]<>"")){

			//成形開始時間
			$date1=$syear[$i]."-".$smonth[$i]."-".$sday[$i];
			$time1 = $shour[$i].":".$sminute[$i];

			if($i<>$kousu){

				$date_yobidashi->select_date($date1);
				$date_yobidashi->select_time($time1);

			}else{

				$starting_time = "09:00";
				$date_yobidashi->select_date($today);
				$date_yobidashi->select_time($starting_time);
					

			}

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


			$date2=$fyear[$i]."-".$fmonth[$i]."-".$fday[$i];
			$time2 = $fhour[$i].":".$fminute[$i];

			if($i<>$kousu){

				$date_yobidashi->select_date($date2);
				$date_yobidashi->select_time($time2);

			}else{

				$starting_time = "09:00";
				$date_yobidashi->select_date($today);
				$date_yobidashi->select_time($starting_time);

			}

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
			$radio = "<input type='checkbox' name='target_p".$i."' value='1' ".$checked.">";

				$data[]=array("radio"=>$radio,"product_id"=>$product_id[$i],
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
				"number_sheet"=>$number_sheet[$i],"num_box"=>$num_box[$i]);
				
		}
	}
		

		$smarty->assign("data",$data);
		$smarty->assign("header",$html_yobidashi->header());
		$smarty->display("form_kobetsu_seikei_t.tpl");
		unset($smarty);
		unset($db);
		exit;

}elseif($_POST['deletion'] <> ""){//削除ボタンが押された場合のスクリプト

	$product_id=$_POST['product_id'];


	$syear=$_POST['syear'];
	$smonth=$_POST['smonth'];
	$sday=$_POST['sday'];
	$shour=$_POST['shour'];
	$sminute=$_POST['sminute'];
	$fyear=$_POST['fyear'];
	$fmonth=$_POST['fmonth'];
	$fday=$_POST['fday'];
	$fhour=$_POST['fhour'];
	$fminute=$_POST['fminute'];

	$kousu=count($_POST['product_id']);

	$count_p =count($product_id);
	//チェックボックスをチェックした要素を探す
	for($h=0;$h<$kousu;$h++){
		$a = $h;
			
			if($_POST['target_p'.$a.'']==1){

				$arr[$h]=1;

			}else{

				$arr[$h]=0;

			}

	}


	if($kousu == 1){

		$err_mess="これ以上削除できません。。";
		$smarty->assign("err_mess",$err_mess);
		$smarty->display("error_input.tpl");
		unset($smarty);
		unset($db);
		exit;

		

	}

	for($i=0;$i<$kousu;$i++){

		if($arr[$i] <> 1){

			//成形開始時間
			$date1=$syear[$i]."-".$smonth[$i]."-".$sday[$i];
			$time1 = $shour[$i].":".$sminute[$i];

			if($i<>$kousu){

				$date_yobidashi->select_date($date1);
				$date_yobidashi->select_time($time1);

			}else{

				$starting_time = "09:00";
				$date_yobidashi->select_date($today);
				$date_yobidashi->select_time($starting_time);
					

			}

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


			$date2=$fyear[$i]."-".$fmonth[$i]."-".$fday[$i];
			$time2 = $fhour[$i].":".$fminute[$i];

			if($i<>$kousu){

				$date_yobidashi->select_date($date2);
				$date_yobidashi->select_time($time2);

			}else{

				$starting_time = "09:00";
				$date_yobidashi->select_date($today);
				$date_yobidashi->select_time($starting_time);

			}

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
			$radio = "<input type='checkbox' name='target_p".$i."' value='1' ".$checked.">";

				$data[]=array("radio"=>$radio,"product_id"=>$product_id[$i],
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
				"number_sheet"=>$number_sheet[$i],"num_box"=>$num_box[$i]);
				
		}
	}
		

		$smarty->assign("data",$data);
		$smarty->assign("header",$html_yobidashi->header());
		$smarty->display("form_kobetsu_seikei_t.tpl");
		unset($smarty);
		unset($db);
		exit;

}else{

		$product_id=$_POST['product_id'];

		$syear=$_POST['syear'];
		$smonth=$_POST['smonth'];
		$sday=$_POST['sday'];
		$shour=$_POST['shour'];
		$sminute=$_POST['sminute'];
		$fyear=$_POST['fyear'];
		$fmonth=$_POST['fmonth'];
		$fday=$_POST['fday'];
		$fhour=$_POST['fhour'];
		$fminute=$_POST['fminute'];

		$number_sheet=$_POST['number_sheet'];
		$num_box=$_POST['num_box'];

		$count_pro=count($_POST['product_id']);

		for($i=0;$i<$count_pro;$i++){

			//夜中の0時から7時59分までのロットは、前日の日付がロット日になる。
			if($shour[$i] >= 0 and $shour[$i] <= 7){

				if($sday[$i] == $fday[$i]){

					if($fhour[$i] >= 9  ){//8時50分までＯＫ

						$mess="成形日時をまたぐので、発行できません。";
						$smarty->assign("mess",$mess);
						$smarty->assign("pre_tag","<!--");
						$smarty->assign("last_tag","--!>");
						$smarty->display("error_input.tpl");
						unset($smarty);
						unset($db);
						exit;

					}

				}elseif($sday[$i] <> $fday[$i]){

						$mess="成形日時をまたぐので、発行できません。";
						$smarty->assign("mess",$mess);
						$smarty->assign("pre_tag","<!--");
						$smarty->assign("last_tag","--!>");
						$smarty->display("error_input.tpl");
						unset($smarty);
						unset($db);
						exit;

				}

			}elseif($sday[$i] <> $fday[$i]){

				if($fhour[$i] >= 9){

					if($fhour[$i] >= 9 ){

						$mess="成形日時をまたぐので、発行できません。";
						$smarty->assign("mess",$mess);
						$smarty->assign("pre_tag","<!--");
						$smarty->assign("last_tag","--!>");
						$smarty->display("error_input.tpl");
						unset($smarty);
						unset($db);
						exit;

					}

				}

			}

			if($shour[$i] >= 0 and $shour[$i] <= 7){

				$date_seikei = date("Y-m-d", mktime(0,0,0,$smonth[$i],$sday[$i],$syear[$i]) - 86400);
				
				$value = $date_seikei;
			}else{

				$date_seikei = $syear[$i]."-".$smonth[$i]."-".$sday[$i];

			}
				$db->query("set names sjis");
				$rs=$db->query("select product_id from product where product_id = '".$product_id[$i]."'");
				$product_rows=$rs->numRows();

			//成形時間（秒）を求める。
			$timestamp1= mktime($shour[$i],$sminute[$i],0,$smonth[$i],$sday[$i],$syear[$i]);
			$timestamp2= mktime($fhour[$i],$fminute[$i],0,$fmonth[$i],$fday[$i],$fyear[$i]);

				$stamp = $timestamp2-$timestamp1;

			//$product_idから前回のショットサイクルを検索し、成形時間から発行枚数の当たりをつける
				$db->query("set names sjis");
				$sql_cycle="SELECT cycle_shot,starting_tm FROM kadou_seikei where pro_num = '".$product_id[$i]."' order by starting_tm desc limit 1";
				$rs_cycle=$db->query($sql_cycle);

				while($row_cycle=$rs_cycle->fetchRow(MDB2_FETCHMODE_ASSOC)){

					$cycle_shot=$row_cycle['cycle_shot'];
					
				}

				$rows_rs_cycle=$rs_cycle->numRows();
				if($rows_rs_cycle == 0){ $cycle_shot = 0;}
			

			//取り数を求める。
				$db->query("set names sjis");
				$sql_torisu="SELECT torisu FROM katakouzou where product_id = '".$product_id[$i]."' order by kataban desc limit 1";
				$rs_torisu=$db->query($sql_torisu);

				while($row_torisu=$rs_torisu->fetchRow(MDB2_FETCHMODE_ASSOC)){

					$torisu=$row_torisu['torisu'];
					
				}

				$rows_rs_torisu=$rs_torisu->numRows();
				if($rows_rs_torisu == 0){ $torisu = 0;}

			//梱包数を求める。
				$db->query("set names sjis");
				$sql_irisu="SELECT irisu FROM konpou where product_id = '".$product_id[$i]."'";
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

			//製品のラベル登録の確認、登録されてなかったら表示させない。

				$db->query("set names sjis");
				$sql_kakunin_product="SELECT product_id FROM label_type_product where product_id like '%".$product_id[$i]."%' ";
				$rs_kakunin=$db->query($sql_kakunin_product);

				while($row_kakunin=$rs_kakunin->fetchRow(MDB2_FETCHMODE_ASSOC)){

					$kakunin_product=$row_kakunin['product_id'];
					
				}

					$s_daytime=$syear[$i]."-".$smonth[$i]."-".$sday[$i]." ".$shour[$i].":".$sminute[$i];
					$f_daytime=$fyear[$i]."-".$fmonth[$i]."-".$fday[$i]." ".$fhour[$i].":".$fminute[$i];

					$data[]=array("product_id"=>$product_id[$i],"date_seikei"=>$date_seikei,"starting_tm"=>$s_daytime,"finishing_tm"=>$f_daytime,"number_sheet"=>$number_sheet,"num_box"=>$num_box);


		}

		$smarty->assign("value","");
		$smarty->assign("data",$data);
		$smarty->assign("header",$html_yobidashi->header());

		$smarty->display("kakunin_kobetsu_seikei_t.tpl");
		unset($smarty);
		unset($db);
		exit;
}

?>