<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=SHIFT_JIS" />
<!-- TemplateBeginEditable name="doctitle" -->
<title>無題ドキュメント</title>
<!-- TemplateEndEditable -->
<!-- TemplateBeginEditable name="head" --><!-- TemplateEndEditable -->
</head>

<body>
<table width="800" border="0" align="center" cellpadding="0" cellspacing="0" bordercolor="#CCCCCC">
  <tr>
    <td bgcolor="#E6FFFF"><p><img src="../img/logo.gif" width="157" height="22" /></p>
	{$header}
    </td>
  </tr>
  <tr valign="middle" bordercolor="#CCCCCC">
    <td bgcolor="#E6FFFF"><!-- TemplateBeginEditable name="body" --><!-- TemplateEndEditable -->
  <hr>
{$semi_header}
<hr />
<table width="800" border="0">
  <tr>
    <td align="center"><a href="form_touroku_layout.php"><img src="../img/label_layout.gif" alt="csv" width="83" height="37" border="0"/></a></td>
    <td align="center"><a href="form_touroku_place.php"><img src="../img/label_touroku_place.gif" alt="csv" width="83" height="37" border="0"/></a></td>
    <td align="center"><a href="form_touroku_unit.php"><img src="../img/label_touroku_unit.gif" alt="csv" width="83" height="37" border="0"/></a></td>
    <td align="center"><a href="form_touroku_insideout.php"><img src="../img/label_insideout.gif" alt="csv" width="83" height="37" border="0"/></a></td>
    <td align="center"><a href="form_touroku_setikkatsu.php"><img src="../img/label_setikkatsu.gif" alt="csv" width="83" height="37" border="0"/></a></td>
    <td align="center"><a href="form_touroku_label_nashi.php"><img src="../img/label_nashi.gif" alt="csv" width="83" height="37" border="0"/></a></td>
  </tr>
</table>
  <hr>
<br />
<table width="800" border="0">
  <tr>
    <td align="center"><a href="form_touroku_label_nashi.php"><img src="../img/label_touroku.gif" alt="csv" width="83" height="37" border="0"/></a></td>
    <td align="center"><a href="rs_label_nashi_ichiran.php"><img src="../img/label_ichiran.gif" alt="csv" width="83" height="37" border="0"/></a></td>
  </tr>
</table>
<br>
<br>
<form action="rs_update_label_nashi.php" method="post">
  <table width="350" border="0" align="center" bgcolor="#666666">
    <tr>
      <td width="100" bgcolor="#FFFFCC"><div align="center" class="style1"><strong><font color="#0000FF">品番</font></strong></div></td>
      <td bgcolor="#FFFFCC"><div align="center"><strong>{$product_id}</strong><input type="hidden" name="product_id1" value="{$product_id1}" size="30"/></div></td>
    </tr>
  </table>
<p><strong><font color="#FF0000">{$mess}</font></strong><p/>
<p align="center">
<label>
<input type="submit" name="button" id="button" value="登録" />
</label>
</p>
<br>
</form>

<br />
</td>
    <hr />  
  </tr>
</table>
</body>
</html>
