<?php
 use App\myClass\EDImenus\htmlEDImenu;//myClassフォルダに配置したクラスを使用
 $htmlEDImenu = new htmlEDImenu();
 $htmlEDIs = $htmlEDImenu->EDImenus();
 ?>
 <hr size="5" style="margin: 0.5rem">
 <table style="margin-bottom:0px" width="750" border="0" align="center" cellpadding="0" cellspacing="0" bordercolor="#CCCCCC">
 <?php
    echo $htmlEDIs;
 ?>
 </table>
 <hr size="5" style="margin: 0.5rem">
 <br>

 <?php
  $htmlEDIsubmenu = new htmlEDImenu();
  $htmlEDIsubs = $htmlEDIsubmenu->EDIsubmenus();
  ?>
  <table style="margin-bottom:0px" width="750" border="0" align="center" cellpadding="0" cellspacing="0" bordercolor="#CCCCCC">
  <?php
     echo $htmlEDIsubs;
  ?>
  </table>
  <br>
   <div align="center"><font color="red" size="2"><?= __($mess) ?></font></div>
   <br>
