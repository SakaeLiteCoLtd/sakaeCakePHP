<?php /* Smarty version 2.6.26, created on 2013-09-07 09:40:04
         compiled from form_hakkou.tpl */ ?>
<?php require_once(SMARTY_CORE_DIR . 'core.load_plugins.php');
smarty_core_load_plugins(array('plugins' => array(array('function', 'html_options', 'form_hakkou.tpl', 55, false),)), $this); ?>
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
<form action="kakunin_hakkou.php" method="post">
  <tr valign="middle" bordercolor="#CCCCCC">
    <td bgcolor="#E1FDFB"><hr>
<?php echo $this->_tpl_vars['semi_header']; ?>

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
<?php $_from = $this->_tpl_vars['ch1']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)):
    foreach ($_from as $this->_tpl_vars['ch1']):
?>
  <tr>
    <td rowspan="2" align="center" nowrap="nowrap" bgcolor="#FFFFCC">
      <?php echo $this->_tpl_vars['ch1']['radio']; ?>

    </td>
    <td rowspan="2" align="center" nowrap="nowrap" bgcolor="#FFFFCC"><font size="-2">
      <input type="text" name="ch1_product_id[]" value="<?php echo $this->_tpl_vars['ch1']['product_id']; ?>
"  size="20"/>
    </font></td>
    <td width="50" align="center" valign="middle" nowrap="nowrap" bgcolor="#FFFFCC"><strong><font color="#0000FF">開始</font></strong></td>
    <td width="366" align="center" valign="middle" nowrap="nowrap" bgcolor="#FFFFCC">
        <font size="-2"><strong>
        <?php echo smarty_function_html_options(array('name' => "ch1_syear[]",'options' => $this->_tpl_vars['ch1']['starting_year'],'selected' => $this->_tpl_vars['ch1']['selected_starting_year']), $this);?>

        年
           <?php echo smarty_function_html_options(array('name' => "ch1_smonth[]",'options' => $this->_tpl_vars['ch1']['starting_month'],'selected' => $this->_tpl_vars['ch1']['selected_starting_month']), $this);?>

        月
          <?php echo smarty_function_html_options(array('name' => "ch1_sday[]",'options' => $this->_tpl_vars['ch1']['starting_day'],'selected' => $this->_tpl_vars['ch1']['selected_starting_day']), $this);?>

          日
          <?php echo smarty_function_html_options(array('name' => "ch1_shour[]",'options' => $this->_tpl_vars['ch1']['starting_hour'],'selected' => $this->_tpl_vars['ch1']['selected_starting_hour']), $this);?>

          時          
          <?php echo smarty_function_html_options(array('name' => "ch1_sminute[]",'options' => $this->_tpl_vars['ch1']['starting_minute'],'selected' => $this->_tpl_vars['ch1']['selected_starting_minute']), $this);?>

          分          </strong></font></td>
    <td rowspan="2" align="center" nowrap="nowrap" bgcolor="#FFFFCC">
      <input type="text" name="ch1_number_sheet[]" value="<?php echo $this->_tpl_vars['ch1']['number_sheet']; ?>
" size="15"/>    </td>
    <td rowspan="2" align="center" nowrap="nowrap" bgcolor="#FFFFCC">
       <input type="text" name="ch1_num_box[]" value="<?php echo $this->_tpl_vars['ch1']['num_box']; ?>
" size="15"/>
    </td>
  </tr>
  <tr>
    <td align="center" valign="middle" nowrap="nowrap" bgcolor="#FFFFCC"><strong><font color="#0000FF">終了</font></strong></td>
    <td align="center" valign="middle" nowrap="nowrap" bgcolor="#FFFFCC">
        <font size="-2"><strong>
        <?php echo smarty_function_html_options(array('name' => "ch1_fyear[]",'options' => $this->_tpl_vars['ch1']['finishing_year'],'selected' => $this->_tpl_vars['ch1']['selected_finishing_year']), $this);?>

        年
           <?php echo smarty_function_html_options(array('name' => "ch1_fmonth[]",'options' => $this->_tpl_vars['ch1']['finishing_month'],'selected' => $this->_tpl_vars['ch1']['selected_finishing_month']), $this);?>

        月
          <?php echo smarty_function_html_options(array('name' => "ch1_fday[]",'options' => $this->_tpl_vars['ch1']['finishing_day'],'selected' => $this->_tpl_vars['ch1']['selected_finishing_day']), $this);?>

          日
          <?php echo smarty_function_html_options(array('name' => "ch1_fhour[]",'options' => $this->_tpl_vars['ch1']['finishing_hour'],'selected' => $this->_tpl_vars['ch1']['selected_finishing_hour']), $this);?>

          時          
          <?php echo smarty_function_html_options(array('name' => "ch1_fminute[]",'options' => $this->_tpl_vars['ch1']['finishing_minute'],'selected' => $this->_tpl_vars['ch1']['selected_finishing_minute']), $this);?>

          分         </strong></font></td>
  </tr>
<?php endforeach; endif; unset($_from); ?>
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
<?php $_from = $this->_tpl_vars['ch2']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)):
    foreach ($_from as $this->_tpl_vars['ch2']):
?>
  <tr>
    <td rowspan="2" align="center" nowrap="nowrap" bgcolor="#FFCCCC">
      <?php echo $this->_tpl_vars['ch2']['radio']; ?>

    </td>
    <td rowspan="2" align="center" nowrap="nowrap" bgcolor="#FFCCCC"><font size="-2">
      <input type="text" name="ch2_product_id[]" value="<?php echo $this->_tpl_vars['ch2']['product_id']; ?>
"  size="20"/>
    </font></td>
    <td width="50" align="center" valign="middle" nowrap="nowrap" bgcolor="#FFCCCC"><strong><font color="#0000FF">開始</font></strong></td>
    <td width="366" align="center" valign="middle" nowrap="nowrap" bgcolor="#FFCCCC">
        <font size="-2"><strong>
        <?php echo smarty_function_html_options(array('name' => "ch2_syear[]",'options' => $this->_tpl_vars['ch2']['starting_year'],'selected' => $this->_tpl_vars['ch2']['selected_starting_year']), $this);?>

        年
           <?php echo smarty_function_html_options(array('name' => "ch2_smonth[]",'options' => $this->_tpl_vars['ch2']['starting_month'],'selected' => $this->_tpl_vars['ch2']['selected_starting_month']), $this);?>

        月
          <?php echo smarty_function_html_options(array('name' => "ch2_sday[]",'options' => $this->_tpl_vars['ch2']['starting_day'],'selected' => $this->_tpl_vars['ch2']['selected_starting_day']), $this);?>

          日
          <?php echo smarty_function_html_options(array('name' => "ch2_shour[]",'options' => $this->_tpl_vars['ch2']['starting_hour'],'selected' => $this->_tpl_vars['ch2']['selected_starting_hour']), $this);?>

          時          
          <?php echo smarty_function_html_options(array('name' => "ch2_sminute[]",'options' => $this->_tpl_vars['ch2']['starting_minute'],'selected' => $this->_tpl_vars['ch2']['selected_starting_minute']), $this);?>

          分          </strong></font></td>
    <td rowspan="2" align="center" nowrap="nowrap" bgcolor="#FFCCCC">
      <input type="text" name="ch2_number_sheet[]" value="<?php echo $this->_tpl_vars['ch2']['number_sheet']; ?>
" size="15"/>    </td>
    <td rowspan="2" align="center" nowrap="nowrap" bgcolor="#FFCCCC">
       <input type="text" name="ch2_num_box[]" value="<?php echo $this->_tpl_vars['ch2']['num_box']; ?>
" size="15"/>
    </td>
  </tr>
  <tr>
    <td align="center" valign="middle" nowrap="nowrap" bgcolor="#FFCCCC"><strong><font color="#0000FF">終了</font></strong></td>
    <td align="center" valign="middle" nowrap="nowrap" bgcolor="#FFCCCC">
        <font size="-2"><strong>
        <?php echo smarty_function_html_options(array('name' => "ch2_fyear[]",'options' => $this->_tpl_vars['ch2']['finishing_year'],'selected' => $this->_tpl_vars['ch2']['selected_finishing_year']), $this);?>

        年
           <?php echo smarty_function_html_options(array('name' => "ch2_fmonth[]",'options' => $this->_tpl_vars['ch2']['finishing_month'],'selected' => $this->_tpl_vars['ch2']['selected_finishing_month']), $this);?>

        月
          <?php echo smarty_function_html_options(array('name' => "ch2_fday[]",'options' => $this->_tpl_vars['ch2']['finishing_day'],'selected' => $this->_tpl_vars['ch2']['selected_finishing_day']), $this);?>

          日
          <?php echo smarty_function_html_options(array('name' => "ch2_fhour[]",'options' => $this->_tpl_vars['ch2']['finishing_hour'],'selected' => $this->_tpl_vars['ch2']['selected_finishing_hour']), $this);?>

          時          
          <?php echo smarty_function_html_options(array('name' => "ch2_fminute[]",'options' => $this->_tpl_vars['ch2']['finishing_minute'],'selected' => $this->_tpl_vars['ch2']['selected_finishing_minute']), $this);?>

          分          </strong></font></td>
  </tr>
<?php endforeach; endif; unset($_from); ?>
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
<?php $_from = $this->_tpl_vars['ch3']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)):
    foreach ($_from as $this->_tpl_vars['ch3']):
?>
  <tr>
    <td rowspan="2" align="center" nowrap="nowrap" bgcolor="#FFFFCC">
      <?php echo $this->_tpl_vars['ch3']['radio']; ?>

    </td>
    <td rowspan="2" align="center" nowrap="nowrap" bgcolor="#FFFFCC"><font size="-2">
      <input type="text" name="ch3_product_id[]" value="<?php echo $this->_tpl_vars['ch3']['product_id']; ?>
"  size="20"/>
    </font></td>
    <td width="50" align="center" valign="middle" nowrap="nowrap" bgcolor="#FFFFCC"><strong><font color="#0000FF">開始</font></strong></td>
    <td width="366" align="center" valign="middle" nowrap="nowrap" bgcolor="#FFFFCC">
        <font size="-2"><strong>
        <?php echo smarty_function_html_options(array('name' => "ch3_syear[]",'options' => $this->_tpl_vars['ch3']['starting_year'],'selected' => $this->_tpl_vars['ch3']['selected_starting_year']), $this);?>

        年
           <?php echo smarty_function_html_options(array('name' => "ch3_smonth[]",'options' => $this->_tpl_vars['ch3']['starting_month'],'selected' => $this->_tpl_vars['ch3']['selected_starting_month']), $this);?>

        月
          <?php echo smarty_function_html_options(array('name' => "ch3_sday[]",'options' => $this->_tpl_vars['ch3']['starting_day'],'selected' => $this->_tpl_vars['ch3']['selected_starting_day']), $this);?>

          日
          <?php echo smarty_function_html_options(array('name' => "ch3_shour[]",'options' => $this->_tpl_vars['ch3']['starting_hour'],'selected' => $this->_tpl_vars['ch3']['selected_starting_hour']), $this);?>

          時          
          <?php echo smarty_function_html_options(array('name' => "ch3_sminute[]",'options' => $this->_tpl_vars['ch3']['starting_minute'],'selected' => $this->_tpl_vars['ch3']['selected_starting_minute']), $this);?>

          分          </strong></font></td>
    <td rowspan="2" align="center" nowrap="nowrap" bgcolor="#FFFFCC">
      <input type="text" name="ch3_number_sheet[]" value="<?php echo $this->_tpl_vars['ch3']['number_sheet']; ?>
" size="15"/>    </td>
    <td rowspan="2" align="center" nowrap="nowrap" bgcolor="#FFFFCC">
       <input type="text" name="ch3_num_box[]" value="<?php echo $this->_tpl_vars['ch3']['num_box']; ?>
" size="15"/>
    </td>
  </tr>
  <tr>
    <td align="center" valign="middle" nowrap="nowrap" bgcolor="#FFFFCC"><strong><font color="#0000FF">終了</font></strong></td>
    <td align="center" valign="middle" nowrap="nowrap" bgcolor="#FFFFCC">
        <font size="-2"><strong>
        <?php echo smarty_function_html_options(array('name' => "ch3_fyear[]",'options' => $this->_tpl_vars['ch3']['finishing_year'],'selected' => $this->_tpl_vars['ch3']['selected_finishing_year']), $this);?>

        年
           <?php echo smarty_function_html_options(array('name' => "ch3_fmonth[]",'options' => $this->_tpl_vars['ch3']['finishing_month'],'selected' => $this->_tpl_vars['ch3']['selected_finishing_month']), $this);?>

        月
          <?php echo smarty_function_html_options(array('name' => "ch3_fday[]",'options' => $this->_tpl_vars['ch3']['finishing_day'],'selected' => $this->_tpl_vars['ch3']['selected_finishing_day']), $this);?>

          日
          <?php echo smarty_function_html_options(array('name' => "ch3_fhour[]",'options' => $this->_tpl_vars['ch3']['finishing_hour'],'selected' => $this->_tpl_vars['ch3']['selected_finishing_hour']), $this);?>

          時          
          <?php echo smarty_function_html_options(array('name' => "ch3_fminute[]",'options' => $this->_tpl_vars['ch3']['finishing_minute'],'selected' => $this->_tpl_vars['ch3']['selected_finishing_minute']), $this);?>

          分          </strong></font></td>
  </tr>
<?php endforeach; endif; unset($_from); ?>
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
<?php $_from = $this->_tpl_vars['ch4']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)):
    foreach ($_from as $this->_tpl_vars['ch4']):
?>
  <tr>
    <td rowspan="2" align="center" nowrap="nowrap" bgcolor="#FFCCCC">
      <?php echo $this->_tpl_vars['ch2']['radio']; ?>

    </td>
    <td rowspan="2" align="center" nowrap="nowrap" bgcolor="#FFCCCC"><font size="-2">
      <input type="text" name="ch4_product_id[]" value="<?php echo $this->_tpl_vars['ch4']['product_id']; ?>
"  size="20"/>
    </font></td>
    <td width="50" align="center" valign="middle" nowrap="nowrap" bgcolor="#FFCCCC"><strong><font color="#0000FF">開始</font></strong></td>
    <td width="366" align="center" valign="middle" nowrap="nowrap" bgcolor="#FFCCCC">
        <font size="-2"><strong>
        <?php echo smarty_function_html_options(array('name' => "ch4_syear[]",'options' => $this->_tpl_vars['ch4']['starting_year'],'selected' => $this->_tpl_vars['ch4']['selected_starting_year']), $this);?>

        年
           <?php echo smarty_function_html_options(array('name' => "ch4_smonth[]",'options' => $this->_tpl_vars['ch4']['starting_month'],'selected' => $this->_tpl_vars['ch4']['selected_starting_month']), $this);?>

        月
          <?php echo smarty_function_html_options(array('name' => "ch4_sday[]",'options' => $this->_tpl_vars['ch4']['starting_day'],'selected' => $this->_tpl_vars['ch4']['selected_starting_day']), $this);?>

          日
          <?php echo smarty_function_html_options(array('name' => "ch4_shour[]",'options' => $this->_tpl_vars['ch4']['starting_hour'],'selected' => $this->_tpl_vars['ch4']['selected_starting_hour']), $this);?>

          時          
          <?php echo smarty_function_html_options(array('name' => "ch4_sminute[]",'options' => $this->_tpl_vars['ch4']['starting_minute'],'selected' => $this->_tpl_vars['ch4']['selected_starting_minute']), $this);?>

          分          </strong></font></td>
    <td rowspan="2" align="center" nowrap="nowrap" bgcolor="#FFCCCC">
      <input type="text" name="ch4_number_sheet[]" value="<?php echo $this->_tpl_vars['ch4']['number_sheet']; ?>
" size="15"/>    </td>
    <td rowspan="2" align="center" nowrap="nowrap" bgcolor="#FFCCCC">
       <input type="text" name="ch4_num_box[]" value="<?php echo $this->_tpl_vars['ch4']['num_box']; ?>
" size="15"/>
    </td>
  </tr>
  <tr>
    <td align="center" valign="middle" nowrap="nowrap" bgcolor="#FFCCCC"><strong><font color="#0000FF">終了</font></strong></td>
    <td align="center" valign="middle" nowrap="nowrap" bgcolor="#FFCCCC">
        <font size="-2"><strong>
        <?php echo smarty_function_html_options(array('name' => "ch4_fyear[]",'options' => $this->_tpl_vars['ch4']['finishing_year'],'selected' => $this->_tpl_vars['ch4']['selected_finishing_year']), $this);?>

        年
           <?php echo smarty_function_html_options(array('name' => "ch4_fmonth[]",'options' => $this->_tpl_vars['ch4']['finishing_month'],'selected' => $this->_tpl_vars['ch4']['selected_finishing_month']), $this);?>

        月
          <?php echo smarty_function_html_options(array('name' => "ch4_fday[]",'options' => $this->_tpl_vars['ch4']['finishing_day'],'selected' => $this->_tpl_vars['ch4']['selected_finishing_day']), $this);?>

          日
          <?php echo smarty_function_html_options(array('name' => "ch4_fhour[]",'options' => $this->_tpl_vars['ch4']['finishing_hour'],'selected' => $this->_tpl_vars['ch4']['selected_finishing_hour']), $this);?>

          時          
          <?php echo smarty_function_html_options(array('name' => "ch4_fminute[]",'options' => $this->_tpl_vars['ch4']['finishing_minute'],'selected' => $this->_tpl_vars['ch4']['selected_finishing_minute']), $this);?>

          分          </strong></font></td>
  </tr>
<?php endforeach; endif; unset($_from); ?>
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
<?php $_from = $this->_tpl_vars['ch5']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)):
    foreach ($_from as $this->_tpl_vars['ch5']):
?>
  <tr>
    <td rowspan="2" align="center" nowrap="nowrap" bgcolor="#FFFFCC">
      <?php echo $this->_tpl_vars['ch5']['radio']; ?>

    </td>
    <td rowspan="2" align="center" nowrap="nowrap" bgcolor="#FFFFCC"><font size="-2">
      <input type="text" name="ch5_product_id[]" value="<?php echo $this->_tpl_vars['ch5']['product_id']; ?>
"  size="20"/>
    </font></td>
    <td width="50" align="center" valign="middle" nowrap="nowrap" bgcolor="#FFFFCC"><strong><font color="#0000FF">開始</font></strong></td>
    <td width="366" align="center" valign="middle" nowrap="nowrap" bgcolor="#FFFFCC">
        <font size="-2"><strong>
        <?php echo smarty_function_html_options(array('name' => "ch5_syear[]",'options' => $this->_tpl_vars['ch5']['starting_year'],'selected' => $this->_tpl_vars['ch5']['selected_starting_year']), $this);?>

        年
           <?php echo smarty_function_html_options(array('name' => "ch5_smonth[]",'options' => $this->_tpl_vars['ch5']['starting_month'],'selected' => $this->_tpl_vars['ch5']['selected_starting_month']), $this);?>

        月
          <?php echo smarty_function_html_options(array('name' => "ch5_sday[]",'options' => $this->_tpl_vars['ch5']['starting_day'],'selected' => $this->_tpl_vars['ch5']['selected_starting_day']), $this);?>

          日
          <?php echo smarty_function_html_options(array('name' => "ch5_shour[]",'options' => $this->_tpl_vars['ch5']['starting_hour'],'selected' => $this->_tpl_vars['ch5']['selected_starting_hour']), $this);?>

          時          
          <?php echo smarty_function_html_options(array('name' => "ch5_sminute[]",'options' => $this->_tpl_vars['ch5']['starting_minute'],'selected' => $this->_tpl_vars['ch5']['selected_starting_minute']), $this);?>

          分          </strong></font></td>
    <td rowspan="2" align="center" nowrap="nowrap" bgcolor="#FFFFCC">
      <input type="text" name="ch5_number_sheet[]" value="<?php echo $this->_tpl_vars['ch5']['number_sheet']; ?>
" size="15"/>    </td>
    <td rowspan="2" align="center" nowrap="nowrap" bgcolor="#FFFFCC">
      <input type="text" name="ch5_num_box[]" value="<?php echo $this->_tpl_vars['ch5']['num_box']; ?>
" size="15"/>
    </td>
  </tr>
  <tr>
    <td align="center" valign="middle" nowrap="nowrap" bgcolor="#FFFFCC"><strong><font color="#0000FF">終了</font></strong></td>
    <td align="center" valign="middle" nowrap="nowrap" bgcolor="#FFFFCC">
        <font size="-2"><strong>
        <?php echo smarty_function_html_options(array('name' => "ch5_fyear[]",'options' => $this->_tpl_vars['ch5']['finishing_year'],'selected' => $this->_tpl_vars['ch5']['selected_finishing_year']), $this);?>

        年
           <?php echo smarty_function_html_options(array('name' => "ch5_fmonth[]",'options' => $this->_tpl_vars['ch5']['finishing_month'],'selected' => $this->_tpl_vars['ch5']['selected_finishing_month']), $this);?>

        月
          <?php echo smarty_function_html_options(array('name' => "ch5_fday[]",'options' => $this->_tpl_vars['ch5']['finishing_day'],'selected' => $this->_tpl_vars['ch5']['selected_finishing_day']), $this);?>

          日
          <?php echo smarty_function_html_options(array('name' => "ch5_fhour[]",'options' => $this->_tpl_vars['ch5']['finishing_hour'],'selected' => $this->_tpl_vars['ch5']['selected_finishing_hour']), $this);?>

          時          
          <?php echo smarty_function_html_options(array('name' => "ch5_fminute[]",'options' => $this->_tpl_vars['ch5']['finishing_minute'],'selected' => $this->_tpl_vars['ch5']['selected_finishing_minute']), $this);?>

          分          </strong></font></td>
  </tr>
<?php endforeach; endif; unset($_from); ?>
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
<?php $_from = $this->_tpl_vars['ch6']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)):
    foreach ($_from as $this->_tpl_vars['ch6']):
?>
  <tr>
    <td rowspan="2" align="center" nowrap="nowrap" bgcolor="#FFCCCC">
      <?php echo $this->_tpl_vars['ch2']['radio']; ?>

    </td>
    <td rowspan="2" align="center" nowrap="nowrap" bgcolor="#FFCCCC"><font size="-2">
      <input type="text" name="ch6_product_id[]" value="<?php echo $this->_tpl_vars['ch6']['product_id']; ?>
"  size="20"/>
    </font></td>
    <td width="50" align="center" valign="middle" nowrap="nowrap" bgcolor="#FFCCCC"><strong><font color="#0000FF">開始</font></strong></td>
    <td width="366" align="center" valign="middle" nowrap="nowrap" bgcolor="#FFCCCC">
        <font size="-2"><strong>
        <?php echo smarty_function_html_options(array('name' => "ch6_syear[]",'options' => $this->_tpl_vars['ch6']['starting_year'],'selected' => $this->_tpl_vars['ch6']['selected_starting_year']), $this);?>

        年
           <?php echo smarty_function_html_options(array('name' => "ch6_smonth[]",'options' => $this->_tpl_vars['ch6']['starting_month'],'selected' => $this->_tpl_vars['ch6']['selected_starting_month']), $this);?>

        月
          <?php echo smarty_function_html_options(array('name' => "ch6_sday[]",'options' => $this->_tpl_vars['ch6']['starting_day'],'selected' => $this->_tpl_vars['ch6']['selected_starting_day']), $this);?>

          日
          <?php echo smarty_function_html_options(array('name' => "ch6_shour[]",'options' => $this->_tpl_vars['ch6']['starting_hour'],'selected' => $this->_tpl_vars['ch6']['selected_starting_hour']), $this);?>

          時          
          <?php echo smarty_function_html_options(array('name' => "ch6_sminute[]",'options' => $this->_tpl_vars['ch6']['starting_minute'],'selected' => $this->_tpl_vars['ch6']['selected_starting_minute']), $this);?>

          分         </strong></font></td>
    <td rowspan="2" align="center" nowrap="nowrap" bgcolor="#FFCCCC">
      <input type="text" name="ch6_number_sheet[]" value="<?php echo $this->_tpl_vars['ch6']['number_sheet']; ?>
" size="15"/>    </td>
    <td rowspan="2" align="center" nowrap="nowrap" bgcolor="#FFCCCC">
       <input type="text" name="ch6_num_box[]" value="<?php echo $this->_tpl_vars['ch6']['num_box']; ?>
" size="15"/>
    </td>
  </tr>
  <tr>
    <td align="center" valign="middle" nowrap="nowrap" bgcolor="#FFCCCC"><strong><font color="#0000FF">終了</font></strong></td>
    <td align="center" valign="middle" nowrap="nowrap" bgcolor="#FFCCCC">
        <font size="-2"><strong>
        <?php echo smarty_function_html_options(array('name' => "ch6_fyear[]",'options' => $this->_tpl_vars['ch6']['finishing_year'],'selected' => $this->_tpl_vars['ch6']['selected_finishing_year']), $this);?>

        年
           <?php echo smarty_function_html_options(array('name' => "ch6_fmonth[]",'options' => $this->_tpl_vars['ch6']['finishing_month'],'selected' => $this->_tpl_vars['ch6']['selected_finishing_month']), $this);?>

        月
          <?php echo smarty_function_html_options(array('name' => "ch6_fday[]",'options' => $this->_tpl_vars['ch6']['finishing_day'],'selected' => $this->_tpl_vars['ch6']['selected_finishing_day']), $this);?>

          日
          <?php echo smarty_function_html_options(array('name' => "ch6_fhour[]",'options' => $this->_tpl_vars['ch6']['finishing_hour'],'selected' => $this->_tpl_vars['ch6']['selected_finishing_hour']), $this);?>

          時          
          <?php echo smarty_function_html_options(array('name' => "ch6_fminute[]",'options' => $this->_tpl_vars['ch6']['finishing_minute'],'selected' => $this->_tpl_vars['ch6']['selected_finishing_minute']), $this);?>

          分          </strong></font></td>
  </tr>
<?php endforeach; endif; unset($_from); ?>
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
<?php $_from = $this->_tpl_vars['ch7']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)):
    foreach ($_from as $this->_tpl_vars['ch7']):
?>
  <tr>
    <td rowspan="2" align="center" nowrap="nowrap" bgcolor="#FFFFCC">
      <?php echo $this->_tpl_vars['ch7']['radio']; ?>

    </td>
    <td rowspan="2" align="center" nowrap="nowrap" bgcolor="#FFFFCC"><font size="-2">
      <input type="text" name="ch7_product_id[]" value="<?php echo $this->_tpl_vars['ch7']['product_id']; ?>
"  size="20"/>
    </font></td>
    <td width="50" align="center" valign="middle" nowrap="nowrap" bgcolor="#FFFFCC"><strong><font color="#0000FF">開始</font></strong></td>
    <td width="366" align="center" valign="middle" nowrap="nowrap" bgcolor="#FFFFCC">
        <font size="-2"><strong>
        <?php echo smarty_function_html_options(array('name' => "ch7_syear[]",'options' => $this->_tpl_vars['ch7']['starting_year'],'selected' => $this->_tpl_vars['ch7']['selected_starting_year']), $this);?>

        年
           <?php echo smarty_function_html_options(array('name' => "ch7_smonth[]",'options' => $this->_tpl_vars['ch7']['starting_month'],'selected' => $this->_tpl_vars['ch7']['selected_starting_month']), $this);?>

        月
          <?php echo smarty_function_html_options(array('name' => "ch7_sday[]",'options' => $this->_tpl_vars['ch7']['starting_day'],'selected' => $this->_tpl_vars['ch7']['selected_starting_day']), $this);?>

          日
          <?php echo smarty_function_html_options(array('name' => "ch7_shour[]",'options' => $this->_tpl_vars['ch7']['starting_hour'],'selected' => $this->_tpl_vars['ch7']['selected_starting_hour']), $this);?>

          時          
          <?php echo smarty_function_html_options(array('name' => "ch7_sminute[]",'options' => $this->_tpl_vars['ch7']['starting_minute'],'selected' => $this->_tpl_vars['ch7']['selected_starting_minute']), $this);?>

          分          </strong></font></td>
    <td rowspan="2" align="center" nowrap="nowrap" bgcolor="#FFFFCC">
      <input type="text" name="ch7_number_sheet[]" value="<?php echo $this->_tpl_vars['ch7']['number_sheet']; ?>
" size="15"/>    </td>
    <td rowspan="2" align="center" nowrap="nowrap" bgcolor="#FFFFCC">
       <input type="text" name="ch7_num_box[]" value="<?php echo $this->_tpl_vars['ch7']['num_box']; ?>
" size="15"/>
    </td>
  </tr>
  <tr>
    <td align="center" valign="middle" nowrap="nowrap" bgcolor="#FFFFCC"><strong><font color="#0000FF">終了</font></strong></td>
    <td align="center" valign="middle" nowrap="nowrap" bgcolor="#FFFFCC">
        <font size="-2"><strong>
        <?php echo smarty_function_html_options(array('name' => "ch7_fyear[]",'options' => $this->_tpl_vars['ch7']['finishing_year'],'selected' => $this->_tpl_vars['ch7']['selected_finishing_year']), $this);?>

        年
           <?php echo smarty_function_html_options(array('name' => "ch7_fmonth[]",'options' => $this->_tpl_vars['ch7']['finishing_month'],'selected' => $this->_tpl_vars['ch7']['selected_finishing_month']), $this);?>

        月
          <?php echo smarty_function_html_options(array('name' => "ch7_fday[]",'options' => $this->_tpl_vars['ch7']['finishing_day'],'selected' => $this->_tpl_vars['ch7']['selected_finishing_day']), $this);?>

          日
          <?php echo smarty_function_html_options(array('name' => "ch7_fhour[]",'options' => $this->_tpl_vars['ch7']['finishing_hour'],'selected' => $this->_tpl_vars['ch7']['selected_finishing_hour']), $this);?>

          時          
          <?php echo smarty_function_html_options(array('name' => "ch7_fminute[]",'options' => $this->_tpl_vars['ch7']['finishing_minute'],'selected' => $this->_tpl_vars['ch7']['selected_finishing_minute']), $this);?>

          分          </strong></font></td>
  </tr>
<?php endforeach; endif; unset($_from); ?>
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
<?php $_from = $this->_tpl_vars['ch8']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)):
    foreach ($_from as $this->_tpl_vars['ch8']):
?>
  <tr>
    <td rowspan="2" align="center" nowrap="nowrap" bgcolor="#FFCCCC">
      <?php echo $this->_tpl_vars['ch2']['radio']; ?>

    </td>
    <td rowspan="2" align="center" nowrap="nowrap" bgcolor="#FFCCCC"><font size="-2">
      <input type="text" name="ch8_product_id[]" value="<?php echo $this->_tpl_vars['ch8']['product_id']; ?>
"  size="20"/>
    </font></td>
    <td width="50" align="center" valign="middle" nowrap="nowrap" bgcolor="#FFCCCC"><strong><font color="#0000FF">開始</font></strong></td>
    <td width="366" align="center" valign="middle" nowrap="nowrap" bgcolor="#FFCCCC">
        <font size="-2"><strong>
        <?php echo smarty_function_html_options(array('name' => "ch8_syear[]",'options' => $this->_tpl_vars['ch8']['starting_year'],'selected' => $this->_tpl_vars['ch8']['selected_starting_year']), $this);?>

        年
           <?php echo smarty_function_html_options(array('name' => "ch8_smonth[]",'options' => $this->_tpl_vars['ch8']['starting_month'],'selected' => $this->_tpl_vars['ch8']['selected_starting_month']), $this);?>

        月
          <?php echo smarty_function_html_options(array('name' => "ch8_sday[]",'options' => $this->_tpl_vars['ch8']['starting_day'],'selected' => $this->_tpl_vars['ch8']['selected_starting_day']), $this);?>

          日
          <?php echo smarty_function_html_options(array('name' => "ch8_shour[]",'options' => $this->_tpl_vars['ch8']['starting_hour'],'selected' => $this->_tpl_vars['ch8']['selected_starting_hour']), $this);?>

          時          
          <?php echo smarty_function_html_options(array('name' => "ch8_sminute[]",'options' => $this->_tpl_vars['ch8']['starting_minute'],'selected' => $this->_tpl_vars['ch8']['selected_starting_minute']), $this);?>

          分          </strong></font></td>
    <td rowspan="2" align="center" nowrap="nowrap" bgcolor="#FFCCCC"><input type="text" name="ch8_number_sheet[]" value="<?php echo $this->_tpl_vars['ch8']['number_sheet']; ?>
" size="15"/></td>
    <td rowspan="2" align="center" nowrap="nowrap" bgcolor="#FFCCCC">
        <input type="text" name="ch8_num_box[]" value="<?php echo $this->_tpl_vars['ch8']['num_box']; ?>
" size="15"/>
    </td>
  <tr>
    <td align="center" valign="middle" nowrap="nowrap" bgcolor="#FFCCCC"><strong><font color="#0000FF">終了</font></strong></td>
    <td align="center" valign="middle" nowrap="nowrap" bgcolor="#FFCCCC">
        <font size="-2"><strong>
        <?php echo smarty_function_html_options(array('name' => "ch8_fyear[]",'options' => $this->_tpl_vars['ch8']['finishing_year'],'selected' => $this->_tpl_vars['ch8']['selected_finishing_year']), $this);?>

        年
           <?php echo smarty_function_html_options(array('name' => "ch8_fmonth[]",'options' => $this->_tpl_vars['ch8']['finishing_month'],'selected' => $this->_tpl_vars['ch8']['selected_finishing_month']), $this);?>

        月
          <?php echo smarty_function_html_options(array('name' => "ch8_fday[]",'options' => $this->_tpl_vars['ch8']['finishing_day'],'selected' => $this->_tpl_vars['ch8']['selected_finishing_day']), $this);?>

          日
          <?php echo smarty_function_html_options(array('name' => "ch8_fhour[]",'options' => $this->_tpl_vars['ch8']['finishing_hour'],'selected' => $this->_tpl_vars['ch8']['selected_finishing_hour']), $this);?>

          時          
          <?php echo smarty_function_html_options(array('name' => "ch8_fminute[]",'options' => $this->_tpl_vars['ch8']['finishing_minute'],'selected' => $this->_tpl_vars['ch8']['selected_finishing_minute']), $this);?>

          分          </strong></font></td>
  </tr>
<?php endforeach; endif; unset($_from); ?>
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
<?php $_from = $this->_tpl_vars['ch9']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)):
    foreach ($_from as $this->_tpl_vars['ch9']):
?>
  <tr>
    <td rowspan="2" align="center" nowrap="nowrap" bgcolor="#FFFFCC">
      <?php echo $this->_tpl_vars['ch9']['radio']; ?>

    </td>
    <td rowspan="2" align="center" nowrap="nowrap" bgcolor="#FFFFCC"><font size="-2">
      <input type="text" name="ch9_product_id[]" value="<?php echo $this->_tpl_vars['ch9']['product_id']; ?>
"  size="20"/>
    </font></td>
    <td width="50" align="center" valign="middle" nowrap="nowrap" bgcolor="#FFFFCC"><strong><font color="#0000FF">開始</font></strong></td>
    <td width="366" align="center" valign="middle" nowrap="nowrap" bgcolor="#FFFFCC">
        <font size="-2"><strong>
        <?php echo smarty_function_html_options(array('name' => "ch9_syear[]",'options' => $this->_tpl_vars['ch9']['starting_year'],'selected' => $this->_tpl_vars['ch9']['selected_starting_year']), $this);?>

        年
           <?php echo smarty_function_html_options(array('name' => "ch9_smonth[]",'options' => $this->_tpl_vars['ch9']['starting_month'],'selected' => $this->_tpl_vars['ch9']['selected_starting_month']), $this);?>

        月
          <?php echo smarty_function_html_options(array('name' => "ch9_sday[]",'options' => $this->_tpl_vars['ch9']['starting_day'],'selected' => $this->_tpl_vars['ch9']['selected_starting_day']), $this);?>

          日
          <?php echo smarty_function_html_options(array('name' => "ch9_shour[]",'options' => $this->_tpl_vars['ch9']['starting_hour'],'selected' => $this->_tpl_vars['ch9']['selected_starting_hour']), $this);?>

          時          
          <?php echo smarty_function_html_options(array('name' => "ch9_sminute[]",'options' => $this->_tpl_vars['ch9']['starting_minute'],'selected' => $this->_tpl_vars['ch9']['selected_starting_minute']), $this);?>

          分          </strong></font></td>
    <td rowspan="2" align="center" nowrap="nowrap" bgcolor="#FFFFCC">
      <input type="text" name="ch9_number_sheet[]" value="<?php echo $this->_tpl_vars['ch9']['number_sheet']; ?>
" size="15"/>    </td>
    <td rowspan="2" align="center" nowrap="nowrap" bgcolor="#FFFFCC">
      <input type="text" name="ch9_num_box[]" value="<?php echo $this->_tpl_vars['ch9']['num_box']; ?>
" size="15"/>
    </td>
  </tr>
  <tr>
    <td align="center" valign="middle" nowrap="nowrap" bgcolor="#FFFFCC"><strong><font color="#0000FF">終了</font></strong></td>
    <td align="center" valign="middle" nowrap="nowrap" bgcolor="#FFFFCC">
        <font size="-2"><strong>
        <?php echo smarty_function_html_options(array('name' => "ch9_fyear[]",'options' => $this->_tpl_vars['ch9']['finishing_year'],'selected' => $this->_tpl_vars['ch9']['selected_finishing_year']), $this);?>

        年
           <?php echo smarty_function_html_options(array('name' => "ch9_fmonth[]",'options' => $this->_tpl_vars['ch9']['finishing_month'],'selected' => $this->_tpl_vars['ch9']['selected_finishing_month']), $this);?>

        月
          <?php echo smarty_function_html_options(array('name' => "ch9_fday[]",'options' => $this->_tpl_vars['ch9']['finishing_day'],'selected' => $this->_tpl_vars['ch9']['selected_finishing_day']), $this);?>

          日
          <?php echo smarty_function_html_options(array('name' => "ch9_fhour[]",'options' => $this->_tpl_vars['ch9']['finishing_hour'],'selected' => $this->_tpl_vars['ch9']['selected_finishing_hour']), $this);?>

          時          
          <?php echo smarty_function_html_options(array('name' => "ch9_fminute[]",'options' => $this->_tpl_vars['ch9']['finishing_minute'],'selected' => $this->_tpl_vars['ch9']['selected_finishing_minute']), $this);?>

          分          </strong></font></td>
  </tr>
<?php endforeach; endif; unset($_from); ?>
</table>
<Div align="right"><input type="submit" name="ch9_addition" id="button" value="追加" /><input type="submit" name="ch9_deletion" id="button" value="削除" /></Div>
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