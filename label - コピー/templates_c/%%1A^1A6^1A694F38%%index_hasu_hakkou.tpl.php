<?php /* Smarty version 2.6.26, created on 2013-09-07 15:30:56
         compiled from index_hasu_hakkou.tpl */ ?>
<?php require_once(SMARTY_CORE_DIR . 'core.load_plugins.php');
smarty_core_load_plugins(array('plugins' => array(array('function', 'html_options', 'index_hasu_hakkou.tpl', 31, false),)), $this); ?>
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
<form action="kakunin_hasu.php" method="post">
  <tr valign="middle" bordercolor="#CCCCCC">
    <td bgcolor="#E1FDFB"><hr>
<?php echo $this->_tpl_vars['semi_header']; ?>

<hr />
<br />
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
          </strong></font>
    </td>
    </tr>
</table>
</form>
<br>
<br />
</td>
<hr>
  </tr>
</table>
</body>
</html>