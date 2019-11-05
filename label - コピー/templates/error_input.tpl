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
	{$header}   
    </td>
  </tr>

  <tr valign="middle" bordercolor="#CCCCCC">
    <td bgcolor="#E1FDFB"><hr>
    <strong><font color="#0000FF" face="ＭＳ Ｐ明朝, 細明朝体, ヒラギノ明朝 Pro W3">。ブラウザの『戻る』で戻ってください。</font></strong><br />
   <br>
      <strong><font color="#FF0000">{$mess}{$value}</font></strong>
      {$pre_tag}<strong><font color="#FF0000">以下のロットは、既に存在します。</font></strong>{$last_tag}
   <br>
   <br>
   {foreach from=$check_arr_lot item=id }
   <strong><font color="#FF0000">{$id.product_id}---{$id.lot_num}</font></strong><br>
   {/foreach}
   <br>
   <br>
  </tr>
</table>
</body>
</html>
