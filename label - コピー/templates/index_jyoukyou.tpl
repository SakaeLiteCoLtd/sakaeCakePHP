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
<form action="index_jyoukyou.php" method="post">
  <tr valign="middle" bordercolor="#CCCCCC">
    <td bgcolor="#E1FDFB"><hr>
{$semi_header}
  <hr />
<table width="800" border="0">
  <tr>
    <td align="center"><a href="index_jyoukyou.php"><img src="../img/label_jyoukyou.gif" alt="label_jyoukyou" width="83" height="37" border="0"/></a></td>
    <td align="center"><a href="index_check_kannou.php"><img src="../img/label_kannou.gif" alt="label_kannou" width="83" height="37" border="0"/></a></td>
  </tr>
</table>
<br />
<br />
<table width="350" border="0" align="center" bordercolor="#333333" bgcolor="#666666">
  <tr>
    <td width="350" align="center" nowrap="nowrap" bgcolor="#FFFFCC"><font color="#0000FF"><strong>納入日</strong></font></td>
  </tr>
  <tr>
    <td align="center" valign="middle" nowrap="nowrap" bgcolor="#FFFFCC">
        <font size="-2"><strong>
        {html_options name=year options=$starting_year selected=$selected_starting_year}
        年
           {html_options name=month options=$starting_month selected=$selected_starting_month}
        月
          {html_options name=day options=$starting_day selected=$selected_starting_day}
          日
        </strong></font>
        <label><font color="#FFFFCC"></font><input type="submit" name="kakunin" id="button" value="確認" /></label>
     </td>
  </tr>
</table>
<br />
{foreach from=$buttons item=id }
{$id.button}
<br />
<br />
{/foreach}
{$value}
</form>
</p>
</td>
    <hr />  
  </tr>
</table>
</body>
</html>
