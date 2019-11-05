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
<form action="csv_hakkou.php" method="post">
  <tr valign="middle" bordercolor="#CCCCCC">
    <td bgcolor="#E1FDFB"><hr>
{$semi_header}
  <hr />
  <strong>1号機</strong><br />
<table width=800 border="0" align="center" bordercolor="#333333" bgcolor="#666666">
  <tr>
    <td width="108" align="center" nowrap="nowrap" bgcolor="#FFFFCC"><font color="#0000FF"><strong>品番</strong></font></td>
    <td colspan="2" align="center" valign="middle" nowrap="nowrap" bgcolor="#FFFFCC"><font color="#0000FF"><strong>成形時間</strong></font></td>
    <td width="120" align="center" bgcolor="#FFFFCC"><p align="center"><font color="#0000FF" size="-3"><strong>予定枚数</strong></font></p></td>
    <td width="110" align="center" nowrap="nowrap" bgcolor="#FFFFCC"><strong><font color="#0000FF" size="-3">箱NO.</font></strong></td>
  </tr>
{foreach from=$ch1 item=ch1 }
  <tr>
    <td rowspan="2" align="center" nowrap="nowrap" bgcolor="#FFFFCC"><font size="2">
      <strong>{$ch1.product_id}</strong><input type="hidden" name="ch1_product_id[]" value="{$ch1.product_id}"  size="20"/>
    </font></td>
    <td width="50" align="center" valign="middle" nowrap="nowrap" bgcolor="#FFFFCC"><strong><font color="#0000FF">開始</font></strong></td>
    <td width="366" align="center" valign="middle" nowrap="nowrap" bgcolor="#FFFFCC">
        <font size="2"><strong>{$ch1.starting_tm}</strong></font></td>
    <td rowspan="2" align="center" nowrap="nowrap" bgcolor="#FFFFCC">
      <strong>{$ch1.number_sheet}</strong><input type="hidden" name="ch1_number_sheet[]" value="{$ch1.number_sheet}" size="15"/>    </td>
    <td rowspan="2" align="center" nowrap="nowrap" bgcolor="#FFFFCC">
       <strong>{$ch1.num_box}</strong><input type="hidden" name="ch1_num_box[]" value="{$ch1.num_box}" size="15"/>
    </td>
  </tr>
  <tr>
    <td align="center" valign="middle" nowrap="nowrap" bgcolor="#FFFFCC"><strong><font color="#0000FF">終了</font></strong></td>
    <td align="center" valign="middle" nowrap="nowrap" bgcolor="#FFFFCC">
        <font size="2"><strong>{$ch1.finishing_tm}</strong></font></td>
  </tr>
{/foreach}
</table>
<br />
<strong>2号機</strong>
<br />
<table width=800 border="0" align="center" bordercolor="#333333" bgcolor="#666666">
  <tr>
    <td width="108" align="center" nowrap="nowrap" bgcolor="#FFCCCC"><font color="#0000FF"><strong>品番</strong></font></td>
    <td colspan="2" align="center" valign="middle" nowrap="nowrap" bgcolor="#FFCCCC"><font color="#0000FF"><strong>成形時間</strong></font></td>
    <td width="120" align="center" bgcolor="#FFCCCC"><p align="center"><font color="#0000FF" size="-3"><strong>予定枚数</strong></font></p></td>
    <td width="110" align="center" nowrap="nowrap" bgcolor="#FFCCCC"><strong><font color="#0000FF" size="-3">箱NO.</font></strong></td>
  </tr>
{foreach from=$ch2 item=ch2 }
  <tr>
    <td rowspan="2" align="center" nowrap="nowrap" bgcolor="#FFCCCC"><font size="2">
      <strong>{$ch2.product_id}</strong><input type="hidden" name="ch2_product_id[]" value="{$ch2.product_id}"  size="20"/>
    </font></td>
    <td width="50" align="center" valign="middle" nowrap="nowrap" bgcolor="#FFCCCC"><strong><font color="#0000FF">開始</font></strong></td>
    <td width="366" align="center" valign="middle" nowrap="nowrap" bgcolor="#FFCCCC">
        <font size="2"><strong>{$ch2.starting_tm}</strong></font></td>
    <td rowspan="2" align="center" nowrap="nowrap" bgcolor="#FFCCCC">
      <strong>{$ch2.number_sheet}</strong><input type="hidden" name="ch2_number_sheet[]" value="{$ch2.number_sheet}" size="15"/>    </td>
    <td rowspan="2" align="center" nowrap="nowrap" bgcolor="#FFCCCC">
       <strong>{$ch2.num_box}</strong><input type="hidden" name="ch2_num_box[]" value="{$ch2.num_box}" size="15"/>
    </td>
  </tr>
  <tr>
    <td align="center" valign="middle" nowrap="nowrap" bgcolor="#FFCCCC"><strong><font color="#0000FF">終了</font></strong></td>
    <td align="center" valign="middle" nowrap="nowrap" bgcolor="#FFCCCC">
        <font size="2"><strong>{$ch2.finishing_tm}</strong></font></td>
  </tr>
{/foreach}
</table>
<br />
<strong>3号機</strong>
<br />
<table width=800 border="0" align="center" bordercolor="#333333" bgcolor="#666666">
  <tr>
    <td width="108" align="center" nowrap="nowrap" bgcolor="#FFFFCC"><font color="#0000FF"><strong>品番</strong></font></td>
    <td colspan="2" align="center" valign="middle" nowrap="nowrap" bgcolor="#FFFFCC"><font color="#0000FF"><strong>成形時間</strong></font></td>
    <td width="120" align="center" bgcolor="#FFFFCC"><p align="center"><font color="#0000FF" size="-3"><strong>予定枚数</strong></font></p></td>
    <td width="110" align="center" nowrap="nowrap" bgcolor="#FFFFCC"><strong><font color="#0000FF" size="-3">箱NO.</font></strong></td>
  </tr>
{foreach from=$ch3 item=ch3 }
  <tr>
    <td rowspan="2" align="center" nowrap="nowrap" bgcolor="#FFFFCC"><font size="2">
      <strong>{$ch3.product_id}</strong><input type="hidden" name="ch3_product_id[]" value="{$ch3.product_id}"  size="20"/>
    </font></td>
    <td width="50" align="center" valign="middle" nowrap="nowrap" bgcolor="#FFFFCC"><strong><font color="#0000FF">開始</font></strong></td>
    <td width="366" align="center" valign="middle" nowrap="nowrap" bgcolor="#FFFFCC">
        <font size="2"><strong>{$ch3.starting_tm}</strong></font></td>
    <td rowspan="2" align="center" nowrap="nowrap" bgcolor="#FFFFCC">
      <strong>{$ch3.number_sheet}</strong><input type="hidden" name="ch3_number_sheet[]" value="{$ch3.number_sheet}" size="15"/>    </td>
    <td rowspan="2" align="center" nowrap="nowrap" bgcolor="#FFFFCC">
       <strong>{$ch3.num_box}</strong><input type="hidden" name="ch3_num_box[]" value="{$ch3.num_box}" size="15"/>
    </td>
  </tr>
  <tr>
    <td align="center" valign="middle" nowrap="nowrap" bgcolor="#FFFFCC"><strong><font color="#0000FF">終了</font></strong></td>
    <td align="center" valign="middle" nowrap="nowrap" bgcolor="#FFFFCC">
        <font size="2"><strong>{$ch3.finishing_tm}</strong></font></td>
  </tr>
{/foreach}
</table>
<br />
<strong>4号機</strong><br />
<table width=800 border="0" align="center" bordercolor="#333333" bgcolor="#666666">
  <tr>
    <td width="108" align="center" nowrap="nowrap" bgcolor="#FFCCCC"><font color="#0000FF"><strong>品番</strong></font></td>
    <td colspan="2" align="center" valign="middle" nowrap="nowrap" bgcolor="#FFCCCC"><font color="#0000FF"><strong>成形時間</strong></font></td>
    <td width="120" align="center" bgcolor="#FFCCCC"><p align="center"><font color="#0000FF" size="-3"><strong>予定枚数</strong></font></p></td>
    <td width="110" align="center" nowrap="nowrap" bgcolor="#FFCCCC"><strong><font color="#0000FF" size="-3">箱NO.</font></strong></td>
  </tr>
{foreach from=$ch4 item=ch4 }
  <tr>
    <td rowspan="2" align="center" nowrap="nowrap" bgcolor="#FFCCCC"><font size="2">
      <strong>{$ch4.product_id}</strong><input type="hidden" name="ch4_product_id[]" value="{$ch4.product_id}"  size="20"/>
    </font></td>
    <td width="50" align="center" valign="middle" nowrap="nowrap" bgcolor="#FFCCCC"><strong><font color="#0000FF">開始</font></strong></td>
    <td width="366" align="center" valign="middle" nowrap="nowrap" bgcolor="#FFCCCC">
        <font size="2"><strong>{$ch4.starting_tm}</strong></font></td>
    <td rowspan="2" align="center" nowrap="nowrap" bgcolor="#FFCCCC">
      <strong>{$ch4.number_sheet}</strong><input type="hidden" name="ch4_number_sheet[]" value="{$ch4.number_sheet}" size="15"/>    </td>
    <td rowspan="2" align="center" nowrap="nowrap" bgcolor="#FFCCCC">
       <strong>{$ch4.num_box}</strong><input type="hidden" name="ch4_num_box[]" value="{$ch4.num_box}" size="15"/>
    </td>
  </tr>
  <tr>
    <td align="center" valign="middle" nowrap="nowrap" bgcolor="#FFCCCC"><strong><font color="#0000FF">終了</font></strong></td>
    <td align="center" valign="middle" nowrap="nowrap" bgcolor="#FFCCCC">
        <font size="2"><strong>{$ch4.finishing_tm}</strong></font></td>
  </tr>
{/foreach}
</table>
<br />
<strong>5号機</strong><br />
<table width=800 border="0" align="center" bordercolor="#333333" bgcolor="#666666">
  <tr>
    <td width="108" align="center" nowrap="nowrap" bgcolor="#FFFFCC"><font color="#0000FF"><strong>品番</strong></font></td>
    <td colspan="2" align="center" valign="middle" nowrap="nowrap" bgcolor="#FFFFCC"><font color="#0000FF"><strong>成形時間</strong></font></td>
    <td width="120" align="center" bgcolor="#FFFFCC"><p align="center"><font color="#0000FF" size="-3"><strong>予定枚数</strong></font></p></td>
    <td width="110" align="center" nowrap="nowrap" bgcolor="#FFFFCC"><strong><font color="#0000FF" size="-3">箱NO.</font></strong></td>
  </tr>
{foreach from=$ch5 item=ch5 }
  <tr>
    <td rowspan="2" align="center" nowrap="nowrap" bgcolor="#FFFFCC"><font size="2">
      <strong>{$ch5.product_id}</strong><input type="hidden" name="ch5_product_id[]" value="{$ch5.product_id}"  size="20"/>
    </font></td>
    <td width="50" align="center" valign="middle" nowrap="nowrap" bgcolor="#FFFFCC"><strong><font color="#0000FF">開始</font></strong></td>
    <td width="366" align="center" valign="middle" nowrap="nowrap" bgcolor="#FFFFCC">
        <font size="2"><strong>{$ch5.starting_tm}</strong></font></td>
    <td rowspan="2" align="center" nowrap="nowrap" bgcolor="#FFFFCC">
      <strong>{$ch5.number_sheet}</strong><input type="hidden" name="ch5_number_sheet[]" value="{$ch5.number_sheet}" size="15"/>    </td>
    <td rowspan="2" align="center" nowrap="nowrap" bgcolor="#FFFFCC">
      <strong>{$ch5.num_box}</strong><input type="hidden" name="ch5_num_box[]" value="{$ch5.num_box}" size="15"/>
    </td>
  </tr>
  <tr>
    <td align="center" valign="middle" nowrap="nowrap" bgcolor="#FFFFCC"><strong><font color="#0000FF">終了</font></strong></td>
    <td align="center" valign="middle" nowrap="nowrap" bgcolor="#FFFFCC">
        <font size="2"><strong>{$ch5.finishing_tm}</strong></font></td>
  </tr>
{/foreach}
</table>
<br />
<strong>6号機</strong>
<br />
<table width=800 border="0" align="center" bordercolor="#333333" bgcolor="#666666">
  <tr>
    <td width="108" align="center" nowrap="nowrap" bgcolor="#FFCCCC"><font color="#0000FF"><strong>品番</strong></font></td>
    <td colspan="2" align="center" valign="middle" nowrap="nowrap" bgcolor="#FFCCCC"><font color="#0000FF"><strong>成形時間</strong></font></td>
    <td width="120" align="center" bgcolor="#FFCCCC"><p align="center"><font color="#0000FF" size="-3"><strong>予定枚数</strong></font></p></td>
    <td width="110" align="center" nowrap="nowrap" bgcolor="#FFCCCC"><strong><font color="#0000FF" size="-3">箱NO.</font></strong></td>
  </tr>
{foreach from=$ch6 item=ch6 }
  <tr>
    <td rowspan="2" align="center" nowrap="nowrap" bgcolor="#FFCCCC"><font size="2">
      <strong>{$ch6.product_id}</strong><input type="hidden" name="ch6_product_id[]" value="{$ch6.product_id}"  size="20"/>
    </font></td>
    <td width="50" align="center" valign="middle" nowrap="nowrap" bgcolor="#FFCCCC"><strong><font color="#0000FF">開始</font></strong></td>
    <td width="366" align="center" valign="middle" nowrap="nowrap" bgcolor="#FFCCCC">
        <font size="2"><strong>{$ch6.starting_tm}</strong></font></td>
    <td rowspan="2" align="center" nowrap="nowrap" bgcolor="#FFCCCC">
      <strong>{$ch6.number_sheet}</strong><input type="hidden" name="ch6_number_sheet[]" value="{$ch6.number_sheet}" size="15"/>    </td>
    <td rowspan="2" align="center" nowrap="nowrap" bgcolor="#FFCCCC">
       <strong>{$ch6.num_box}</strong><input type="hidden" name="ch6_num_box[]" value="{$ch6.num_box}" size="15"/>
    </td>
  </tr>
  <tr>
    <td align="center" valign="middle" nowrap="nowrap" bgcolor="#FFCCCC"><strong><font color="#0000FF">終了</font></strong></td>
    <td align="center" valign="middle" nowrap="nowrap" bgcolor="#FFCCCC">
        <font size="2"><strong>{$ch6.finishing_tm}</strong></font></td>
  </tr>
{/foreach}
</table>
<br />
<strong>7号機</strong><br />
<table width=800 border="0" align="center" bordercolor="#333333" bgcolor="#666666">
  <tr>
    <td width="108" align="center" nowrap="nowrap" bgcolor="#FFFFCC"><font color="#0000FF"><strong>品番</strong></font></td>
    <td colspan="2" align="center" valign="middle" nowrap="nowrap" bgcolor="#FFFFCC"><font color="#0000FF"><strong>成形時間</strong></font></td>
    <td width="120" align="center" bgcolor="#FFFFCC"><p align="center"><font color="#0000FF" size="-3"><strong>予定枚数</strong></font></p></td>
    <td width="110" align="center" nowrap="nowrap" bgcolor="#FFFFCC"><strong><font color="#0000FF" size="-3">箱NO.</font></strong></td>
  </tr>
{foreach from=$ch7 item=ch7 }
  <tr>
    <td rowspan="2" align="center" nowrap="nowrap" bgcolor="#FFFFCC"><font size="2">
      <strong>{$ch7.product_id}</strong><input type="hidden" name="ch7_product_id[]" value="{$ch7.product_id}"  size="20"/>
    </font></td>
    <td width="50" align="center" valign="middle" nowrap="nowrap" bgcolor="#FFFFCC"><strong><font color="#0000FF">開始</font></strong></td>
    <td width="366" align="center" valign="middle" nowrap="nowrap" bgcolor="#FFFFCC">
        <font size="2"><strong>{$ch7.starting_tm}</strong></font></td>
    <td rowspan="2" align="center" nowrap="nowrap" bgcolor="#FFFFCC">
      <strong>{$ch7.number_sheet}</strong><input type="hidden" name="ch7_number_sheet[]" value="{$ch7.number_sheet}" size="15"/>    </td>
    <td rowspan="2" align="center" nowrap="nowrap" bgcolor="#FFFFCC">
       <strong>{$ch7.num_box}</strong><input type="hidden" name="ch7_num_box[]" value="{$ch7.num_box}" size="15"/>
    </td>
  </tr>
  <tr>
    <td align="center" valign="middle" nowrap="nowrap" bgcolor="#FFFFCC"><strong><font color="#0000FF">終了</font></strong></td>
    <td align="center" valign="middle" nowrap="nowrap" bgcolor="#FFFFCC">
        <font size="2"><strong>{$ch7.finishing_tm}</strong></font></td>
  </tr>
{/foreach}
</table>
<br />
<strong>8号機</strong><br />
<table width=800 border="0" align="center" bordercolor="#333333" bgcolor="#666666">
  <tr>
    <td width="108" align="center" nowrap="nowrap" bgcolor="#FFCCCC"><font color="#0000FF"><strong>品番</strong></font></td>
    <td colspan="2" align="center" valign="middle" nowrap="nowrap" bgcolor="#FFCCCC"><font color="#0000FF"><strong>成形時間</strong></font></td>
    <td width="120" align="center" nowrap="nowrap" bgcolor="#FFCCCC"><p align="center"><font color="#0000FF" size="-3"><strong>予定枚数</strong></font></p></td>
    <td width="110" align="center" nowrap="nowrap" bgcolor="#FFCCCC"><strong><font color="#0000FF" size="-3">箱NO.</font></strong></td>
  </tr>
{foreach from=$ch8 item=ch8 }
  <tr>
    <td rowspan="2" align="center" nowrap="nowrap" bgcolor="#FFCCCC"><font size="2">
      <strong>{$ch8.product_id}</strong><input type="hidden" name="ch8_product_id[]" value="{$ch8.product_id}"  size="20"/>
    </font></td>
    <td width="50" align="center" valign="middle" nowrap="nowrap" bgcolor="#FFCCCC"><strong><font color="#0000FF">開始</font></strong></td>
    <td width="366" align="center" valign="middle" nowrap="nowrap" bgcolor="#FFCCCC">
        <font size="2"><strong>{$ch8.starting_tm}</strong></font></td>
    <td rowspan="2" align="center" nowrap="nowrap" bgcolor="#FFCCCC"><strong>{$ch8.number_sheet}</strong><input type="hidden" name="ch8_number_sheet[]" value="{$ch8.number_sheet}" size="15"/></td>
    <td rowspan="2" align="center" nowrap="nowrap" bgcolor="#FFCCCC">
        <strong>{$ch8.num_box}</strong><input type="hidden" name="ch8_num_box[]" value="{$ch8.num_box}" size="15"/>
    </td>
  <tr>
    <td align="center" valign="middle" nowrap="nowrap" bgcolor="#FFCCCC"><strong><font color="#0000FF">終了</font></strong></td>
    <td align="center" valign="middle" nowrap="nowrap" bgcolor="#FFCCCC">
        <font size="2"><strong>{$ch8.finishing_tm}</strong></font></td>
  </tr>
{/foreach}
</table>
<br />
<strong>9号機</strong><br />
<table width=800 border="0" align="center" bordercolor="#333333" bgcolor="#666666">
  <tr>
    <td width="108" align="center" nowrap="nowrap" bgcolor="#FFFFCC"><font color="#0000FF"><strong>品番</strong></font></td>
    <td colspan="2" align="center" valign="middle" nowrap="nowrap" bgcolor="#FFFFCC"><font color="#0000FF"><strong>成形時間</strong></font></td>
    <td width="120" align="center" nowrap="nowrap" bgcolor="#FFFFCC"><p align="center"><font color="#0000FF" size="-3"><strong>予定枚数</strong></font></p></td>
    <td width="110" align="center" nowrap="nowrap" bgcolor="#FFFFCC"><strong><font color="#0000FF" size="-3">箱NO.</font></strong></td>
  </tr>
{foreach from=$ch9 item=ch9 }
  <tr>
    <td rowspan="2" align="center" nowrap="nowrap" bgcolor="#FFFFCC"><font size="2">
      <strong>{$ch9.product_id}</strong><input type="hidden" name="ch9_product_id[]" value="{$ch9.product_id}"  size="20"/>
    </font></td>
    <td width="50" align="center" valign="middle" nowrap="nowrap" bgcolor="#FFFFCC"><strong><font color="#0000FF">開始</font></strong></td>
    <td width="366" align="center" valign="middle" nowrap="nowrap" bgcolor="#FFFFCC">
        <font size="2"><strong>{$ch9.starting_tm}</strong></font></td>
    <td rowspan="2" align="center" nowrap="nowrap" bgcolor="#FFFFCC">
      <strong>{$ch9.number_sheet}</strong><input type="hidden" name="ch9_number_sheet[]" value="{$ch9.number_sheet}" size="15"/>    </td>
    <td rowspan="2" align="center" nowrap="nowrap" bgcolor="#FFFFCC">
      <strong>{$ch9.num_box}</strong><input type="hidden" name="ch9_num_box[]" value="{$ch9.num_box}" size="15"/>
    </td>
  </tr>
  <tr>
    <td align="center" valign="middle" nowrap="nowrap" bgcolor="#FFFFCC"><strong><font color="#0000FF">終了</font></strong></td>
    <td align="center" valign="middle" nowrap="nowrap" bgcolor="#FFFFCC">
        <font size="2"><strong>{$ch9.finishing_tm}</strong></font></td>
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
                <input type="submit" name="touroku" id="button" value="csv登録" />
        </label>
    </form>
</p>
</td>
    <hr />  
  </tr>
</table>
</body>
</html>
