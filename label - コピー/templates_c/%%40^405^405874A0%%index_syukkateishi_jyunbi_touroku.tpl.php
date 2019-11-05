<?php /* Smarty version 2.6.26, created on 2015-01-31 05:46:43
         compiled from index_syukkateishi_jyunbi_touroku.tpl */ ?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=SHIFT_JIS" />
<!-- TemplateBeginEditable name="doctitle" -->
<title>無題ドキュメント</title>
<!-- TemplateEndEditable -->
<!-- TemplateBeginEditable name="head" --><!-- TemplateEndEditable -->
</head>
<script type = "text/javascript">
 <?php echo '
  window.onload = function(){document.getElementById("qrText").focus()}
 '; ?>

</script>
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
<?php echo $this->_tpl_vars['semi_zensu_jikkou_header']; ?>

<br />
<form action="form_syukkateishi_jyunbi_touroku.php" method="post">
  <p align="center" ><strong><font color="#0000FF">出荷停止　社員ID登録</font></strong></p>
  <table width="350" border="0" align="center" bgcolor="#666666">
    <tr>
      <td width="100" bgcolor="#FFFFCC"><div align="center" class="style1"><strong><font color="#0000FF">社員ID</font></strong></div></td>
      <td bgcolor="#FFFFCC"><div align="center"><input type="text" name="emp_id" id="qrText" value="" size="30" autocomplete="off"/></div></td>
    </tr>
  </table>
<br>
</form>
<br />
<?php echo $this->_tpl_vars['mess']; ?>

</td>
    <hr />  
  </tr>
</table>
</body>
</html>