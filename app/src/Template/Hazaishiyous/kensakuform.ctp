<?php
 use App\myClass\Genryoumenu\htmlGenryoumenu;//myClassフォルダに配置したクラスを使用
 $htmlGenryoumenu = new htmlGenryoumenu();
 $htmlGenryou = $htmlGenryoumenu->Genryoumenus();

 echo $this->Form->create($stockEndMaterials, ['url' => ['action' => 'kensakuichiran']]);

 ?>

 <link rel="stylesheet" href="http://code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css" />
 <script src="https://code.jquery.com/jquery-3.5.1.js"></script>
 <script src="http://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>

 <?php
 $arrMaterial_list = json_encode($arrMaterial_list);//jsに配列を受け渡すために変換
 ?>

 <script>

 $(function() {
       // 入力補完候補の単語リスト
       let wordlist = <?php echo $arrMaterial_list; ?>
       // 入力補完を実施する要素に単語リストを設定
       $("#material_list").autocomplete({
         source: wordlist
       });
   });

 </script>

 <hr size="5" style="margin: 0.5rem">
 <table style="margin-bottom:0px" width="750" border="0" align="center" cellpadding="0" cellspacing="0" bordercolor="#CCCCCC">
 <?php
    echo $htmlGenryou;
 ?>
 </table>
 <hr size="5" style="margin: 0.5rem">
<table style="margin-bottom:0px" width="750" border="0" align="center" cellpadding="0" cellspacing="0" bordercolor="#CCCCCC">
  <tr style="background-color: #E6FFFF">
    <td style="padding: 0.1rem 0.1rem;"><a href="qr/index.php"><?php echo $this->Html->image('Labelimg/hazaisiyousuuryou.gif',array('width'=>'105','url'=>array('controller'=>'Hazaishiyous', 'action'=>'menu')));?></td>
  </tr>
</table>
<hr size="5" style="margin: 0.5rem">
 <table style="margin-bottom:0px" width="750" border="0" align="center" cellpadding="0" cellspacing="0" bordercolor="#CCCCCC">
  <tr style="background-color: #E6FFFF">
    <td style="padding: 0.1rem 0.1rem;"><a href="qr/index.php"><?php echo $this->Html->image('Labelimg/hazaisiyoukensakugreen.gif',array('width'=>'105','url'=>array('action'=>'kensakuform')));?></td>
  </tr>
</table>
<hr size="5" style="margin: 0.5rem">
<br>

<table align="center" border="2" bordercolor="#E6FFFF" cellpadding="0" cellspacing="0">
  <tbody border="2" bordercolor="#E6FFFF" bgcolor="#FFFFCC" style="border-bottom: solid;border-width: 1px">
    <tr>
      <td width="350" colspan="20" nowrap="nowrap"><div align="center"><strong style="font-size: 13pt; color:blue">原料グレード_色</strong></div></td>
      <td width="400" colspan="40" nowrap="nowrap"><div align="center"><strong style="font-size: 13pt; color:blue">端材使用日絞込</strong></div></td>
    </tr>

    <tr>
      <td  rowspan='2'  height='6' colspan='20' style='border-bottom: 1px solid black;border-width: 1px'>
        <?= $this->Form->control('materialgrade_color', array('type'=>'text', 'label'=>false, 'id'=>"material_list", 'autofocus'=>true, 'required'=>true)) ?>
      </td>

      <?php
        $dateYMD = date('Y-m-d');
        $dateYMD1 = strtotime($dateYMD);
        $dayye = date('Y-m-d', strtotime('-1 day', $dateYMD1));

        echo "<td colspan='10' style='border-bottom: 0px'><div align='center'><strong style='font-size: 13pt; color:blue'>\n";
        echo "開始";
        echo "</strong></div></td>\n";

      ?>

      <td colspan="30" style="border-bottom: 1px;border-width: 1px"><div align="center"><?= $this->Form->input("date_sta", array('type' => 'date', 'value' => $dayye, 'monthNames' => false, 'label'=>false)); ?></div></td>

      <?php

        echo "</tr>\n";
        echo "<tr style='border-bottom: 0px;border-width: 0px'>\n";
        echo "<td colspan='10'><div align='center'><strong style='font-size: 13pt; color:blue'>\n";
        echo "終了";
        echo "</strong></div></td>\n";

      ?>

      <td width="350" colspan="30" style="border-bottom: solid;border-width: 1px"><div align="center"><?= $this->Form->input("date_fin", array('type' => 'date', 'value' => $dateYMD, 'monthNames' => false, 'label'=>false)); ?></div></td>
    </tr>
</table>
<br>
<table align="center" border="2" bordercolor="#E6FFFF" cellpadding="0" cellspacing="0">
  <tr>
    <td style="border-style: none;"><div align="center"><?= $this->Form->submit('検索', array('name' => 'next')); ?></div></td>
  </tr>
</table>

<br><br><br>
