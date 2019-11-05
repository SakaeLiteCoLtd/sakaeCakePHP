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
<table width=800 border="0" align="center" bordercolor="#333333" bgcolor="#666666">
  <tr>
    <td width="108" align="center" nowrap="nowrap" bgcolor="#FFFFCC"><font color="#0000FF"><strong>品番</strong></font></td>
    <td colspan="2" align="center" valign="middle" nowrap="nowrap" bgcolor="#FFFFCC"><font color="#0000FF"><strong>成形時間</strong></font></td>
    <td width="120" align="center" bgcolor="#FFFFCC"><p align="center"><font color="#0000FF" size="-3"><strong>予定枚数</strong></font></p></td>
    <td width="110" align="center" nowrap="nowrap" bgcolor="#FFFFCC"><strong><font color="#0000FF" size="-3">箱NO.</font></strong></td>
  </tr>
{foreach from=$data item=id }
  <tr>
    <td rowspan="2" align="center" nowrap="nowrap" bgcolor="#FFFFCC"><font size="2">
      <strong>{$id.product_id}</strong><input type="hidden" name="product_id[]" value="{$id.product_id}"  size="20"/>
    </font></td>
    <td width="50" align="center" valign="middle" nowrap="nowrap" bgcolor="#FFFFCC"><strong><font color="#0000FF">開始</font></strong></td>
    <td width="366" align="center" valign="middle" nowrap="nowrap" bgcolor="#FFFFCC">
        <font size="2"><strong>{$id.starting_tm}</strong><input type="hidden" name="starting_tm[]" value="{$id.starting_tm}"  size="20"/></font></td>
    <td rowspan="2" align="center" nowrap="nowrap" bgcolor="#FFFFCC">
      <strong>{$id.number_sheet}</strong><input type="hidden" name="number_sheet[]" value="{$id.number_sheet}" size="15"/>    </td>
    <td rowspan="2" align="center" nowrap="nowrap" bgcolor="#FFFFCC">
       <strong>{$id.num_box}</strong><input type="text" name="num_box[]" value="" size="15"/><input type="hidden" name="date_seikei[]" value="{$id.date_seikei}"/>
    </td>
  </tr>
  <tr>
    <td align="center" valign="middle" nowrap="nowrap" bgcolor="#FFFFCC"><strong><font color="#0000FF">終了</font></strong></td>
    <td align="center" valign="middle" nowrap="nowrap" bgcolor="#FFFFCC">
        <font size="2"><strong>{$id.finishing_tm}</strong></font></td>
  </tr>
{/foreach}
</table>
<br />
<p align="right">
{$value}
<input type="hidden" name="year" value="{$year}" size="15"/>
<input type="hidden" name="month" value="{$month}" size="15"/>
<input type="hidden" name="day" value="{$day}" size="15"/>
                <label><font color="#FFFFCC"></font>
                <input type="submit" name="csv_seikei_t" id="button" value="csv登録" />
        </label>
    </form>
</p>
</td>
    <hr />  
  </tr>
</table>
</body>
</html>
