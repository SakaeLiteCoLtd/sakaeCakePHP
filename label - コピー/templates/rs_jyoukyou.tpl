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
    <td align="center"><a href="index_jyoukyou.php"><img src="../img/label_jyoukyou.gif" alt="label_jyoukyou" width="83" height="37" border="0"/></a></td>
    <td align="center"><a href="index_lot_fushiyou.php"><img src="../img/label_kannou.gif" alt="label_kannou" width="83" height="37" border="0"/></a></td>
  </tr>
</table>
<br />
<br />
<form action="index_jyoukyou.php" method="post">
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
        </strong></font><input type="hidden" name="place_deliver_id" value="{$place_deliver_id}" />
        <label><font color="#FFFFCC"></font><input type="submit" name="kakunin" id="button" value="確認" /></label>
     </td>
  </tr>
</table>
<br>
<br>
  <table width="800" border="0" align="center" bgcolor="#666666">
    <tr>
      <td width="150" bgcolor="#FFFFCC" nowrap="nowrap"><div align="center" class="style1"><strong><font color="#0000FF">品番</font></strong></div></td>
      <td width="200" bgcolor="#FFFFCC" nowrap="nowrap"><div align="center" class="style1"><strong><font color="#0000FF">品名</font></strong></div></td>
      <td width="150" bgcolor="#FFFFCC" nowrap="nowrap"><div align="center" class="style1"><strong><font color="#0000FF">出荷予定数量</font></strong></div></td>
      <td width="150" bgcolor="#FFFFCC" nowrap="nowrap"><div align="center" class="style1"><strong><font color="#0000FF">チェック済数量</font></strong></div></td>
      <td width="50" bgcolor="#FFFFCC" nowrap="nowrap"><div align="center" class="style1"><strong><font color="#0000FF">ロット</font></strong></div></td>
    </tr>
{foreach from=$data item=id}
    <tr>
      <td bgcolor="#FFFFCC"><div align="center"><strong>{$id.product_id}</strong><input type="hidden" name="product_id[]" value="{$id.product_id}" /></div></td>
      <td bgcolor="#FFFFCC"><div align="center"><strong>{$id.product_name}</strong><input type="hidden" name="product_name[]" value="{$id.product_name}" /></div></td>
      <td bgcolor="#FFFFCC"><div align="center"><strong>{$id.sum_order_amount}</strong><input type="hidden" name="sum_order_amount[]" value="{$id.sum_order_amount}" /></div></td>
      <td bgcolor="#FFFFCC"><div align="center"><strong>{$id.sum_lot_amount}</strong><input type="hidden" name="sum_lot_amount[]" value="{$id.sum_lot_amount}" /></div></td>
      <td bgcolor="#FFFFCC"><div align="center">{$id.button_lot}</div></td>
    </tr>
{/foreach}
  </table>
<br>
</form>

<br />
</td>
    <hr />  
  </tr>
</table>
</body>
</html>
