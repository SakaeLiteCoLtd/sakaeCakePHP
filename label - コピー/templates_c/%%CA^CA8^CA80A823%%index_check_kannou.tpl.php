<?php /* Smarty version 2.6.26, created on 2013-09-15 23:08:11
         compiled from index_check_kannou.tpl */ ?>
<?php require_once(SMARTY_CORE_DIR . 'core.load_plugins.php');
smarty_core_load_plugins(array('plugins' => array(array('function', 'html_options', 'index_check_kannou.tpl', 38, false),)), $this); ?>
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
<form action="rs_check_kannou.php" method="post">
  <tr valign="middle" bordercolor="#CCCCCC">
    <td bgcolor="#E1FDFB"><hr>
<?php echo $this->_tpl_vars['semi_header']; ?>

<hr />
<table width="800" border="0">
  <tr>
    <td align="center"><a href="index_jyoukyou.php"><img src="../img/label_jyoukyou.gif" alt="label_jyoukyou" width="83" height="37" border="0"/></a></td>
    <td align="center"><a href="index_check_kannou.php"><img src="../img/label_kannou.gif" alt="label_kannou" width="83" height="37" border="0"/></a></td>
  </tr>
</table>
<br>
<br>
<table width="500" align="center" border="0" bordercolor="#666666" bgcolor="#666666">
  <tr>
    <td align="center" bgcolor="#FFFFCC"><strong><font color="#0000FF">完納未納日程絞込み</font></strong></td>
    <td rowspan="2" align="center" bgcolor="#FFFFCC"><input type="submit" name="target" id="button" value="日程絞込" /></td>
  </tr>
  <tr>
    <td height="17" align="center" bgcolor="#FFFFCC"><font size="-2"><strong>
        <?php echo smarty_function_html_options(array('name' => 'syear','options' => $this->_tpl_vars['syear'],'selected' => $this->_tpl_vars['selected_syear']), $this);?>

        年
           <?php echo smarty_function_html_options(array('name' => 'smonth','options' => $this->_tpl_vars['smonth'],'selected' => $this->_tpl_vars['selected_smonth']), $this);?>

        月
          <?php echo smarty_function_html_options(array('name' => 'sday','options' => $this->_tpl_vars['sday'],'selected' => $this->_tpl_vars['selected_sday']), $this);?>

          日～
        <?php echo smarty_function_html_options(array('name' => 'fyear','options' => $this->_tpl_vars['fyear'],'selected' => $this->_tpl_vars['selected_fyear']), $this);?>

        年
           <?php echo smarty_function_html_options(array('name' => 'fmonth','options' => $this->_tpl_vars['fmonth'],'selected' => $this->_tpl_vars['selected_fmonth']), $this);?>

        月
          <?php echo smarty_function_html_options(array('name' => 'fday','options' => $this->_tpl_vars['fday'],'selected' => $this->_tpl_vars['selected_fday']), $this);?>

          日
          </strong></font>
    </td>
    </tr>
</table>
<br />
<?php echo $this->_tpl_vars['rs_text']; ?>

<?php echo $this->_tpl_vars['pre_table']; ?>

<?php $_from = $this->_tpl_vars['arr_table']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)):
    foreach ($_from as $this->_tpl_vars['id']):
?>
    <?php echo $this->_tpl_vars['id']['row']; ?>

<?php endforeach; endif; unset($_from); ?>
<?php echo $this->_tpl_vars['last_table']; ?>

<br />
<?php $_from = $this->_tpl_vars['arr_mikan']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)):
    foreach ($_from as $this->_tpl_vars['id']):
?>
    <?php echo $this->_tpl_vars['id']['product_id']; ?>
---<?php echo $this->_tpl_vars['id']['mikan_amount']; ?>
<br />
<?php endforeach; endif; unset($_from); ?>

</form>
<br>
<br />
</td>
<hr>
  </tr>
</table>
</body>
</html>