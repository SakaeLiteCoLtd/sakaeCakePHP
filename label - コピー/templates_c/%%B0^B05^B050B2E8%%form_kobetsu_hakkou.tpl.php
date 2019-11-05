<?php /* Smarty version 2.6.26, created on 2013-09-07 12:58:35
         compiled from form_kobetsu_hakkou.tpl */ ?>
<?php require_once(SMARTY_CORE_DIR . 'core.load_plugins.php');
smarty_core_load_plugins(array('plugins' => array(array('function', 'html_options', 'form_kobetsu_hakkou.tpl', 34, false),)), $this); ?>
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
<form action="kakunin_kobetsu_hakkou.php" method="post">
  <tr valign="middle" bordercolor="#CCCCCC">
    <td bgcolor="#E1FDFB"><hr>
<?php echo $this->_tpl_vars['semi_header']; ?>

  <hr />
<table width=500 border="0" align="center" bordercolor="#333333" bgcolor="#666666">
  <tr>
    <td width="150" align="center" bgcolor="#FFFFCC"><strong><font color="#0000FF">品番</font></strong></td>
    <td width="250" align="center" nowrap="nowrap" bgcolor="#FFFFCC"><font color="#0000FF"><strong>成形日</strong></font></td>
    <td width="100" align="center" valign="middle" nowrap="nowrap" bgcolor="#FFFFCC"><font color="#0000FF"><strong>箱NO.</strong></font></td>
  </tr>
<?php $_from = $this->_tpl_vars['data']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)):
    foreach ($_from as $this->_tpl_vars['id']):
?>
  <tr>
    <td align="center" nowrap="nowrap" bgcolor="#FFFFCC"><input type="text" name="product_id"  size="20"/></td>
    <td align="center" valign="middle" nowrap="nowrap" bgcolor="#FFFFCC">
        <font size="-2"><strong>
        <?php echo smarty_function_html_options(array('name' => 'year','options' => $this->_tpl_vars['id']['starting_year'],'selected' => $this->_tpl_vars['id']['selected_starting_year']), $this);?>

        年
           <?php echo smarty_function_html_options(array('name' => 'month','options' => $this->_tpl_vars['id']['starting_month'],'selected' => $this->_tpl_vars['id']['selected_starting_month']), $this);?>

        月
          <?php echo smarty_function_html_options(array('name' => 'day','options' => $this->_tpl_vars['id']['starting_day'],'selected' => $this->_tpl_vars['id']['selected_starting_day']), $this);?>

          日
        </strong></font>
     </td>
    <td align="center" nowrap="nowrap" bgcolor="#FFFFCC"><input type="text" name="num_box"  size="20"/></td>
  </tr>
<?php endforeach; endif; unset($_from); ?>
</table>

<p align="right">
<?php echo $this->_tpl_vars['value']; ?>

<label><font color="#FFFFCC"></font><input type="submit" name="touroku" id="button" value="登録" /></label>
</form>
</p>
</td>
    <hr />  
  </tr>
</table>
</body>
</html>