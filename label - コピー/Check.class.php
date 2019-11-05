<?php

class Check{

	//�S���ς��̃`�F�b�N�B
	public function checkZenkenFinish($product_id,$lot_num){

		require_once("MySmarty.class.php");
		$smarty=new MySmarty();
		$db=$smarty->getDb();
				
		$db->query("set names sjis");
		$sql = "SELECT id from check_lots ".
			" where product_id = '".$product_id."' and lot_num = '".$lot_num."' and (flag_used = 0 or flag_used = 3)";
		$rs=$db->query($sql);
		$rows=$rs->numRows();

		$this->hantei = $rows;

	}

	//���t�ʂɐ��i���[���ς����`�F�b�N����
	public function check_deliver_flag($date,$place_deliver_id){

		$nowDatetime = date('Y-m-d H:i:s');//���[���`�F�b�N�����Ƃ��̎���

		require_once("MySmarty.class.php");
		$smarty=new MySmarty();
		$db=$smarty->getDb();

		$db->query("set names sjis");
		$wherestr = " where date_deliver = '".$date."' ".
				" and place_deliver_id = '".$place_deliver_id."'".
				" group by product_id order by product_id asc";
		$sql = "select product_id from order_edi ".$wherestr;
		$rs=$db->query($sql);
		$data = array();
		while($row=$rs->fetchRow(MDB2_FETCHMODE_ASSOC)){

			$data[] = array("product_id"=>$row['product_id']);

		}

		//�o�׍ς݃��b�g�̐��ʂ𐻕i���Ƃɍ��v���A�z��Ɋi�[���Ă���
		$arr_mikan = array();
		$arr_kannou = array();
		$hantei = 0;  //$hantei��0�̂܂܂Ȃ�S�Ċ��[���Ă���B

		for($i=0;$i<count($data);$i++){

			$db->query("set names sjis");
			$wherestr = " where product_id = '".$data[$i]['product_id']."' ".
					" and date_deliver = '".$date."' ".
					" and place_deliver_id = '".$place_deliver_id."' and delete_flg = 0 ".
					" order by product_id, place_deliver_id, place_line ASC";
			$sql_order = "select sum(amount) from order_edi ".$wherestr;
			$sum_order_amount = $db->queryOne($sql_order);
			
			$db->query("set names sjis");
			$wherestr_lots = " where product_id = '".$data[$i]['product_id']."' ".
					" and date_deliver = '".$date."' ".
					" and place_deliver_id = '".$place_deliver_id."' and delete_flg is NULL ";
			$sql_lots = "select sum(amount) from check_lots ".$wherestr_lots;
			$sum_lots_amount=$db->queryOne($sql_lots);

			if($sum_order_amount > $sum_lots_amount){

				$mikan_amount = $arr_order_box[$j]['amount'] - $rs_sum_lots;

				$arr_mikan[] = array("product_id"=> $data[$i]['product_id'],"mikan_amount"=>$mikan_amount);

				$hantei = $hantei + 1;

			}elseif($sum_order_amount == $sum_lots_amount){

				//���[�̃`�F�b�N�̗L���𒲂ׁA���[�t���b�O�𗧂Ă�B
				$db->query("set names sjis");
				$sql_kannou_order = "select num_order,check_kannou from order_edi ".$wherestr;
				$rs_kannou=$db->query($sql_kannou_order);
				$data_kannou = array();
				while($row_kannou=$rs_kannou->fetchRow(MDB2_FETCHMODE_ASSOC)){

					$data_kannou[] = array("num_order"=>$row_kannou['num_order'],"check_kannou"=>$row_kannou['check_kannou']);

				}

				for($j=0;$j<count($data_kannou);$j++){

					//�t���b�O�������Ă��Ȃ�������A�b�v�f�[�g����B
					if($data_kannou[$j]['check_kannou'] == ""){

						$db->query("set names sjis");
						$updatestr = "UPDATE order_edi set kannou=1,check_kannou='".$nowDatetime."' ".
								"where place_deliver_id = '".$place_deliver_id."' ".
								"and date_deliver = '".$date."' ".
								"and product_id = '".$data[$i]['product_id']."' ".
								"and num_order = '".$data_kannou[$j]['num_order']."'";
						$db->query($updatestr);

					}

				}

				$arr_kannou[] = array("product_id"=> $data[$i]['product_id'],"kannou_amount"=>$sum_lots_amount);

			}elseif($sum_order_amount < $sum_lots_amount){

				

			}


		}

		$this->arr_mikan = $arr_mikan;
		$this->arr_kannou = $arr_kannou;
		$this->hantei = $hantei;

	}

	//���i���o�^�ς����`�F�b�N����
	public function check_product($product_id){

		require_once("MySmarty.class.php");
		$smarty=new MySmarty();
		$db=$smarty->getDb();
				
		$db->query("set names sjis");
		$wherestr = " where product_id = '".$product_id."'";
		$sql = "select product_id from product ".$wherestr;
		$rs=$db->query($sql);
		$rows=$rs->numRows();

		$this->rows = $rows;

	}

	//���i���S�������Ώۂ����`�F�b�N����
	public function check_zensu_product($product_id){

		require_once("MySmarty.class.php");
		$smarty=new MySmarty();
		$db=$smarty->getDb();
				
		$db->query("set names sjis");
		$wherestr = " where product_id = '".$product_id."' order by datetime_touroku desc limit 1";
		$sql = "select status from zensu_product ".$wherestr;
		$rs=$db->query($sql);
		$rows=$rs->numRows();
		if($rows > 0){

			while($row=$rs->fetchRow(MDB2_FETCHMODE_ASSOC)){

				$hantei = $row['status'];

			}
		
		}
		$this->rows = $rows;
		$this->hantei = $hantei;

	}


	//���b�g���o�^�ς����`�F�b�N����
	public function check_lots_tourokusumi($number_sheet,$product_id,$lot_date,$num_box){

		$arr_product_id = array();
		$arr_lot_num = array();
		$arr_flag_used = array();
		$arr_not_product_id = array();
		$arr_not_lot_num = array();

		if($num_box == "HS."){

			$lot_hasu = "HS.";
			$num_box = 1;

		}else{

			$num_box = $num_box;

		}

		//���b�g�ԍ��𐬌`
		for($i=0;$i<$number_sheet;$i++){

			$hako_num = $num_box + $i;

			if($num_box < 10){

				if($hako_num < 10){

					$hako_num = "00".$hako_num;

				}else{

					$hako_num = "0".$hako_num;

				}

			}elseif($num_box < 100){

				if($hako_num < 100){

					$hako_num = "0".$hako_num;

				}else{

					$hako_num = $hako_num;

				}

			}else{

				$hako_num = $hako_num;

			}

			$lot_num = $lot_date."-".$hako_num;

			if($lot_hasu <> ""){

				$lot_num = $lot_hasu.$lot_num;

			}

			require_once("MySmarty.class.php");
			$smarty=new MySmarty();
			$db=$smarty->getDb();
			
			//���b�gNO�����݂���A�܂��́A���b�gNO�����݂��Ċ��ɕs�g�p�o�^����Ă���B
			$db->query("set names sjis");
			$wherestr = " where (product_id = '".$product_id."' and lot_num = '".$lot_num."')".
			" or (product_id = '".$product_id."' and lot_num = '".$lot_num."' and flag_used = 1) ".
			" or (product_id = '".$product_id."' and lot_num = '".$lot_num."' and flag_used = 2) ";
			$sql = "select product_id,lot_num,flag_used from check_lots ".$wherestr;
			$rs=$db->query($sql);
			$rows=$rs->numRows();

			if($rows==0){//���b�g�o�^����Ă��Ȃ��B

				$hantei = 0;
				$arr_not_product_id[] = array("product_id"=>$row['product_id']);
				$arr_not_lot_num[] = array("lot_num"=>$row['lot_num']);

			}else{//���b�g�o�^�͂���Ă���B�܂��́A�����ĕs�g�p�o�^�A�o�דo�^���Ȃ���Ă���B

				$hantei = 1;
			
				while($row=$rs->fetchRow(MDB2_FETCHMODE_ASSOC)){

					$arr_product_id[] = array("product_id"=>$row['product_id']);
					$arr_lot_num[] = array("lot_num"=>$row['lot_num']);
					$arr_flag_used[] = array("flag_used"=>$row['flag_used']);

				}


			}

		}

		$this->arr_not_product_id = $arr_not_product_id;
		$this->arr_not_lot_num = $arr_not_lot_num;
	
		$this->arr_product_id = $arr_product_id;
		$this->arr_lot_num = $arr_lot_num;
		$this->arr_flag_used = $arr_flag_used;

		$this->hantei = $hantei;

	}

	public function check_uni_lot_tourokusumi($product_id,$lot_num){//�ʂŃ��b�g���`�F�b�N����Ƃ�

			require_once("MySmarty.class.php");
			$smarty=new MySmarty();
			$db=$smarty->getDb();
				
			$db->query("set names sjis");
			$wherestr = " where product_id = '".$product_id."' and lot_num = '".$lot_num."'";
			$sql = "select product_id,lot_num from check_lots ".$wherestr;
			$rs=$db->query($sql);
			$rows=$rs->numRows();

			if($rows==0){

				$hantei = 0;//�Ώۃ��b�g���o�^����Ă��Ȃ��Ƃ��B

			}else{

				$hantei = 1;//�Ώۃ��b�g���o�^����Ă���Ƃ��B

			}

		$this->hantei = $hantei;
	}

	public function check_touroku_hasu_lot($product_id,$lot_num){//�[�����b�g�o�^�Ń��b�g���`�F�b�N����Ƃ�

			require_once("MySmarty.class.php");
			$smarty=new MySmarty();
			$db=$smarty->getDb();
				
			$db->query("set names sjis");
			$wherestr = " where product_id = '".$product_id."' and lot_num = '".$lot_num."'";
			$sql = "select id,flag_used,flag_deliver from check_lots ".$wherestr;
			$rs=$db->query($sql);
			$rows=$rs->numRows();

			if($rows==0){

				$hantei = 0;//�Ώۃ��b�g���o�^����Ă��Ȃ��Ƃ��B

			}else{

				$hantei = 1;//�Ώۃ��b�g���o�^����Ă���Ƃ��B
				while($row=$rs->fetchRow(MDB2_FETCHMODE_ASSOC)){

					$id = $row['id'];
					$flag_used = $row['flag_used'];
					$flag_deliver = $row['flag_deliver'];

				}


			}

		$this->hantei = $hantei;
		$this->id = $id;
		$this->flag_used = $flag_used;
		$this->flag_deliver = $flag_deliver;

	}

	//���萔�Q�b�g
	public function check_irisu($product_id){

		require_once("MySmarty.class.php");
		$smarty=new MySmarty();
		$db=$smarty->getDb();
				
		$db->query("set names sjis");
		$wherestr = " where product_id = '".$product_id."'";
		$sql = "select irisu from konpou ".$wherestr;
		$rs=$db->query($sql);
		$konpou_rows=$rs->numRows();

		$this->konpou_rows = $konpou_rows;

		while($row=$rs->fetchRow(MDB2_FETCHMODE_ASSOC)){

			$irisu = $row['irisu'];

		}

		$this->irisu = $irisu;

	}

	public function check_box_insideout($product_id,$num_inside){

		require_once("MySmarty.class.php");
		$smarty=new MySmarty();
		$db=$smarty->getDb();
				
		$db->query("set names sjis");
		$wherestr = " where product_id = '".$product_id."'";
		$sql = "select irisu from konpou ".$wherestr;
		$rs=$db->query($sql);
		$konpou_rows=$rs->numRows();

		$this->konpou_rows = $konpou_rows;

		while($row=$rs->fetchRow(MDB2_FETCHMODE_ASSOC)){

			$irisu = $row['irisu'];

		}

		$this->irisu = $irisu;

		$result = $irisu % $num_inside;	

		if($result == 0){

			$checker = 0; //����؂��̂�OK

		}else{

			$checker = 1; //����؂�Ȃ��̂ŃG���[

		}

		$this->checker = $checker;

	}

	public function check_insideout($product_id){

		require_once("MySmarty.class.php");
		$smarty=new MySmarty();
		$db=$smarty->getDb();
				
		$db->query("set names sjis");
		$wherestr = " where product_id = '".$product_id."'";
		$sql = "select product_id,num_inside from label_insideout ".$wherestr;
		$rs=$db->query($sql);
		$rows=$rs->numRows();
		$this->rows = $rows;

		while($row=$rs->fetchRow(MDB2_FETCHMODE_ASSOC)){

			$num_inside = $row['num_inside'];

		}

			$this->num_inside = $num_inside;

	}

	//�Z�b�g���ꊇ����ɓo�^�ς����`�F�b�N����
	public function check_setikkatsu($product_id1){

		require_once("MySmarty.class.php");
		$smarty=new MySmarty();
		$db=$smarty->getDb();
				
		$db->query("set names sjis");
		$wherestr = " where product_id1 = '".$product_id1."'  or product_id2 = '".$product_id1."'";
		$sql = "select product_id1,product_id2 from label_setikkatsu ".$wherestr;
		$rs=$db->query($sql);
		$rows=$rs->numRows();

		$this->rows = $rows;

		while($row=$rs->fetchRow(MDB2_FETCHMODE_ASSOC)){

			$product_id1 = $row['product_id1'];
			$product_id2 = $row['product_id2'];

		}

		$this->product_id1 = $product_id1;
		$this->product_id2 = $product_id2;
		$this->rows = $rows;

	}

	//label_nashi�e�[�u���ɓo�^�ς����`�F�b�N����
	public function check_label_nashi($product_id){

		require_once("MySmarty.class.php");
		$smarty=new MySmarty();
		$db=$smarty->getDb();
				
		$db->query("set names sjis");
		$wherestr = " where product_id = '".$product_id."'";
		$sql = "select product_id from label_nashi ".$wherestr;
		$rs=$db->query($sql);
		$rows=$rs->numRows();

		$this->rows = $rows;

	}

public function get_arr_kannou(){
	return $this->arr_kannou;
	}

public function get_arr_mikan(){
	return $this->arr_mikan;
	}

public function get_id(){
	return $this->id;
	}

public function get_flag_used(){
	return $this->flag_used;
	}

public function get_flag_deliver(){
	return $this->flag_deliver;
	}


public function get_product_id1(){
	return $this->product_id1;
	}

public function get_product_id2(){
	return $this->product_id2;
	}

public function get_num_inside(){
	return $this->num_inside;
	}


public function get_rows(){
	return $this->rows;
	}

public function get_irisu(){
	return $this->irisu;
	}

public function get_checker(){
	return $this->checker;
	}

public function get_konpou_rows(){
	return $this->konpou_rows;
	}

public function get_hantei(){
	return $this->hantei;
	}

public function get_arr_product_id(){
	return $this->arr_product_id;
	}

public function get_arr_lot_num(){
	return $this->arr_lot_num;
	}

public function get_arr_not_product_id(){
	return $this->arr_not_product_id;
	}

public function get_arr_not_lot_num(){
	return $this->arr_not_lot_num;
	}

public function get_arr_flag_used(){
	return $this->arr_flag_used;
	}

}
?>