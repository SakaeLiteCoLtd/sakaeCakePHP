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
<form action="rs_check_kannou.php" method="post">
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
<br>
<br>
<table width="500" align="center" border="0" bordercolor="#666666" bgcolor="#666666">
  <tr>
    <td align="center" bgcolor="#FFFFCC"><strong><font color="#0000FF">完納未納日程絞込み</font></strong></td>
    <td rowspan="2" align="center" bgcolor="#FFFFCC"><input type="submit" name="target" id="button" value="日程絞込" /></td>
  </tr>
  <tr>
    <td height="17" align="center" bgcolor="#FFFFCC"><font size="-2"><strong>
        {html_options name=syear options=$syear selected=$selected_syear}
        年
           {html_options name=smonth options=$smonth selected=$selected_smonth}
        月
          {html_options name=sday options=$sday selected=$selected_sday}
          日～
        {html_options name=fyear options=$fyear selected=$selected_fyear}
        年
           {html_options name=fmonth options=$fmonth selected=$selected_fmonth}
        月
          {html_options name=fday options=$fday selected=$selected_fday}
          日
          </strong></font>
    </td>
    </tr>
</table>
<br />
{$rs_text}
{$pre_table}
{foreach from=$arr_table item=id}
    {$id.row}
{/foreach}
{$last_table}
<br />
{foreach from=$arr_mikan item=id}
    {$id.product_id}---{$id.mikan_amount}<br />
{/foreach}

</form>
<br>
<br />
</td>
<hr>
  </tr>
</table>
</body>
</html>
