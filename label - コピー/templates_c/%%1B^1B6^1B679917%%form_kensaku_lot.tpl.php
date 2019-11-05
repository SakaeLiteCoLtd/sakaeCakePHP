<?php /* Smarty version 2.6.7, created on 2013-09-09 21:46:56
         compiled from form_kensaku_lot.tpl */ ?>
<?php require_once(SMARTY_CORE_DIR . 'core.load_plugins.php');
smarty_core_load_plugins(array('plugins' => array(array('function', 'html_options', 'form_kensaku_lot.tpl', 40, false),)), $this); ?>
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
<form action="rs_kensaku_lot.php" method="post">
  <tr valign="middle" bordercolor="#CCCCCC">
    <td bgcolor="#E1FDFB"><hr>
<?php echo $this->_tpl_vars['semi_header']; ?>

  <hr />
<table width=800 border="0" align="center" bordercolor="#333333" bgcolor="#666666">
  <tr>
    <td width="108" align="center" nowrap="nowrap" bgcolor="#FFFFCC"><font color="#0000FF"><strong>品番</strong></font></td>
    <td width="108" align="center" nowrap="nowrap" bgcolor="#FFFFCC"><font color="#0000FF"><strong>ロットNo.</strong></font></td>
    <td colspan="2" align="center" valign="middle" nowrap="nowrap" bgcolor="#FFFFCC"><font color="#0000FF"><strong>ロット発行日</strong></font></td>
  </tr>
<?php if (count($_from = (array)$this->_tpl_vars['data'])):
    foreach ($_from as $this->_tpl_vars['id']):
?>
  <tr>
    <td rowspan="2" align="center" nowrap="nowrap" bgcolor="#FFFFCC"><font size="-2">
      <input type="text" name="product_id" value="<?php echo $this->_tpl_vars['id']['product_id']; ?>
"  size="20"/>
    </font></td>
    <td rowspan="2" align="center" nowrap="nowrap" bgcolor="#FFFFCC"><font size="-2">
      <input type="text" name="lot_num" value="<?php echo $this->_tpl_vars['id']['lot_num']; ?>
"  size="20"/>
    </font></td>
    <td width="50" align="center" valign="middle" nowrap="nowrap" bgcolor="#FFFFCC"><strong><font color="#0000FF">開始</font></strong></td>
    <td width="366" align="center" valign="middle" nowrap="nowrap" bgcolor="#FFFFCC">
        <font size="-2"><strong>
        <?php echo smarty_function_html_options(array('name' => 'syear','options' => $this->_tpl_vars['id']['starting_year'],'selected' => $this->_tpl_vars['id']['selected_starting_year']), $this);?>

        年
           <?php echo smarty_function_html_options(array('name' => 'smonth','options' => $this->_tpl_vars['id']['starting_month'],'selected' => $this->_tpl_vars['id']['selected_starting_month']), $this);?>

        月
          <?php echo smarty_function_html_options(array('name' => 'sday','options' => $this->_tpl_vars['id']['starting_day'],'selected' => $this->_tpl_vars['id']['selected_starting_day']), $this);?>

          日</strong>
        </font>
     </td>
  </tr>
  <tr>
    <td align="center" valign="middle" nowrap="nowrap" bgcolor="#FFFFCC"><strong><font color="#0000FF">終了</font></strong></td>
    <td align="center" valign="middle" nowrap="nowrap" bgcolor="#FFFFCC">
        <font size="-2"><strong>
        <?php echo smarty_function_html_options(array('name' => 'fyear','options' => $this->_tpl_vars['id']['finishing_year'],'selected' => $this->_tpl_vars['id']['selected_finishing_year']), $this);?>

        年
           <?php echo smarty_function_html_options(array('name' => 'fmonth','options' => $this->_tpl_vars['id']['finishing_month'],'selected' => $this->_tpl_vars['id']['selected_finishing_month']), $this);?>

        月
          <?php echo smarty_function_html_options(array('name' => 'fday','options' => $this->_tpl_vars['id']['finishing_day'],'selected' => $this->_tpl_vars['id']['selected_finishing_day']), $this);?>

          日</strong>
        </font>
    </td>
  </tr>
<?php endforeach; endif; unset($_from); ?>
</table>

<p align="right">
<?php echo $this->_tpl_vars['value']; ?>

<input type="hidden" name="year" value="<?php echo $this->_tpl_vars['year']; ?>
" size="15"/>
<input type="hidden" name="month" value="<?php echo $this->_tpl_vars['month']; ?>
" size="15"/>
<input type="hidden" name="day" value="<?php echo $this->_tpl_vars['day']; ?>
" size="15"/>
                <label><font color="#FFFFCC"></font>
                <input type="submit" name="touroku" id="button" value="検索" />
        </label>
    </form>
</p>
</td>
    <hr />  
  </tr>
</table>
</body>
</html>