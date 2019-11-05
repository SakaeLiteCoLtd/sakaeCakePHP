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
 {literal}
  window.onload = function(){document.getElementById("qrText").focus()}
 {/literal}
</script>
<body>
<table width="800" border="0" align="center" cellpadding="0" cellspacing="0" bordercolor="#CCCCCC">
  <tr>
    <td bgcolor="#E6FFFF"><p><img src="../img/logo.gif" width="157" height="22" /></p>
	{$header}
    </td>
  </tr>
  <tr valign="middle" bordercolor="#CCCCCC">
    <td bgcolor="#E6FFFF"><!-- TemplateBeginEditable name="body" --><!-- TemplateEndEditable -->
  <hr>
{$semi_header}
<hr />
{$semi_zensu_jikkou_header}
<br />
<form action="form_touroku_hasu.php" method="post">
<table align="center" width="365" border="0" bordercolor="#666666" bgcolor="#666666">
  <tr>
    <td width="365" align="center" bgcolor="#FFFFCC"><strong><font color="#0000FF">担当者</font></strong></td>
  </tr>
  <tr>
    <td align="center" bgcolor="#FFFFCC"><div align="center">
        <strong>{$full_name}<input type="hidden" name="emp_id" value="{$emp_id}" /></strong>
      </div></td>
  </tr>
</table><br /><br />
  <p align="center" ><strong><font color="#0000FF">端数登録　製品登録</font></strong></p>
  <table width="350" border="0" align="center" bgcolor="#666666">
    <tr>
      <td width="100" bgcolor="#FFFFCC"><div align="center" class="style1"><strong><font color="#0000FF">製品ラベルRQコード読込</font></strong></div></td>
      <td bgcolor="#FFFFCC"><div align="center"><input type="text" name="qr_lot" id="qrText" value="" size="30" autocomplete="off"/></div></td>
    </tr>
  </table>
<br>
</form>
<br />
{$mess}
</td>
    <hr />  
  </tr>
</table>
</body>
</html>
