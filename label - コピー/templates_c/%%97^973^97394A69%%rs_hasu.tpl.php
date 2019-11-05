<?php /* Smarty version 2.6.26, created on 2014-10-08 19:10:27
         compiled from rs_hasu.tpl */ ?>
<?php require_once(SMARTY_CORE_DIR . 'core.load_plugins.php');
smarty_core_load_plugins(array('plugins' => array(array('function', 'html_options', 'rs_hasu.tpl', 31, false),)), $this); ?>
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
  <tr valign="middle" bordercolor="#CCCCCC">
    <td bgcolor="#E1FDFB"><hr>
<?php echo $this->_tpl_vars['semi_header']; ?>

<hr />
<br />
<form action="kakunin_hasu.php" method="post">
<table width="500" border="0" align="center" bordercolor="#666666" bgcolor="#666666">
  <tr>
    <td align="center" bgcolor="#FFFFCC"><strong><font color="#0000FF">納入日指定</font></strong></td>
    <td rowspan="2" align="center" bgcolor="#FFFFCC"><input type="submit" name="target" id="button" value="呼出" /></td>
  </tr>
  <tr>
    <td height="17" align="center" bgcolor="#FFFFCC"><font size="-2"><strong>
        <?php echo smarty_function_html_options(array('name' => 'year','options' => $this->_tpl_vars['syear'],'selected' => $this->_tpl_vars['selected_syear']), $this);?>

        年
           <?php echo smarty_function_html_options(array('name' => 'month','options' => $this->_tpl_vars['smonth'],'selected' => $this->_tpl_vars['selected_smonth']), $this);?>

        月
          <?php echo smarty_function_html_options(array('name' => 'day','options' => $this->_tpl_vars['sday'],'selected' => $this->_tpl_vars['selected_sday']), $this);?>

          日
          </strong><input type="hidden" name="date_deliver" value="<?php echo $this->_tpl_vars['date_deliver']; ?>
" ></font>
    </td>
    </tr>
</table>
<p align="right"><input type="submit" name="all_check" id="button" value="全てチェック" /></p>
<p align="right"><input type="submit" name="un_check" id="button" value="全てのチェックをはずす" /></p>
<table width="800" border="0" align="center" bordercolor="#666666" bgcolor="#666666">
  <tr>
    <td width="25" align="center" bgcolor="#FFFFCC"><strong><font color="#0000FF"></font></strong></td>
    <td width="100" align="center" bgcolor="#FFFFCC"><strong><font color="#0000FF">品番</font></strong></td>
    <td width="150" align="center" bgcolor="#FFFFCC"><strong><font color="#0000FF">品名</font></strong></td>
    <td width="100" align="center" bgcolor="#FFFFCC"><strong><font color="#0000FF">端数</font></strong></td>
  </tr>
<?php $_from = $this->_tpl_vars['arr_hasu_box']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)):
    foreach ($_from as $this->_tpl_vars['id']):
?>
  <tr>
    <td height="17" align="center" bgcolor="#FFFFCC"><strong><?php echo $this->_tpl_vars['id']['radio']; ?>
</strong></td>
    <td height="17" align="center" bgcolor="#FFFFCC"><strong><?php echo $this->_tpl_vars['id']['product_id']; ?>
</strong><input type="hidden" name="product_id[]" value="<?php echo $this->_tpl_vars['id']['product_id']; ?>
" ></td>
    <td height="17" align="center" bgcolor="#FFFFCC" nowrap><strong><?php echo $this->_tpl_vars['id']['product_name']; ?>
</strong><input type="hidden" name="product_name[]" value="<?php echo $this->_tpl_vars['id']['product_name']; ?>
" ></td>
   <td height="17" align="center" bgcolor="#FFFFCC" nowrap><strong><?php echo $this->_tpl_vars['id']['hasu']; ?>
</strong><input type="hidden" name="hasu[]" value="<?php echo $this->_tpl_vars['id']['hasu']; ?>
" size="15" /></td>
    </tr>
<?php endforeach; endif; unset($_from); ?>
</table>
<label>
  <input type="submit" name="rs_csv" id="button" value="CSV登録準備" />
  </label>
</form>
<br>
<?php echo $this->_tpl_vars['value']; ?>

<br />
</td>
<hr>
  </tr>
</table>
</body>
</html>