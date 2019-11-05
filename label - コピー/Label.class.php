<?php

class Label{

	private $hakosu;
	private $hasu;

	public function calc_hakosu($a_product_id,$a_amount){

	require_once("MySmarty.class.php");
	$smarty=new MySmarty();
	$db=$smarty->getDb();
			
		$db->query("set names sjis");
		$rs=$db->query("select irisu from konpou where product_id = '".$a_product_id."'");
		$rows=$rs->numRows();
		while($row=$rs->fetchRow(MDB2_FETCHMODE_ASSOC)){

			$irisu= $row['irisu'];

		}

		if($rows <> 0){

			if($a_amount-$irisu >0){

				$hakosu = floor($a_amount / $irisu);//Ø‚è‰º‚°‚é
				$hasu = $a_amount % $irisu;

			}elseif($a_amount-$irisu == 0){

				$hakosu = 1;
				$hasu = 0;

			}else{

				$hakosu = 0;
				$hasu = $a_amount;

			}
		}else{

				$hakosu = "ERROR";
				$hasu = "ERROR";

		}

		$this->hakosu=$hakosu;
		$this->hasu=$hasu;

	}

public function get_hakosu(){
	return $this->hakosu;
	}


public function get_hasu(){
	return $this->hasu;
	}

}
?>