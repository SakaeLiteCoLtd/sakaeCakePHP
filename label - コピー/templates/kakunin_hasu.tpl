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
<form action="rs_hasu.php" method="post">
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
<br>
<table width="800" border="0" align="center" bordercolor="#666666" bgcolor="#666666">
  <tr>
    <td width="100" align="center" bgcolor="#FFFFCC"><strong><font color="#0000FF">品番</font></strong></td>
    <td width="150" align="center" bgcolor="#FFFFCC"><strong><font color="#0000FF">品名</font></strong></td>
    <td width="150" align="center" bgcolor="#FFFFCC"><strong><font color="#0000FF">顧客</font></strong></td>
    <td width="100" align="center" bgcolor="#FFFFCC"><strong><font color="#0000FF">納品ライン</font></strong></td>
    <td width="100" align="center" bgcolor="#FFFFCC"><strong><font color="#0000FF">納品数</font></strong></td>
    <td width="100" align="center" bgcolor="#FFFFCC"><strong><font color="#0000FF">箱数</font></strong></td>
    <td width="100" align="center" bgcolor="#FFFFCC"><strong><font color="#0000FF">端数</font></strong></td>
  </tr>
{foreach from=$arr_hasu_box item=id }
  <tr>
    <td height="17" align="center" bgcolor="#FFFFCC"><strong>{$id.product_id}</strong><input type="hidden" name="product_id[]" value="{$id.product_id}" ></td>
    <td height="17" align="center" bgcolor="#FFFFCC" nowrap><strong>{$id.product_name}</strong><input type="hidden" name="product_name[]" value="{$id.product_name}" ></td>
    <td height="17" align="center" bgcolor="#FFFFCC" nowrap><strong>{$id.cs}</strong><input type="hidden" name="cs[]" value="{$id.cs}" ></td>
    <td height="17" align="center" bgcolor="#FFFFCC" nowrap><strong>{$id.place_line}</strong><input type="hidden" name="place_line[]" value="{$id.place_line}" ></td>
    <td height="17" align="center" bgcolor="#FFFFCC" nowrap><strong>{$id.amount}</strong><input type="hidden" name="amount[]" value="{$id.amount}" size="15" /></td>
    <td height="17" align="center" bgcolor="#FFFFCC" nowrap><strong>{$id.hakosu}</strong><input type="hidden" name="hakosu[]" value="{$id.hakosu}" size="15" /></td>
    <td height="17" align="center" bgcolor="#FFFFCC" nowrap><strong>{$id.hasu}</strong><input type="hidden" name="hasu[]" value="{$id.hasu}" size="15" /></td>
    </tr>
{/foreach}
</table>
<br>
<label>
  <input type="submit" name="csv" id="button" value="csv発行" />
</label>
</form>
<br>
{$value}
<br />
</td>
<hr>
  </tr>
</table>
</body>
</html>
