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
	{$header}
    </td>
  </tr>
  <tr valign="middle" bordercolor="#CCCCCC">
    <td bgcolor="#E6FFFF"><!-- TemplateBeginEditable name="body" --><!-- TemplateEndEditable -->
  <hr>
{$semi_header}
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
      <td width="120" bgcolor="#FFFFCC" nowrap="nowrap"><div align="center" class="style1"><strong><font color="#0000FF">日付</font></strong></div></td>
      <td width="100" bgcolor="#FFFFCC" nowrap="nowrap"><div align="center" class="style1"><strong><font color="#0000FF">作成枚数</font></strong></div></td>
      <td width="100" bgcolor="#FFFFCC" nowrap="nowrap"><div align="center" class="style1"><strong><font color="#0000FF">不使用ロット枚数</font></strong></div></td>
      <td width="100" bgcolor="#FFFFCC" nowrap="nowrap"><div align="center" class="style1"><strong><font color="#0000FF">使用禁止ロット枚数</font></strong></div></td>
      <td width="100" bgcolor="#FFFFCC" nowrap="nowrap"><div align="center" class="style1"><strong><font color="#0000FF">在庫ロット枚数</font></strong></div></td>
    </tr>
{foreach from=$ichiran item=id}
    <tr>
      <td align="center" nowrap="nowrap" bgcolor="#FFFFCC">
        {$id.radio}
      </td>
      <td bgcolor="#FFFFCC"><div align="center"><strong>{$id.date}</strong><input type="hidden" name="date[]" value="{$id.date}" size="30"/></div></td>
      <td bgcolor="#FFFFCC"><div align="center"><strong>{$id.num_making_lot}</strong><input type="hidden" name="num_making_lot[]" value="{$id.num_making_lot}" /></div></td>
      <td bgcolor="#FFFFCC"><div align="center"><strong>{$id.num_fushiyou}</strong><input type="hidden" name="num_fushiyou[]" value="{$id.num_fushiyou}" /></div></td>
      <td bgcolor="#FFFFCC"><div align="center"><strong>{$id.num_kinshi_lot}</strong><input type="hidden" name="num_kinshi_lot[]" value="{$id.num_kinshi_lot}" /></div></td>
      <td bgcolor="#FFFFCC"><div align="center"><strong>{$id.num_zaiko}</strong><input type="hidden" name="num_zaiko[]" value="{$id.num_zaiko}" /></div></td>
    </tr>
{/foreach}
  </table>
<br>
{$mess}
<p align="center">
{$pre_tag}
<label>
<input type="submit" name="button" id="button" value="ロット別一覧" />
</label>
{$last_tag}
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
