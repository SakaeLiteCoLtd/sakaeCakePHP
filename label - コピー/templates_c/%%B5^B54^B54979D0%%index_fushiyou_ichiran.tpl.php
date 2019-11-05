<?php /* Smarty version 2.6.7, created on 2013-09-15 20:26:09
         compiled from index_fushiyou_ichiran.tpl */ ?>
<?php require_once(SMARTY_CORE_DIR . 'core.load_plugins.php');
smarty_core_load_plugins(array('plugins' => array(array('function', 'html_options', 'index_fushiyou_ichiran.tpl', 48, false),)), $this); ?>
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
<form action="rs_fushiyou_ichiran.php" method="post">
  <tr valign="middle" bordercolor="#CCCCCC">
    <td bgcolor="#E1FDFB"><hr>
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
<table width="500" align="center" border="0" bordercolor="#666666" bgcolor="#666666">
  <tr>
    <td align="center" bgcolor="#FFFFCC"><strong><font color="#0000FF">不使用ロット日程絞込み</font></strong></td>
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
</form>
<br>
<br />
</td>
<hr>
  </tr>
</table>
</body>
</html>