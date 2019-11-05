<?php /* Smarty version 2.6.26, created on 2015-01-31 05:51:19
         compiled from pre_form_lot_syukkateishi.tpl */ ?>
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
  window.onload = function(){document.getElementById("qrLot").focus()}
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
<table width="800" border="0">
  <tr>
    <td align="center"><a href="index_import_lot.php"><img src="../img/lot_rireki_torikomi.gif" alt="lot_rireki_torikomi" width="83" height="37" border="0"/></a></td>
    <td align="center"><a href="index_lot_fushiyou.php"><img src="../img/label_fushiyou.gif" alt="label_fushiyou" width="83" height="37" border="0"/></a></td>
    <td align="center"><a href="index_touroku_hasu.php"><img src="../img/label_hasu.gif" alt="label_hasu" width="83" height="37" border="0"/></a></td>
    <td align="center"><a href="index_syukkateishi_jyunbi_touroku.php"><img src="../img/label_syukkateishi.gif" alt="label_syukkateishi" width="83" height="37" border="0"/></a></td>
    <td align="center"><a href="index_kensaku_lot.php"><img src="../img/label_kensaku_lot.gif" alt="kensaku_lot" width="83" height="37" border="0"/></a></td>
  </tr>
</table>
<br />
<br />
<form action="pre_touroku_lot_syukkateishi.php" method="post">
  <p align="center" ><strong><font color="#0000FF">出荷停止ロット登録</font></strong></p>
  <table width="350" border="0" align="center" bgcolor="#666666">
    <tr>
      <td width="200" bgcolor="#FFFFCC"><div align="center" class="style1"><strong><font color="#0000FF">ロットNo.</font></strong></div></td>
    </tr>
    <tr>
      <td bgcolor="#FFFFCC"><div align="center"><input type="text" name="qrLot" value="" size="50" id="qrLot"  autocomplete="off"/></div></td>
    </tr>
  </table>
<p><strong><font color="#FF0000"><?php echo $this->_tpl_vars['mess']; ?>
</font></strong><p/>
<p align="center">
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