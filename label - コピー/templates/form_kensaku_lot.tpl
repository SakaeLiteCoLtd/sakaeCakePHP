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
<form action="rs_kensaku_lot.php" method="post">
  <tr valign="middle" bordercolor="#CCCCCC">
    <td bgcolor="#E1FDFB"><hr>
{$semi_header}
  <hr />
<table width=800 border="0" align="center" bordercolor="#333333" bgcolor="#666666">
  <tr>
    <td width="108" align="center" nowrap="nowrap" bgcolor="#FFFFCC"><font color="#0000FF"><strong>品番</strong></font></td>
    <td width="108" align="center" nowrap="nowrap" bgcolor="#FFFFCC"><font color="#0000FF"><strong>ロットNo.</strong></font></td>
    <td colspan="2" align="center" valign="middle" nowrap="nowrap" bgcolor="#FFFFCC"><font color="#0000FF"><strong>ロット発行日</strong></font></td>
  </tr>
{foreach from=$data item=id }
  <tr>
    <td rowspan="2" align="center" nowrap="nowrap" bgcolor="#FFFFCC"><font size="-2">
      <input type="text" name="product_id" value="{$id.product_id}"  size="20"/>
    </font></td>
    <td rowspan="2" align="center" nowrap="nowrap" bgcolor="#FFFFCC"><font size="-2">
      <input type="text" name="lot_num" value="{$id.lot_num}"  size="20"/>
    </font></td>
    <td width="50" align="center" valign="middle" nowrap="nowrap" bgcolor="#FFFFCC"><strong><font color="#0000FF">開始</font></strong></td>
    <td width="366" align="center" valign="middle" nowrap="nowrap" bgcolor="#FFFFCC">
        <font size="-2"><strong>
        {html_options name=syear options=$id.starting_year selected=$id.selected_starting_year}
        年
           {html_options name=smonth options=$id.starting_month selected=$id.selected_starting_month}
        月
          {html_options name=sday options=$id.starting_day selected=$id.selected_starting_day}
          日</strong>
        </font>
     </td>
  </tr>
  <tr>
    <td align="center" valign="middle" nowrap="nowrap" bgcolor="#FFFFCC"><strong><font color="#0000FF">終了</font></strong></td>
    <td align="center" valign="middle" nowrap="nowrap" bgcolor="#FFFFCC">
        <font size="-2"><strong>
        {html_options name=fyear options=$id.finishing_year selected=$id.selected_finishing_year}
        年
           {html_options name=fmonth options=$id.finishing_month selected=$id.selected_finishing_month}
        月
          {html_options name=fday options=$id.finishing_day selected=$id.selected_finishing_day}
          日</strong>
        </font>
    </td>
  </tr>
{/foreach}
</table>

<p align="right">
{$value}
<input type="hidden" name="year" value="{$year}" size="15"/>
<input type="hidden" name="month" value="{$month}" size="15"/>
<input type="hidden" name="day" value="{$day}" size="15"/>
                <label><font color="#FFFFCC"></font>
                <input type="submit" name="touroku" id="button" value="検索" />
        </label>
    </form>
</p>
</td>
    <hr />  
  </tr>
</table>
</body>
</html>
