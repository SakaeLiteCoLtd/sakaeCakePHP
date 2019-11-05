<?php
require_once("MySmarty.class.php");
$smarty=new MySmarty();
$db=$smarty->getDb();
require_once("../HTML_yobidashi.class.php");
$html_yobidashi = new HTML_yobidashi();
	$smarty->assign("header",$html_yobidashi->header());
require_once("../Date_yobidashi.class.php");
$date_yobidashi =new Date_yobidashi();
$today = date("Y-m-d");
require_once("semiHTML.class.php");
$html_semiheader = new HTML_semiheader();
require_once("Check.class.php");
$Check = new Check();

$arr_error_lot = array();

//CSV�t�@�C���ǂݍ���
$inif =  $_FILES['file']['tmp_name'];
$count = 0;
if(file_exists($inif)){
	$fp = fopen("$inif", "r");
	unset($inif);
	while(!feof($fp)){
		$buf = fgets($fp, 4096);
		list($f1,$f2,$f3,$f4,$f5,$f6,$f7,$f8,$f9,$f10,$f11,$f12) = preg_split("/\t/", $buf);
		
		if($f1 == ""){

			break;

		}else {

			$f5 = str_replace("/","-",$f5);
			if(preg_match("/-/", $f5)){//�\�t�gLavelist5�����悤�����ꍇ

				$f1 = substr($f1,2);
				$f1 = str_replace("/","-",$f1);

				
				
				$date_hakkou = trim($f5);
				$time_hakkou = trim($f2);

				$datetime_hakkou = $date_hakkou." ".$time_hakkou;

				
				$year1=mb_substr("$f6",0,6);
				//$time1=mb_substr("$datetime_hakkou",11,8);
				//list($y1,$m1,$d1)=explode("-", $year1);
				//list($h1,$min1,$sec1)=explode(":", $time1);
				//$timestamp1= mktime($h1,$min1,$sec1,$m1,$d1,$y1);

				$value = $f6;

				$maisu_hakkou = trim($f4);
				$header_lot = trim($f6);
				$fooder_lot = trim($f7);
				$product_id1 = trim($f8);
				$product_id2 = trim($f9);
				$amount1 = trim($f10);
				$amount2 = trim($f11);

			}else{//�\�t�gLavelist4�����悤�����ꍇ

				//$f1 = str_replace("/","-",$f1);

				$date_hakkou = trim($f1);
				$time_hakkou = trim($f2);

				$datetime_hakkou = $date_hakkou." ".$time_hakkou;

				//$year1=mb_substr("$f5",0,6);
				//$time1=mb_substr("$datetime_hakkou",11,8);

				$maisu_hakkou = trim($f4);
				$header_lot = trim($f5);
				$fooder_lot = trim($f6);
				$product_id1 = trim($f7);
				$product_id2 = trim($f8);
				$amount1 = trim($f9);
				$amount2 = trim($f10);

			}

			for($i=0;$i<$maisu_hakkou;$i++){

				//���b�g�ԍ��𐬌`
				$hako_num = $fooder_lot + $i;

				if($fooder_lot < 10){

					if($hako_num < 10){

						$hako_num = "00".$hako_num;

					}else{

						$hako_num = "0".$hako_num;

					}

				}elseif($fooder_lot < 100){

					if($hako_num < 100){

						$hako_num = "0".$hako_num;

					}else{

						$hako_num = $hako_num;

					}

				}else{

					$hako_num = $hako_num;

				}

				$lot_num = $header_lot."-".$hako_num;

				//////////////////////
				//�������b�g�`�F�b�N//
				//////////////////////

				$arr_check_product = array();
				
				$arr_check_product[] = $product_id1;

				if($product_id2 <> ""){

					$arr_check_product[] = $product_id2;

				}

				$arr_hantei = array();
				//�������b�g�`�F�b�N�̂��߁A�N���X�֓�����
				for($h=0;$h<count($arr_check_product);$h++){

					$Check->check_uni_lot_tourokusumi($arr_check_product[$h],$lot_num);

					$arr_hantei[] = $Check->get_hantei();//�������b�g������΁A�ȉ����s

					if($Check->get_hantei() == 1){

						$arr_error_lot[] = array("product_id"=>$arr_check_product[$h],"lot_num"=>$lot_num);

					}

				}

				if($arr_hantei[0] == 0){

					//���i���S�������Ώۂ����`�F�b�N����
					$Check->check_zensu_product($product_id1);

					if($Check->get_hantei() == 1 or $Check->get_rows() == 0){

						$flag_used = 0;

					}else{

						$flag_used = 9;

					}
					//�[����flag_used=9�̑Ώۂɂ���B
					if(preg_match("/^[HS]/", $lot_num)){

						$Check->check_label_nashi($product_id1);
						$rows = $Check->get_rows();
						if($rows==0){

							$flag_used = 9;

						}else{//�O�����i�Ń��x�������̐��i

							$flag_used = 0;

						}

					}

					$value_lot1 = " ('".$datetime_hakkou."','".$product_id1."','".$lot_num."','".$amount1."',".$flag_used.")";

					$db->query("set names sjis");
					$insert_lot1="insert into check_lots (datetime_hakkou,product_id,lot_num,amount,flag_used) values " .$value_lot1;
					$db->query($insert_lot1);

				}

				if($product_id2 <> ""){//set���ȂǂŐ��i���Q��������Ă���ꍇ�̏���

					if($amount2 <> ""){

						$amount = $amount2;

					}else{

						$amount = $amount1;

					}

					if($arr_hantei[1] == 0){

						//���i���S�������Ώۂ��𓯍��̏ꍇ�̓`�F�b�N���Ȃ��B

						$value_lot2 = " ('".$datetime_hakkou."','".$product_id2."','".$lot_num."','".$amount."',0)";

						$db->query("set names sjis");
						$insert_lot2="insert into check_lots (datetime_hakkou,product_id,lot_num,amount,flag_used) values " .$value_lot2;
						$db->query($insert_lot2);

					}

				}

			}

		}
		$count++;
	}

	$dirname = dirname($inif, PATHINFO_DIRNAME);
	//�t�@�C���폜
	//unlink("C:/Users/Public/SERVER���x�����s����/furiwake.txt");	
	//closedir("C:/Users/Public/SERVER���x�����s����");
	unset($fp);
	unset($buf);

}else{

	unset($fp);
	unset($buf);
	$err_mess=$inif."�t�@�C�������݂��܂���B";
	
	$smarty->assign("mess",$err_mess);
	$smarty->assign("pre_tag","<!--");
	$smarty->assign("last_tag","--!>");
	$smarty->display("error_input.tpl");
	unset($smarty);
	unset($db);
	exit;

}

if(count($arr_error_lot) > 0){//�������b�g������΁A�G�X�P�[�v���ăG���[��ʂ�

	$smarty->assign("mess","���L�ȊO�̃��b�g�͓o�^���܂����B�g���u�����������͐ӔC�҂ɘA�����邱�ƁI");
	$smarty->assign("check_arr_lot",$arr_error_lot);
	$smarty->display("error_input.tpl");
	unset($smarty);
	unset($db);
	exit;

}


	$smarty->assign("mess","����ɓo�^����܂����B");
	$smarty->assign("semi_header",$html_semiheader->semi_header());
	$smarty->assign("header",$html_yobidashi->header());
	$smarty->display("rs.tpl");
	unset($smarty);
	unset($db);
	exit;

?>
