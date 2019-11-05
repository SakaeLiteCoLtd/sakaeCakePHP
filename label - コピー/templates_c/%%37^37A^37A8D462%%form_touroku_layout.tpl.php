<?php /* Smarty version 2.6.26, created on 2013-09-07 15:30:36
         compiled from form_touroku_layout.tpl */ ?>
<?php require_once(SMARTY_CORE_DIR . 'core.load_plugins.php');
smarty_core_load_plugins(array('plugins' => array(array('function', 'html_options', 'form_touroku_layout.tpl', 41, false),)), $this); ?>
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
    <td bgcolor="#E6FFFF"><p><img src="../img/logo.gif" width="157" height="22" /></p>
	<?php echo $this->_tpl_vars['header']; ?>

    </td>
  </tr>
  <tr valign="middle" bordercolor="#CCCCCC">
    <td bgcolor="#E6FFFF"><!-- TemplateBeginEditable name="body" --><!-- TemplateEndEditable -->
  <hr>
<?php echo $this->_tpl_vars['semi_header']; ?>

<hr />
<br />
<table width="800" border="0">
  <tr>
    <td align="center"><a href="form_touroku_layout.php"><img src="../img/label_layout.gif" alt="csv" width="83" height="37" border="0"/></a></td>
    <td align="center"><a href="form_touroku_place.php"><img src="../img/label_touroku_place.gif" alt="csv" width="83" height="37" border="0"/></a></td>
    <td align="center"><a href="form_touroku_unit.php"><img src="../img/label_touroku_unit.gif" alt="csv" width="83" height="37" border="0"/></a></td>
  </tr>
</table>
  <hr>
<form action="place_touroku_layout.php" method="post">
  <p align="center" ><strong><font color="#0000FF">ラベル製品登録</font></strong></p>
  <table width="350" border="0" align="center" bgcolor="#666666">
    <tr>
      <td width="100" bgcolor="#FFFFCC"><div align="center" class="style1"><strong><font color="#0000FF">品番</font></strong></div></td>
      <td bgcolor="#FFFFCC"><div align="center"><input type="text" name="product" value="<?php echo $this->_tpl_vars['product']; ?>
" size="30"/></div></td>
    </tr>
    <tr>
      <td width="100" bgcolor="#FFFFCC"><div align="center" class="style1"><strong><font color="#0000FF">ラベルタイプ</font></strong></div></td>
      <td bgcolor="#FFFFCC"><div align="center"><?php echo smarty_function_html_options(array('name' => 'type_label','options' => $this->_tpl_vars['type_label'],'selected' => $this->_tpl_vars['type_label']), $this);?>
</div></td>
    </tr>
  </table>
<p><strong><font color="#FF0000"><?php echo $this->_tpl_vars['mess']; ?>
</font></strong><p/>
<p align="center">
<label>
<input type="submit" name="button" id="button" value="納品場所登録画面" />
</label>
</p>
<br>
</form>

<br />
</td>
    <hr />  
  </tr>
</table>
</body>
</html>