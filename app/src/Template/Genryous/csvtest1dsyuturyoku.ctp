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
 <table style="margin-bottom:0px" width="750" border="0" align="center" cellpadding="0" cellspacing="0" bordercolor="#CCCCCC">
 <?php
    echo $htmlcsvmenus;
 ?>
 </table>
 <hr size="5" style="margin: 0.5rem">
 <?=$this->Form->create($OrderMaterials, ['url' => ['action' => 'csvtest']]) ?>
 <br>
    <div align="left"><font color="blue" size="3"><?= __("　　　１日分データ出力") ?></font></div>
    <br>
       <div align="center"><font color="red" size="3"><a href="http://localhost:5000/genryous/csvtest1dApi/api/test.xml"><?= __($mes) ?></a></font></div>
    <br>
