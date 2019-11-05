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
<form action="kakunin_hakkou.php" method="post">
  <tr valign="middle" bordercolor="#CCCCCC">
    <td bgcolor="#E1FDFB"><hr>
{$semi_header}
  <hr />
<input type="submit" name="seikeiki_1" id="button" value="1号機" />
<input type="submit" name="seikeiki_2" id="button" value="2号機" />
<input type="submit" name="seikeiki_3" id="button" value="3号機" />
<input type="submit" name="seikeiki_4" id="button" value="4号機" />
<input type="submit" name="seikeiki_5" id="button" value="5号機" />
<br />
<input type="submit" name="seikeiki_6" id="button" value="6号機" />
<input type="submit" name="seikeiki_7" id="button" value="7号機" />
<input type="submit" name="seikeiki_8" id="button" value="8号機" />
<input type="submit" name="seikeiki_9" id="button" value="9号機" />
<br />
<br />
  <strong>1号機</strong><br />
<table width=800 border="0" align="center" bordercolor="#333333" bgcolor="#666666">
  <tr>
    <td width="25" align="center" bgcolor="#FFFFCC"><strong><font color="#0000FF"></font></strong></td>
    <td width="108" align="center" nowrap="nowrap" bgcolor="#FFFFCC"><font color="#0000FF"><strong>品番</strong></font></td>
    <td colspan="2" align="center" valign="middle" nowrap="nowrap" bgcolor="#FFFFCC"><font color="#0000FF"><strong>成形時間</strong></font></td>
    <td width="120" align="center" bgcolor="#FFFFCC"><p align="center"><font color="#0000FF" size="-3"><strong>予定枚数</strong></font></p></td>
    <td width="110" align="center" nowrap="nowrap" bgcolor="#FFFFCC"><strong><font color="#0000FF" size="-3">箱NO.</font></strong></td>
  </tr>
{foreach from=$ch1 item=ch1 }
  <tr>
    <td rowspan="2" align="center" nowrap="nowrap" bgcolor="#FFFFCC">
      {$ch1.radio}
    </td>
    <td rowspan="2" align="center" nowrap="nowrap" bgcolor="#FFFFCC"><font size="-2">
      <input type="text" name="ch1_product_id[]" value="{$ch1.product_id}"  size="20"/>
    </font></td>
    <td width="50" align="center" valign="middle" nowrap="nowrap" bgcolor="#FFFFCC"><strong><font color="#0000FF">開始</font></strong></td>
    <td width="366" align="center" valign="middle" nowrap="nowrap" bgcolor="#FFFFCC">
        <font size="-2"><strong>
        {html_options name=ch1_syear[] options=$ch1.starting_year selected=$ch1.selected_starting_year}
        年
           {html_options name=ch1_smonth[] options=$ch1.starting_month selected=$ch1.selected_starting_month}
        月
          {html_options name=ch1_sday[] options=$ch1.starting_day selected=$ch1.selected_starting_day}
          日
          {html_options name=ch1_shour[] options=$ch1.starting_hour selected=$ch1.selected_starting_hour}
          時          
          {html_options name=ch1_sminute[] options=$ch1.starting_minute selected=$ch1.selected_starting_minute}
          分          </strong></font></td>
    <td rowspan="2" align="center" nowrap="nowrap" bgcolor="#FFFFCC">
      <input type="text" name="ch1_number_sheet[]" value="{$ch1.number_sheet}" size="15"/>    </td>
    <td rowspan="2" align="center" nowrap="nowrap" bgcolor="#FFFFCC">
       <input type="text" name="ch1_num_box[]" value="{$ch1.num_box}" size="15"/>
    </td>
  </tr>
  <tr>
    <td align="center" valign="middle" nowrap="nowrap" bgcolor="#FFFFCC"><strong><font color="#0000FF">終了</font></strong></td>
    <td align="center" valign="middle" nowrap="nowrap" bgcolor="#FFFFCC">
        <font size="-2"><strong>
        {html_options name=ch1_fyear[] options=$ch1.finishing_year selected=$ch1.selected_finishing_year}
        年
           {html_options name=ch1_fmonth[] options=$ch1.finishing_month selected=$ch1.selected_finishing_month}
        月
          {html_options name=ch1_fday[] options=$ch1.finishing_day selected=$ch1.selected_finishing_day}
          日
          {html_options name=ch1_fhour[] options=$ch1.finishing_hour selected=$ch1.selected_finishing_hour}
          時          
          {html_options name=ch1_fminute[] options=$ch1.finishing_minute selected=$ch1.selected_finishing_minute}
          分         </strong></font></td>
  </tr>
{/foreach}
</table>
<Div align="right"><input type="submit" name="ch1_addition" id="button" value="追加" /><input type="submit" name="ch1_deletion" id="button" value="削除" /></Div>
<br />
<strong>2号機</strong>
<br />
<table width=800 border="0" align="center" bordercolor="#333333" bgcolor="#666666">
  <tr>
    <td width="25" align="center" nowrap="nowrap" bgcolor="#FFCCCC"><font color="#0000FF"></font></td>
    <td width="108" align="center" nowrap="nowrap" bgcolor="#FFCCCC"><font color="#0000FF"><strong>品番</strong></font></td>
    <td colspan="2" align="center" valign="middle" nowrap="nowrap" bgcolor="#FFCCCC"><font color="#0000FF"><strong>成形時間</strong></font></td>
    <td width="120" align="center" bgcolor="#FFCCCC"><p align="center"><font color="#0000FF" size="-3"><strong>予定枚数</strong></font></p></td>
    <td width="110" align="center" nowrap="nowrap" bgcolor="#FFCCCC"><strong><font color="#0000FF" size="-3">箱NO.</font></strong></td>
  </tr>
{foreach from=$ch2 item=ch2 }
  <tr>
    <td rowspan="2" align="center" nowrap="nowrap" bgcolor="#FFCCCC">
      {$ch2.radio}
    </td>
    <td rowspan="2" align="center" nowrap="nowrap" bgcolor="#FFCCCC"><font size="-2">
      <input type="text" name="ch2_product_id[]" value="{$ch2.product_id}"  size="20"/>
    </font></td>
    <td width="50" align="center" valign="middle" nowrap="nowrap" bgcolor="#FFCCCC"><strong><font color="#0000FF">開始</font></strong></td>
    <td width="366" align="center" valign="middle" nowrap="nowrap" bgcolor="#FFCCCC">
        <font size="-2"><strong>
        {html_options name=ch2_syear[] options=$ch2.starting_year selected=$ch2.selected_starting_year}
        年
           {html_options name=ch2_smonth[] options=$ch2.starting_month selected=$ch2.selected_starting_month}
        月
          {html_options name=ch2_sday[] options=$ch2.starting_day selected=$ch2.selected_starting_day}
          日
          {html_options name=ch2_shour[] options=$ch2.starting_hour selected=$ch2.selected_starting_hour}
          時          
          {html_options name=ch2_sminute[] options=$ch2.starting_minute selected=$ch2.selected_starting_minute}
          分          </strong></font></td>
    <td rowspan="2" align="center" nowrap="nowrap" bgcolor="#FFCCCC">
      <input type="text" name="ch2_number_sheet[]" value="{$ch2.number_sheet}" size="15"/>    </td>
    <td rowspan="2" align="center" nowrap="nowrap" bgcolor="#FFCCCC">
       <input type="text" name="ch2_num_box[]" value="{$ch2.num_box}" size="15"/>
    </td>
  </tr>
  <tr>
    <td align="center" valign="middle" nowrap="nowrap" bgcolor="#FFCCCC"><strong><font color="#0000FF">終了</font></strong></td>
    <td align="center" valign="middle" nowrap="nowrap" bgcolor="#FFCCCC">
        <font size="-2"><strong>
        {html_options name=ch2_fyear[] options=$ch2.finishing_year selected=$ch2.selected_finishing_year}
        年
           {html_options name=ch2_fmonth[] options=$ch2.finishing_month selected=$ch2.selected_finishing_month}
        月
          {html_options name=ch2_fday[] options=$ch2.finishing_day selected=$ch2.selected_finishing_day}
          日
          {html_options name=ch2_fhour[] options=$ch2.finishing_hour selected=$ch2.selected_finishing_hour}
          時          
          {html_options name=ch2_fminute[] options=$ch2.finishing_minute selected=$ch2.selected_finishing_minute}
          分          </strong></font></td>
  </tr>
{/foreach}
</table>
<Div align="right"><input type="submit" name="ch2_addition" id="button" value="追加" /><input type="submit" name="ch2_deletion" id="button" value="削除" /></Div>
<br />
<strong>3号機</strong>
<br />
<table width=800 border="0" align="center" bordercolor="#333333" bgcolor="#666666">
  <tr>
    <td width="25" align="center" bgcolor="#FFFFCC"><strong><font color="#0000FF"></font></strong></td>
    <td width="108" align="center" nowrap="nowrap" bgcolor="#FFFFCC"><font color="#0000FF"><strong>品番</strong></font></td>
    <td colspan="2" align="center" valign="middle" nowrap="nowrap" bgcolor="#FFFFCC"><font color="#0000FF"><strong>成形時間</strong></font></td>
    <td width="120" align="center" bgcolor="#FFFFCC"><p align="center"><font color="#0000FF" size="-3"><strong>予定枚数</strong></font></p></td>
    <td width="110" align="center" nowrap="nowrap" bgcolor="#FFFFCC"><strong><font color="#0000FF" size="-3">箱NO.</font></strong></td>
  </tr>
{foreach from=$ch3 item=ch3 }
  <tr>
    <td rowspan="2" align="center" nowrap="nowrap" bgcolor="#FFFFCC">
      {$ch3.radio}
    </td>
    <td rowspan="2" align="center" nowrap="nowrap" bgcolor="#FFFFCC"><font size="-2">
      <input type="text" name="ch3_product_id[]" value="{$ch3.product_id}"  size="20"/>
    </font></td>
    <td width="50" align="center" valign="middle" nowrap="nowrap" bgcolor="#FFFFCC"><strong><font color="#0000FF">開始</font></strong></td>
    <td width="366" align="center" valign="middle" nowrap="nowrap" bgcolor="#FFFFCC">
        <font size="-2"><strong>
        {html_options name=ch3_syear[] options=$ch3.starting_year selected=$ch3.selected_starting_year}
        年
           {html_options name=ch3_smonth[] options=$ch3.starting_month selected=$ch3.selected_starting_month}
        月
          {html_options name=ch3_sday[] options=$ch3.starting_day selected=$ch3.selected_starting_day}
          日
          {html_options name=ch3_shour[] options=$ch3.starting_hour selected=$ch3.selected_starting_hour}
          時          
          {html_options name=ch3_sminute[] options=$ch3.starting_minute selected=$ch3.selected_starting_minute}
          分          </strong></font></td>
    <td rowspan="2" align="center" nowrap="nowrap" bgcolor="#FFFFCC">
      <input type="text" name="ch3_number_sheet[]" value="{$ch3.number_sheet}" size="15"/>    </td>
    <td rowspan="2" align="center" nowrap="nowrap" bgcolor="#FFFFCC">
       <input type="text" name="ch3_num_box[]" value="{$ch3.num_box}" size="15"/>
    </td>
  </tr>
  <tr>
    <td align="center" valign="middle" nowrap="nowrap" bgcolor="#FFFFCC"><strong><font color="#0000FF">終了</font></strong></td>
    <td align="center" valign="middle" nowrap="nowrap" bgcolor="#FFFFCC">
        <font size="-2"><strong>
        {html_options name=ch3_fyear[] options=$ch3.finishing_year selected=$ch3.selected_finishing_year}
        年
           {html_options name=ch3_fmonth[] options=$ch3.finishing_month selected=$ch3.selected_finishing_month}
        月
          {html_options name=ch3_fday[] options=$ch3.finishing_day selected=$ch3.selected_finishing_day}
          日
          {html_options name=ch3_fhour[] options=$ch3.finishing_hour selected=$ch3.selected_finishing_hour}
          時          
          {html_options name=ch3_fminute[] options=$ch3.finishing_minute selected=$ch3.selected_finishing_minute}
          分          </strong></font></td>
  </tr>
{/foreach}
</table>
<Div align="right"><input type="submit" name="ch3_addition" id="button" value="追加" /><input type="submit" name="ch3_deletion" id="button" value="削除" /></Div>
<br />
<strong>4号機</strong><br />
<table width=800 border="0" align="center" bordercolor="#333333" bgcolor="#666666">
  <tr>
    <td width="25" align="center" nowrap="nowrap" bgcolor="#FFCCCC"><font color="#0000FF"></font></td>
    <td width="108" align="center" nowrap="nowrap" bgcolor="#FFCCCC"><font color="#0000FF"><strong>品番</strong></font></td>
    <td colspan="2" align="center" valign="middle" nowrap="nowrap" bgcolor="#FFCCCC"><font color="#0000FF"><strong>成形時間</strong></font></td>
    <td width="120" align="center" bgcolor="#FFCCCC"><p align="center"><font color="#0000FF" size="-3"><strong>予定枚数</strong></font></p></td>
    <td width="110" align="center" nowrap="nowrap" bgcolor="#FFCCCC"><strong><font color="#0000FF" size="-3">箱NO.</font></strong></td>
  </tr>
{foreach from=$ch4 item=ch4 }
  <tr>
    <td rowspan="2" align="center" nowrap="nowrap" bgcolor="#FFCCCC">
      {$ch2.radio}
    </td>
    <td rowspan="2" align="center" nowrap="nowrap" bgcolor="#FFCCCC"><font size="-2">
      <input type="text" name="ch4_product_id[]" value="{$ch4.product_id}"  size="20"/>
    </font></td>
    <td width="50" align="center" valign="middle" nowrap="nowrap" bgcolor="#FFCCCC"><strong><font color="#0000FF">開始</font></strong></td>
    <td width="366" align="center" valign="middle" nowrap="nowrap" bgcolor="#FFCCCC">
        <font size="-2"><strong>
        {html_options name=ch4_syear[] options=$ch4.starting_year selected=$ch4.selected_starting_year}
        年
           {html_options name=ch4_smonth[] options=$ch4.starting_month selected=$ch4.selected_starting_month}
        月
          {html_options name=ch4_sday[] options=$ch4.starting_day selected=$ch4.selected_starting_day}
          日
          {html_options name=ch4_shour[] options=$ch4.starting_hour selected=$ch4.selected_starting_hour}
          時          
          {html_options name=ch4_sminute[] options=$ch4.starting_minute selected=$ch4.selected_starting_minute}
          分          </strong></font></td>
    <td rowspan="2" align="center" nowrap="nowrap" bgcolor="#FFCCCC">
      <input type="text" name="ch4_number_sheet[]" value="{$ch4.number_sheet}" size="15"/>    </td>
    <td rowspan="2" align="center" nowrap="nowrap" bgcolor="#FFCCCC">
       <input type="text" name="ch4_num_box[]" value="{$ch4.num_box}" size="15"/>
    </td>
  </tr>
  <tr>
    <td align="center" valign="middle" nowrap="nowrap" bgcolor="#FFCCCC"><strong><font color="#0000FF">終了</font></strong></td>
    <td align="center" valign="middle" nowrap="nowrap" bgcolor="#FFCCCC">
        <font size="-2"><strong>
        {html_options name=ch4_fyear[] options=$ch4.finishing_year selected=$ch4.selected_finishing_year}
        年
           {html_options name=ch4_fmonth[] options=$ch4.finishing_month selected=$ch4.selected_finishing_month}
        月
          {html_options name=ch4_fday[] options=$ch4.finishing_day selected=$ch4.selected_finishing_day}
          日
          {html_options name=ch4_fhour[] options=$ch4.finishing_hour selected=$ch4.selected_finishing_hour}
          時          
          {html_options name=ch4_fminute[] options=$ch4.finishing_minute selected=$ch4.selected_finishing_minute}
          分          </strong></font></td>
  </tr>
{/foreach}
</table>
<Div align="right"><input type="submit" name="ch4_addition" id="button" value="追加" /><input type="submit" name="ch4_deletion" id="button" value="削除" /></Div>
<br />
<strong>5号機</strong><br />
<table width=800 border="0" align="center" bordercolor="#333333" bgcolor="#666666">
  <tr>
    <td width="25" align="center" bgcolor="#FFFFCC"><strong><font color="#0000FF"></font></strong></td>
    <td width="108" align="center" nowrap="nowrap" bgcolor="#FFFFCC"><font color="#0000FF"><strong>品番</strong></font></td>
    <td colspan="2" align="center" valign="middle" nowrap="nowrap" bgcolor="#FFFFCC"><font color="#0000FF"><strong>成形時間</strong></font></td>
    <td width="120" align="center" bgcolor="#FFFFCC"><p align="center"><font color="#0000FF" size="-3"><strong>予定枚数</strong></font></p></td>
    <td width="110" align="center" nowrap="nowrap" bgcolor="#FFFFCC"><strong><font color="#0000FF" size="-3">箱NO.</font></strong></td>
  </tr>
{foreach from=$ch5 item=ch5 }
  <tr>
    <td rowspan="2" align="center" nowrap="nowrap" bgcolor="#FFFFCC">
      {$ch5.radio}
    </td>
    <td rowspan="2" align="center" nowrap="nowrap" bgcolor="#FFFFCC"><font size="-2">
      <input type="text" name="ch5_product_id[]" value="{$ch5.product_id}"  size="20"/>
    </font></td>
    <td width="50" align="center" valign="middle" nowrap="nowrap" bgcolor="#FFFFCC"><strong><font color="#0000FF">開始</font></strong></td>
    <td width="366" align="center" valign="middle" nowrap="nowrap" bgcolor="#FFFFCC">
        <font size="-2"><strong>
        {html_options name=ch5_syear[] options=$ch5.starting_year selected=$ch5.selected_starting_year}
        年
           {html_options name=ch5_smonth[] options=$ch5.starting_month selected=$ch5.selected_starting_month}
        月
          {html_options name=ch5_sday[] options=$ch5.starting_day selected=$ch5.selected_starting_day}
          日
          {html_options name=ch5_shour[] options=$ch5.starting_hour selected=$ch5.selected_starting_hour}
          時          
          {html_options name=ch5_sminute[] options=$ch5.starting_minute selected=$ch5.selected_starting_minute}
          分          </strong></font></td>
    <td rowspan="2" align="center" nowrap="nowrap" bgcolor="#FFFFCC">
      <input type="text" name="ch5_number_sheet[]" value="{$ch5.number_sheet}" size="15"/>    </td>
    <td rowspan="2" align="center" nowrap="nowrap" bgcolor="#FFFFCC">
      <input type="text" name="ch5_num_box[]" value="{$ch5.num_box}" size="15"/>
    </td>
  </tr>
  <tr>
    <td align="center" valign="middle" nowrap="nowrap" bgcolor="#FFFFCC"><strong><font color="#0000FF">終了</font></strong></td>
    <td align="center" valign="middle" nowrap="nowrap" bgcolor="#FFFFCC">
        <font size="-2"><strong>
        {html_options name=ch5_fyear[] options=$ch5.finishing_year selected=$ch5.selected_finishing_year}
        年
           {html_options name=ch5_fmonth[] options=$ch5.finishing_month selected=$ch5.selected_finishing_month}
        月
          {html_options name=ch5_fday[] options=$ch5.finishing_day selected=$ch5.selected_finishing_day}
          日
          {html_options name=ch5_fhour[] options=$ch5.finishing_hour selected=$ch5.selected_finishing_hour}
          時          
          {html_options name=ch5_fminute[] options=$ch5.finishing_minute selected=$ch5.selected_finishing_minute}
          分          </strong></font></td>
  </tr>
{/foreach}
</table>
<Div align="right"><input type="submit" name="ch5_addition" id="button" value="追加" /><input type="submit" name="ch5_deletion" id="button" value="削除" /></Div>

<br />
<strong>6号機</strong>
<br />
<table width=800 border="0" align="center" bordercolor="#333333" bgcolor="#666666">
  <tr>
    <td width="25" align="center" nowrap="nowrap" bgcolor="#FFCCCC"><font color="#0000FF"></font></td>
    <td width="108" align="center" nowrap="nowrap" bgcolor="#FFCCCC"><font color="#0000FF"><strong>品番</strong></font></td>
    <td colspan="2" align="center" valign="middle" nowrap="nowrap" bgcolor="#FFCCCC"><font color="#0000FF"><strong>成形時間</strong></font></td>
    <td width="120" align="center" bgcolor="#FFCCCC"><p align="center"><font color="#0000FF" size="-3"><strong>予定枚数</strong></font></p></td>
    <td width="110" align="center" nowrap="nowrap" bgcolor="#FFCCCC"><strong><font color="#0000FF" size="-3">箱NO.</font></strong></td>
  </tr>
{foreach from=$ch6 item=ch6 }
  <tr>
    <td rowspan="2" align="center" nowrap="nowrap" bgcolor="#FFCCCC">
      {$ch2.radio}
    </td>
    <td rowspan="2" align="center" nowrap="nowrap" bgcolor="#FFCCCC"><font size="-2">
      <input type="text" name="ch6_product_id[]" value="{$ch6.product_id}"  size="20"/>
    </font></td>
    <td width="50" align="center" valign="middle" nowrap="nowrap" bgcolor="#FFCCCC"><strong><font color="#0000FF">開始</font></strong></td>
    <td width="366" align="center" valign="middle" nowrap="nowrap" bgcolor="#FFCCCC">
        <font size="-2"><strong>
        {html_options name=ch6_syear[] options=$ch6.starting_year selected=$ch6.selected_starting_year}
        年
           {html_options name=ch6_smonth[] options=$ch6.starting_month selected=$ch6.selected_starting_month}
        月
          {html_options name=ch6_sday[] options=$ch6.starting_day selected=$ch6.selected_starting_day}
          日
          {html_options name=ch6_shour[] options=$ch6.starting_hour selected=$ch6.selected_starting_hour}
          時          
          {html_options name=ch6_sminute[] options=$ch6.starting_minute selected=$ch6.selected_starting_minute}
          分         </strong></font></td>
    <td rowspan="2" align="center" nowrap="nowrap" bgcolor="#FFCCCC">
      <input type="text" name="ch6_number_sheet[]" value="{$ch6.number_sheet}" size="15"/>    </td>
    <td rowspan="2" align="center" nowrap="nowrap" bgcolor="#FFCCCC">
       <input type="text" name="ch6_num_box[]" value="{$ch6.num_box}" size="15"/>
    </td>
  </tr>
  <tr>
    <td align="center" valign="middle" nowrap="nowrap" bgcolor="#FFCCCC"><strong><font color="#0000FF">終了</font></strong></td>
    <td align="center" valign="middle" nowrap="nowrap" bgcolor="#FFCCCC">
        <font size="-2"><strong>
        {html_options name=ch6_fyear[] options=$ch6.finishing_year selected=$ch6.selected_finishing_year}
        年
           {html_options name=ch6_fmonth[] options=$ch6.finishing_month selected=$ch6.selected_finishing_month}
        月
          {html_options name=ch6_fday[] options=$ch6.finishing_day selected=$ch6.selected_finishing_day}
          日
          {html_options name=ch6_fhour[] options=$ch6.finishing_hour selected=$ch6.selected_finishing_hour}
          時          
          {html_options name=ch6_fminute[] options=$ch6.finishing_minute selected=$ch6.selected_finishing_minute}
          分          </strong></font></td>
  </tr>
{/foreach}
</table>
<Div align="right"><input type="submit" name="ch6_addition" id="button" value="追加" /><input type="submit" name="ch6_deletion" id="button" value="削除" /></Div>
<br />
<strong>7号機</strong><br />
<table width=800 border="0" align="center" bordercolor="#333333" bgcolor="#666666">
  <tr>
    <td width="25" align="center" bgcolor="#FFFFCC"><strong><font color="#0000FF"></font></strong></td>
    <td width="108" align="center" nowrap="nowrap" bgcolor="#FFFFCC"><font color="#0000FF"><strong>品番</strong></font></td>
    <td colspan="2" align="center" valign="middle" nowrap="nowrap" bgcolor="#FFFFCC"><font color="#0000FF"><strong>成形時間</strong></font></td>
    <td width="120" align="center" bgcolor="#FFFFCC"><p align="center"><font color="#0000FF" size="-3"><strong>予定枚数</strong></font></p></td>
    <td width="110" align="center" nowrap="nowrap" bgcolor="#FFFFCC"><strong><font color="#0000FF" size="-3">箱NO.</font></strong></td>
  </tr>
{foreach from=$ch7 item=ch7 }
  <tr>
    <td rowspan="2" align="center" nowrap="nowrap" bgcolor="#FFFFCC">
      {$ch7.radio}
    </td>
    <td rowspan="2" align="center" nowrap="nowrap" bgcolor="#FFFFCC"><font size="-2">
      <input type="text" name="ch7_product_id[]" value="{$ch7.product_id}"  size="20"/>
    </font></td>
    <td width="50" align="center" valign="middle" nowrap="nowrap" bgcolor="#FFFFCC"><strong><font color="#0000FF">開始</font></strong></td>
    <td width="366" align="center" valign="middle" nowrap="nowrap" bgcolor="#FFFFCC">
        <font size="-2"><strong>
        {html_options name=ch7_syear[] options=$ch7.starting_year selected=$ch7.selected_starting_year}
        年
           {html_options name=ch7_smonth[] options=$ch7.starting_month selected=$ch7.selected_starting_month}
        月
          {html_options name=ch7_sday[] options=$ch7.starting_day selected=$ch7.selected_starting_day}
          日
          {html_options name=ch7_shour[] options=$ch7.starting_hour selected=$ch7.selected_starting_hour}
          時          
          {html_options name=ch7_sminute[] options=$ch7.starting_minute selected=$ch7.selected_starting_minute}
          分          </strong></font></td>
    <td rowspan="2" align="center" nowrap="nowrap" bgcolor="#FFFFCC">
      <input type="text" name="ch7_number_sheet[]" value="{$ch7.number_sheet}" size="15"/>    </td>
    <td rowspan="2" align="center" nowrap="nowrap" bgcolor="#FFFFCC">
       <input type="text" name="ch7_num_box[]" value="{$ch7.num_box}" size="15"/>
    </td>
  </tr>
  <tr>
    <td align="center" valign="middle" nowrap="nowrap" bgcolor="#FFFFCC"><strong><font color="#0000FF">終了</font></strong></td>
    <td align="center" valign="middle" nowrap="nowrap" bgcolor="#FFFFCC">
        <font size="-2"><strong>
        {html_options name=ch7_fyear[] options=$ch7.finishing_year selected=$ch7.selected_finishing_year}
        年
           {html_options name=ch7_fmonth[] options=$ch7.finishing_month selected=$ch7.selected_finishing_month}
        月
          {html_options name=ch7_fday[] options=$ch7.finishing_day selected=$ch7.selected_finishing_day}
          日
          {html_options name=ch7_fhour[] options=$ch7.finishing_hour selected=$ch7.selected_finishing_hour}
          時          
          {html_options name=ch7_fminute[] options=$ch7.finishing_minute selected=$ch7.selected_finishing_minute}
          分          </strong></font></td>
  </tr>
{/foreach}
</table>
<Div align="right"><input type="submit" name="ch7_addition" id="button" value="追加" /><input type="submit" name="ch7_deletion" id="button" value="削除" /></Div>
<br />
<strong>8号機</strong><br />
<table width=800 border="0" align="center" bordercolor="#333333" bgcolor="#666666">
  <tr>
    <td width="25" align="center" nowrap="nowrap" bgcolor="#FFCCCC"><font color="#0000FF"></font></td>
    <td width="108" align="center" nowrap="nowrap" bgcolor="#FFCCCC"><font color="#0000FF"><strong>品番</strong></font></td>
    <td colspan="2" align="center" valign="middle" nowrap="nowrap" bgcolor="#FFCCCC"><font color="#0000FF"><strong>成形時間</strong></font></td>
    <td width="120" align="center" nowrap="nowrap" bgcolor="#FFCCCC"><p align="center"><font color="#0000FF" size="-3"><strong>予定枚数</strong></font></p></td>
    <td width="110" align="center" nowrap="nowrap" bgcolor="#FFCCCC"><strong><font color="#0000FF" size="-3">箱NO.</font></strong></td>
  </tr>
{foreach from=$ch8 item=ch8 }
  <tr>
    <td rowspan="2" align="center" nowrap="nowrap" bgcolor="#FFCCCC">
      {$ch2.radio}
    </td>
    <td rowspan="2" align="center" nowrap="nowrap" bgcolor="#FFCCCC"><font size="-2">
      <input type="text" name="ch8_product_id[]" value="{$ch8.product_id}"  size="20"/>
    </font></td>
    <td width="50" align="center" valign="middle" nowrap="nowrap" bgcolor="#FFCCCC"><strong><font color="#0000FF">開始</font></strong></td>
    <td width="366" align="center" valign="middle" nowrap="nowrap" bgcolor="#FFCCCC">
        <font size="-2"><strong>
        {html_options name=ch8_syear[] options=$ch8.starting_year selected=$ch8.selected_starting_year}
        年
           {html_options name=ch8_smonth[] options=$ch8.starting_month selected=$ch8.selected_starting_month}
        月
          {html_options name=ch8_sday[] options=$ch8.starting_day selected=$ch8.selected_starting_day}
          日
          {html_options name=ch8_shour[] options=$ch8.starting_hour selected=$ch8.selected_starting_hour}
          時          
          {html_options name=ch8_sminute[] options=$ch8.starting_minute selected=$ch8.selected_starting_minute}
          分          </strong></font></td>
    <td rowspan="2" align="center" nowrap="nowrap" bgcolor="#FFCCCC"><input type="text" name="ch8_number_sheet[]" value="{$ch8.number_sheet}" size="15"/></td>
    <td rowspan="2" align="center" nowrap="nowrap" bgcolor="#FFCCCC">
        <input type="text" name="ch8_num_box[]" value="{$ch8.num_box}" size="15"/>
    </td>
  <tr>
    <td align="center" valign="middle" nowrap="nowrap" bgcolor="#FFCCCC"><strong><font color="#0000FF">終了</font></strong></td>
    <td align="center" valign="middle" nowrap="nowrap" bgcolor="#FFCCCC">
        <font size="-2"><strong>
        {html_options name=ch8_fyear[] options=$ch8.finishing_year selected=$ch8.selected_finishing_year}
        年
           {html_options name=ch8_fmonth[] options=$ch8.finishing_month selected=$ch8.selected_finishing_month}
        月
          {html_options name=ch8_fday[] options=$ch8.finishing_day selected=$ch8.selected_finishing_day}
          日
          {html_options name=ch8_fhour[] options=$ch8.finishing_hour selected=$ch8.selected_finishing_hour}
          時          
          {html_options name=ch8_fminute[] options=$ch8.finishing_minute selected=$ch8.selected_finishing_minute}
          分          </strong></font></td>
  </tr>
{/foreach}
</table>
<Div align="right"><input type="submit" name="ch8_addition" id="button" value="追加" /><input type="submit" name="ch8_deletion" id="button" value="削除" /></Div>
<br />
<strong>9号機</strong><br />
<table width=800 border="0" align="center" bordercolor="#333333" bgcolor="#666666">
  <tr>
    <td width="25" align="center" bgcolor="#FFFFCC"><strong><font color="#0000FF"></font></strong></td>
    <td width="108" align="center" nowrap="nowrap" bgcolor="#FFFFCC"><font color="#0000FF"><strong>品番</strong></font></td>
    <td colspan="2" align="center" valign="middle" nowrap="nowrap" bgcolor="#FFFFCC"><font color="#0000FF"><strong>成形時間</strong></font></td>
    <td width="120" align="center" nowrap="nowrap" bgcolor="#FFFFCC"><p align="center"><font color="#0000FF" size="-3"><strong>予定枚数</strong></font></p></td>
    <td width="110" align="center" nowrap="nowrap" bgcolor="#FFFFCC"><strong><font color="#0000FF" size="-3">箱NO.</font></strong></td>
  </tr>
{foreach from=$ch9 item=ch9 }
  <tr>
    <td rowspan="2" align="center" nowrap="nowrap" bgcolor="#FFFFCC">
      {$ch9.radio}
    </td>
    <td rowspan="2" align="center" nowrap="nowrap" bgcolor="#FFFFCC"><font size="-2">
      <input type="text" name="ch9_product_id[]" value="{$ch9.product_id}"  size="20"/>
    </font></td>
    <td width="50" align="center" valign="middle" nowrap="nowrap" bgcolor="#FFFFCC"><strong><font color="#0000FF">開始</font></strong></td>
    <td width="366" align="center" valign="middle" nowrap="nowrap" bgcolor="#FFFFCC">
        <font size="-2"><strong>
        {html_options name=ch9_syear[] options=$ch9.starting_year selected=$ch9.selected_starting_year}
        年
           {html_options name=ch9_smonth[] options=$ch9.starting_month selected=$ch9.selected_starting_month}
        月
          {html_options name=ch9_sday[] options=$ch9.starting_day selected=$ch9.selected_starting_day}
          日
          {html_options name=ch9_shour[] options=$ch9.starting_hour selected=$ch9.selected_starting_hour}
          時          
          {html_options name=ch9_sminute[] options=$ch9.starting_minute selected=$ch9.selected_starting_minute}
          分          </strong></font></td>
    <td rowspan="2" align="center" nowrap="nowrap" bgcolor="#FFFFCC">
      <input type="text" name="ch9_number_sheet[]" value="{$ch9.number_sheet}" size="15"/>    </td>
    <td rowspan="2" align="center" nowrap="nowrap" bgcolor="#FFFFCC">
      <input type="text" name="ch9_num_box[]" value="{$ch9.num_box}" size="15"/>
    </td>
  </tr>
  <tr>
    <td align="center" valign="middle" nowrap="nowrap" bgcolor="#FFFFCC"><strong><font color="#0000FF">終了</font></strong></td>
    <td align="center" valign="middle" nowrap="nowrap" bgcolor="#FFFFCC">
        <font size="-2"><strong>
        {html_options name=ch9_fyear[] options=$ch9.finishing_year selected=$ch9.selected_finishing_year}
        年
           {html_options name=ch9_fmonth[] options=$ch9.finishing_month selected=$ch9.selected_finishing_month}
        月
          {html_options name=ch9_fday[] options=$ch9.finishing_day selected=$ch9.selected_finishing_day}
          日
          {html_options name=ch9_fhour[] options=$ch9.finishing_hour selected=$ch9.selected_finishing_hour}
          時          
          {html_options name=ch9_fminute[] options=$ch9.finishing_minute selected=$ch9.selected_finishing_minute}
          分          </strong></font></td>
  </tr>
{/foreach}
</table>
<Div align="right"><input type="submit" name="ch9_addition" id="button" value="追加" /><input type="submit" name="ch9_deletion" id="button" value="削除" /></Div>
<br />
<p align="right">
{$value}
<input type="hidden" name="year" value="{$year}" size="15"/>
<input type="hidden" name="month" value="{$month}" size="15"/>
<input type="hidden" name="day" value="{$day}" size="15"/>
        <label><font color="#FFFFCC"></font>
                <input type="submit" name="all_delete" id="button" value="チェックした工程全て削除" />
        </label>
        <label><font color="#FFFFCC"></font>
                <input type="submit" name="touroku" id="button" value="登録" />
        </label>
    </form>
</p>
</td>
    <hr />  
  </tr>
</table>
</body>
</html>
