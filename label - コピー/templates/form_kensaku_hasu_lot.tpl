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
    <td align="center"><a href="index_import_lot.php"><img src="../img/lot_rireki_torikomi.gif" alt="lot_rireki_torikomi" width="83" height="37" border="0"/></a></td>
    <td align="center"><a href="index_lot_fushiyou.php"><img src="../img/label_fushiyou.gif" alt="lot_rireki_torikomi" width="83" height="37" border="0"/></a></td>
    <td align="center"><a href="index_touroku_hasu.php"><img src="../img/label_hasu.gif" alt="csv" width="83" height="37" border="0"/></a></td>
  </tr>
</table>
<br />
<br />
<table width="800" border="0">
  <tr>
    <td align="center"><a href="index_touroku_hasu.php"><img src="../img/label_touroku.gif" alt="csv" width="83" height="37" border="0"/></a></td>
    <td align="center"><a href="index_kensaku_hasu_lot.php"><img src="../img/label_kensaku.gif" alt="csv" width="83" height="37" border="0"/></a></td>
  </tr>
</table>
<br />
<br />
<form action="rs_kensaku_hasu_lot.php" method="post">
  <table width="500" border="0" align="left" bgcolor="#666666">
    <tr>
      <td width="100" bgcolor="#FFFFCC" ><div align="center" class="style1"><strong><font color="#0000FF">品番</font></strong></div></td>
      <td width="100" bgcolor="#FFFFCC"><div align="center" class="style1"><strong><font color="#0000FF">ロットNo.</font></strong></div></td>
      {$td1}
    </tr>
    <tr>
      <td bgcolor="#FFFFCC"><div align="center"><strong>{$product_id}</strong><input type="{$type}" name="product_id" value="{$product_id}" size="30"/><input type="hidden" name="hasu_check_lots_id" value="{$hasu_check_lots_id}" /></div></td>
      <td bgcolor="#FFFFCC"><div align="center"><strong>{$taisyou_lot_num}</strong><input type="{$type}" name="taisyou_lot_num" value="{$taisyou_lot_num}" size="30"/></div></td>
      {$td2}
    </tr>
  </table>
<br />
<br />
<br />
<br />
<table width="350" border="0" align="left" bordercolor="#666666" bgcolor="#666666">
  <tr>
    <td width="25" align="center" nowrap="nowrap" bgcolor="#FFFFCC"><strong><font color="#0000FF"></font></strong></td>
    <td width="75" align="center" nowrap="nowrap" bgcolor="#FFFFCC"><strong><font color="#0000FF">ロットNo.</font></strong></td>
    <td width="100" align="center" nowrap="nowrap" bgcolor="#FFFFCC"><strong><font color="#0000FF">数量</font></strong></td>
  </tr>
{foreach from=$arr_lot item=id }
  <tr>
    <td height="17" align="center" bgcolor="#FFFFCC" nowrap="nowrap">
       <strong>{$id.num}</strong>
    </td>
    <td height="17" align="center" bgcolor="#FFFFCC" nowrap="nowrap">
       <strong>{$id.lot_num}</strong>
    </td>
    <td height="17" align="center" bgcolor="#FFFFCC" nowrap="nowrap">
       <strong>{$id.amount}</strong>
    </td>
  </tr>
{/foreach}
</table>
<br />
<br />
<br />
<br />
<br />
<br />
<br />
{$mess}
{$label_kensaku}
</form>

<br />
</td>
    <hr />  
  </tr>
</table>
</body>
</html>
