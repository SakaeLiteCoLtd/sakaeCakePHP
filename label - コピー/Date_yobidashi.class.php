<?php

class Date_yobidashi{

	private $starting_year;
	private $starting_month;
	private $starting_day;
	private $selected_starting_year;
	private $selected_starting_month;
	private $selected_starting_day;
	private $finishing_year;
	private $finishing_month;
	private $finishing_day;
	private $selected_finishing_year;
	private $selected_finishing_month;
	private $selected_finishing_day;
	private $starting_hour;
	private $starting_minute;
	private $finishing_hour;
	private $finishing_minute;

	public function label_lot_seikei_date($a_date){

		//今日の日付を年、月、日に分割して変数にそれぞれ格納する。
		list($date_year,$date_month,$date_day)=preg_split("/-/", $a_date);

		if(preg_match("/^[0]/",$date_month)){

			$date_month = substr($date_month ,1, 1);

		}

		if(preg_match("/^[0]/",$date_day)){

			$date_day = substr($date_day ,1, 1);

		}

		$seikei_year=mb_substr("$date_year",2,2);

		if($date_month <10){

			$seikei_month = "0".$date_month;

		}else{

			$seikei_month = $date_month;

		}

		if($date_day <10){

			$seikei_day = "0".$date_day;

		}else{

			$seikei_day = $date_day;

		}

		$lot_seikei_date = $seikei_year.$seikei_month.$seikei_day;
		$this->lot_seikei_date = $lot_seikei_date;

	}

	public function select_date($a_date,$a){

		//今日の日付を年、月、日に分割して変数にそれぞれ格納する。
		list($date_year,$date_month,$date_day)=preg_split("/-/", $a_date);

		$this->selected_year=$date_year;

		$select_year=array();

		//select_day[]に3年分配列で返す
		if($a == 1){$select_year[] = "";}
		for($y=2013;$y<=$date_year + 1;$y++){

			$select_year[$y]=$y;

		}

		$this->starting_year=$select_year;

		$select_month=array();

		//select_day[]に12ヶ月分配列で返す
		if($a == 1){$select_month[] = "";}
		for($i=1;$i<=12;$i++){

			$select_month[$i]=$i;

		}
		
		$this->starting_month=$select_month;

		$select_day=array();
		//select_day[]に31日分配列で返す
		if($a == 1){$select_day[] = "";}
		for($j=1;$j<=31;$j++){

			$select_day[$j]=$j;

		}

		$this->starting_day=$select_day;
	
		

		//$date_monthの最初が0だったら、取り除く。
		if(preg_match("/^[0]/", $date_month)){

			$date_month=substr($date_month, 1);
		}

		//今日の日付の月をselectedに指定するための変数を作る
		for($m=1;$m<=12;$m++){

			if($m==$date_month){
			
			$selected_month=$m;

			}

		}

		$this->selected_month=$selected_month;

		//$date_dayの最初が0だったら、取り除く。
		if(preg_match("/^[0]/", $date_day)){
			$date_day=substr($date_day, 1);
		}

		//今日の日付の日をselectedに指定するための変数を作る
		for($d=1;$d<=31;$d++){

			if($d==$date_day){
			
			$selected_day=$d;

			}

		}
		
		$this->selected_day=$selected_day;


	}


	



	public function select_time($a_s_time){

		
		list($s_hour,$s_minute)=preg_split("/:/", $a_s_time);

		

		$select_hour=array();
		
		//select_day[]に２４時間分を配列で返す
		
		for($i=0;$i<=23;$i++){
			$time=$i;
			if($time<10){$time = "0".$time;}
			$select_hour[$i]=$time;

		}
		
		$this->select_hour=$select_hour;

		//$s_hourの最初が0だったら、取り除く。
		if(preg_match("/^[0]/", $s_hour)){

			$s_hour=substr($s_hour, 1);
		}

	
		for($h=0;$h<=23;$h++){

			if($h==$s_hour){
			
			$selected_hour=$h;

			}

		}

		$this->selected_hour=$selected_hour;


		$select_minute=array();

		//select_minute[]に10分毎を配列で返す

		$select_minute=array();
		$select_minute[]=array("00"=>"00",
				       "10"=>"10",
				       "20"=>"20",
				       "30"=>"30",
				       "40"=>"40",
				       "50"=>"50");

		$this->select_minute=$select_minute;
	
		

		$this->selected_minute=$s_minute;


	}


public function get_lot_seikei_date(){
	return $this->lot_seikei_date;
	}


public function get_year(){
	return $this->starting_year;
	}

public function get_month(){
	return $this->starting_month;
	}

public function get_day(){
	return $this->starting_day;
	}

public function get_selected_year(){
	return $this->selected_year;
	}

public function get_selected_month(){
	return $this->selected_month;
	}

public function get_selected_day(){
	return $this->selected_day;
	}


public function get_select_hour(){
	return $this->select_hour;
	}

public function get_selected_hour(){
	return $this->selected_hour;
	}

public function get_select_minute(){
	return $this->select_minute;
	}

public function get_selected_minute(){
	return $this->selected_minute;
	}

}
?>