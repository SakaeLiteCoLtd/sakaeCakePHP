<?php /* Smarty version 2.6.7, created on 2013-09-09 23:01:44
         compiled from rs_fushiyou_ichiran.tpl */ ?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=SHIFT_JIS" />
<!-- TemplateBeginEditable name="doctitle" -->
<title>����h�L�������g</title>
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
    <td align="center"><a href="index_lot_fushiyou.php"><img src="../img/label_fushiyou.gif" alt="label_fushiyou" width="83" height="37" border="0"/></a></td>
    <td align="center"><a href="index_touroku_hasu.php"><img src="../img/label_hasu.gif" alt="label_hasu" width="83" height="37" border="0"/></a></td>
    <td align="center"><a href="index_kensaku_lot.php"><img src="../img/label_kensaku_lot.gif" alt="kensaku_lot" width="83" height="37" border="0"/></a></td>
  </tr>
</table>
<br />
<br />
<table width="800" border="0">
  <tr>
    <td align="center"><a href="index_lot_fushiyou.php"><img src="../img/label_touroku.gif" alt="csv" width="83" height="37" border="0"/></a></td>
    <td align="center"><a href="index_fushiyou_ichiran.php"><img src="../img/label_ichiran.gif" alt="csv" width="83" height="37" border="0"/></a></td>
  </tr>
</table>
<br>
<br>
<form action="form_update_insideout.php" method="post">
  <table width="800" border="0" align="center" bgcolor="#666666">
    <tr>
      <td width="25" align="center" bgcolor="#FFFFCC"><strong><font color="#0000FF"></font></strong></td>
      <td width="120" bgcolor="#FFFFCC" nowrap="nowrap"><div align="center" class="style1"><strong><font color="#0000FF">���t</font></strong></div></td>
      <td width="100" bgcolor="#FFFFCC" nowrap="nowrap"><div align="center" class="style1"><strong><font color="#0000FF">�쐬����</font></strong></div></td>
      <td width="100" bgcolor="#FFFFCC" nowrap="nowrap"><div align="center" class="style1"><strong><font color="#0000FF">�s�g�p���b�g����</font></strong></div></td>
      <td width="100" bgcolor="#FFFFCC" nowrap="nowrap"><div align="center" class="style1"><strong><font color="#0000FF">�g�p�֎~���b�g����</font></strong></div></td>
      <td width="100" bgcolor="#FFFFCC" nowrap="nowrap"><div align="center" class="style1"><strong><font color="#0000FF">�݌Ƀ��b�g����</font></strong></div></td>
    </tr>
<?php if (count($_from = (array)$this->_tpl_vars['ichiran'])):
    foreach ($_from as $this->_tpl_vars['id']):
?>
    <tr>
      <td align="center" nowrap="nowrap" bgcolor="#FFFFCC">
        <?php echo $this->_tpl_vars['id']['radio']; ?>

      </td>
      <td bgcolor="#FFFFCC"><div align="center"><strong><?php echo $this->_tpl_vars['id']['date']; ?>
</strong><input type="hidden" name="date[]" value="<?php echo $this->_tpl_vars['id']['date']; ?>
" size="30"/></div></td>
      <td bgcolor="#FFFFCC"><div align="center"><strong><?php echo $this->_tpl_vars['id']['num_making_lot']; ?>
</strong><input type="hidden" name="num_making_lot[]" value="<?php echo $this->_tpl_vars['id']['num_making_lot']; ?>
" /></div></td>
      <td bgcolor="#FFFFCC"><div align="center"><strong><?php echo $this->_tpl_vars['id']['num_fushiyou']; ?>
</strong><input type="hidden" name="num_fushiyou[]" value="<?php echo $this->_tpl_vars['id']['num_fushiyou']; ?>
" /></div></td>
      <td bgcolor="#FFFFCC"><div align="center"><strong><?php echo $this->_tpl_vars['id']['num_kinshi_lot']; ?>
</strong><input type="hidden" name="num_kinshi_lot[]" value="<?php echo $this->_tpl_vars['id']['num_kinshi_lot']; ?>
" /></div></td>
      <td bgcolor="#FFFFCC"><div align="center"><strong><?php echo $this->_tpl_vars['id']['num_zaiko']; ?>
</strong><input type="hidden" name="num_zaiko[]" value="<?php echo $this->_tpl_vars['id']['num_zaiko']; ?>
" /></div></td>
    </tr>
<?php endforeach; endif; unset($_from); ?>
  </table>
<br>
<?php echo $this->_tpl_vars['mess']; ?>

<p align="center">
<?php echo $this->_tpl_vars['pre_tag']; ?>

<label>
<input type="submit" name="button" id="button" value="���b�g�ʈꗗ" />
</label>
<?php echo $this->_tpl_vars['last_tag']; ?>

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