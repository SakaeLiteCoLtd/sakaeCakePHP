<?php /* Smarty version 2.6.7, created on 2013-09-09 23:03:16
         compiled from index_import_lot.tpl */ ?>
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
    <td align="center"><a href="index_import_lot.php"><img src="../img/lot_rireki_torikomi.gif" alt="lot_rireki_torikomi" width="83" height="37" border="0"/></a></td>
    <td align="center"><a href="index_lot_fushiyou.php"><img src="../img/label_fushiyou.gif" alt="label_fushiyou" width="83" height="37" border="0"/></a></td>
    <td align="center"><a href="index_touroku_hasu.php"><img src="../img/label_hasu.gif" alt="label_hasu" width="83" height="37" border="0"/></a></td>
    <td align="center"><a href="index_kensaku_lot.php"><img src="../img/label_kensaku_lot.gif" alt="kensaku_lot" width="83" height="37" border="0"/></a></td>
  </tr>
</table>
<br />
<br />
<form action="rs_import_tab.php" method="post" enctype="multipart/form-data">
<table width=500 border="0" align="center" bordercolor="#333333" bgcolor="#666666">
  <tr>
    <td width="131" align="center" nowrap="nowrap" bgcolor="#FFFFCC"><font color="#0000FF"><strong>読込ファイル</strong></font></td>
    <td width="128" align="center" valign="middle" nowrap="nowrap" bgcolor="#FFFFCC">
      <BLOCKQUOTE>
        <INPUT TYPE="file" NAME="file"></BLOCKQUOTE>    </td>
    <td width="129" align="center" bgcolor="#FFFFCC"><label>
  <input type="submit" name="button" id="button" value="取込" />
  </label></td>
  </tr>
</table>
</form>
<br />
<?php echo $this->_tpl_vars['value']; ?>

<br />
</td>
    <hr />  
  </tr>
</table>
</body>
</html>