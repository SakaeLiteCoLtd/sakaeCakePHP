<?php
 use App\myClass\Genryoumenu\htmlGenryoumenu;//myClassフォルダに配置したクラスを使用
 $htmlGenryoumenu = new htmlGenryoumenu();
 $htmlGenryou = $htmlGenryoumenu->Genryoumenus();

 echo $this->Form->create($stockEndMaterials, ['url' => ['action' => 'mishiyouichiran']]);

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
    <td style="padding: 0.1rem 0.1rem;"><a href="qr/index.php"><?php echo $this->Html->image('Labelimg/hazaisiyousuuryou.gif',array('width'=>'85','url'=>array('controller'=>'Hazaishiyous', 'action'=>'menu')));?></td>
  </tr>
</table>
<hr size="5" style="margin: 0.5rem">
 <table style="margin-bottom:0px" width="750" border="0" align="center" cellpadding="0" cellspacing="0" bordercolor="#CCCCCC">
  <tr style="background-color: #E6FFFF">
    <td style="padding: 0.1rem 0.1rem;"><a href="qr/index.php"><?php echo $this->Html->image('Labelimg/hazaimishiyoukensakublue.gif',array('width'=>'85','url'=>array('action'=>'mishiyoukensakuform')));?></td>
  </tr>
</table>
<hr size="5" style="margin: 0.5rem">
<br>
<table style="margin-bottom:0px" width="750" border="0" align="center" cellpadding="0" cellspacing="0" bordercolor="#CCCCCC">
   <tr style="background-color: #E6FFFF">
     <td bgcolor="#E6FFFF"><strong style="font-size: 11pt; color:black"><?= h("「原料グレード_色」を空欄のまま検索した場合、全ての未使用端材が表示されます") ?></strong></td>
   </tr>
 </table>
 <br>

<table align="center" border="2" bordercolor="#E6FFFF" cellpadding="0" cellspacing="0">
  <tbody border="2" bordercolor="#E6FFFF" bgcolor="#FFFFCC" style="border-bottom: solid;border-width: 1px">
    <tr>
      <td width="350" colspan="20" nowrap="nowrap"><div align="center"><strong style="font-size: 13pt; color:blue">原料グレード_色</strong></div></td>
    </tr>
    <tr>
      <td  rowspan='2'  height='6' colspan='20' style='border-bottom: 1px solid black;border-width: 1px'>
        <?= $this->Form->control('materialgrade_color', array('type'=>'text', 'label'=>false, 'id'=>"material_list", 'autofocus'=>true)) ?>
      </td>
    </tr>
</table>
<br>
<table align="center" border="2" bordercolor="#E6FFFF" cellpadding="0" cellspacing="0">
  <tr>
    <td style="border-style: none;"><div align="center"><?= $this->Form->submit('検索', array('name' => 'next')); ?></div></td>
  </tr>
</table>

<br><br><br>
