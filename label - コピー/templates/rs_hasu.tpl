<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=SHIFT_JIS" />
<!-- TemplateBeginEditable name="doctitle" -->
<title>����h�L�������g</title>
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
  <tr valign="middle" bordercolor="#CCCCCC">
    <td bgcolor="#E1FDFB"><hr>
{$semi_header}
<hr />
<br />
<form action="kakunin_hasu.php" method="post">
<table width="500" border="0" align="center" bordercolor="#666666" bgcolor="#666666">
  <tr>
    <td align="center" bgcolor="#FFFFCC"><strong><font color="#0000FF">�[�����w��</font></strong></td>
    <td rowspan="2" align="center" bgcolor="#FFFFCC"><input type="submit" name="target" id="button" value="�ďo" /></td>
  </tr>
  <tr>
    <td height="17" align="center" bgcolor="#FFFFCC"><font size="-2"><strong>
        {html_options name=year options=$syear selected=$selected_syear}
        �N
           {html_options name=month options=$smonth selected=$selected_smonth}
        ��
          {html_options name=day options=$sday selected=$selected_sday}
          ��
          </strong><input type="hidden" name="date_deliver" value="{$date_deliver}" ></font>
    </td>
    </tr>
</table>
<p align="right"><input type="submit" name="all_check" id="button" value="�S�ă`�F�b�N" /></p>
<p align="right"><input type="submit" name="un_check" id="button" value="�S�Ẵ`�F�b�N���͂���" /></p>
<table width="800" border="0" align="center" bordercolor="#666666" bgcolor="#666666">
  <tr>
    <td width="25" align="center" bgcolor="#FFFFCC"><strong><font color="#0000FF"></font></strong></td>
    <td width="100" align="center" bgcolor="#FFFFCC"><strong><font color="#0000FF">�i��</font></strong></td>
    <td width="150" align="center" bgcolor="#FFFFCC"><strong><font color="#0000FF">�i��</font></strong></td>
    <td width="100" align="center" bgcolor="#FFFFCC"><strong><font color="#0000FF">�[��</font></strong></td>
  </tr>
{foreach from=$arr_hasu_box item=id }
  <tr>
    <td height="17" align="center" bgcolor="#FFFFCC"><strong>{$id.radio}</strong></td>
    <td height="17" align="center" bgcolor="#FFFFCC"><strong>{$id.product_id}</strong><input type="hidden" name="product_id[]" value="{$id.product_id}" ></td>
    <td height="17" align="center" bgcolor="#FFFFCC" nowrap><strong>{$id.product_name}</strong><input type="hidden" name="product_name[]" value="{$id.product_name}" ></td>
   <td height="17" align="center" bgcolor="#FFFFCC" nowrap><strong>{$id.hasu}</strong><input type="hidden" name="hasu[]" value="{$id.hasu}" size="15" /></td>
    </tr>
{/foreach}
</table>
<label>
  <input type="submit" name="rs_csv" id="button" value="CSV�o�^����" />
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
