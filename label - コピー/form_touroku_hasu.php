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
require_once("../qr/QrCode.class.php");
$QrCode =new QrCode();
require_once("../qr/SelectSql.class.php");
$SelectSql =new SelectSql();

require_once("Date_yobidashi.class.php");
$date_yobidashi =new Date_yobidashi();

	$emp_id = $_POST['emp_id'];

	$SelectSql->select_employee($emp_id);
	$full_name = $SelectSql->get_full_name();
	$smarty->assign("emp_id",$emp_id);
	$smarty->assign("full_name",$emp_id."�F".$full_name);

	if($_POST['qr_lot'] <> ""){

		if($QrCode->get_product_id1() == "emp.id"){

			$mess = "�Ј��؂��ǂݍ��܂�܂����B";

			$smarty->assign("mess",$mess);
			$smarty->display("error_input.tpl");
			unset($smarty);
			unset($db);
			exit;

		}else{

			$QrCode->getQr($_POST['qr_lot']);
			$hasu_product_id = $QrCode->get_product_id1();
			$hasu_lot_num = $QrCode->get_lot_num();
			$hasu_amount = $QrCode->get_amount1();

		}

	}else{

		$hasu_product_id = $_POST['hasu_product_id'];
		$hasu_lot_num = $_POST['hasu_lot_num'];
		$hasu_amount = $_POST['hasu_amount'];

	}

	$Check->check_touroku_hasu_lot($hasu_product_id,$hasu_lot_num);
	$hantei = $Check->get_hantei();
	$hasu_check_lots_id = $Check->get_id();

	if($hantei == 0){

		$err_mess = "���̃��b�gNo.�͓o�^����Ă��܂���B";
			
		$smarty->assign("mess",$err_mess);
		$smarty->assign("pre_tag","<!--");
		$smarty->assign("last_tag","--!>");
		$smarty->display("error_input.tpl");
		unset($smarty);
		unset($db);
		exit;

	}


$moto_lot_num = $_POST['moto_lot_num'];
$moto_amount = $_POST['moto_amount'];




if($_POST['kakunin'] == "" and $_POST['touroku'] == ""){//������ʁA�܂��́A�e�L�X�g�{�b�N�X�ǉ����

		$arr_lot = array();
		if($_POST['mot_amount'] == ""){

			$count = count($moto_lot_num);

		}else{

			$count = count($moto_lot_num) - 1;//���ʓo�^��ʂ́A1�s���炷�B

		}

		for($i=0;$i<$count;$i++){

			$QrCode->getQr($moto_lot_num[$i]);
			$date_hakkou = $QrCode->get_date_hakkou();

			if($date_hakkou == ""){

				$moto_lots_num = $moto_lot_num[$i];

			}else{

				//QR�œǂݍ��񂾃��b�g���A���ꐻ�i���ǂ������`�F�b�N����B
				$qr_product_id = $QrCode->get_product_id1();
				$moto_lots_num = $QrCode->get_lot_num();
				if($qr_product_id <> $hasu_product_id){

					$err_mess = "���̃��b�g�́A���i���Ⴂ�܂��B";
						
					$smarty->assign("mess",$err_mess);
					$smarty->assign("pre_tag","<!--");
					$smarty->assign("last_tag","--!>");
					$smarty->display("error_input.tpl");
					unset($smarty);
					unset($db);
					exit;

				}

			}

			$Check->check_touroku_hasu_lot($hasu_product_id,$moto_lots_num);
			$arr_check_lots_id = $Check->get_id();

			if($_POST['mot_amount'] == ""){

				$arr_lot[] = array("type"=>"hidden","moto_lot_num"=>$moto_lots_num);

			}else{

				$td2 = "<td height='17' align='center' bgcolor='#FFFFCC' nowrap='nowrap'>".
					"<input type='text' name='moto_amount[]' value='' size='30'/>".
					"</td>";

				$arr_lot[] = array("type"=>"hidden","moto_lot_num"=>$moto_lots_num,"moto_amount"=>$moto_amount[$i],"td2"=>$td2);

			}

		}

	$label_add = "<label><input type='submit' name='add' id='button' value='�ǉ�' /></label>";
	$label_amount = "<label><input type='submit' name='mot_amount' id='button' value='���ʓo�^' /></label>";
	if($_POST['add'] <> "" or count($moto_lot_num) == 0){

			$arr_lot[] = array("type"=>"text","moto_lot_num"=>"","moto_amount"=>"","qr"=>"qrLot");

	}elseif($_POST['mot_amount'] <> ""){

		$td1 =   "<td width='200' align='center' nowrap='nowrap' bgcolor='#FFFFCC'><strong><font color='#0000FF'>�����b�g����</font></strong></td>";
		$smarty->assign("td1",$td1);
		$label_add = "";
		$label_amount = "";
		$label_kakunin = "<label><input type='submit' name='kakunin' id='button' value='�o�^�m�F' /></label>";

	}

		
			$smarty->assign("label_kakunin",$label_kakunin);
			$smarty->assign("label_add",$label_add);
			$smarty->assign("label_amount",$label_amount);
			$smarty->assign("hasu_product_id",$hasu_product_id);
			$smarty->assign("hasu_lot_num",$hasu_lot_num);
			$smarty->assign("hasu_amount",$hasu_amount);
			$smarty->assign("arr_lot",$arr_lot);
			$smarty->display("form_touroku_hasu_pre.tpl");
			unset($smarty);
			unset($db);
			exit;

}elseif($_POST['kakunin'] <> ""){//�o�^�m�F���


	for($i=0;$i<count($moto_lot_num);$i++){

		for($j=$i + 1;$j<count($moto_lot_num);$j++){

			if($moto_lot_num[$i] == $moto_lot_num[$j]){

				$err_mess = "�������b�g�͈�x�ɓo�^�ł��܂���B".
						"<br>�߂��ēo�^�������Ă��������B";
				
				$smarty->assign("mess",$err_mess);
				$smarty->assign("pre_tag","<!--");
				$smarty->assign("last_tag","--!>");
				$smarty->display("error_input.tpl");
				unset($smarty);
				unset($db);
				exit;

			}

		}

	}

	//���b�g���Ɍ����ς����`�F�b�N����B
	for($i=0;$i<count($moto_lot_num);$i++){

		$Check->checkZenkenFinish($hasu_product_id,$moto_lot_num[$i]);
		$hantei = $Check->get_hantei();
		if($hantei == 0){

			$err_mess = "���b�g ".$moto_lot_num[$i]." �́A�������ł��B".
					"<br>�������Ă���o�^�������Ă��������B";
			
			$smarty->assign("mess",$err_mess);
			$smarty->assign("pre_tag","<!--");
			$smarty->assign("last_tag","--!>");
			$smarty->display("error_input.tpl");
			unset($smarty);
			unset($db);
			exit;

		}

	}

	$sum_amount = 0;
	for($i=0;$i<count($moto_lot_num);$i++){

		$td2 = "<td height='17' align='center' bgcolor='#FFFFCC' nowrap='nowrap'>".
			"<strong>".$moto_amount[$i]."</strong>".
			"<input type='hidden' name='moto_amount[]' value='".$moto_amount[$i]."' size='30'/>".
			"</td>";

		$sum_amount = $sum_amount + $moto_amount[$i];
		$arr_lot[] = array("type"=>"hidden","arr_check_lots_id"=>$arr_check_lots_id,"moto_lot_num"=>$moto_lot_num[$i],
				"hyouji_moto_lot_num"=>$moto_lot_num[$i],"td2"=>$td2);

	}

		$td1 =   "<td width='200' align='center' nowrap='nowrap' bgcolor='#FFFFCC'><strong><font color='#0000FF'>�����b�g����</font></strong></td>";
		$smarty->assign("td1",$td1);

	if($sum_amount <> $hasu_amount){

		$err_mess = "�[�����b�g�̐��ʂƌ����b�g�̐��ʂ̍��v�����܂���B".
				"<br>�߂��ēo�^�������Ă��������B";
		
		$smarty->assign("mess",$err_mess);
		$smarty->assign("pre_tag","<!--");
		$smarty->assign("last_tag","--!>");
		$smarty->display("error_input.tpl");
		unset($smarty);
		unset($db);
		exit;


	}


	$label_touroku = "<label><input type='submit' name='touroku' id='button' value='�o�^' /></label>";

			$smarty->assign("label_touroku",$label_touroku);
			$smarty->assign("hasu_product_id",$hasu_product_id);
			$smarty->assign("hasu_lot_num",$hasu_lot_num);
			$smarty->assign("hasu_amount",$hasu_amount);
			$smarty->assign("arr_lot",$arr_lot);
			$smarty->display("form_touroku_hasu_pre.tpl");
			unset($smarty);
			unset($db);
			exit;

}elseif($_POST['touroku'] <> ""){//�o�^���

	$str_datetime = date("Y-m-d H:i:s");
	for($i=0;$i<count($moto_lot_num);$i++){

		$Check->check_touroku_hasu_lot($hasu_product_id,$moto_lot_num[$i]);
		$moto_lots_id = $Check->get_id();
		$db->query("set names sjis");
		$insertr = "INSERT INTO moto_lots (hasu_lot_id,moto_lot_id,moto_lot_amount,touroku_datetime,emp_id)".
			" values ".
			"(".$hasu_check_lots_id.",".$moto_lots_id.",".$moto_amount[$i].",'".$str_datetime."','".$emp_id."')";
		$db->query($insertr);

		$db->query("set names sjis");
		$updater = "UPDATE check_lots set flag_used = 3 where id = ".$moto_lots_id." ";
		$db->query($updater);

	}

		//�S���������K�v�Ȑ��i�̏ꍇ�ƃ��b�g�̓���HS�̃��b�g�́Aflag_used=0�ɂ��Ă��A�o��OK��Ԃɂ���B
		$Check->check_zensu_product($hasu_product_id);
		if($Check->get_rows() <> 0 or preg_match("/^[HS]/", $hasu_lot_num)){

			$db->query("set names sjis");
			$updater = "UPDATE check_lots set flag_used = 0 where id = ".$hasu_check_lots_id." ";
			$db->query($updater);

		}
	$sum_amount = 0;
	for($i=0;$i<count($moto_lot_num);$i++){

		$Check->check_touroku_hasu_lot($hasu_product_id,$moto_lot_num[$i]);
		$moto_lots_id = $Check->get_id();
		$db->query("set names sjis");
		$sql = "select b.moto_lot_amount,a.lot_num,b.moto_lot_id from check_lots as a inner join moto_lots as b on a.id= b.moto_lot_id ".
			"where b.moto_lot_id = ".$moto_lots_id." and a.flag_used = 3 and b.touroku_datetime = '".$str_datetime."'";
		$rs=$db->query($sql);

		while($row=$rs->fetchRow(MDB2_FETCHMODE_ASSOC)){

			$td2 = "<td height='17' align='center' bgcolor='#FFFFCC' nowrap='nowrap'>".
				"<strong>".$row['moto_lot_amount']."</strong>".
				"<input type='hidden' name='moto_amount[]' value='".$row['moto_lot_amount']."'/>".
				"</td>";

			$arr_lot[] = array("type"=>"hidden","moto_lot_num"=>$row['lot_num'],
				"hyouji_moto_lot_num"=>$row['lot_num'],"td2"=>$td2);

			$sum_amount = $sum_amount + $row['moto_lot_amount'];
			
		}

	}

		if($sum_amount <> $hasu_amount){

			$err_mess = "�o�^���ꂽ���l�̍��v�������܂���B".
					"<br>�����ɐӔC�҂ɘA�����Ă��������B";
			
			$smarty->assign("mess",$err_mess);
			$smarty->assign("pre_tag","<!--");
			$smarty->assign("last_tag","--!>");
			$smarty->display("error_input.tpl");
			unset($smarty);
			unset($db);
			exit;


		}

		$td1 =   "<td width='200' align='center' nowrap='nowrap' bgcolor='#FFFFCC'><strong><font color='#0000FF'>�����b�g����</font></strong></td>";
		$smarty->assign("td1",$td1);

	$mess = "<strong><font color='#FF0000'>�ȏ�̂悤�ɓo�^����܂����B</font></strong>";
	$label_addition = "";
	$label_deletion = "";
	$label_kakunin = "";
	$label_touroku = "";

			$smarty->assign("mess",$mess);
			$smarty->assign("hasu_product_id",$hasu_product_id);
			$smarty->assign("hasu_lot_num",$hasu_lot_num);
			$smarty->assign("hasu_amount",$hasu_amount);
			$smarty->assign("arr_lot",$arr_lot);
			$smarty->display("form_touroku_hasu_pre.tpl");
			unset($smarty);
			unset($db);
			exit;

}
?>