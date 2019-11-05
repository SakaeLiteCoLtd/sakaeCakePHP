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
<form action="index_jyoukyou.php" method="post">
<table width="800" border="0">
  <tr>
    <td align="center"><a href="index_jyoukyou.php"><img src="../img/label_jyoukyou.gif" alt="label_jyoukyou" width="83" height="37" border="0"/></a></td>
    <td align="center"><a href="index_lot_fushiyou.php"><img src="../img/label_kannou.gif" alt="label_kannou" width="83" height="37" border="0"/></a></td>
  </tr>
</table>
<br />
<br />
<table width="350" border="0" align="left" bordercolor="#333333" bgcolor="#666666">
  <tr>
    <td width="350" align="center" nowrap="nowrap" bgcolor="#FFFFCC"><font color="#0000FF"><strong>納入日</strong></font></td>
    <td width="350" align="center" nowrap="nowrap" bgcolor="#FFFFCC"><font color="#0000FF"><strong>納入場所</strong></font></td>
  </tr>
  <tr>
    <td align="center" valign="middle" nowrap="nowrap" bgcolor="#FFFFCC">
        <strong>{$date_deliver}</strong><input type="hidden" name="date_deliver" value="{$date_deliver}" />
    </td>
    <td align="center" valign="middle" nowrap="nowrap" bgcolor="#FFFFCC">
        <strong>{$name_deliver}</strong><input type="hidden" name="name_deliver" value="{$name_deliver}" />
    </td>
  </tr>
</table>
<br>
<br>
<br>
<br>
<table width="650" border="0" align="left" bordercolor="#333333" bgcolor="#666666">
  <tr>
    <td width="150" align="center" nowrap="nowrap" bgcolor="#FFFFCC"><font color="#0000FF"><strong>品番</strong></font></td>
    <td width="200" align="center" nowrap="nowrap" bgcolor="#FFFFCC"><font color="#0000FF"><strong>品名</strong></font></td>
    <td width="125" align="center" nowrap="nowrap" bgcolor="#FFFFCC"><font color="#0000FF"><strong>数量</strong></font></td>
    <td width="125" align="center" nowrap="nowrap" bgcolor="#FFFFCC"><font color="#0000FF"><strong>ロット数</strong></font></td>
  </tr>
  <tr>
    <td align="center" valign="middle" nowrap="nowrap" bgcolor="#FFFFCC">
        <strong>{$product_id}</strong><input type="hidden" name="product_id" value="{$product_id}" />
    </td>
    <td align="center" valign="middle" nowrap="nowrap" bgcolor="#FFFFCC">
        <strong>{$product_name}</strong><input type="hidden" name="product_name" value="{$product_name}" />
    </td>
    <td align="center" valign="middle" nowrap="nowrap" bgcolor="#FFFFCC">
        <strong>{$sum_order_amount}</strong><input type="hidden" name="sum_order_amount" value="{$sum_order_amount}" />
    </td>
    <td align="center" valign="middle" nowrap="nowrap" bgcolor="#FFFFCC">
        <strong>{$rows}</strong>
    </td>
  </tr>
</table>
<br>
<br>
<br>
<br>
<table width="100" border="0" align="left" bordercolor="#333333" bgcolor="#666666">
  <tr>
    <td width="100" align="center" nowrap="nowrap" bgcolor="#FFFFCC"><font color="#0000FF"><strong>納入ロット</strong></font></td>
  </tr>
</table>
<br>
<br />
<table border="0">
<tr>
 <td>
  <table width="350" border="0" align="left" bgcolor="#666666">
    <tr>
      <td width="150" bgcolor="#FFFFCC" nowrap="nowrap"><div align="center" class="style1"><strong><font color="#0000FF">ロットNo.</font></strong></div></td>
      <td width="200" bgcolor="#FFFFCC" nowrap="nowrap"><div align="center" class="style1"><strong><font color="#0000FF">数量</font></strong></div></td>
    </tr>
{foreach from=$data item=id}
    <tr>
      <td bgcolor="#FFFFCC"><div align="center"><strong>{$id.lot_num}</strong><input type="hidden" name="lot_num[]" value="{$id.lot_num}" /></div></td>
      <td bgcolor="#FFFFCC"><div align="center"><strong>{$id.amount}</strong><input type="hidden" name="lot_amount[]" value="{$id.amount}" /></div></td>
    </tr>
{/foreach}
  </table>
 </td>
</tr>
</table>
<br>
{$value}
<br>
{$hasu_text}
{$pre_table}
{foreach from=$arr_hasu_lots item=id}
    <tr>
      <td bgcolor="#FFFFCC"><div align="center"><strong>{$id.hasu_lot_num}</strong><input type="hidden" name="hasu_lot_num[]" value="{$id.hasu_lot_num}" /></div></td>
      <td bgcolor="#FFFFCC"><div align="center"><strong>{$id.moto_lot_num}</strong><input type="hidden" name="moto_lot_num[]" value="{$id.moto_lot_num}" /></div></td>
      <td bgcolor="#FFFFCC"><div align="center"><strong>{$id.moto_lot_amount}</strong><input type="hidden" name="moto_lot_amount[]" value="{$id.moto_lot_amount}" /></div></td>
    </tr>
{/foreach}
{$last_table}
</form>

<br />
</td>
    <hr />  
  </tr>
</table>
</body>
</html>
