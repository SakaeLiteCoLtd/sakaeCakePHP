<?php /* Smarty version 2.6.26, created on 2013-09-07 09:44:21
         compiled from kakunin_hakkou.tpl */ ?>
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
	<?php echo $this->_tpl_vars['header']; ?>
   
    </td>
  </tr>
<form action="csv_hakkou.php" method="post">
  <tr valign="middle" bordercolor="#CCCCCC">
    <td bgcolor="#E1FDFB"><hr>
<?php echo $this->_tpl_vars['semi_header']; ?>

  <hr />
  <strong>1号機</strong><br />
<table width=800 border="0" align="center" bordercolor="#333333" bgcolor="#666666">
  <tr>
    <td width="108" align="center" nowrap="nowrap" bgcolor="#FFFFCC"><font color="#0000FF"><strong>品番</strong></font></td>
    <td colspan="2" align="center" valign="middle" nowrap="nowrap" bgcolor="#FFFFCC"><font color="#0000FF"><strong>成形時間</strong></font></td>
    <td width="120" align="center" bgcolor="#FFFFCC"><p align="center"><font color="#0000FF" size="-3"><strong>予定枚数</strong></font></p></td>
    <td width="110" align="center" nowrap="nowrap" bgcolor="#FFFFCC"><strong><font color="#0000FF" size="-3">箱NO.</font></strong></td>
  </tr>
<?php $_from = $this->_tpl_vars['ch1']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)):
    foreach ($_from as $this->_tpl_vars['ch1']):
?>
  <tr>
    <td rowspan="2" align="center" nowrap="nowrap" bgcolor="#FFFFCC"><font size="2">
      <strong><?php echo $this->_tpl_vars['ch1']['product_id']; ?>
</strong><input type="hidden" name="ch1_product_id[]" value="<?php echo $this->_tpl_vars['ch1']['product_id']; ?>
"  size="20"/>
    </font></td>
    <td width="50" align="center" valign="middle" nowrap="nowrap" bgcolor="#FFFFCC"><strong><font color="#0000FF">開始</font></strong></td>
    <td width="366" align="center" valign="middle" nowrap="nowrap" bgcolor="#FFFFCC">
        <font size="2"><strong><?php echo $this->_tpl_vars['ch1']['starting_tm']; ?>
</strong></font></td>
    <td rowspan="2" align="center" nowrap="nowrap" bgcolor="#FFFFCC">
      <strong><?php echo $this->_tpl_vars['ch1']['number_sheet']; ?>
</strong><input type="hidden" name="ch1_number_sheet[]" value="<?php echo $this->_tpl_vars['ch1']['number_sheet']; ?>
" size="15"/>    </td>
    <td rowspan="2" align="center" nowrap="nowrap" bgcolor="#FFFFCC">
       <strong><?php echo $this->_tpl_vars['ch1']['num_box']; ?>
</strong><input type="hidden" name="ch1_num_box[]" value="<?php echo $this->_tpl_vars['ch1']['num_box']; ?>
" size="15"/>
    </td>
  </tr>
  <tr>
    <td align="center" valign="middle" nowrap="nowrap" bgcolor="#FFFFCC"><strong><font color="#0000FF">終了</font></strong></td>
    <td align="center" valign="middle" nowrap="nowrap" bgcolor="#FFFFCC">
        <font size="2"><strong><?php echo $this->_tpl_vars['ch1']['finishing_tm']; ?>
</strong></font></td>
  </tr>
<?php endforeach; endif; unset($_from); ?>
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
<?php $_from = $this->_tpl_vars['ch2']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)):
    foreach ($_from as $this->_tpl_vars['ch2']):
?>
  <tr>
    <td rowspan="2" align="center" nowrap="nowrap" bgcolor="#FFCCCC"><font size="2">
      <strong><?php echo $this->_tpl_vars['ch2']['product_id']; ?>
</strong><input type="hidden" name="ch2_product_id[]" value="<?php echo $this->_tpl_vars['ch2']['product_id']; ?>
"  size="20"/>
    </font></td>
    <td width="50" align="center" valign="middle" nowrap="nowrap" bgcolor="#FFCCCC"><strong><font color="#0000FF">開始</font></strong></td>
    <td width="366" align="center" valign="middle" nowrap="nowrap" bgcolor="#FFCCCC">
        <font size="2"><strong><?php echo $this->_tpl_vars['ch2']['starting_tm']; ?>
</strong></font></td>
    <td rowspan="2" align="center" nowrap="nowrap" bgcolor="#FFCCCC">
      <strong><?php echo $this->_tpl_vars['ch2']['number_sheet']; ?>
</strong><input type="hidden" name="ch2_number_sheet[]" value="<?php echo $this->_tpl_vars['ch2']['number_sheet']; ?>
" size="15"/>    </td>
    <td rowspan="2" align="center" nowrap="nowrap" bgcolor="#FFCCCC">
       <strong><?php echo $this->_tpl_vars['ch2']['num_box']; ?>
</strong><input type="hidden" name="ch2_num_box[]" value="<?php echo $this->_tpl_vars['ch2']['num_box']; ?>
" size="15"/>
    </td>
  </tr>
  <tr>
    <td align="center" valign="middle" nowrap="nowrap" bgcolor="#FFCCCC"><strong><font color="#0000FF">終了</font></strong></td>
    <td align="center" valign="middle" nowrap="nowrap" bgcolor="#FFCCCC">
        <font size="2"><strong><?php echo $this->_tpl_vars['ch2']['finishing_tm']; ?>
</strong></font></td>
  </tr>
<?php endforeach; endif; unset($_from); ?>
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
<?php $_from = $this->_tpl_vars['ch3']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)):
    foreach ($_from as $this->_tpl_vars['ch3']):
?>
  <tr>
    <td rowspan="2" align="center" nowrap="nowrap" bgcolor="#FFFFCC"><font size="2">
      <strong><?php echo $this->_tpl_vars['ch3']['product_id']; ?>
</strong><input type="hidden" name="ch3_product_id[]" value="<?php echo $this->_tpl_vars['ch3']['product_id']; ?>
"  size="20"/>
    </font></td>
    <td width="50" align="center" valign="middle" nowrap="nowrap" bgcolor="#FFFFCC"><strong><font color="#0000FF">開始</font></strong></td>
    <td width="366" align="center" valign="middle" nowrap="nowrap" bgcolor="#FFFFCC">
        <font size="2"><strong><?php echo $this->_tpl_vars['ch3']['starting_tm']; ?>
</strong></font></td>
    <td rowspan="2" align="center" nowrap="nowrap" bgcolor="#FFFFCC">
      <strong><?php echo $this->_tpl_vars['ch3']['number_sheet']; ?>
</strong><input type="hidden" name="ch3_number_sheet[]" value="<?php echo $this->_tpl_vars['ch3']['number_sheet']; ?>
" size="15"/>    </td>
    <td rowspan="2" align="center" nowrap="nowrap" bgcolor="#FFFFCC">
       <strong><?php echo $this->_tpl_vars['ch3']['num_box']; ?>
</strong><input type="hidden" name="ch3_num_box[]" value="<?php echo $this->_tpl_vars['ch3']['num_box']; ?>
" size="15"/>
    </td>
  </tr>
  <tr>
    <td align="center" valign="middle" nowrap="nowrap" bgcolor="#FFFFCC"><strong><font color="#0000FF">終了</font></strong></td>
    <td align="center" valign="middle" nowrap="nowrap" bgcolor="#FFFFCC">
        <font size="2"><strong><?php echo $this->_tpl_vars['ch3']['finishing_tm']; ?>
</strong></font></td>
  </tr>
<?php endforeach; endif; unset($_from); ?>
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
<?php $_from = $this->_tpl_vars['ch4']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)):
    foreach ($_from as $this->_tpl_vars['ch4']):
?>
  <tr>
    <td rowspan="2" align="center" nowrap="nowrap" bgcolor="#FFCCCC"><font size="2">
      <strong><?php echo $this->_tpl_vars['ch4']['product_id']; ?>
</strong><input type="hidden" name="ch4_product_id[]" value="<?php echo $this->_tpl_vars['ch4']['product_id']; ?>
"  size="20"/>
    </font></td>
    <td width="50" align="center" valign="middle" nowrap="nowrap" bgcolor="#FFCCCC"><strong><font color="#0000FF">開始</font></strong></td>
    <td width="366" align="center" valign="middle" nowrap="nowrap" bgcolor="#FFCCCC">
        <font size="2"><strong><?php echo $this->_tpl_vars['ch4']['starting_tm']; ?>
</strong></font></td>
    <td rowspan="2" align="center" nowrap="nowrap" bgcolor="#FFCCCC">
      <strong><?php echo $this->_tpl_vars['ch4']['number_sheet']; ?>
</strong><input type="hidden" name="ch4_number_sheet[]" value="<?php echo $this->_tpl_vars['ch4']['number_sheet']; ?>
" size="15"/>    </td>
    <td rowspan="2" align="center" nowrap="nowrap" bgcolor="#FFCCCC">
       <strong><?php echo $this->_tpl_vars['ch4']['num_box']; ?>
</strong><input type="hidden" name="ch4_num_box[]" value="<?php echo $this->_tpl_vars['ch4']['num_box']; ?>
" size="15"/>
    </td>
  </tr>
  <tr>
    <td align="center" valign="middle" nowrap="nowrap" bgcolor="#FFCCCC"><strong><font color="#0000FF">終了</font></strong></td>
    <td align="center" valign="middle" nowrap="nowrap" bgcolor="#FFCCCC">
        <font size="2"><strong><?php echo $this->_tpl_vars['ch4']['finishing_tm']; ?>
</strong></font></td>
  </tr>
<?php endforeach; endif; unset($_from); ?>
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
<?php $_from = $this->_tpl_vars['ch5']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)):
    foreach ($_from as $this->_tpl_vars['ch5']):
?>
  <tr>
    <td rowspan="2" align="center" nowrap="nowrap" bgcolor="#FFFFCC"><font size="2">
      <strong><?php echo $this->_tpl_vars['ch5']['product_id']; ?>
</strong><input type="hidden" name="ch5_product_id[]" value="<?php echo $this->_tpl_vars['ch5']['product_id']; ?>
"  size="20"/>
    </font></td>
    <td width="50" align="center" valign="middle" nowrap="nowrap" bgcolor="#FFFFCC"><strong><font color="#0000FF">開始</font></strong></td>
    <td width="366" align="center" valign="middle" nowrap="nowrap" bgcolor="#FFFFCC">
        <font size="2"><strong><?php echo $this->_tpl_vars['ch5']['starting_tm']; ?>
</strong></font></td>
    <td rowspan="2" align="center" nowrap="nowrap" bgcolor="#FFFFCC">
      <strong><?php echo $this->_tpl_vars['ch5']['number_sheet']; ?>
</strong><input type="hidden" name="ch5_number_sheet[]" value="<?php echo $this->_tpl_vars['ch5']['number_sheet']; ?>
" size="15"/>    </td>
    <td rowspan="2" align="center" nowrap="nowrap" bgcolor="#FFFFCC">
      <strong><?php echo $this->_tpl_vars['ch5']['num_box']; ?>
</strong><input type="hidden" name="ch5_num_box[]" value="<?php echo $this->_tpl_vars['ch5']['num_box']; ?>
" size="15"/>
    </td>
  </tr>
  <tr>
    <td align="center" valign="middle" nowrap="nowrap" bgcolor="#FFFFCC"><strong><font color="#0000FF">終了</font></strong></td>
    <td align="center" valign="middle" nowrap="nowrap" bgcolor="#FFFFCC">
        <font size="2"><strong><?php echo $this->_tpl_vars['ch5']['finishing_tm']; ?>
</strong></font></td>
  </tr>
<?php endforeach; endif; unset($_from); ?>
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
<?php $_from = $this->_tpl_vars['ch6']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)):
    foreach ($_from as $this->_tpl_vars['ch6']):
?>
  <tr>
    <td rowspan="2" align="center" nowrap="nowrap" bgcolor="#FFCCCC"><font size="2">
      <strong><?php echo $this->_tpl_vars['ch6']['product_id']; ?>
</strong><input type="hidden" name="ch6_product_id[]" value="<?php echo $this->_tpl_vars['ch6']['product_id']; ?>
"  size="20"/>
    </font></td>
    <td width="50" align="center" valign="middle" nowrap="nowrap" bgcolor="#FFCCCC"><strong><font color="#0000FF">開始</font></strong></td>
    <td width="366" align="center" valign="middle" nowrap="nowrap" bgcolor="#FFCCCC">
        <font size="2"><strong><?php echo $this->_tpl_vars['ch6']['starting_tm']; ?>
</strong></font></td>
    <td rowspan="2" align="center" nowrap="nowrap" bgcolor="#FFCCCC">
      <strong><?php echo $this->_tpl_vars['ch6']['number_sheet']; ?>
</strong><input type="hidden" name="ch6_number_sheet[]" value="<?php echo $this->_tpl_vars['ch6']['number_sheet']; ?>
" size="15"/>    </td>
    <td rowspan="2" align="center" nowrap="nowrap" bgcolor="#FFCCCC">
       <strong><?php echo $this->_tpl_vars['ch6']['num_box']; ?>
</strong><input type="hidden" name="ch6_num_box[]" value="<?php echo $this->_tpl_vars['ch6']['num_box']; ?>
" size="15"/>
    </td>
  </tr>
  <tr>
    <td align="center" valign="middle" nowrap="nowrap" bgcolor="#FFCCCC"><strong><font color="#0000FF">終了</font></strong></td>
    <td align="center" valign="middle" nowrap="nowrap" bgcolor="#FFCCCC">
        <font size="2"><strong><?php echo $this->_tpl_vars['ch6']['finishing_tm']; ?>
</strong></font></td>
  </tr>
<?php endforeach; endif; unset($_from); ?>
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
<?php $_from = $this->_tpl_vars['ch7']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)):
    foreach ($_from as $this->_tpl_vars['ch7']):
?>
  <tr>
    <td rowspan="2" align="center" nowrap="nowrap" bgcolor="#FFFFCC"><font size="2">
      <strong><?php echo $this->_tpl_vars['ch7']['product_id']; ?>
</strong><input type="hidden" name="ch7_product_id[]" value="<?php echo $this->_tpl_vars['ch7']['product_id']; ?>
"  size="20"/>
    </font></td>
    <td width="50" align="center" valign="middle" nowrap="nowrap" bgcolor="#FFFFCC"><strong><font color="#0000FF">開始</font></strong></td>
    <td width="366" align="center" valign="middle" nowrap="nowrap" bgcolor="#FFFFCC">
        <font size="2"><strong><?php echo $this->_tpl_vars['ch7']['starting_tm']; ?>
</strong></font></td>
    <td rowspan="2" align="center" nowrap="nowrap" bgcolor="#FFFFCC">
      <strong><?php echo $this->_tpl_vars['ch7']['number_sheet']; ?>
</strong><input type="hidden" name="ch7_number_sheet[]" value="<?php echo $this->_tpl_vars['ch7']['number_sheet']; ?>
" size="15"/>    </td>
    <td rowspan="2" align="center" nowrap="nowrap" bgcolor="#FFFFCC">
       <strong><?php echo $this->_tpl_vars['ch7']['num_box']; ?>
</strong><input type="hidden" name="ch7_num_box[]" value="<?php echo $this->_tpl_vars['ch7']['num_box']; ?>
" size="15"/>
    </td>
  </tr>
  <tr>
    <td align="center" valign="middle" nowrap="nowrap" bgcolor="#FFFFCC"><strong><font color="#0000FF">終了</font></strong></td>
    <td align="center" valign="middle" nowrap="nowrap" bgcolor="#FFFFCC">
        <font size="2"><strong><?php echo $this->_tpl_vars['ch7']['finishing_tm']; ?>
</strong></font></td>
  </tr>
<?php endforeach; endif; unset($_from); ?>
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
<?php $_from = $this->_tpl_vars['ch8']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)):
    foreach ($_from as $this->_tpl_vars['ch8']):
?>
  <tr>
    <td rowspan="2" align="center" nowrap="nowrap" bgcolor="#FFCCCC"><font size="2">
      <strong><?php echo $this->_tpl_vars['ch8']['product_id']; ?>
</strong><input type="hidden" name="ch8_product_id[]" value="<?php echo $this->_tpl_vars['ch8']['product_id']; ?>
"  size="20"/>
    </font></td>
    <td width="50" align="center" valign="middle" nowrap="nowrap" bgcolor="#FFCCCC"><strong><font color="#0000FF">開始</font></strong></td>
    <td width="366" align="center" valign="middle" nowrap="nowrap" bgcolor="#FFCCCC">
        <font size="2"><strong><?php echo $this->_tpl_vars['ch8']['starting_tm']; ?>
</strong></font></td>
    <td rowspan="2" align="center" nowrap="nowrap" bgcolor="#FFCCCC"><strong><?php echo $this->_tpl_vars['ch8']['number_sheet']; ?>
</strong><input type="hidden" name="ch8_number_sheet[]" value="<?php echo $this->_tpl_vars['ch8']['number_sheet']; ?>
" size="15"/></td>
    <td rowspan="2" align="center" nowrap="nowrap" bgcolor="#FFCCCC">
        <strong><?php echo $this->_tpl_vars['ch8']['num_box']; ?>
</strong><input type="hidden" name="ch8_num_box[]" value="<?php echo $this->_tpl_vars['ch8']['num_box']; ?>
" size="15"/>
    </td>
  <tr>
    <td align="center" valign="middle" nowrap="nowrap" bgcolor="#FFCCCC"><strong><font color="#0000FF">終了</font></strong></td>
    <td align="center" valign="middle" nowrap="nowrap" bgcolor="#FFCCCC">
        <font size="2"><strong><?php echo $this->_tpl_vars['ch8']['finishing_tm']; ?>
</strong></font></td>
  </tr>
<?php endforeach; endif; unset($_from); ?>
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
<?php $_from = $this->_tpl_vars['ch9']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)):
    foreach ($_from as $this->_tpl_vars['ch9']):
?>
  <tr>
    <td rowspan="2" align="center" nowrap="nowrap" bgcolor="#FFFFCC"><font size="2">
      <strong><?php echo $this->_tpl_vars['ch9']['product_id']; ?>
</strong><input type="hidden" name="ch9_product_id[]" value="<?php echo $this->_tpl_vars['ch9']['product_id']; ?>
"  size="20"/>
    </font></td>
    <td width="50" align="center" valign="middle" nowrap="nowrap" bgcolor="#FFFFCC"><strong><font color="#0000FF">開始</font></strong></td>
    <td width="366" align="center" valign="middle" nowrap="nowrap" bgcolor="#FFFFCC">
        <font size="2"><strong><?php echo $this->_tpl_vars['ch9']['starting_tm']; ?>
</strong></font></td>
    <td rowspan="2" align="center" nowrap="nowrap" bgcolor="#FFFFCC">
      <strong><?php echo $this->_tpl_vars['ch9']['number_sheet']; ?>
</strong><input type="hidden" name="ch9_number_sheet[]" value="<?php echo $this->_tpl_vars['ch9']['number_sheet']; ?>
" size="15"/>    </td>
    <td rowspan="2" align="center" nowrap="nowrap" bgcolor="#FFFFCC">
      <strong><?php echo $this->_tpl_vars['ch9']['num_box']; ?>
</strong><input type="hidden" name="ch9_num_box[]" value="<?php echo $this->_tpl_vars['ch9']['num_box']; ?>
" size="15"/>
    </td>
  </tr>
  <tr>
    <td align="center" valign="middle" nowrap="nowrap" bgcolor="#FFFFCC"><strong><font color="#0000FF">終了</font></strong></td>
    <td align="center" valign="middle" nowrap="nowrap" bgcolor="#FFFFCC">
        <font size="2"><strong><?php echo $this->_tpl_vars['ch9']['finishing_tm']; ?>
</strong></font></td>
  </tr>
<?php endforeach; endif; unset($_from); ?>
</table>
<br />
<p align="right">
<?php echo $this->_tpl_vars['value']; ?>

<input type="hidden" name="year" value="<?php echo $this->_tpl_vars['year']; ?>
" size="15"/>
<input type="hidden" name="month" value="<?php echo $this->_tpl_vars['month']; ?>
" size="15"/>
<input type="hidden" name="day" value="<?php echo $this->_tpl_vars['day']; ?>
" size="15"/>
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