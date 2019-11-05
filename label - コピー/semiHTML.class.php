<?php

class HTML_semiheader{
	
	public function semi_header(){

		$semi_header = "<table width='800' border='0' align='center'>".
				"<tr>".
				"<td align='center'><a href='index_hakkou.php'><img src='../img/label_hakkou.gif' width='120' height='36' border='0' /></a></td>".
				"<td align='center'><a href='index_lot.php'><img src='../img/label_lot.gif' width='120' height='36' border='0' /></a></td>".
				"<td align='center'><a href='index_genzai.php'><img src='../img/label_genzai.gif' width='120' height='36' border='0' /></a></td>".
				"<td align='center'><a href='index_shinki.php'><img src='../img/label_shinki.gif' width='120' height='36' border='0' /></a></td>".
				"</tr>".
				"</table>";

			return $semi_header;

	}

}
?>