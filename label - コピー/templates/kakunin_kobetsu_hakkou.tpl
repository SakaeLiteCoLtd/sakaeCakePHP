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
<form action="csv_kobetsu.php" method="post">
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
    <td align="center" nowrap="nowrap" bgcolor="#FFFFCC"><strong>{$id.product_id}</strong><input type="hidden" name="product_id" value="{$id.product_id}" /></td>
    <td align="center" valign="middle" nowrap="nowrap" bgcolor="#FFFFCC"><strong>{$id.date}</strong><input type="hidden" name="date" value="{$id.date}" /></td>
    <td align="center" nowrap="nowrap" bgcolor="#FFFFCC"><strong>{$id.num_box}</strong><input type="hidden" name="num_box" value="{$id.num_box}" /></td>
  </tr>
{/foreach}
</table>

<p align="right">
{$value}

<label><font color="#FFFFCC"></font>
<input type="submit" name="csv_kobetsu" id="button" value="csv登録" />
</label>
</form>
</p>
</td>
    <hr />  
  </tr>
</table>
</body>
</html>
