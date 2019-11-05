<?php /* Smarty version 2.6.26, created on 2013-11-27 14:32:42
         compiled from form_touroku_hasu_pre.tpl */ ?>
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
<form action="form_touroku_hasu.php" method="post">
<table align="left" width="365" border="0" bordercolor="#666666" bgcolor="#666666">
  <tr>
    <td width="365" align="center" bgcolor="#FFFFCC"><strong><font color="#0000FF">担当者</font></strong></td>
  </tr>
  <tr>
    <td align="center" bgcolor="#FFFFCC"><div align="center">
        <strong><?php echo $this->_tpl_vars['full_name']; ?>
<input type="hidden" name="emp_id" value="<?php echo $this->_tpl_vars['emp_id']; ?>
" /></strong>
      </div></td>
  </tr>
</table><br /><br /><br /><br />
  <table width="500" border="0" align="left" bgcolor="#666666">
    <tr>
      <td width="100" bgcolor="#FFFFCC" ><div align="center" class="style1"><strong><font color="#0000FF">品番</font></strong></div></td>
      <td width="100" bgcolor="#FFFFCC"><div align="center" class="style1"><strong><font color="#0000FF">端数ロットNo.</font></strong></div></td>
      <td width="100" bgcolor="#FFFFCC" ><div align="center" class="style1"><strong><font color="#0000FF">数量</font></strong></div></td>
    </tr>
    <tr>
      <td bgcolor="#FFFFCC"><div align="center"><strong><?php echo $this->_tpl_vars['hasu_product_id']; ?>
</strong><input type="hidden" name="hasu_product_id" value="<?php echo $this->_tpl_vars['hasu_product_id']; ?>
" /><input type="hidden" name="hasu_check_lots_id" value="<?php echo $this->_tpl_vars['hasu_check_lots_id']; ?>
" /></div></td>
      <td bgcolor="#FFFFCC"><div align="center"><strong><?php echo $this->_tpl_vars['hasu_lot_num']; ?>
</strong><input type="hidden" name="hasu_lot_num" value="<?php echo $this->_tpl_vars['hasu_lot_num']; ?>
" /></div></td>
      <td bgcolor="#FFFFCC"><div align="center"><strong><?php echo $this->_tpl_vars['hasu_amount']; ?>
</strong><input type="hidden" name="hasu_amount" value="<?php echo $this->_tpl_vars['hasu_amount']; ?>
" /></div></td>
    </tr>
  </table>
<br />
<br />
<br />
<br />
<br />
<table width="350" border="0" align="left" bordercolor="#666666" bgcolor="#666666">
  <tr>
    <td width="200" align="center" nowrap="nowrap" bgcolor="#FFFFCC"><strong><font color="#0000FF">元ロットNo.</font></strong></td>
   <?php echo $this->_tpl_vars['td1']; ?>

  </tr>
<?php $_from = $this->_tpl_vars['arr_lot']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)):
    foreach ($_from as $this->_tpl_vars['id']):
?>
  <tr>
    <td height="17" align="center" bgcolor="#FFFFCC" nowrap="nowrap">
       <strong><?php echo $this->_tpl_vars['id']['moto_lot_num']; ?>
</strong>
       <input type="<?php echo $this->_tpl_vars['id']['type']; ?>
" name="moto_lot_num[]" id="<?php echo $this->_tpl_vars['id']['qr']; ?>
" value="<?php echo $this->_tpl_vars['id']['moto_lot_num']; ?>
" size="50"  autocomplete="off"/>
    </td>
    <?php echo $this->_tpl_vars['id']['td2']; ?>

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
<?php echo $this->_tpl_vars['label_add']; ?>

<?php echo $this->_tpl_vars['label_amount']; ?>

<?php echo $this->_tpl_vars['label_kakunin']; ?>

<?php echo $this->_tpl_vars['label_touroku']; ?>

<br />

<?php echo $this->_tpl_vars['mess']; ?>

</form>

<br />
</td>
    <hr />  
  </tr>
</table>
</body>
</html>