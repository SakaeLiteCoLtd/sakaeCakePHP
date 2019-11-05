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
<form action="kakunin_kobetsu_hakkou.php" method="post">
  <tr valign="middle" bordercolor="#CCCCCC">
    <td bgcolor="#E1FDFB"><hr>
{$semi_header}
  <hr />
<table width=500 border="0" align="center" bordercolor="#333333" bgcolor="#666666">
  <tr>
    <td width="150" align="center" bgcolor="#FFFFCC"><strong><font color="#0000FF">品番</font></strong></td>
    <td width="250" align="center" nowrap="nowrap" bgcolor="#FFFFCC"><font color="#0000FF"><strong>成形日</strong></font></td>
    <td width="100" align="center" valign="middle" nowrap="nowrap" bgcolor="#FFFFCC"><font color="#0000FF"><strong>箱NO.</strong></font></td>
  </tr>
{foreach from=$data item=id }
  <tr>
    <td align="center" nowrap="nowrap" bgcolor="#FFFFCC"><input type="text" name="product_id"  size="20"/></td>
    <td align="center" valign="middle" nowrap="nowrap" bgcolor="#FFFFCC">
        <font size="-2"><strong>
        {html_options name=year options=$id.starting_year selected=$id.selected_starting_year}
        年
           {html_options name=month options=$id.starting_month selected=$id.selected_starting_month}
        月
          {html_options name=day options=$id.starting_day selected=$id.selected_starting_day}
          日
        </strong></font>
     </td>
    <td align="center" nowrap="nowrap" bgcolor="#FFFFCC"><input type="text" name="num_box"  size="20"/></td>
  </tr>
{/foreach}
</table>

<p align="right">
{$value}
<label><font color="#FFFFCC"></font><input type="submit" name="touroku" id="button" value="登録" /></label>
</form>
</p>
</td>
    <hr />  
  </tr>
</table>
</body>
</html>
