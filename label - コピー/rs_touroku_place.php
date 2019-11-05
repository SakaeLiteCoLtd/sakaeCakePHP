<?php
require_once("MySmarty.class.php");
$smarty=new MySmarty();
$db=$smarty->getDb();
require_once("../HTML_yobidashi.class.php");
$html_yobidashi = new HTML_yobidashi();
require_once("semiHTML.class.php");
$html_semiheader = new HTML_semiheader();
$today = date("Y-m-d");

$place1 = $_POST['place1'];
$place2 = $_POST['place2'];

	$db->query("set names sjis");
	$insertr_place = "INSERT INTO label_element_place (place1,place2,genjyou) values ('".$place1."','".$place2."','0')";

	$db->query($insertr_place);

		$db->query("set names sjis");
		$kakunin_place=$db->query("select place1,place2 from label_element_place ".
						" where place1 = '".$place1."' and place2 = '".$place2."'");

		while($row=$kakunin_place->fetchRow(MDB2_FETCHMODE_ASSOC)){

			$kakunin_place1=$row['place1'];
			$kakunin_place2=$row['place2'];

		}

	$mess = "�ȏ��̂悤�ɓo�^�����܂����B";

	$smarty->assign("place1",$kakunin_place1);
	$smarty->assign("place2",$kakunin_place2);
	$smarty->assign("mess",$mess);
	$smarty->assign("semi_header",$html_semiheader->semi_header());
	$smarty->assign("header",$html_yobidashi->header());
	$smarty->display("kakunin_touroku_place.tpl");
	unset($smarty);
	unset($db);
	exit;


?>
