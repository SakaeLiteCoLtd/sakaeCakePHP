<?php
			
class GetArray{

	private $arr_koutei;

	public function kouteiSeikeiki($arr,$c,$product_id,$starting_year,$selected_starting_year,
					$starting_month,$selected_starting_month,$starting_day,$selected_starting_day,
					$starting_hour,$selected_starting_hour,$starting_minute,$selected_starting_minute,
					$finishing_year,$selected_finishing_year,$finishing_month,$selected_finishing_month,
					$finishing_day,$selected_finishing_day,$finishing_hour,$selected_finishing_hour,
					$finishing_minute,$selected_finishing_minute,$number_sheet,$num_box){

		$checked = "";
		$radio = "<input type='checkbox' name='target_p".$c."[]' value='1' ".$checked.">";
		

		$arr_koutei = array();
/*
		for($i=0;$i<count($arr);$i++){

			$arr_koutei[] = array("radio"=>$arr[$i]['radio'],"product_id"=>$arr[$i]['product_id'],
						"starting_year"=>$arr[$i]['starting_year'],"selected_starting_year"=>$arr[$i]['selected_starting_year'],
						"starting_month"=>$arr[$i]['starting_month'],"selected_starting_month"=>$arr[$i]['selected_starting_month'],
						"starting_day"=>$arr[$i]['starting_day'],"selected_starting_day"=>$arr[$i]['selected_starting_day'],
						"starting_hour"=>$arr[$i]['starting_hour'],"selected_starting_hour"=>$arr[$i]['selected_starting_hour'],
						"starting_minute"=>$arr[$i]['starting_minute'],"selected_starting_minute"=>$arr[$i]['selected_starting_minute'],
						"finishing_year"=>$arr[$i]['finishing_year'],"selected_finishing_year"=>$arr[$i]['selected_finishing_year'],
						"finishing_month"=>$arr[$i]['finishing_month'],"selected_finishing_month"=>$arr[$i]['selected_finishing_month'],
						"finishing_day"=>$arr[$i]['finishing_day'],"selected_finishing_day"=>$arr[$i]['selected_finishing_day'],
						"finishing_hour"=>$arr[$i]['finishing_hour'],"selected_finishing_hour"=>$arr[$i]['selected_finishing_hour'],
						"finishing_minute"=>$arr[$i]['finishing_minute'],"selected_finishing_minute"=>$arr[$i]['selected_finishing_minute'],
						"number_sheet"=>$arr[$i]['number_sheet'],"num_box"=>$arr[$i]['num_box']);

		}
*/
		$arr_koutei[] = array("radio"=>$radio,"product_id"=>$product_id,
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
					"number_sheet"=>$number_sheet,"num_box"=>$num_box);

		$this->arr_koutei = $arr_koutei;
		$this->arr = $arr;
	}


public function get_arr_koutei(){
	return $this->arr_koutei;
	}


public function get_array(){
	return $this->arr;
	}

}
?>