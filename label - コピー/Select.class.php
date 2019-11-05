<?php

class Select{

	public function select_label_type(){
	require_once("MySmarty.class.php");
	$smarty=new MySmarty();
	$db=$smarty->getDb();
			
		$db->query("set names sjis");
		$rs=$db->query("select type_id from label_type");

		$select_label_type = array();
		$select_label_type[]=array("0"=>"");
		while($row=$rs->fetchRow(MDB2_FETCHMODE_ASSOC)){

			$select_label_type[]=array($row['type_id']=>$row['type_id']);

		}

		$this->select_label_type=$select_label_type;

	}

	public function select_label_place($type_label){
	require_once("MySmarty.class.php");
	$smarty=new MySmarty();
	$db=$smarty->getDb();

		$db->query("set names sjis");
		$rs=$db->query("select row_place,row_product from label_type where type_id = '".$type_label."'");
		while($row=$rs->fetchRow(MDB2_FETCHMODE_ASSOC)){

			$row_product = $row['row_product'];
			$this->row_product=$row_product;
			$row_place = $row['row_place'];
			$this->row_place=$row_place;

		}

		$db->query("set names sjis");
		$sql = "select id,place1,place2 from label_element_place where genjyou = '0' ";
		if($row_place==2){
			$wherestr = " and place2 <> ''";
		}else{
			$wherestr = " and place2 = ''";
		}
		$rs_place=$db->query($sql.$wherestr);
		$this->sql=$sql.$wherestr;

		$select_label_place = array();
		$select_label_place[]=array("0"=>"");
		while($row_place=$rs_place->fetchRow(MDB2_FETCHMODE_ASSOC)){

			$place = $row_place['place1'];
			if($this->row_place==2){$place = $place."_".$row_place['place2'];}
			$select_label_place[]=array($row_place['id']=>$place);

		}

		$this->select_label_place=$select_label_place;

	}

	public function select_label_unit($type_label){
	require_once("MySmarty.class.php");
	$smarty=new MySmarty();
	$db=$smarty->getDb();

		$db->query("set names sjis");
		$rs=$db->query("select row_place,row_product,row_amount from label_type where type_id = '".$type_label."'");
		while($row=$rs->fetchRow(MDB2_FETCHMODE_ASSOC)){

			$row_product = $row['row_product'];
			$this->row_product=$row_product;
			$row_place = $row['row_place'];
			$this->row_place=$row_place;
			$row_amount = $row['row_amount'];
			$this->row_amount=$row_amount;

		}

		$select_label_unit = array();
		if($this->row_product==1 and $this->row_amount==1){

			$select_label_unit[]=array("1"=>"(ƒP)ˆóŽš–³‚µ");

		}elseif($this->row_product==2 and $this->row_amount==1){

			$select_label_unit[]=array("2"=>"set");

		}elseif($this->row_product==2 and $this->row_amount==2){

			$select_label_unit[]=array("1"=>"(ƒP)ˆóŽš–³‚µ");

		}

		$this->select_label_unit=$select_label_unit;

	}

	public function label_place($place_id){
	require_once("MySmarty.class.php");
	$smarty=new MySmarty();
	$db=$smarty->getDb();



		$db->query("set names sjis");
		$rs_place = $db->query("select id,place1,place2 from label_element_place where id = ".$place_id."");
		while($row_place=$rs_place->fetchRow(MDB2_FETCHMODE_ASSOC)){

			$name_place = $row_place['place1'];
			if($row_place['place2']<>""){

				$name_place = $name_place."_".$row_place['place2'];

			}
			
			$this->name_place1=$row_place['place1'];
			$this->name_place2=$row_place['place2'];
			$this->name_place=$name_place;

		}

		$this->place_id=$place_id;

	}

	public function label_unit($unit_id){
	require_once("MySmarty.class.php");
	$smarty=new MySmarty();
	$db=$smarty->getDb();



		$db->query("set names sjis");
		$rs_unit = $db->query("select id,unit from label_element_unit where id = ".$unit_id."");
		while($row_unit=$rs_unit->fetchRow(MDB2_FETCHMODE_ASSOC)){

			$unit = $row_unit['unit'];
			$this->label_unit = $row_unit['unit'];

			if($row_unit['unit'] == ""){$unit = "(ƒP)ˆóŽš–³‚µ";}
			
			$this->unit=$unit;

		}

		$this->unit_id=$unit_id;

	}

public function get_select_label_type(){
	return $this->select_label_type;
	}

public function get_select_label_place(){
	return $this->select_label_place;
	}

public function get_select_label_unit(){
	return $this->select_label_unit;
	}

public function get_row_product(){
	return $this->row_product;
	}

public function get_row_place(){
	return $this->row_place;
	}

public function get_name_place(){
	return $this->name_place;
	}

public function get_name_place1(){
	return $this->name_place1;
	}

public function get_name_place2(){
	return $this->name_place2;
	}

public function get_unit(){
	return $this->unit;
	}

public function get_label_unit(){
	return $this->label_unit;
	}

}



?>