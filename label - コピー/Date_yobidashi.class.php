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

		//�����̓��t��N�A���A���ɕ������ĕϐ��ɂ��ꂼ��i�[����B
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

		//�����̓��t��N�A���A���ɕ������ĕϐ��ɂ��ꂼ��i�[����B
		list($date_year,$date_month,$date_day)=preg_split("/-/", $a_date);

		$this->selected_year=$date_year;

		$select_year=array();

		//select_day[]��3�N���z��ŕԂ�
		if($a == 1){$select_year[] = "";}
		for($y=2013;$y<=$date_year + 1;$y++){

			$select_year[$y]=$y;

		}

		$this->starting_year=$select_year;

		$select_month=array();

		//select_day[]��12�������z��ŕԂ�
		if($a == 1){$select_month[] = "";}
		for($i=1;$i<=12;$i++){

			$select_month[$i]=$i;

		}
		
		$this->starting_month=$select_month;

		$select_day=array();
		//select_day[]��31�����z��ŕԂ�
		if($a == 1){$select_day[] = "";}
		for($j=1;$j<=31;$j++){

			$select_day[$j]=$j;

		}

		$this->starting_day=$select_day;
	
		

		//$date_month�̍ŏ���0��������A��菜���B
		if(preg_match("/^[0]/", $date_month)){

			$date_month=substr($date_month, 1);
		}

		//�����̓��t�̌���selected�Ɏw�肷�邽�߂̕ϐ������
		for($m=1;$m<=12;$m++){

			if($m==$date_month){
			
			$selected_month=$m;

			}

		}

		$this->selected_month=$selected_month;

		//$date_day�̍ŏ���0��������A��菜���B
		if(preg_match("/^[0]/", $date_day)){
			$date_day=substr($date_day, 1);
		}

		//�����̓��t�̓���selected�Ɏw�肷�邽�߂̕ϐ������
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
		
		//select_day[]�ɂQ�S���ԕ���z��ŕԂ�
		
		for($i=0;$i<=23;$i++){
			$time=$i;
			if($time<10){$time = "0".$time;}
			$select_hour[$i]=$time;

		}
		
		$this->select_hour=$select_hour;

		//$s_hour�̍ŏ���0��������A��菜���B
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

		//select_minute[]��10������z��ŕԂ�

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