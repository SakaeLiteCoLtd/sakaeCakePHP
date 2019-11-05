<?php

class SelectSql{

	//日付別の納品場所を配列に格納する。
	public function select_datebetsu_deliver($date){

		require_once("MySmarty.class.php");
		$smarty=new MySmarty();
		$db=$smarty->getDb();
				
		$db->query("set names sjis");
		$wherestr = " where a.date_deliver = '".$date."'";
		$sql = "select a.place_deliver_id,b.name from order_edi as a ".
			" inner join customers_handy as b on a.place_deliver_id= b.place_deliver_id ".
			$wherestr." group by place_deliver_id";
		$rs=$db->query($sql);
		$rows=$rs->numRows();
		$data = array();
		while($row=$rs->fetchRow(MDB2_FETCHMODE_ASSOC)){

			$data[] = array("place_deliver_id"=>$row['place_deliver_id'],"name"=>$row['name']);

		}

		$this->data = $data;
	}

	//納品場所をゲットする
	public function select_name_deliver($place_deliver_id){

		require_once("MySmarty.class.php");
		$smarty=new MySmarty();
		$db=$smarty->getDb();
				
		$db->query("set names sjis");
		$wherestr = " where place_deliver_id = '".$place_deliver_id."'";
		$sql = "select name from customers_handy ".$wherestr;
		$rs=$db->query($sql);
		$rows=$rs->numRows();

		while($row=$rs->fetchRow(MDB2_FETCHMODE_ASSOC)){

			$name = $row['name'];

		}

		$this->name = $name;
	}

	public function select_lots($product_id,$date_deliver,$place_deliver_id){

		require_once("MySmarty.class.php");
		$smarty=new MySmarty();
		$db=$smarty->getDb();
				
		$db->query("set names sjis");
		$wherestr = " where product_id = '".$product_id."'".
				" and place_deliver_id = '".$place_deliver_id."' and date_deliver = '".$date_deliver."'";
		$sql = "select lot_num,amount from check_lots ".$wherestr;

		$rs=$db->query($sql);
		$rows=$rs->numRows();
		$data = array();
		while($row=$rs->fetchRow(MDB2_FETCHMODE_ASSOC)){

			$data[] = array("lot_num"=>$row['lot_num'],"amount"=>$row['amount']);

		}

		$this->data = $data;
		$this->rows = $rows;

	}

	public function select_moto_lots($product_id,$hasu_lot_num){

		require_once("MySmarty.class.php");
		$smarty=new MySmarty();
		$db=$smarty->getDb();
				
		$db->query("set names sjis");
		$wherestr = " where product_id = '".$product_id."'".
				" and lot_num = '".$hasu_lot_num."'";
		$sql_id = "select id from check_lots ".$wherestr;

		$rs_id=$db->query($sql_id);
		while($row_id=$rs_id->fetchRow(MDB2_FETCHMODE_ASSOC)){

			$id = $row_id['id'];

		}

		$db->query("set names sjis");

		$sql_moto_lot = "select moto_lot_id,moto_lot_amount from moto_lots where hasu_lot_id = ".$id;

		$rs_moto=$db->query($sql_moto_lot);
		$rows=$rs_moto->numRows();
		$arr_moto_lots = array();
		while($row_moto=$rs_moto->fetchRow(MDB2_FETCHMODE_ASSOC)){

			$db->query("set names sjis");
			$sql_check_lots = "select lot_num from check_lots where id =".$row_moto['moto_lot_id'];
			$rs_check_lots=$db->query($sql_check_lots);
			while($row_check_lots=$rs_check_lots->fetchRow(MDB2_FETCHMODE_ASSOC)){

				$arr_moto_lots[] = array("lot_num"=>$row_check_lots['lot_num'],"moto_lot_amount"=>$row_moto['moto_lot_amount']);

			}
			

		}

		$this->arr_moto_lots = $arr_moto_lots;
		$this->rows = $sql_moto_lot;

	}


public function get_rows(){
	return $this->rows;
	}

public function get_name(){
	return $this->name;
	}

public function get_data(){
	return $this->data;
	}

public function get_arr_moto_lots(){
	return $this->arr_moto_lots;
	}
}
?>