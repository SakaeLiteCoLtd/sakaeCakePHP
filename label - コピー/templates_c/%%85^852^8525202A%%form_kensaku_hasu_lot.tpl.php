<?php /* Smarty version 2.6.26, created on 2013-09-07 10:27:29
         compiled from form_kensaku_hasu_lot.tpl */ ?>
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
<table width="800" border="0">
  <tr>
    <td align="center"><a href="index_import_lot.php"><img src="../img/lot_rireki_torikomi.gif" alt="lot_rireki_torikomi" width="83" height="37" border="0"/></a></td>
    <td align="center"><a href="index_lot_fushiyou.php"><img src="../img/label_fushiyou.gif" alt="lot_rireki_torikomi" width="83" height="37" border="0"/></a></td>
    <td align="center"><a href="index_touroku_hasu.php"><img src="../img/label_hasu.gif" alt="csv" width="83" height="37" border="0"/></a></td>
  </tr>
</table>
<br />
<br />
<table width="800" border="0">
  <tr>
    <td align="center"><a href="index_touroku_hasu.php"><img src="../img/label_touroku.gif" alt="csv" width="83" height="37" border="0"/></a></td>
    <td align="center"><a href="index_kensaku_hasu_lot.php"><img src="../img/label_kensaku.gif" alt="csv" width="83" height="37" border="0"/></a></td>
  </tr>
</table>
<br />
<br />
<form action="rs_kensaku_hasu_lot.php" method="post">
  <table width="500" border="0" align="left" bgcolor="#666666">
    <tr>
      <td width="100" bgcolor="#FFFFCC" ><div align="center" class="style1"><strong><font color="#0000FF">品番</font></strong></div></td>
      <td width="100" bgcolor="#FFFFCC"><div align="center" class="style1"><strong><font color="#0000FF">ロットNo.</font></strong></div></td>
      <?php echo $this->_tpl_vars['td1']; ?>

    </tr>
    <tr>
      <td bgcolor="#FFFFCC"><div align="center"><strong><?php echo $this->_tpl_vars['product_id']; ?>
</strong><input type="<?php echo $this->_tpl_vars['type']; ?>
" name="product_id" value="<?php echo $this->_tpl_vars['product_id']; ?>
" size="30"/><input type="hidden" name="hasu_check_lots_id" value="<?php echo $this->_tpl_vars['hasu_check_lots_id']; ?>
" /></div></td>
      <td bgcolor="#FFFFCC"><div align="center"><strong><?php echo $this->_tpl_vars['taisyou_lot_num']; ?>
</strong><input type="<?php echo $this->_tpl_vars['type']; ?>
" name="taisyou_lot_num" value="<?php echo $this->_tpl_vars['taisyou_lot_num']; ?>
" size="30"/></div></td>
      <?php echo $this->_tpl_vars['td2']; ?>

    </tr>
  </table>
<br />
<br />
<br />
<br />
<table width="350" border="0" align="left" bordercolor="#666666" bgcolor="#666666">
  <tr>
    <td width="25" align="center" nowrap="nowrap" bgcolor="#FFFFCC"><strong><font color="#0000FF"></font></strong></td>
    <td width="75" align="center" nowrap="nowrap" bgcolor="#FFFFCC"><strong><font color="#0000FF">ロットNo.</font></strong></td>
    <td width="100" align="center" nowrap="nowrap" bgcolor="#FFFFCC"><strong><font color="#0000FF">数量</font></strong></td>
  </tr>
<?php $_from = $this->_tpl_vars['arr_lot']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)):
    foreach ($_from as $this->_tpl_vars['id']):
?>
  <tr>
    <td height="17" align="center" bgcolor="#FFFFCC" nowrap="nowrap">
       <strong><?php echo $this->_tpl_vars['id']['num']; ?>
</strong>
    </td>
    <td height="17" align="center" bgcolor="#FFFFCC" nowrap="nowrap">
       <strong><?php echo $this->_tpl_vars['id']['lot_num']; ?>
</strong>
    </td>
    <td height="17" align="center" bgcolor="#FFFFCC" nowrap="nowrap">
       <strong><?php echo $this->_tpl_vars['id']['amount']; ?>
</strong>
    </td>
  </tr>
<?php endforeach; endif; unset($_from); ?>
</table>
<br />
<br />
<br />
<br />
<br />
<br />
<br />
<?php echo $this->_tpl_vars['mess']; ?>

<?php echo $this->_tpl_vars['label_kensaku']; ?>

</form>

<br />
</td>
    <hr />  
  </tr>
</table>
</body>
</html>