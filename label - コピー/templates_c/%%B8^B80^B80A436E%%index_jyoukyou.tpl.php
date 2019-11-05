<?php /* Smarty version 2.6.26, created on 2013-09-19 16:27:43
         compiled from index_jyoukyou.tpl */ ?>
<?php require_once(SMARTY_CORE_DIR . 'core.load_plugins.php');
smarty_core_load_plugins(array('plugins' => array(array('function', 'html_options', 'index_jyoukyou.tpl', 38, false),)), $this); ?>
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
<form action="index_jyoukyou.php" method="post">
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
<br />
<br />
<table width="350" border="0" align="center" bordercolor="#333333" bgcolor="#666666">
  <tr>
    <td width="350" align="center" nowrap="nowrap" bgcolor="#FFFFCC"><font color="#0000FF"><strong>納入日</strong></font></td>
  </tr>
  <tr>
    <td align="center" valign="middle" nowrap="nowrap" bgcolor="#FFFFCC">
        <font size="-2"><strong>
        <?php echo smarty_function_html_options(array('name' => 'year','options' => $this->_tpl_vars['starting_year'],'selected' => $this->_tpl_vars['selected_starting_year']), $this);?>

        年
           <?php echo smarty_function_html_options(array('name' => 'month','options' => $this->_tpl_vars['starting_month'],'selected' => $this->_tpl_vars['selected_starting_month']), $this);?>

        月
          <?php echo smarty_function_html_options(array('name' => 'day','options' => $this->_tpl_vars['starting_day'],'selected' => $this->_tpl_vars['selected_starting_day']), $this);?>

          日
        </strong></font>
        <label><font color="#FFFFCC"></font><input type="submit" name="kakunin" id="button" value="確認" /></label>
     </td>
  </tr>
</table>
<br />
<?php $_from = $this->_tpl_vars['buttons']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)):
    foreach ($_from as $this->_tpl_vars['id']):
?>
<?php echo $this->_tpl_vars['id']['button']; ?>

<br />
<br />
<?php endforeach; endif; unset($_from); ?>
<?php echo $this->_tpl_vars['value']; ?>

</form>
</p>
</td>
    <hr />  
  </tr>
</table>
</body>
</html>