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
$today = date("Y-m-d");
$yesterday= date("Y-m-d", time() - 86400);

//IMデータ取込のスクリプト開始
if($_POST['yomikomi']){

	$mess = "　　　　　　　　　　　　　　　　　<strong><font color = '#FF0000'>取り込む対象のデータはありませんでした。</font></strong>";

	$dirName = "//192.168.1.225/社内共通/h品質管理/IM測定データ関係/data_IM測定/";

	if(is_dir($dirName)){
	  if($dir = opendir($dirName)){
	    while(($folder = readdir($dir)) !== false){//親while
	      if($folder != "." && $folder != ".."){
	        if(strpos($folder,".",0)==""){//フォルダーなら("."が無いならフォルダーという認識)
	          if(is_dir($dirName.$folder)){//ファイルでなくフォルダーなら

	            if($child_dir = opendir($dirName.$folder)){

			$folder_check = 0;
			if(strpos($folder,"_",0)==""){//"_"が無いなら、そのフォルダーは無視する

				$folder_check = 1;
			}else{

				$num = strpos($folder,"_",0);
				$product_id = mb_substr($folder,0,$num);

			}

			if($folder_check == 0){

				while(($file = readdir($child_dir)) !== false){//子while

					if($file != "." && $file != ".."){
											

						if(substr($file, -4, 4) == ".csv" ){//csvファイルだけOPEN

							if(substr($file, 0, 5) <> "sumi_" ){//sumi_でないファイルだけOPEN
											
								$inspec_date = substr($file,0,4)."-".substr($file,4,2)."-".substr($file,6,2);
								$return_arr = array();

								$open_filename = $dirName.$folder."/".$file;
								$fp = fopen("$open_filename", "r");

								$arr[]=array("file"=>$open_filename);

								$count_column = sizeof(fgetcsv(fopen($open_filename, "r"), 1000, ","));//csvファイルの列数取得コマンド
								$count = 0;//行の位置確認に使用
								$arr_size_num = array();
								$arr_size = array();				
								$arr_upper = array();
								$arr_lower = array();
								$arr_inspec_datetime = array();
								$arr_lot_num = array();
								$arr_serial = array();
								$arr_status = array();
								$arr_result = array();
								while(!feof($fp)){

									$return_arr = fgetcsv($fp, 4096);//ここの1行手前でreturn_arrを初期化した方がいい
															
									$arr_lot_num[]=array("lot_num"=>$return_arr[2],"count"=>$count);
									$arr_status[]=array("status"=>$return_arr[4]);

									for($i=7;$i<$count_column;$i++){

										if($count == 0){
														
											//0のときは何もしない
															
										}elseif($count == 1){

											$arr_size[$i] = $return_arr[$i];

										}elseif($count == 2){

											$arr_upper[$i] = $return_arr[$i];

										}elseif($count == 3){

											$arr_lower[$i] = $return_arr[$i];

										}else{//5行目以降

											$arr_inspec_datetime[]=array("inspec_datetime"=>$return_arr[1]);
											$arr_serial[]=array("serial"=>$return_arr[3]);
											$arr_result[] = $return_arr[$i];

										}

									}

									$count++;

								}


								$box = array();
								$q = 0;
								$x = 0;
								for($j=4;$j<count($arr_lot_num)-1;$j++){//ロット番号線形探索(-1しているのは、行を1行多く数えてしまうから)

									for($i=$x;$i<$q;$i++){

										if($box[$i]['lot_num']==$arr_lot_num[$j]['lot_num']){

											break;

										}

									}

										if($i<$q && $box[$i]['lot_num']==$arr_lot_num[$j]['lot_num']){

									

										}else{

											$box[$q] = array("lot_num"=>$arr_lot_num[$j]['lot_num'],"row"=>$arr_lot_num[$j]['count']-4);//既存のロットと違うロットの場合、box配列に挿入
											$arr[]=array("file"=>$arr_lot_num[$j]['count']);//ロットの切り替わりの行を取得
											if($q != 0){$x++;}//ロットが同じでも間に別のロットを検査した場合は、別の検査表として登録
											$q++;
										
										}

								}
													
								$n=0;
								for($i=0;$i<count($box);$i++){//kensahyou_headの数だけループ
									
									
									$cycle_size_num = $count_column -7;
									if($i==count($box)-1){
										$n = $box[$i]['row'];
										$last_row=count($arr_result);
									}elseif($i==0){
										$n = 0;
										$last_row=($box[$i+1]['row']*$cycle_size_num)-1;
									}else{
										$n = $box[$i]['row'];
										$last_row=($box[$i+1]['row']*$cycle_size_num)-1;
									}
									
									if(count($arr_result) > 0){//万が一測定データが０の場合
										//im_change_csvfilete
										$mess = "　　　　　　　　　　　　　　　　　<strong>IMデータを取り込みました！</strong>";

										$db->query("set names sjis");
										$value_head = "'".$product_id."','".$folder."','".$inspec_date."','".$box[$i]['lot_num']."'";
										$insert_head = "INSERT INTO im_sokuteidata_head (product_id,kind_kensa,inspec_date,lot_num) value (".$value_head.")";
										$db->query($insert_head);
															
										$db->query("set names sjis");
										$rs_id = $db->queryOne("SELECT id FROM im_sokuteidata_head order by id desc limit 1");
										for($k=7;$k<$count_column;$k++){
											$size_num = $k-6;
											$insert_kikaku = "INSERT INTO im_kikaku (id,size_num,size,upper,lower) value (".$rs_id.",".$size_num.",".$arr_size[$k].",".$arr_upper[$k].",".$arr_lower[$k].")";
											$db->query($insert_kikaku);
																

										}
									}
									
									for($k=$n*$cycle_size_num;$k<$last_row;$k++){

										if($k < $cycle_size_num){

											$size_num = $k + 1;

										}elseif($k >= $cycle_size_num && ($k+1)%$cycle_size_num==0){

											$size_num = $cycle_size_num;

										}else{

											$size_num = ($k+1)%$cycle_size_num;

										}

										$upper_size = $arr_size[$k+1] + $arr_upper[$k+1];
										$lower_aize = $arr_size[$k+1] + $arr_lower[$k+1];
										if($arr_result[$k] >= $lower_size && $arr_result[$k] <= $upper_size ){

											$status = 0;

										}else{

											$status = 1;

										}

										if($arr_result[$k]<>""){
											
											$data_result = round($arr_result[$k],2);
											$values .= "(".$rs_id.",'".$arr_inspec_datetime[$k]['inspec_datetime']."','".$arr_serial[$k]['serial']."',".$size_num.",".$data_result.",'".
												  $status."'),";

										}
										
									
									}
									$values = substr($values ,0, -1);
									$db->query("set names sjis");
									$insert_result = "INSERT im_sokuteidata_result (id,inspec_datetime,serial,size_num,result,status) value ".
											  $values;
									$db->query($insert_result);
									$values = "";//$valuesの初期化

									$db->query("set names sjis");
									$sql_change_file="select num from im_change_csvfile_num where kind_kensa = '".$folder."' and date = '".$today."'";//240行目くらいまでむし
									$rs_change_file=$db->query($sql_change_file);//テーブル使ってない
									$rows = $rs_change_file->numRows();
									if($rows == 0){

										$num = 1;

									}else{

										while($row_change_file=$rs_change_file->fetchRow(MDB2_FETCHMODE_ASSOC)){

											$num = $row_change_file['num'];
											
										}

									}
									fclose($fp);

									$toDirCopy =  "D:\buckupImData\data_IM測定/".$folder;
									$toCopyFile = $toDirCopy."/sumi_".$num."_".$file;
									rename($open_filename, $toCopyFile);//DB登録後にファイル名を変更する。

									unlink($open_filename);
									
									list($nameFile,$kakutyoushi) = explode(".",$file);
									$bi2File = $nameFile."005.bi2";
									$toCopyBi2File = $toDirCopy."/".$bi2File;
									rename($dirName.$folder."/".$bi2File, $toCopyBi2File);//DB登録後にファイル名を変更する。
									
									unlink($dirName.$folder."/".$bi2File);


									$num = $num + 1;

									$db->query("set names sjis");
									$update_change_file = "update im_change_csvfile_num set num = ".$num.",date = '".$today."' where kind_kensa = '".$folder."'" ;
									$db->query($update_change_file);
									
								}//kensahyou_headの数だけループの終わり

							}//sumi_でないファイルだけOPEN

						}//csvファイルだけOPENの終わり

					}//if($file != "." && $file != "..")の終わり

				}//子whileの終わり
			}//if($folder_check==0)の終わり
	            }

	          }//if(ファイルでなくフォルダーであるなら)の終わり
	        }//フォルダーであるなら
	      }
	    }//親whileの終わり
	  }
	}

$smarty->assign("mess",$mess);
}//IMデータ取込のスクリプト終了



//登録済kadou_seikeiから対象ロットを引っ張り出す。
$db->query("set names sjis");
$rs=$db->query("SELECT a.pro_num,a.seikeiki_id,a.starting_tm,a.finishing_tm,b.product_name FROM kadou_seikei as a ".
		" inner join product as b on a.pro_num = b.product_id ".
		" where a.present_kensahyou = '0'");
$data=array();
$check=array();
while($row=$rs->fetchRow(MDB2_FETCHMODE_ASSOC)){
	//kadou_seikeiから対象ロットの日報とその日報の一つ前の日報の差を取得する。（２４時間成形+２時間以内は同一ロットとみなすため）
	$starting_zenkai = 0;
	$db->query("set names sjis");
	$rs_zenkai=$db->query("SELECT starting_tm FROM kadou_seikei where pro_num = '".$row['pro_num']."' and seikeiki_id = '".$row['seikeiki_id']."' and starting_tm < '".$row['starting_tm']."' order by starting_tm desc limit 1");
	
	while($row_zenkai=$rs_zenkai->fetchRow(MDB2_FETCHMODE_ASSOC)){

		$starting_zenkai = $row_zenkai['starting_tm'];

	}

		
			$daytime1=$row['finishing_tm'];
			$year1=mb_substr("$daytime1",0,10);
			$time1=mb_substr("$daytime1",11,8);
			list($y1,$m1,$d1)=explode("-", $year1);
			list($h1,$min1,$sec1)=explode(":", $time1);
			$check_lot1= mktime($h1,$min1,$sec1,$m1,$d1,$y1);

			$daytime2=$starting_zenkai;
			$year2=mb_substr("$daytime2",0,10);
			$time2=mb_substr("$daytime2",11,8);
			list($y2,$m2,$d2)=explode("-", $year2);
			list($h2,$min2,$sec2)=explode(":", $time2);
			$check_lot2= mktime($h2,$min2,$sec2,$m2,$d2,$y2);

	if($check_lot1-$check_lot2 < 93600){//２４時間成形+２時間以内は同一ロットとみなす。

			$check[] = array("product_id"=>$row['pro_num'],"starting_tm"=>$row['starting_tm']);

			$db->query("set names sjis");
			$update="update kadou_seikei set  present_kensahyou = '1' ".
				"where pro_num = '".$row['pro_num']."' and seikeiki_id = '".$row['seikeiki_id']."' and starting_tm = '".$row['starting_tm']."'";
			$db->query($update);

	}else{

		//starting_tmのmktime
		$starting_tm=$row['starting_tm'];
		$starting_date=mb_substr("$starting_tm",0,10);
		$starting_time=mb_substr("$starting_tm",11,8);
		list($y,$m,$d)=explode("-", $starting_date);
		list($h,$min,$sec)=explode(":", $starting_time);
		$starting_mk= mktime($h,$min,$sec,$m,$d,$y);

		//日付特定のためのmktime
		if($h >= 8 and $h <= 23){

			$manu_date = $starting_date;

		}else{

			$starting_mk= mktime(8,0,0,$m,$d,$y);
			$manu_date_mk = $starting_mk - 86400;
			$manu_date = date("Y-m-d",$manu_date_mk);

		}

		$db->query("set names sjis");
		$rs_kobetsu=$db->query("SELECT kensahyou_sokuteidata_head_id from kensahyou_sokuteidata_head  ".
			" where product_id = '".$row['pro_num']."' and manu_date = '".$manu_date."'");
		$kobetsu_rows=$rs_kobetsu->numRows();

		if($kobetsu_rows > 0){

			$update_kadou_seikei="update kadou_seikei set present_kensahyou='1' ".
					" where pro_num ='".$row['pro_num']."' ".
					"and starting_tm ='".$row['starting_tm']."'";
			$db->query($update_kadou_seikei);

		}else{

				$data[]=array("product_id"=>$row['pro_num'],
						"product_name"=>$row['product_name'],
						"manu_date"=>$manu_date);

		}

	}

}

//仮日報から対象ロットを引っ張り出す。
$db->query("set names sjis");
$rs_kari_kadou=$db->query("SELECT a.product_id,a.seikeiki_id,a.starting_tm,a.finishing_tm,b.product_name FROM kari_kadou_seikei as a ".
		" inner join product as b on a.product_id = b.product_id ".
		" where a.present_kensahyou = '0' and a.starting_tm >= '".$today." 8:00' and a.starting_tm <= '".$today." 23:59'");
$kari_kadou=array();
while($row_kari_kadou=$rs_kari_kadou->fetchRow(MDB2_FETCHMODE_ASSOC)){

	$starting_zenkai = 0;
	$db->query("set names sjis");
	$rs_zenkai=$db->query("SELECT starting_tm FROM kadou_seikei where pro_num = '".$row_kari_kadou['product_id']."' and seikeiki_id = '".$row_kari_kadou['seikeiki_id']."' order by starting_tm desc limit 1");
	
	while($row_zenkai=$rs_zenkai->fetchRow(MDB2_FETCHMODE_ASSOC)){

		$starting_zenkai = $row_zenkai['starting_tm'];

	}

		
			$daytime1=$row_kari_kadou['finishing_tm'];
			$year1=mb_substr("$daytime1",0,10);
			$time1=mb_substr("$daytime1",11,8);
			list($y1,$m1,$d1)=explode("-", $year1);
			list($h1,$min1,$sec1)=explode(":", $time1);
			$check_lot1= mktime($h1,$min1,$sec1,$m1,$d1,$y1);

			$daytime2=$starting_zenkai;
			$year2=mb_substr("$daytime2",0,10);
			$time2=mb_substr("$daytime2",11,8);
			list($y2,$m2,$d2)=explode("-", $year2);
			list($h2,$min2,$sec2)=explode(":", $time2);
			$check_lot2= mktime($h2,$min2,$sec2,$m2,$d2,$y2);

	if($check_lot1-$check_lot2 < 86400){

			$check[] = array("product_id"=>$row_kari_kadou['product_id'],"starting_tm"=>$row_kari_kadou['starting_tm']);
	}else{

		//starting_tmのmktime
		$starting_tm=$row_kari_kadou['starting_tm'];
		$starting_date=mb_substr("$starting_tm",0,10);
		$starting_time=mb_substr("$starting_tm",11,8);
		list($y,$m,$d)=explode("-", $starting_date);
		list($h,$min,$sec)=explode(":", $starting_time);
		$starting_mk= mktime($h,$min,$sec,$m,$d,$y);

		//日付特定のためのmktime
		if($h >= 8 and $h <= 23){

			$manu_date = $starting_date;

		}else{

			$starting_mk= mktime(8,0,0,$m,$d,$y);
			$manu_date_mk = $starting_mk - 86400;
			$manu_date = date("Y-m-d",$manu_date_mk);

		}

		$db->query("set names sjis");
		$rs_kobetsu=$db->query("SELECT kensahyou_sokuteidata_head_id from kensahyou_sokuteidata_head  ".
			" where product_id = '".$row_kari_kadou['product_id']."' and manu_date = '".$manu_date."'");
		$kobetsu_rows=$rs_kobetsu->numRows();

		if($kobetsu_rows > 0){

			$update_kari_kadou_seikei="update kari_kadou_seikei set present_kensahyou='1' ".
					" where product_id ='".$row_kari_kadou['product_id']."' ".
					"and starting_tm ='".$row_kari_kadou['starting_tm']."'";
			$db->query($update_kari_kadou_seikei);

		}else{

			$kari_kadou[]=array("product_id"=>$row_kari_kadou['product_id'],
					"product_name"=>$row_kari_kadou['product_name'],
					"manu_date"=>$manu_date);

		}

	}

}

//schedule_kouteiから対象ロットを引っ張り出す。
$db->query("set names sjis");
$rs_schedule_koutei=$db->query("SELECT a.product_id,a.datetime,a.seikeiki,b.product_name FROM schedule_koutei as a ".
		" inner join product as b on a.product_id = b.product_id ".
		" where a.present_kensahyou = '0' and a.datetime >= '".$today." 8:00' and a.datetime <= '".$today." 23:59'");

while($row_schedule_koutei=$rs_schedule_koutei->fetchRow(MDB2_FETCHMODE_ASSOC)){

	$seikeiki = $row_schedule_koutei['seikeiki']."号機";
	$db->query("set names sjis");
	$rs_seikeiki=$db->query("SELECT seikeiki_id FROM seikeiki where genjyou = '".$seikeiki."'  order by dounyuubi desc limit 1");
	
	while($row_seikeiki=$rs_seikeiki->fetchRow(MDB2_FETCHMODE_ASSOC)){

		$seikeiki_id = $row_seikeiki['seikeiki_id'];

	}

	$starting_zenkai = 0;
	$db->query("set names sjis");
	$rs_zenkai=$db->query("SELECT starting_tm FROM kadou_seikei where pro_num = '".$row_schedule_koutei['product_id']."' and seikeiki_id = '".$seikeiki_id."' order by starting_tm desc limit 1");

	while($row_zenkai=$rs_zenkai->fetchRow(MDB2_FETCHMODE_ASSOC)){

		$starting_zenkai = $row_zenkai['starting_tm'];

	}
		

	$db->query("set names sjis");
	$rs_zenkai=$db->query("SELECT datetime FROM schedule_koutei where seikeiki = '".$row_schedule_koutei['seikeiki']."' and datetime > '".$row_schedule_koutei['datetime']."' order by datetime asc limit 1");

	while($row_zenkai=$rs_zenkai->fetchRow(MDB2_FETCHMODE_ASSOC)){

		$finishingtime = $row_zenkai['datetime'];

	}


			$daytime1=$finishingtime;
			$year1=mb_substr("$daytime1",0,10);
			$time1=mb_substr("$daytime1",11,8);
			list($y1,$m1,$d1)=explode("-", $year1);
			list($h1,$min1,$sec1)=explode(":", $time1);
			$check_lot1= mktime($h1,$min1,$sec1,$m1,$d1,$y1);

			$daytime2=$starting_zenkai;
			$year2=mb_substr("$daytime2",0,10);
			$time2=mb_substr("$daytime2",11,8);
			list($y2,$m2,$d2)=explode("-", $year2);
			list($h2,$min2,$sec2)=explode(":", $time2);
			$check_lot2= mktime($h2,$min2,$sec2,$m2,$d2,$y2);

	if($check_lot1-$check_lot2 < 86400){

			$check[] = array("product_id"=>$row_schedule_koutei['product_id'],"starting_tm"=>$row_schedule_koutei['datetime']);
	}else{

		//starting_tmのmktime
		$starting_tm=$row_schedule_koutei['datetime'];
		$starting_date=mb_substr("$starting_tm",0,10);
		$starting_time=mb_substr("$starting_tm",11,8);
		list($y,$m,$d)=explode("-", $starting_date);
		list($h,$min,$sec)=explode(":", $starting_time);
		$starting_mk= mktime($h,$min,$sec,$m,$d,$y);

		//日付特定のためのmktime
		if($h >= 8 and $h <= 23){

			$manu_date = $starting_date;

		}else{

			$starting_mk= mktime(8,0,0,$m,$d,$y);
			$manu_date_mk = $starting_mk - 86400;
			$manu_date = date("Y-m-d",$manu_date_mk);

		}

		$db->query("set names sjis");
		$rs_kobetsu=$db->query("SELECT kensahyou_sokuteidata_head_id from kensahyou_sokuteidata_head  ".
			" where product_id = '".$row_schedule_koutei['product_id']."' and manu_date = '".$manu_date."'");
		$kobetsu_rows=$rs_kobetsu->numRows();

		if($kobetsu_rows > 0){

			$update_schedule_koutei_seikei="update schedule_koutei set present_kensahyou='1' ".
					" where product_id ='".$row_schedule_koutei['product_id']."' ".
					"and datetime ='".$row_schedule_koutei['datetime']."'";
			$db->query($update_schedule_koutei_seikei);

		}else{

			for($i=0;$i<count($kari_kadou);$i++){

				if($kari_kadou[$i]['product_id']==$row_schedule_koutei['product_id']){

					break;

				}

			}

			if($i == count($kari_kadou)){

				$kari_kadou[]=array("product_id"=>$row_schedule_koutei['product_id'],
						"product_name"=>$row_schedule_koutei['product_name'],
						"manu_date"=>$manu_date);

			}

		}

	}

}

	$smarty->assign("check",$check);
	$smarty->assign("value",$dirName.$folder);

	$smarty->assign("data",$data);
	$smarty->assign("kari_kadou",$kari_kadou);
	$smarty->assign("semi_header",$html_semiheader->semi_header());
	$smarty->assign("header",$html_yobidashi->header());
	$smarty->display("syukka_kensa.tpl");
	unset($smarty);
	exit;



?>