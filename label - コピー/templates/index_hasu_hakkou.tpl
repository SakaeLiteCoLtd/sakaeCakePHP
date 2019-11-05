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
    <td bgcolor="#E1FDFB"><p><img src="../img/logo.gif" width="157" height="22" /></p>
	{$header}   
    </td>
  </tr>
<form action="kakunin_hasu.php" method="post">
  <tr valign="middle" bordercolor="#CCCCCC">
    <td bgcolor="#E1FDFB"><hr>
{$semi_header}
<hr />
<br />
<table width="500" border="0" align="center" bordercolor="#666666" bgcolor="#666666">
  <tr>
    <td align="center" bgcolor="#FFFFCC"><strong><font color="#0000FF">納入日指定</font></strong></td>
    <td rowspan="2" align="center" bgcolor="#FFFFCC"><input type="submit" name="target" id="button" value="呼出" /></td>
  </tr>
  <tr>
    <td height="17" align="center" bgcolor="#FFFFCC"><font size="-2"><strong>
        {html_options name=year options=$syear selected=$selected_syear}
        年
           {html_options name=month options=$smonth selected=$selected_smonth}
        月
          {html_options name=day options=$sday selected=$selected_sday}
          日
          </strong></font>
    </td>
    </tr>
</table>
</form>
<br>
<br />
</td>
<hr>
  </tr>
</table>
</body>
</html>
