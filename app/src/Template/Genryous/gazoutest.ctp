<?php
 use App\myClass\Genryoumenu\htmlGenryoumenu;//myClassフォルダに配置したクラスを使用
 $htmlGenryoumenu = new htmlGenryoumenu();
 $htmlGenryou = $htmlGenryoumenu->Genryoumenus();
 $htmlcsvmenus = $htmlGenryoumenu->csvmenus();
 ?>
 <hr size="5" style="margin: 0.5rem">
 <table style="margin-bottom:0px" width="750" border="0" align="center" cellpadding="0" cellspacing="0" bordercolor="#CCCCCC">
 <?php
    echo $htmlGenryou;
 ?>
 </table>
 <hr size="5" style="margin: 0.5rem">

  <br><br><br>

  <form method="post" action="gazouhyoujitest" enctype="multipart/form-data">
    <table align="center" border="2" bordercolor="#E6FFFF" cellpadding="0" cellspacing="0">
      <tbody border="2" bordercolor="#E6FFFF" bgcolor="#FFFFCC">
        <tr>
          <td colspan="20" style="border-bottom: solid;border-width: 1px" ><input name="upfile" type="file" size="80" /></td>
          <td colspan="20" style="border-bottom: solid;border-width: 1px"><input type="submit" name="submit" value="決定" /></td>
        </tr>
    </table>
  </form>

  <br><br>
