<?php /* Smarty version 2.6.26, created on 2013-09-07 09:37:50
         compiled from form_kobetsu_seikei_t.tpl */ ?>
<?php require_once(SMARTY_CORE_DIR . 'core.load_plugins.php');
smarty_core_load_plugins(array('plugins' => array(array('function', 'html_options', 'form_kobetsu_seikei_t.tpl', 39, false),)), $this); ?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=SHIFT_JIS" />
<!-- TemplateBeginEditable name="doctitle" -->
<title>����h�L�������g</title>
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
<form action="kakunin_kobetsu_seikei_t.php" method="post">
  <tr valign="middle" bordercolor="#CCCCCC">
    <td bgcolor="#E1FDFB"><hr>
<?php echo $this->_tpl_vars['semi_header']; ?>

  <hr />
<Div align="right"><input type="submit" name="addition" id="button" value="�ǉ�" /><input type="submit" name="deletion" id="button" value="�폜" /></Div>
<table width=800 border="0" align="center" bordercolor="#333333" bgcolor="#666666">
  <tr>
    <td width="25" align="center" bgcolor="#FFFFCC"><strong><font color="#0000FF"></font></strong></td>
    <td width="108" align="center" nowrap="nowrap" bgcolor="#FFFFCC"><font color="#0000FF"><strong>�i��</strong></font></td>
    <td colspan="2" align="center" valign="middle" nowrap="nowrap" bgcolor="#FFFFCC"><font color="#0000FF"><strong>���`����</strong></font></td>
  </tr>
<?php $_from = $this->_tpl_vars['data']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)):
    foreach ($_from as $this->_tpl_vars['id']):
?>
  <tr>
    <td rowspan="2" align="center" bgcolor="#FFFFCC"><strong><?php echo $this->_tpl_vars['id']['radio']; ?>
</strong></td>
    <td rowspan="2" align="center" nowrap="nowrap" bgcolor="#FFFFCC"><font size="-2">
      <input type="text" name="product_id[]" value="<?php echo $this->_tpl_vars['id']['product_id']; ?>
"  size="20"/>
    </font></td>
    <td width="50" align="center" valign="middle" nowrap="nowrap" bgcolor="#FFFFCC"><strong><font color="#0000FF">�J�n</font></strong></td>
    <td width="366" align="center" valign="middle" nowrap="nowrap" bgcolor="#FFFFCC">
        <font size="-2"><strong>
        <?php echo smarty_function_html_options(array('name' => "syear[]",'options' => $this->_tpl_vars['id']['starting_year'],'selected' => $this->_tpl_vars['id']['selected_starting_year']), $this);?>

        �N
           <?php echo smarty_function_html_options(array('name' => "smonth[]",'options' => $this->_tpl_vars['id']['starting_month'],'selected' => $this->_tpl_vars['id']['selected_starting_month']), $this);?>

        ��
          <?php echo smarty_function_html_options(array('name' => "sday[]",'options' => $this->_tpl_vars['id']['starting_day'],'selected' => $this->_tpl_vars['id']['selected_starting_day']), $this);?>

          ��
          <?php echo smarty_function_html_options(array('name' => "shour[]",'options' => $this->_tpl_vars['id']['starting_hour'],'selected' => $this->_tpl_vars['id']['selected_starting_hour']), $this);?>

          ��          
          <?php echo smarty_function_html_options(array('name' => "sminute[]",'options' => $this->_tpl_vars['id']['starting_minute'],'selected' => $this->_tpl_vars['id']['selected_starting_minute']), $this);?>

          ��          </strong></font></td>
  </tr>
  <tr>
    <td align="center" valign="middle" nowrap="nowrap" bgcolor="#FFFFCC"><strong><font color="#0000FF">�I��</font></strong></td>
    <td align="center" valign="middle" nowrap="nowrap" bgcolor="#FFFFCC">
        <font size="-2"><strong>
        <?php echo smarty_function_html_options(array('name' => "fyear[]",'options' => $this->_tpl_vars['id']['finishing_year'],'selected' => $this->_tpl_vars['id']['selected_finishing_year']), $this);?>

        �N
           <?php echo smarty_function_html_options(array('name' => "fmonth[]",'options' => $this->_tpl_vars['id']['finishing_month'],'selected' => $this->_tpl_vars['id']['selected_finishing_month']), $this);?>

        ��
          <?php echo smarty_function_html_options(array('name' => "fday[]",'options' => $this->_tpl_vars['id']['finishing_day'],'selected' => $this->_tpl_vars['id']['selected_finishing_day']), $this);?>

          ��
          <?php echo smarty_function_html_options(array('name' => "fhour[]",'options' => $this->_tpl_vars['id']['finishing_hour'],'selected' => $this->_tpl_vars['id']['selected_finishing_hour']), $this);?>

          ��          
          <?php echo smarty_function_html_options(array('name' => "fminute[]",'options' => $this->_tpl_vars['id']['finishing_minute'],'selected' => $this->_tpl_vars['id']['selected_finishing_minute']), $this);?>

          ��         </strong></font></td>
  </tr>
<?php endforeach; endif; unset($_from); ?>
</table>

<p align="right">
<?php echo $this->_tpl_vars['value']; ?>

<input type="hidden" name="year" value="<?php echo $this->_tpl_vars['year']; ?>
" size="15"/>
<input type="hidden" name="month" value="<?php echo $this->_tpl_vars['month']; ?>
" size="15"/>
<input type="hidden" name="day" value="<?php echo $this->_tpl_vars['day']; ?>
" size="15"/>
                <label><font color="#FFFFCC"></font>
                <input type="submit" name="touroku" id="button" value="�o�^" />
        </label>
    </form>
</p>
</td>
    <hr />  
  </tr>
</table>
</body>
</html>